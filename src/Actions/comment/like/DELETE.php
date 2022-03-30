<?php

namespace Actions\comment\like;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class DELETE extends Action {

    protected function parameters(): array {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $token = isset($_GET["token"]) ? $_GET["token"] : "";
        return [
            "id" => $id,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verfied = Token::verify($parameters["token"]);
        if (!$verfied || !$parameters["id"]) {
            http_response_code(400);
            return [];
        }

        // delete from database
        $uid = Token::payload($parameters["token"])["uid"];
        $sqlite = new SQLite(DATABASE);

        $query = "DELETE FROM COMMENTLIKES WHERE comment = :comment AND user = :user;";
        $query_params = [
            ":comment" => $parameters["id"],
            ":user" => $uid
        ];

        $sqlite->execute($query, $query_params);

        // check errors
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

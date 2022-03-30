<?php

namespace Actions\comment\like;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
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

        // insert to database
        $uid = Token::payload($parameters["token"])["uid"];
        $sqlite = new SQLite(DATABASE);

        $query = "INSERT INTO COMMENTLIKES(comment, user) VALUES(:comment, :user);";
        $query_params = [
            ":comment" => $parameters["id"],
            ":user" => $uid
        ];

        $sqlite->execute($query, $query_params);

        // check error
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

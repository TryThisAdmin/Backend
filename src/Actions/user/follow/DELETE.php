<?php

namespace Actions\user\follow;

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
        $verified = Token::verify($parameters["token"]);
        if (!$parameters["id"] || !$verified) {
            http_response_code(400);
            return [];
        }

        // delete from database
        $sqlite = new SQLite(DATABASE);
        $uid = Token::payload($parameters["token"])["uid"];

        $query = "DELETE FROM FOLLOWERS WHERE user = :id AND follower = :uid;";
        $query_params = [
            ":id" => $parameters["id"],
            ":uid" => $uid
        ];

        $sqlite->execute($query, $query_params);

        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

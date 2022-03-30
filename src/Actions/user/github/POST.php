<?php

namespace Actions\user\github;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $username = isset($_POST["username"]) ? $_POST["username"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        return [
            "username" => $username,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verfied = Token::verify($parameters["token"]);
        if (
            !$verfied
            || !$parameters["username"]
        ) {
            http_response_code(400);
            return [];
        }

        // update database
        $uid = Token::payload($parameters["token"])["uid"];

        $sqlite = new SQLite(DATABASE);

        $query = "UPDATE USERS SET github = :github WHERE id = :id";
        $query_params = [
            ":github" => $parameters["username"],
            ":id" => $uid
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

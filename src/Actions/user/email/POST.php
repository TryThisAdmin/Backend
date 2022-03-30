<?php

namespace Actions\user\email;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        return [
            "email" => $email,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verfied = Token::verify($parameters["token"]);
        if (
            !$verfied
            || !$parameters["email"]
            || !filter_var($parameters["email"], FILTER_VALIDATE_EMAIL)
        ) {
            http_response_code(400);
            return [];
        }

        // update database
        $uid = Token::payload($parameters["token"])["uid"];

        $sqlite = new SQLite(DATABASE);

        $query = "UPDATE USERS SET email = :email WHERE id = :id";
        $query_params = [
            ":email" => $parameters["email"],
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

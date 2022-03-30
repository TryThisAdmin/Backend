<?php

namespace Actions\user\password;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        return [
            "password" => $password,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verfied = Token::verify($parameters["token"]);
        if (!$verfied || !$parameters["password"]) {
            http_response_code(400);
            return [];
        }

        // update database
        $uid = Token::payload($parameters["token"])["uid"];
        $hash = password_hash($parameters["password"], PASSWORD_DEFAULT);

        $sqlite = new SQLite(DATABASE);

        $query = "UPDATE USERS SET hash = :hash WHERE id = :id";
        $query_params = [
            ":hash" => $hash,
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

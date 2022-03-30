<?php

namespace Actions\user\name;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        return [
            "name" => $name,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verfied = Token::verify($parameters["token"]);
        if (!$verfied || !$parameters["name"]) {
            http_response_code(400);
            return [];
        }

        // update database
        $uid = Token::payload($parameters["token"])["uid"];

        $sqlite = new SQLite(DATABASE);

        $query = "UPDATE USERS SET name = :name WHERE id = :id";
        $query_params = [
            ":name" => $parameters["name"],
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

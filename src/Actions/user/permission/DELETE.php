<?php

namespace Actions\user\permission;

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

        // check permission
        $isAdmin = Token::payload($parameters["token"])["role"] == "admin";
        if (!$isAdmin) {
            http_response_code(403);
            return [];
        }
        
        
        // update database
        $sqlite = new SQLite(DATABASE);

        $query = "UPDATE USERS SET role = :role WHERE id = :id";
        $query_params = [
            ":role" => "user",
            ":id" => $parameters["id"]
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

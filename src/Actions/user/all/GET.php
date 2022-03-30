<?php

namespace Actions\user\all;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class GET extends Action {

    protected function parameters(): array {
        $token = isset($_GET["token"]) ? $_GET["token"] : "";
        return [
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verfied = Token::verify($parameters["token"]);
        if (!$verfied) {
            http_response_code(403);
            return [];
        }

        // only admin can fetch list of users
        $isAdmin = Token::payload($parameters["token"])["role"] == "admin";
        if (!$isAdmin) {
            http_response_code(403);
            return [];
        }

        // fetch data
        $sqlite = new SQLite(DATABASE);
        $query = "SELECT name, id, email, role FROM USERS;";

        $data = $sqlite->execute($query);

        // check errors
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return ["entries" => $data];
    }
}

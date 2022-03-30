<?php

namespace Actions\idea;

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
        // check params
        $valid = Token::verify($parameters["token"]);
        if (!$valid || $parameters["id"] == "") {
            http_response_code(400);
            return [];
        }

        $sqlite = new SQLite(DATABASE);
        $payload = Token::payload($parameters["token"]);
        $uid = $payload["uid"];
        $role = $payload["role"];

        if ($role == "admin") {
            // admin can always delete
            $query = "DELETE FROM IDEAS WHERE id = :id;";
            $query_params = [
                ":id" => $parameters["id"]
            ];
            $sqlite->execute($query, $query_params);
        } else {
            // normal user needs to be the author
            $query = "DELETE FROM IDEAS WHERE id = :id AND author = :author;";
            $query_params = [
                ":id" => $parameters["id"],
                ":author" => $uid
            ];
            $sqlite->execute($query, $query_params);
        }

        // check for error
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

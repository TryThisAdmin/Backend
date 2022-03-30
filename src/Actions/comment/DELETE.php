<?php

namespace Actions\comment;

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
        $payload = Token::payload($parameters["token"]);
        $uid = $payload["uid"];
        $role = $payload["role"];
        $sqlite = new SQLite(DATABASE);

        if ($role == "admin") {
            // admin can delete anything
            $query = "DELETE FROM COMMENTS WHERE id = :id";
            $query_params = [
                ":id" => $parameters["id"]
            ];
            $sqlite->execute($query, $query_params);
        } else {
            // user needs to author the comment
            $query = "DELETE FROM COMMENTS WHERE id = :id AND author = :author";
            $query_params = [
                ":id" => $parameters["id"],
                ":author" => $uid
            ];

            $sqlite->execute($query, $query_params);
        }

        // check error
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

<?php

namespace Actions\user;

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
        if (!$verified || !$parameters["id"]) {
            http_response_code(400);
            return [];
        }

        // check access
        $payload = Token::payload($parameters["token"]);
        $uid = $payload["uid"];
        $isAdmin = $payload["role"] == "admin";

        if (!$isAdmin && $uid != $parameters["id"]) {
            http_response_code(403);
            return [];
        }

        // delete from database
        $sqlite = new SQLite(DATABASE);
        $query = "DELETE FROM USERS WHERE id = :id;";
        $query_params = [
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

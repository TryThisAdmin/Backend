<?php

namespace Actions\user\follow;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
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

        // insert into database
        $sqlite = new SQLite(DATABASE);
        $uid = Token::payload($parameters["token"])["uid"];

        $query = "INSERT INTO FOLLOWERS(user, follower) VALUES(:id, :uid);";
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

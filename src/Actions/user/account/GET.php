<?php

namespace Actions\user\account;

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
            http_response_code(400);
            return [];
        }

        // fetch data from database
        $uid = Token::payload($parameters["token"])["uid"];
        $sqlite = new SQLite(DATABASE);

        $query = "
            SELECT
            name,
            id,
            email,
            github,
            role,
            (SELECT COUNT() FROM FOLLOWERS WHERE user = :uid) as followers,
            (SELECT COUNT() FROM IDEALIKES WHERE idea IN (SELECT id FROM IDEAS WHERE author = :uid)) as ideaLikes,
            (SELECT COUNT() FROM COMMENTLIKES WHERE comment IN (SELECT id FROM COMMENTS where author = :uid)) as commentLikes,
            (SELECT COUNT() FROM IDEAS WHERE author = :uid) as ideas,
            (SELECT COUNT() FROM COMMENTS WHERE author = :uid) as comments
        FROM
            USERS
        WHERE
            id = :uid;";
        $query_params = [
            ":uid" => $uid
        ];

        $data = $sqlite->execute($query, $query_params);

        // check errors
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        // check not found
        if ($data == []) {
            http_response_code(404);
            return [];
        }

        return ["entries" => $data];
    }
}

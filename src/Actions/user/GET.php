<?php

namespace Actions\user;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class GET extends Action {

    protected function parameters(): array {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $token = isset($_GET["token"]) ? $_GET["token"] : "";
        return [
            "id" => $id,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // Check parameters
        if (!$parameters["id"]) {
            http_response_code(400);
            return [];
        }

        // fetch data
        $sqlite = new SQLite(DATABASE);
        $query = "";
        $query_params = [];

        // logged in user
        if ($parameters["token"] && Token::verify($parameters["token"])) {
            $uid = Token::payload($parameters["token"])["uid"];
            $query = "
                SELECT
                    name,
                    id,
                    role,
                    github,
                    CASE
                        WHEN (SELECT COUNT() FROM FOLLOWERS WHERE user = :id AND follower = :uid) > 0
                            THEN 'true'
                        ELSE
                            ''
                    END as following,
                    (SELECT COUNT() FROM FOLLOWERS WHERE user = :id) as followers,
                    (SELECT COUNT() FROM IDEALIKES WHERE idea IN (SELECT id FROM IDEAS WHERE author = :id)) as ideaLikes,
                    (SELECT COUNT() FROM COMMENTLIKES WHERE comment IN (SELECT id FROM COMMENTS where author = :id)) as commentLikes,
                    (SELECT COUNT() FROM IDEAS WHERE author = :id) as ideas,
                    (SELECT COUNT() FROM COMMENTS WHERE author = :id) as comments
                FROM
                    USERS
                WHERE
                    id = :id;";
            $query_params[":id"] = $parameters["id"];
            $query_params[":uid"] = $uid;
        } else {
            // non logged in user
            $query = "
                SELECT
                    name,
                    id,
                    role,
                    github,
                    '' as following,
                    (SELECT COUNT() FROM FOLLOWERS WHERE user = :id) as followers,
                    (SELECT COUNT() FROM IDEALIKES WHERE idea IN (SELECT id FROM IDEAS WHERE author = :id)) as ideaLikes,
                    (SELECT COUNT() FROM COMMENTLIKES WHERE comment IN (SELECT id FROM COMMENTS where author = :id)) as commentLikes,
                    (SELECT COUNT() FROM IDEAS WHERE author = :id) as ideas,
                    (SELECT COUNT() FROM COMMENTS WHERE author = :id) as comments
                FROM
                    USERS
                WHERE
                    id = :id;";
            $query_params[":id"] = $parameters["id"];
        }
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

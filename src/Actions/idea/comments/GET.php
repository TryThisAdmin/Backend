<?php

namespace Actions\idea\comments;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class GET extends Action {

    protected function parameters(): array {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $limit = isset($_GET["limit"]) ? $_GET["limit"] : "";
        $offset = isset($_GET["offset"]) ? $_GET["offset"] : "";
        $token = isset($_GET["token"]) ? $_GET["token"] : "";
        return [
            "id" => $id,
            "limit" => $limit,
            "offset" => $offset,
            "token" => $token
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        if (
            !$parameters["id"]
            || ($parameters["limit"] && !is_numeric($parameters["limit"]))
            || ($parameters["offset"] && !is_numeric($parameters["offset"]))
        ) {
            http_response_code(400);
            return [];
        }

        // fetch from database
        $sqlite = new SQLite(DATABASE);

        $query = "";
        $query_params = [
            ":idea" => $parameters["id"]
        ];

        if ($parameters["token"] && Token::verify($parameters["token"])) {
            $uid = Token::payload($parameters["token"])["uid"];
            $query = "
                SELECT
                    c.id,
                    c.idea,
                    c.content,
                    u.id as authorID,
                    u.name as author,
                    c.created,
                    c.updated,
                    (SELECT COUNT() FROM COMMENTLIKES l WHERE l.comment = c.id GROUP BY l.comment) as likes,
                    CASE
                        WHEN (SELECT COUNT() FROM COMMENTLIKES l WHERE l.user = :uid AND l.comment = c.id GROUP BY l.comment) > 0
                            THEN 'true'
                        ELSE
                            ''
                    END as liked
                FROM 
                    COMMENTS c
                    LEFT JOIN USERS u
                    ON c.author = u.id
                WHERE 
                    c.idea = :idea
                ORDER BY
                    c.created DESC
                    ";
            $query_params[":uid"] = $uid;
        } else {
            $query = "
                SELECT
                    c.id,
                    c.idea,
                    c.content,
                    u.id as authorID,
                    u.name as author,
                    c.created,
                    c.updated,
                    (SELECT COUNT(l.user) FROM COMMENTLIKES l WHERE l.comment = c.id GROUP BY l.comment) as likes,
                    '' as liked
                FROM 
                    COMMENTS c
                    LEFT JOIN USERS u
                    ON c.author = u.id
                WHERE 
                    c.idea = :idea
                ORDER BY
                    c.created DESC
                    ";
        }

        // set limiters according to parameters
        if ($parameters["limit"] && $parameters["offset"]) {
            $query .= "LIMIT :limit OFFSET :offset;";
            $query_params[":idea"] = $parameters["id"];
            $query_params[":limit"] = $parameters["limit"];
            $query_params[":offset"] = $parameters["offset"];
        } elseif ($parameters["limit"]) {
            $query .= "LIMIT :limit";
            $query_params[":idea"] = $parameters["id"];
            $query_params[":limit"] = $parameters["limit"];
        } else {
            $query .= ";";
        }

        $data = $sqlite->execute($query, $query_params);

        // Check errors
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return ["entries" => $data];
    }
}

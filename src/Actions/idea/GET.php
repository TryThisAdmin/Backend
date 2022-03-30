<?php

namespace Actions\idea;

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
        // check parameters
        if ($parameters["id"] == "") {
            http_response_code(400);
            return [];
        }

        // fetch from database
        $sqlite = new SQLite(DATABASE);

        $query = "";
        $query_params = [];

        // logged in user
        if ($parameters["token"] && Token::verify($parameters["token"])) {
            $uid = Token::payload($parameters["token"])["uid"];
            $query = "
                SELECT
                    i.id,
                    i.title,
                    i.content,
                    u.id as authorID,
                    u.name as author,
                    i.created,
                    i.updated,
                    (SELECT COUNT() FROM IDEALIKES l WHERE l.idea = i.id GROUP BY l.idea) as likes,
                    (SELECT COALESCE(GROUP_CONCAT(t.name, ','), '') FROM TAGS t WHERE t.idea = i.id GROUP BY t.idea) as tags,
                    CASE
                        WHEN (SELECT COUNT() FROM IDEALIKES l WHERE l.user = :uid AND l.idea = i.id GROUP BY l.idea) > 0
                            THEN 'true'
                        ELSE
                            ''
                    END as liked,
                    CASE
                        WHEN (SELECT COUNT() FROM IDEASAVES s WHERE s.user = :uid AND s.idea = i.id GROUP BY s.idea) > 0
                            THEN 'true'
                        ELSE
                            ''
                    END as saved
                FROM 
                    IDEAS i
                    LEFT JOIN USERS u
                    ON i.author = u.id
                WHERE 
                    i.id = :id";
            $query_params = [
                ":id" => $parameters["id"],
                ":uid" => $uid
            ];
        } else {
            // non logged in user
            $query = "
                SELECT
                    i.id,
                    i.title,
                    i.content,
                    u.id as authorID,
                    u.name as author,
                    i.created,
                    i.updated,
                    (SELECT COUNT(l.user) FROM IDEALIKES l WHERE l.idea = i.id GROUP BY l.idea) as likes,
                    (SELECT COALESCE(GROUP_CONCAT(t.name, ','), '') FROM TAGS t WHERE t.idea = i.id GROUP BY t.idea) as tags,
                    '' as liked,
                    '' as saved
                FROM 
                    IDEAS i
                    LEFT JOIN USERS u
                    ON i.author = u.id
                WHERE 
                    i.id = :id;";
            $query_params = [
                ":id" => $parameters["id"]
            ];
        }
        $data = $sqlite->execute($query, $query_params);

        // Check errors
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

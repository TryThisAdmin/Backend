<?php

namespace Actions\idea\user;

use base\Action;
use Helpers\SQLite;

class GET extends Action {

    protected function parameters(): array {
        $uid = isset($_GET["uid"]) ? $_GET["uid"] : "";
        $limit = isset($_GET["limit"]) ? $_GET["limit"] : "";
        $offset = isset($_GET["offset"]) ? $_GET["offset"] : "";
        return [
            "uid" => $uid,
            "limit" => $limit,
            "offset" => $offset
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        if (
            !$parameters["uid"]
            || ($parameters["limit"] && !is_numeric($parameters["limit"]))
            || ($parameters["offset"] && !is_numeric($parameters["offset"]))
        ) {
            http_response_code(400);
            return [];
        }

        // fetch from database
        $sqlite = new SQLite(DATABASE);

        $query = "
            SELECT
                i.id,
                i.title,
                u.id as authorID,
                u.name as author,
                i.created,
                i.updated,
                (SELECT COUNT() FROM IDEALIKES l WHERE l.idea = i.id GROUP BY l.idea) as likes,
                (SELECT COALESCE(GROUP_CONCAT(t.name, ','), '') FROM TAGS t WHERE t.idea = i.id GROUP BY t.idea) as tags
            FROM 
                IDEAS i
                LEFT JOIN USERS u
                ON i.author = u.id
            WHERE
                u.id = :uid
            ORDER BY
                i.updated DESC,
                i.title ASC
            ";
        $query_params = [":uid" => $parameters["uid"]];

        // set limiters according to parameters
        if ($parameters["limit"] && $parameters["offset"]) {
            $query .= "LIMIT :limit OFFSET :offset;";
            $query_params[":limit"] = $parameters["limit"];
            $query_params[":offset"] = $parameters["offset"];
        } elseif ($parameters["limit"]) {
            $query .= "LIMIT :limit";
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

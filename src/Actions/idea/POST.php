<?php

namespace Actions\idea;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $title = isset($_POST["title"]) ? $_POST["title"] : "";
        $content = isset($_POST["content"]) ? $_POST["content"] : "";
        $tags = isset($_POST["tags"]) ? $_POST["tags"] : "";
        $date = date("Y-m-d H:i:s");
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        return [
            "id" => $id,
            "title" => $title,
            "content" => $content,
            "tags" => $tags,
            "date" => $date,
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

        // title is required
        if (!$parameters["title"]) {
            http_response_code(400);
            return [];
        }

        $sqlite = new SQLite(DATABASE);
        $uid = Token::payload($parameters["token"])["uid"];
        $rid = "";

        // if id is not given, insert new idea
        if (!$parameters["id"]) {
            $query = "
                INSERT INTO IDEAS(title, content, author, created, updated)
                VALUES(:title, :content, :author, :date, :date);";
            $query_params = [
                ":title" => $parameters["title"],
                ":content" => $parameters["content"],
                ":author" => $uid,
                ":date" => $parameters["date"]
            ];
            $sqlite->execute($query, $query_params);

            // insert tags
            if ($parameters["tags"]) {
                $rid = $sqlite->execute("SELECT last_insert_rowid() as rid;")[0]["rid"];

                $tags = explode(",", $parameters["tags"]);
                foreach ($tags as $tag) {
                    if ($tag) {
                        $query = "INSERT INTO TAGS(idea,name) VALUES(:rid, :name);";
                        $query_params = [
                            ":rid" => $rid,
                            ":name" => $tag
                        ];
                        $sqlite->execute($query, $query_params);
                    }
                }
            }
        } else {
            // if id is given update the entry
            $rid = $parameters["id"];
            $query = "UPDATE IDEAS SET title = :title, content = :content, updated = :date WHERE author = :author AND id = :id;";
            $query_params = [
                ":title" => $parameters["title"],
                ":content" => $parameters["content"],
                ":date" => $parameters["date"],
                ":author" => $uid,
                ":id" => $rid
            ];
            $sqlite->execute($query, $query_params);

            // insert tags
            if ($parameters["tags"]) {
                $sqlite->execute("DELETE FROM TAGS WHERE idea = :rid", [":rid" => $rid]);

                $tags = explode(",", $parameters["tags"]);
                foreach ($tags as $tag) {
                    if ($tag) {
                        $query = "INSERT INTO TAGS(idea,name) VALUES(:rid, :name);";
                        $query_params = [
                            ":rid" => $rid,
                            ":name" => $tag
                        ];
                        $sqlite->execute($query, $query_params);
                    }
                }
            }
        }

        // check for error
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

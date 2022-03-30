<?php

namespace Actions\comment;

use base\Action;
use Helpers\SQLite;
use Helpers\Token;

class POST extends Action {

    protected function parameters(): array {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $idea = isset($_POST["idea"]) ? $_POST["idea"] : "";
        $content = isset($_POST["content"]) ? $_POST["content"] : "";
        $token = isset($_POST["token"]) ? $_POST["token"] : "";
        $date = date("Y-m-d H:i:s");
        return [
            "id" => $id,
            "idea" => $idea,
            "content" => $content,
            "token" => $token,
            "date" => $date
        ];
    }

    protected function action(array $parameters): array {
        // check parameters
        $verified = Token::verify($parameters["token"]);

        if (!$verified) {
            http_response_code(403);
            return [];
        }

        if (!$parameters["content"] || (!$parameters["id"] && !$parameters["idea"])) {
            http_response_code(400);
            return [];
        }

        // write to database
        $uid = Token::payload($parameters["token"])["uid"];
        $sqlite = new SQLite(DATABASE);

        if (!$parameters["id"]) {
            // insert new Idea
            $query = "
                INSERT INTO COMMENTS(idea, content, author, created, updated)
                VALUES(:idea, :content, :author, :date, :date);
            ";
            $query_params = [
                ":idea" => $parameters["idea"],
                ":content" => $parameters["content"],
                ":author" => $uid,
                ":date" => $parameters["date"]
            ];
            $sqlite->execute($query, $query_params);
        } else {
            // update existing comment
            $query = "UPDATE COMMENTS SET content = :content, updated = :updated WHERE id = :id AND author = :author;";
            $query_params = [
                ":content" => $parameters["content"],
                ":updated" => $parameters["date"],
                ":id" => $parameters["id"],
                ":author" => $uid
            ];
            $sqlite->execute($query, $query_params);
        }

        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

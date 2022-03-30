<?php

namespace Actions\register;

use base\Action;
use Helpers\SQLite;

class POST extends Action {

    protected function parameters(): array {
        $username = isset($_POST["username"]) ? $_POST["username"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        return [
            "username" => $username,
            "password" => $password,
            "email" => $email
        ];
    }

    protected function action(array $parameters): array {
        // verify parameters
        if (
            !$parameters["username"]
            || !$parameters["password"]
            || !$parameters["email"]
            || !filter_var($parameters["email"], FILTER_VALIDATE_EMAIL)
        ) {
            http_response_code(400);
            return [];
        }

        // insert to table
        $sqlite = new SQLite(DATABASE);
        $query = "INSERT INTO USERS(name, hash, email, github, role) VALUES(:name, :hash, :email, :github, :role);";
        $query_params = [
            ":name" => $parameters["username"],
            ":hash" => password_hash($parameters["password"], PASSWORD_DEFAULT),
            ":email" => $parameters["email"],
            ":github" => "",
            ":role" => "user"
        ];
        $sqlite->execute($query, $query_params);

        // check for errors
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        return [];
    }
}

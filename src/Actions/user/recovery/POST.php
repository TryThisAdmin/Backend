<?php

namespace Actions\user\recovery;

use base\Action;
use Helpers\SQLite;

class POST extends Action {

    protected function parameters(): array {
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        return [
            "email" => $email
        ];
    }

    protected function action(array $parameters): array {
        // check params
        if (!$parameters["email"] || !filter_var($parameters["email"], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            return [];
        }

        $sqlite = new SQLite(DATABASE);

        // Check for user with email
        $query = "SELECT * FROM USERS WHERE email = :email";
        $query_params = [":email" => $parameters["email"]];

        $userExists = $sqlite->execute($query, $query_params) != array();
        if (!$userExists) {
            http_response_code(403);
            return [];
        }


        // generate recovery password
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $password = "";
        for ($i = 0; $i < 8; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // update password
        $query = "UPDATE USERS SET hash = :hash WHERE email = :email;";
        $query_params = [
            ":hash" => $hash,
            ":email" => $parameters["email"]
        ];

        $sqlite->execute($query, $query_params);

        // check for errors
        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        // send email
        $message = "Your recovery password is '{$password}'.\r\nPlease login into your account and change it.";
        $subject = "Password recovery";
        mail($parameters["email"], $subject, $message);

        return [];
    }
}

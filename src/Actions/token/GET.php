<?php
namespace Actions\token;

use base\Action;
use Helpers\Token;
use Helpers\User;

class GET extends Action {

    protected function parameters ():array {
        $username = isset($_GET["username"]) ? $_GET["username"] : "";
        $password = isset($_GET["password"]) ? $_GET["password"] : "";
        return [
            "username"=>$username,
            "password"=>$password
        ];
    }

    protected function action (array $parameters):array {
        // check parameters
        if(!$parameters["username"] || !$parameters["password"]) {
            http_response_code(400);
            return [];
        }

        // check credentials
        $verified = User::verify($parameters["username"], $parameters["password"]);
        if(!$verified) {
            http_response_code(403);
            return [];
        }
        
        // generate token
        $token = Token::generate(User::get($parameters["username"])["id"], User::get($parameters["username"])["role"]);
        return ["token"=>$token];
    }
}
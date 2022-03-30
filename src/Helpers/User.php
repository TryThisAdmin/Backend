<?php
namespace Helpers;

class User {

    public static function verify (string $username, string $password) {
        $sqlite = new SQLite(DATABASE);
        $entries = $sqlite->execute("SELECT * FROM USERS WHERE name = :name", [":name"=>$username]);

        foreach ($entries as $entry) {
            if(password_verify($password, $entry["hash"])) return true;
        }
        return false;
    }

    public static function get (string $username) {
        $sqlite = new SQLite(DATABASE);
        $entries = $sqlite->execute("SELECT * FROM USERS WHERE name = :name", [":name"=>$username]);

        foreach ($entries as $entry) {
            if($entry["name"] === $username) return $entry;
        }
        return [];
    }

}
<?php

namespace Actions\info\tags;

use base\Action;
use Helpers\SQLite;

class GET extends Action {

    protected function parameters(): array {
        return [];
    }

    protected function action(array $parameters): array {
        $sqlite = new SQLite(DATABASE);
        $query = "SELECT DISTINCT name FROM TAGS ORDER BY name ASC;";

        $data = $sqlite->execute($query);

        if ($sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        if($data == []) {
            return ["entries"=>[]];
        }

        $data = array_map(function ($a) {
            return $a["name"];
        }, $data);

        return ["entries" => $data];
    }
}

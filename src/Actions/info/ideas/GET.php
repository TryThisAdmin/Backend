<?php

namespace Actions\info\ideas;

use base\Action;
use Helpers\SQLite;

class GET extends Action {

    protected function parameters(): array {
        return [];
    }

    protected function action(array $parameters): array {
        $sqlite = new SQLite(DATABASE);

        $query = "SELECT COUNT() as cnt FROM IDEAS;";
        $data = $sqlite->execute($query);

        if ($data == [] || $sqlite->getError()) {
            http_response_code(500);
            return [];
        }

        $count = $data[0]["cnt"];
        return ["ideas" => $count];
    }
}

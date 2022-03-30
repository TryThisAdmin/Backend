<?php

namespace Helpers;

use PDO;
use Exception;
use PDOException;

class SQLite {
    private PDO $PDO;
    private ?Exception $db_error = null;

    /**
     * @param string $path path to database
     */
    public function __construct(string $path) {
        $this->connect($path);
    }

    private function connect(string $path) {
        $this->PDO = new PDO("sqlite:" . $path);
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->PDO->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);
    }

    /**
     * Executes a SQL query and return the result as array
     * @param string $query query to be executed
     * @param array $params query parameters like [":id"=>"1"];
     * @return array Result of the query
     */
    public function execute(string $query, array $params = []): array {
        // check params for invalid formats
        $secure_params = array_reduce($params, function ($a, $b) {
            $valid = is_string($b) || is_numeric($b);
            return $a && $valid;
        }, true);

        if (!$secure_params) {
            $this->db_error = new PDOException("Parameters are not string or number");
            return [];
        }

        // start transaction
        try {
            $this->PDO->exec("PRAGMA foreign_keys = ON"); // ensures foreign key support
            $this->PDO->beginTransaction();
            $statement = $this->PDO->prepare($query);
            $statement->execute($params);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->PDO->commit();
            return $data;
        } catch (Exception $e) {
            $this->db_error = $e;
            $this->PDO->rollBack();
            return [];
        }
    }

    /**
     * Gets the last error in operation
     */
    public function getError(): ?Exception {
        return $this->db_error;
    }
}

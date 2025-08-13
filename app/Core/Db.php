<?php

namespace App\Core;

use PDO;

class Db
{
    private PDO $db;
    private static $instance;

    public function __construct()
    {
        $config = require $_SERVER['DOCUMENT_ROOT'] . '/app/config/db.php';
        $this->db = new PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
            $config['user'],
            $config['password']
        );
    }

    public static function getInstance(): object
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query($sql, $params = []): false | \PDOStatement
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                if (is_int($val)) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
                $stmt->bindValue(':' . $key, $val, $type);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []): array
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []): int
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}

<?php

namespace Util;
use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private static Database $_instance;

    private PDO $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost:3306;dbname=ticketing_app;charset=utf8mb4', 'root', null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function execute($sql, $params = null): PDoStatement
    {
        if (!is_null($params)) {
            foreach ($params as $key => $value) {
                if (is_string($value)) {
                    $params[$key] = htmlspecialchars($value);
                }
            }
        }
        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public function lastInsertId(): int {
        return $this->pdo->lastInsertId();
    }

    public static function get(): Database
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }
}
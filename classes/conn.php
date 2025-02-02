<?php

class Dbconnection
{
    private static $instance = null;
    private $pdo;

    private function __construct($dsn, $username, $password)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            throw new Exception('Connection unsuccessfully!' . $e->getMessage());
        }
    }

    static function getInstance($dsn = null, $username = null, $password = null)
    {
        if (self::$instance == null) {
            $dsn = $dsn ?? 'mysql:host=localhost;dbname=youdemy';
            $username = $username ?? 'root';
            $password = $password ?? '';
            self::$instance = new Dbconnection($dsn, $username, $password);
        }
        return self::$instance;
    }

    function getConnection()
    {
        return $this->pdo;
    }
}

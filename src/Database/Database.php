<?php

namespace AssistensTestTask\Database;

use Config\Env;
use PDO;
use PDOException;

/**
 * Represents a singleton database connection manager.
 *
 * This class is designed to manage and provide a single database connection instance
 * using the PHP Data Objects (PDO) extension. It ensures that only one instance of
 * the Database class is created and provides a consistent entry point to interact
 * with the database connection.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $conn;

    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . self::getDBHost() . ";dbname=" . self::getDBName(),
                self::getDBUsername(), self::getDBPassword()
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }

    public static function getDBHost()
    {
        return Env::get('DB_HOST', 'db');
    }

    public static function getDBName()
    {
        return Env::get('DB_NAME', 'assistant-test-task;');
    }

    public static function getDBUsername()
    {
        return Env::get('DB_USERNAME', 'root');
    }

    public static function getDBPassword()
    {
        return Env::get('DB_PASSWORD', 'root');
    }
}
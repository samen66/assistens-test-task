<?php

namespace AssistensTestTask\Database\Migrations;

use AssistensTestTask\Database\Database;
use PDOException;

class CreateUsersTable
{
    public static function up(): void
    {
        $db = Database::getInstance()->getConnection();

        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            email_verified BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        try {
            $db->exec($sql);
            echo "Таблица users создана успешно!\n";
        } catch (PDOException $e) {
            die("Ошибка создания таблицы: " . $e->getMessage());
        }
    }
}
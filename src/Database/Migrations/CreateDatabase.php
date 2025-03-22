<?php

namespace AssistensTestTask\Database\Migrations;

use AssistensTestTask\Database\Database;
use PDO;
use PDOException;

class CreateDatabase
{
    public static function up(): void
    {
        $dbname = Database::getDBName();

        try {
            // Подключение без указания базы данных для ее создания
            $pdo = new PDO(
                "mysql:host=" . Database::getDBHost(),
                Database::getDBUsername(),
                Database::getDBPassword()
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Создание базы данных, если она не существует
            $sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $pdo->exec($sql);

            echo "База данных '$dbname' успешно создана (если не существовала).\n";

        } catch (PDOException $e) {
            echo "Ошибка при создании базы данных: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
}
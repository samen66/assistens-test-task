<?php

use AssistensTestTask\Database\Migrations\CreateDatabase;
use AssistensTestTask\Database\Migrations\CreateUsersTable;

require_once __DIR__ . '/vendor/autoload.php';

echo "Запуск миграций...\n";

// Создаем базу данных
CreateDatabase::up();

// Создаем таблицы
CreateUsersTable::up();

echo "Миграции завершены!\n";
?>

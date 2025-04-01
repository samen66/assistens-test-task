#!/bin/bash

# Ждем, пока MySQL будет готов
until mysql -u root -proot -h db -e "SELECT 1" 2>/dev/null; do
    echo "Ожидание готовности MySQL (хост: db)..."
    sleep 2
done

# Запускаем миграции
echo "Запуск миграций..."
php migration.php || {
    echo "Ошибка при выполнении миграций, завершение контейнера."
    exit 1
}

echo "Миграции успешно завершены, запуск Apache..."
exec "$@"

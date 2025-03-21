<?php

namespace Config;

/**
 * Loads and retrieves .env configuration variables.
 */
class Env
{
    private static array $config = [];

    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Файл .env не найден: " . $filePath);
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue; // Пропуск комментариев
            }

            [$key, $value] = explode('=', $line, 2);
            self::$config[trim($key)] = trim($value);
        }
    }

    public static function get(string $key, $default = null)
    {
        return self::$config[$key] ?? $default;
    }
}
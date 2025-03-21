<?php

namespace AssistensTestTask\Services\Auth;

use AssistensTestTask\Services\Auth\SessionManagerInterface;

class SessionManager implements SessionManagerInterface
{

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Запускаем сессию, если она не запущена
        }
    }
    public function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    public function clear(): void {
        session_destroy();
    }

}
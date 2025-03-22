<?php

namespace AssistensTestTask\Middleware;

use AssistensTestTask\Services\Auth\AuthenticatorInterface;

class AuthMiddleware
{
    private AuthenticatorInterface $authenticator;

    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function handle(): void
    {
        // Проверяем, авторизован ли пользователь
        if (!$this->authenticator->check()) {
            header("Location: /login");
            exit();
        }
    }

}
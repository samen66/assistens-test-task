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
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Unauthorized access. Please log in.']);
            exit;
        }
    }

}
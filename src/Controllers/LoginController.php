<?php

namespace AssistensTestTask\Controllers;

use AssistensTestTask\Services\Auth\AuthenticatorInterface;

class LoginController
{
    private AuthenticatorInterface $authenticator;

    public function __construct(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function login(string $email, string $password): string
    {
        if ($this->authenticator->login($email, $password)) {
            header('Location: /users-page');
            exit();
        }

        http_response_code(401);
        return json_encode(['error' => 'Invalid credentials.']);
    }

    public function logout(): void
    {
        $this->authenticator->logout();
        header('Location: /login');
        exit();
    }

    public function getLoginPage(): bool|string
    {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/login.html');
    }

}
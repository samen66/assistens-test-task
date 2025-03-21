<?php

namespace AssistensTestTask\Services\Auth;

use AssistensTestTask\Exceptions\UserNotFoundException;
use AssistensTestTask\Services\UserService;

class Authenticator implements AuthenticatorInterface
{
    private SessionManagerInterface $sessionManager;
    private UserService $userService;

    public function __construct(SessionManagerInterface $sessionManager, UserService $userService)
    {
        $this->sessionManager = $sessionManager;
        $this->userService = $userService;
    }

    public function login(string $username, string $password): bool
    {

        try {
            $user = $this->userService->findByEmail($username);
        } catch (UserNotFoundException $e) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            // Сохраняем информацию о пользователе в сессии
            $this->sessionManager->set('user_id', $user->getId());
            return true;
        }

        return false; // Неверные данные
    }

    public function logout(): bool
    {
        $this->sessionManager->clear();
        return true;
    }

    public function check(): bool
    {
        return $this->sessionManager->get('user_id') !== null;
    }

}
<?php

namespace AssistensTestTask\Controllers;

use AssistensTestTask\Exceptions\UserNotFoundException;
use AssistensTestTask\Models\User;
use AssistensTestTask\Services\UserService;

class RegisterController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(string $name, string $email, string $password): string
    {
        $user = User::createWithoutId($name, $email, $password);

        // Проверка существования email
        try {
            $this->userService->findByEmail($email);
            return json_encode([
                'errors' => [
                    'email' => 'Email already exists'
                ]
            ]);
        } catch (UserNotFoundException $e) {
            // Если email еще не существует
            if ($this->userService->create($user)) {
                header('Location: /login');
                exit();
            }

            return json_encode(['error' => 'Registration failed.']);
        }
    }

}

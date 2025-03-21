<?php

namespace AssistensTestTask\Services\Auth;

use AssistensTestTask\Exceptions\UserNotFoundException;
use AssistensTestTask\Services\UserService;

class Authorization
{
    private SessionManagerInterface $sessionManager;
    private UserService $userService;

    public function __construct(SessionManagerInterface $sessionManager, UserService $userService) {
        $this->sessionManager = $sessionManager;
        $this->userService = $userService;
    }

    public function canAccess(string $permission): bool {
        $userId = $this->sessionManager->get('user_id');
        if (!$userId) {
            return false; // Неавторизованный пользователь
        }

        try {
            $user = $this->userService->findById($userId);
        } catch (UserNotFoundException $e) {
            return false;
        }
        return in_array($permission, $user->getPermissions(), true);
    }

}
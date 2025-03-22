<?php

namespace AssistensTestTask\Controllers;

use AssistensTestTask\Exceptions\UserNotFoundException;
use AssistensTestTask\Models\User;
use AssistensTestTask\Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllUsers(int $page = 1, int $pageSize = 10): void
    {
        $users = $this->userService->getAllUsers($page, $pageSize);
        echo json_encode($users);
    }

    public function getUser(int $id): void
    {
        try {
            $user = $this->userService->findById($id);
            echo json_encode($user->toArray());
        } catch (UserNotFoundException $e) {
//            http_response_code(404);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function createUser(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = User::createWithoutId($data['name'], $data['email'], $data['password']);
        $createdUser = $this->userService->create($user);
        echo json_encode($createdUser->toArray());
    }

    public function updateUser(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $this->userService->updateUser($id, $data['name'], $data['email']);
            echo json_encode(['success' => true]);
        } catch (UserNotFoundException $e) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found.']);
        }
    }

    public function deleteUser(int $id): void
    {
        if ($this->userService->deleteUser($id)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found.']);
        }
    }
}
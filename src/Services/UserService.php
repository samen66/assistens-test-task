<?php

namespace AssistensTestTask\Services;

use AssistensTestTask\Exceptions\UserNotFoundException;
use AssistensTestTask\Models\User;
use AssistensTestTask\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @throws UserNotFoundException
     */
    public function findByEmail(string $email): User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Retrieves a user by their unique identifier.
     *
     * @param int $userId The unique identifier of the user to be retrieved.
     * @return User The user object corresponding to the given identifier.
     * @throws UserNotFoundException
     */
    public function findById(int $userId): User
    {
        return $this->userRepository->findById($userId);
    }

    public function create(User $user): User
    {
        return $this->userRepository->create($user);
    }

    public function getAllUsers(int $page = 1, int $pageSize = 10): array
    {
        return $this->userRepository->getAllUsers($page, $pageSize);
    }

    /**
     * @throws UserNotFoundException
     */
    public function updateUser(int $userId, string $name, string $email): bool
    {
        return $this->userRepository->updateUser($userId, $name, $email);
    }

    public function deleteUser(int $userId): bool
    {
        return $this->userRepository->deleteUser($userId);
    }
}
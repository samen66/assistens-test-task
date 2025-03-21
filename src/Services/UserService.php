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

    public function create(User $user): User {
        return $this->userRepository->create($user);
    }
}
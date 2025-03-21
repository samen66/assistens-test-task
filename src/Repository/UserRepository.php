<?php

namespace AssistensTestTask\Repository;

use AssistensTestTask\Database\Database;
use AssistensTestTask\Exceptions\UserNotFoundException;
use AssistensTestTask\Models\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Creates a new record in the database for the given user.
     *
     * @param User $user The user object containing details to be inserted into the database.
     * @return User Returns true if the insertion was successful, false otherwise.
     */
    public function create(User $user): User
    {
        $stmt = $this->db->prepare("INSERT INTO " . User::$tableName . " (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
        ]);

        $userId = (int)$this->db->lastInsertId();
        $user->setId($userId);

        return $user;
    }

    /**
     * Retrieves a user from the database by their email address.
     *
     * @param string $email The email address of the user to retrieve.
     * @return User Returns the User object corresponding to the provided email address.
     * @throws UserNotFoundException If no user is found with the given email address.
     */
    public function findByEmail(string $email): User
    {
        $stmt = $this->db->prepare("SELECT * FROM " . User::$tableName . " WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new UserNotFoundException("User with email {$email} not found.");
        }

        return new User(
            $result['id'],
            $result['name'],
            $result['email'],
            $result['password']
        );
    }

    /**
     * Retrieves a user by their unique ID.
     *
     * @param int $userId The unique identifier for the user.
     *
     * @return User Returns an instance of the User object corresponding to the provided ID.
     *
     * @throws UserNotFoundException Thrown if no user is found with the given ID.
     */
    public function findById(int $userId): User
    {

        $stmt = $this->db->prepare("SELECT * FROM " . User::$tableName . " WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new UserNotFoundException("User with ID {$userId} not found.");
        }

        return new User(
            $result['id'],
            $result['name'],
            $result['email'],
            $result['password']
        );
    }
}
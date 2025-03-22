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

    public function getAllUsers(int $page = 1, int $pageSize = 10): array
    {
        $offset = ($page - 1) * $pageSize;
        $stmt = $this->db->prepare("SELECT * FROM " . User::$tableName . " LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        $data['total'] = $this->db->query("SELECT COUNT(*) FROM " . User::$tableName)->fetchColumn();
        $data['users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['page'] = $page;
        $data['pageSize'] = $pageSize;
        return $data;
    }

    /**
     * @throws UserNotFoundException
     */
    public function updateUser(int $userId, string $name, string $email): bool
    {
        $stmt = $this->db->prepare("UPDATE " . User::$tableName . " SET name = :name, email = :email WHERE id = :id");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'id' => $userId,
        ]);

        if ($stmt->rowCount() === 0) {
            throw new UserNotFoundException("User with ID {$userId} not found.");
        }
        return true;
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM " . User::$tableName . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
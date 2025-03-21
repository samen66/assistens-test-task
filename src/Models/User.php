<?php

namespace AssistensTestTask\Models;

/**
 * Represents a user with an ID, name, email, and password.
 */
class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;

    public static string $tableName = "users";

    /**
     * Constructor method for initializing the class properties.
     *
     * @param int|null $id The unique identifier for the user.
     * @param string $name The name of the user.
     * @param string $email The email address of the user.
     * @param string $password The password for the user account.
     */
    public function __construct(?int $id, string $name, string $email, string $password)
    {
        if ($id !== null) {
            $this->setId($id);
        }
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    public static function createWithId(int $id, string $name, string $email, string $password): self
    {
        return new self($id, $name, $email, $password);
    }

    public static function createWithoutId(string $name, string $email, string $password): self
    {
        return new self(null, $name, $email, $password);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPermissions()
    {
        //TODO: create Permissions modal
    }


}
<?php

namespace AssistensTestTask\Services\Auth;

interface AuthenticatorInterface
{
    public function login(string $username, string $password): bool;
    public function logout(): bool;
    public function check(): bool;

}
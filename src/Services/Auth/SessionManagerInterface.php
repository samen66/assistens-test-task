<?php

namespace AssistensTestTask\Services\Auth;

interface SessionManagerInterface
{
    public function set(string $key, $value): void;
    public function get(string $key);
    public function remove(string $key): void;
    public function clear(): void;

}
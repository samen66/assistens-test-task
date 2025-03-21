<?php

namespace AssistensTestTask\Middleware;

use AssistensTestTask\Security\CsrfProtection;

class CsrfMiddleware
{
    private CsrfProtection $csrfProtection;

    public function __construct(CsrfProtection $csrfProtection)
    {
        $this->csrfProtection = $csrfProtection;
    }

    public function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if (!$this->csrfProtection->verifyToken($token)) {
                http_response_code(403); // Forbidden
                echo json_encode(['error' => 'Invalid CSRF token.']);
                exit;
            }
        }
    }
}
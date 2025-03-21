<?php

namespace AssistensTestTask\Security;

use AssistensTestTask\Services\Auth\SessionManager;

class CsrfProtection
{
    private SessionManager $sessionManager;

    /**
     * @param SessionManager $sessionManager
     */
    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function generateToken(): string {
        $this->sessionManager->start();

        if (!$this->sessionManager->get('csrf_token')) {
            $this->sessionManager->set('csrf_token', bin2hex(random_bytes(32)));
        }

        return $this->sessionManager->get('csrf_token');
    }

   public function verifyToken(string $token): bool {
       $this->sessionManager->start();
       $csrfToken = $this->sessionManager->get('csrf_token');
       if ($csrfToken === null) {
           return false;
       }
       return hash_equals($csrfToken, $token);
   }
}
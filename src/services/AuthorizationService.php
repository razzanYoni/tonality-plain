<?php

namespace services;

use bases\BaseService;

class AuthorizationService extends BaseService
{
    protected static BaseService $instance;
    private BaseService $userService;

    private function __construct()
    {
        $this->userService = UserService::getInstance();
    }

    public static function getInstance(): AuthorizationService
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function isLogin(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin(): bool
    {
        return $this->isLogin() && $_SESSION['is_admin'];
    }

    public function getUserService(): BaseService|UserService
    {
        return $this->userService;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
    }

    public function getCurrentUser()
    {
        if (!$this->isLogin()) {
            return null;
        }

        return $this->userService->getById($_SESSION['user_id']);
    }
}
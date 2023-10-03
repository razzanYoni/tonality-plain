<?php

namespace services;

use bases\BaseService;

class AuthService extends BaseService {
    private static $instance;
    private $userService;

    private function __construct() {
        $this->userService = UserService::getInstance();
    }

    public static function getInstance() : AuthService {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function isLogin() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin() {
        return $this->isLogin() && $_SESSION['is_admin'];
    }

    public function getUserService() {
        return $this->userService;
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['is_admin']);
    }

    public function getCurrentUser() {
        if (!$this->isLogin()) {
            return null;
        }

        return $this->userService->getById($_SESSION['user_id']);
    }
}
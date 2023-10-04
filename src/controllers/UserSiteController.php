<?php

namespace controllers;

require_once ROOT_DIR . "src/controllers/auth/RegisterController.php";
require_once ROOT_DIR . "src/middlewares/AuthMiddleware.php";

use bases\BaseController;
use controllers\auth\RegisterController;
use controllers\auth\LoginController;

class UserSiteController extends BaseController {
    protected static UserSiteController $instance;
    protected LoginController $loginController;
    protected RegisterController $registerController;

    public function __construct() {
        $this->loginController = LoginController::getInstance();
        $this->registerController = RegisterController::getInstance();
        // jangan lupa tambahin fungsi yang bisa dilakuin user
        $this->registerMiddleware(new \middlewares\AuthMiddleware(['']));
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getLoginController() {
        return $this->loginController;
    }
    public function getRegisterController() {
        return $this->registerController;
    }
}
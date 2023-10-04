<?php

namespace controllers;

require_once ROOT_DIR . "src/controllers/auth/RegisterController.php";
require_once ROOT_DIR . "src/middlewares/AuthMiddleware.php";
require_once ROOT_DIR . "src/controllers/auth/LogoutController.php";

use bases\BaseController;
use controllers\auth\LogoutController;
use controllers\auth\RegisterController;
use controllers\auth\LoginController;

class UserSiteController extends BaseController {
    protected static UserSiteController $instance;
    protected static LoginController $loginController;
    protected static RegisterController $registerController;
    protected static LogoutController $logoutController;

    public function __construct() {
        self::$loginController = LoginController::getInstance();
        self::$registerController = RegisterController::getInstance();
        self::$logoutController = LogoutController::getInstance();
        // jangan lupa tambahin fungsi yang bisa dilakuin user
        $this->registerMiddleware(new \middlewares\AuthMiddleware(['home']));
    }

    public function home()
    {
        return $this->render('home', [
            'name' => 'Your Name'
        ]);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public static function getLoginController() {
        return self::$loginController;
    }
    public static function getRegisterController() {
        return self::$registerController;
    }

    public static function getLogoutController() {
        return self::$logoutController;
    }

    public function __toString(): string
    {
        return 'UserSiteController';
    }
}
<?php

namespace controllers\auth;

require_once ROOT_DIR . "src/bases/BaseController.php";

use bases\BaseController,
    cores\Request,
    cores\Application;
use cores\Response;

class LogoutController extends BaseController {
    protected static LogoutController $instance;
    public function logout (Request $request, Response $response) {
        Application::$app->logout();
        $response->redirect('/login');
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
<?php

namespace controllers\auth;

require_once ROOT_DIR . "src/bases/BaseController.php";
require_once ROOT_DIR . "src/models/LoginForm.php";

use bases\BaseController,
    cores\Request,
    models\LoginForm,
    cores\Application;

class LoginController extends BaseController {
    protected static LoginController $instance;
    public function login (Request $request) {
        $loginForm = new LoginForm();
        if ($request->getMethod() === 'post') {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()[0]) {
                if (!$loginForm->login()[1]) {
                    // Not Admin
                    Application::$app->response->redirect('/');
                } else {
                    // Admin
                    Application::$app->response->redirect('/homeAdmin'); //homeAdmin
                }
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}

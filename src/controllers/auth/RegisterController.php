<?php

namespace controllers\auth;

require_once ROOT_DIR . "src/bases/BaseController.php";
require_once ROOT_DIR . "src/models/UserModel.php";

use bases\BaseController,
    cores\Request,
    cores\Application;
use models\UserModel;

class RegisterController extends BaseController {
    protected static RegisterController $instance;
    public function register (Request $request) {
        $registerModel = new UserModel();
        if ($request->getMethod() === 'post') {
            $registerModel->loadData($request->getBody());
            if ($registerModel->validate() && $registerModel->insert()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/login');
                return 'Show success page';
            }
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $registerModel
        ]);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
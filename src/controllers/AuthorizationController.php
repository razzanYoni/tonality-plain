<?php

namespace controllers;

require_once ROOT_DIR . "src/bases/BaseController.php";
require_once ROOT_DIR . "src/models/UserLoginModel.php";

use bases\BaseController,
    cores\Application,
    cores\Request,
    cores\Response,
    models\UserLoginModel,
    models\UserModel;
use repositories\UserRepository;

class AuthorizationController extends BaseController
{
    public function __construct()
    {
    } // doesn't have middleware

    public function signup(Request $request)
    {

        if (isset(Application::$app->loggedUser)) {
            Application::$app->response->redirect('/');
            return;
        }

        $userRegisterModel = new UserModel();

        if ($request->getMethod() === 'post') {

            $userRegisterModel->loadData($request->getBody());

            if ($userRegisterModel->validate() && UserRepository::getInstance()
                    ->insert(
                        $userRegisterModel->toArray()
                    )
            ) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/login');
                return 'Show success page';
            }
        }

        // Method : GET
        $this->setLayout('authorization');
        return $this->render('authorization/Signup', [
            'view' => [
                'model' => $userRegisterModel,
                ],
            'layout' => [
                'title' => 'Register'
            ]
        ]);
    }

    public function login(Request $request)
    {
        if (isset(Application::$app->loggedUser)) {
            Application::$app->response->redirect('/');
            return;
        }

        $userLoginModel = new UserLoginModel();

        if ($request->getMethod() === 'post') {
            $userLoginModel->loadData($request->getBody());
            if ($userLoginModel->validate() && $userLoginModel->login()) {
                Application::$app->response->redirect('/');
                return;
            }
        }

        // Method : GET
        $this->setLayout('authorization');
        return $this->render('authorization/Login', [
            'view' => [
                'model' => $userLoginModel,
                    ],
            'layout' => [
                'title' => 'Login'
            ]
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/login');
    }


    public function __toString(): string
    {
        return 'AuthorizationController';
    }
}
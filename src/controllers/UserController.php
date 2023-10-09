<?php

namespace controllers;

use bases\BaseController;
use cores\Application;
use cores\Request;
use middlewares\AdminMiddleware;
use repositories\UserRepository;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware(['getAllUsers', 'deleteUserById']));
    }

    public function getAllUsers(Request $request)
    {
        // Method : GET
        $requestBody = $request->getBody();

        $page = 1;
        if (isset($requestBody['page'])) {
            $page = $requestBody['page'];
        }

        $offset = ($page - 1) * ROWS_PER_PAGE;

        $user = UserRepository::getInstance()->getAllUsers(
            order: 'username',
            offset: $offset
        );

        $totalPage = ceil(UserRepository::getInstance()->getCountUsers() / ROWS_PER_PAGE);

        $this->setLayout('UserPage');
        return $this->render('user/user', [
            'view' => [
                'users' => $user,
                'page' => $page,
            ],
            'layout' => [
                'title' => 'User',
                'totalPage' => $totalPage,
                'page' => $page,
            ]
        ]);
    }

    public function deleteUserById(Request $request) {
        $user_id = $request->getRouteParam('user_id');
        if ($request->isDelete()) {
            if (UserRepository::getInstance()->delete($user_id)) {
                Application::$app->session->setFlash('success', 'User deleted successfully');
                Application::$app->response->redirect('/users');
            }
        }

        Application::$app->response->redirect('/users');
    }
}
<?php

namespace controllers;

use bases\BaseController;
use cores\Request;
use middlewares\AdminMiddleware;
use repositories\UserRepository;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware(['user', 'userById']));
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

        $this->setLayout('UserPage');
        return $this->render('user/user', [
            'view' => [
                'users' => $user,
            ],
            'layout' => [
                'title' => 'User'
            ]
        ]);
    }
}
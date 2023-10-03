<?php

namespace controllers\auth;

use bases\BaseController;
use bases\BaseService;
use services\UserService;

class CheckUsernameController extends BaseController
{
    /* @var UserService $service */
    protected BaseService $service;

    public static function getInstance($service): CheckUsernameController
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(UserService::getInstance());
        }
        return self::$instance;
    }

    public function post($urlParameters): void
    {
        $username = $_POST['username'];
        $user = $this->service->isUsernameExist($username);

        http_response_code(200);
        echo json_encode(array(
            'is_exists' => $user != null,
            'message' => $user != null ? 'Username already exists' : 'Username is available'
        ));
    }
}
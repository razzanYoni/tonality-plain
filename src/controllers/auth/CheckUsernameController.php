<?php

namespace controllers\auth;

use bases\BaseController,
    bases\BaseRepository,
    repositories\UserRepository;

class CheckUsernameController extends BaseController
{
    protected static CheckUsernameController $instance;
    public static function getInstance(): CheckUsernameController
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function post($urlParameters): void
    {
        $username = $_POST['username'];
        $user = UserRepository::getInstance()->getUserByUsername($username);

        http_response_code(200);
        echo json_encode(array(
            'is_exists' => $user != null,
            'message' => $user != null ? 'Username already exists' : 'Username is available'
        ));
    }
}
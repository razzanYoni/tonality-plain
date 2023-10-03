<?php

use bases\BaseController;
use services\UserService;

class CheckUsernameController extends BaseController {
    private static $instance;

    private function __construct($userService) {
        parent::__construct($userService);
    }
    
    public static function getInstance() : CheckUsernameController {
        if (!isset(self::$instance)) {
            self::$instance = new static(UserService::getInstance());
        }
        return self::$instance;
    }

    public function post($urlParameters) {
        $username = $_POST['username'];
        $user = $this->service->isUsernameExists($username);

        http_response_code(200);
        echo json_encode(array(
            'is_exists' => $user != null,
            'message' => $user != null ? 'Username already exists' : 'Username is available'
        ));

        return;
    }
}
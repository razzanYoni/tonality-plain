<?php

namespace models;

require_once ROOT_DIR . "src/cores/Model.php";
require_once ROOT_DIR . "src/repositories/UserRepository.php";
require_once ROOT_DIR . "src/models/UserModel.php";

use cores\Application,
    cores\Model,
    cores\UserAuth,
    repositories\UserRepository;

class UserLoginModel extends Model {
    public string $username = '';
    public string $password = '';

    public function rules()
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels()
    {
        return [
            'username' => 'Your username',
            'password' => 'Your Password'
        ];
    }

    public function login() {
        $userAuth = new UserAuth();
        $userModel = new UserModel();
        $user = UserRepository::getInstance()->getUserByUsername($this->username);
        $userModel->constructFromArray($user);

        if (!$user) {
            $this->addError('username', 'User does not exist with this username');
            return false;
        }

        if (!password_verify($this->password, $userModel->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        $userAuth->constructFromArray($user);

        return Application::$app->login($userAuth);
    }
}
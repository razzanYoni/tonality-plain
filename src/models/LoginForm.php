<?php

namespace models;

require_once ROOT_DIR . "src/cores/Model.php";
require_once ROOT_DIR . "src/repositories/UserRepository.php";

use cores\Application;
use cores\Model;
use repositories\UserRepository;

class LoginForm extends Model {
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

        return Application::$app->login($userModel);
    }
}
<?php

namespace models;

require_once ROOT_DIR . "src/bases/BaseModel.php";
require_once ROOT_DIR . "src/repositories/UserRepository.php";
require_once ROOT_DIR . "src/models/UserModel.php";

use bases\BaseModel;
use cores\Application;
use cores\UserAuth;
use repositories\UserRepository;

class UserLoginModel extends BaseModel
{
    protected string $username = '';
    protected string $password = '';

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password'
        ];
    }

    public function login(): bool|array
    {
        $userAuth = new UserAuth();
        $userModel = new UserModel();
        $user = UserRepository::getInstance()->getUserByUsername($this->username);

        if (!$user) {
            $this->addError('username', 'User does not exist with this username');
            return false;
        }

        $userModel->constructFromArray($user);
        if (!password_verify($this->password, $userModel->get('password'))) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }
        $userAuth->constructFromArray($user);

        return Application::$app->login($userAuth);
    }

    public function constructFromArray(array $data): UserLoginModel
    {
        $this->username = $data['username'];
        $this->password = $data['password'];
        return $this;
    }

    public function toArray(): array
    {
        return array(
            'username' => $this->username,
            'password' => $this->password,
        );
    }
}
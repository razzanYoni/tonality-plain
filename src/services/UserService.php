<?php

namespace services;

use bases\BaseService, models\UserModel, repositories\UserRepository;
use PDO, exceptions;

class UserService extends BaseService {
    private static $instance;

    private function __construct($repository) {
        parent::__construct();
        $this->repository = UserRepository::getInstance();
    }

    public static function getInstance() : UserService {
        if (!isset(self::$instance)) {
            self::$instance = new static(UserRepository::getInstance());
        }
        return self::$instance;
    }

    public function register($username, $password, $confirmation_password) {
        if ($password != $confirmation_password) {
            throw new exceptions\BadRequestException("Password doesn't match");
        }

        $user = (new UserModel(
            array(
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT, array('cost' => BCRYPT_COST))
            )
            ));

        if ($this->repository->getByUsername($username)) {
            throw new exceptions\BadRequestException("Username already exists");
        }

        $sqlReturn = $this->repository
        -> getById(
            $this->repository->insert
            (
                $user, 
                array(
                    'username' => PDO::PARAM_STR,
                    'password' => PDO::PARAM_STR,
                )
            )
        );

        $registeredUser = new UserModel(
            array(
                'user_id' => $sqlReturn['user_id'],
                'username' => $sqlReturn['username'],
            )
        );      

        return $registeredUser;      
    }

    public function login($username, $password) {
        $user = null;

        $user = $this->repository->getByUsername($username);

        if (!$user || is_null($user)) {
            throw new exceptions\BadRequestException("Username doesn't exist");
        }

        if (!password_verify($password, $user['password'])) {
            throw new exceptions\BadRequestException("Password doesn't match");
        }

        $user = new UserModel(
            array(
                'user_id' => $user['user_id'],
                'username' => $user['username'],
                'is_admin' => $user['is_admin'],
            )
        );

        $_SESSION['user'] = $user->get('user_id');
        $_SESSION['is_admin'] = $user->get('is_admin');

        return $user;
    }

    public function getByUsername($username) {
        $user = null;
        $sqlReturn = $this->repository->getByUsername($username);

        if ($sqlReturn) {
            $user = new UserModel(
                array(
                    'user_id' => $sqlReturn['user_id'],
                    'username' => $sqlReturn['username'],
                    'is_admin' => $sqlReturn['is_admin'],
                )
            );
        }
        $user = new UserModel(
            array(
                'username' => $username,
            )
        );
        return $user;
    }

    public function getById($user_id) {
        $user = null;
        $sqlReturn = $this->repository->getById($user_id);

        if ($sqlReturn) {
            $user = new UserModel(
                array(
                    'user_id' => $sqlReturn['user_id'],
                    'username' => $sqlReturn['username'],
                    'is_admin' => $sqlReturn['is_admin'],
                )
            );
        }

        return $user;
    }

    public function getAllUsers() {
        $userSQL = $this->repository->getAll();
        $users = array();
        foreach ($userSQL as $user) {
            $users[] = new UserModel(
                array(
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'is_admin' => $user['is_admin'],
                )
            );
        }
        return $users;
    }

    public function isUsernameExist($username) { 
        $user = $this->repository->getByUsername($username);
        return !is_null($user);
    }
}
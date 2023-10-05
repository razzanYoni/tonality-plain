<?php

namespace repositories;

require_once ROOT_DIR . "src/bases/BaseRepository.php";

use bases\BaseRepository;

class UserRepository extends BaseRepository
{
    protected static BaseRepository $instance;
    public static function tableName(): string
    {
        return 'users';
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function getUserById($user_id)
    {
        return $this->findOne(where : ["user_id" => $user_id]);
    }

    public function getUserByUsername($username)
    {
        return $this->findOne(where : ["username" => $username]);
    }
}
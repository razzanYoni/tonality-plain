<?php

namespace repositories;

use bases\BaseRepository;

class UserRepository extends BaseRepository
{
    protected string $table = "users";

    public static function getInstance(): UserRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function getById($user_id)
    {
        return $this->getOne(["user_id" => $user_id]);
    }

    public function getByUsername($username)
    {
        return $this->getOne(["username" => $username]);
    }
}
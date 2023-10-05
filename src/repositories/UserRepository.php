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

    public static function attributes(): array
    {
        return [
            'username',
            'password',
        ];
    }

    public static function primaryKey(): string
    {
        return 'user_id';
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getUserById($user_id)
    {
        return $this->findOne(where: ["user_id" => $user_id]);
    }

    public function getUserByUsername($username)
    {
        return $this->findOne(where: ["username" => $username]);
    }

    public function insert(array $data): bool
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return parent::insert($data);
    }
}
<?php

namespace models;

require_once ROOT_DIR . "src/bases/BaseModel.php";

use bases\BaseModel,
    cores,
    PDOException;

class UserModel extends BaseModel
{
    public $userId;
    public $username = '';
    public $password = '';
    public $passwordConfirm = '';
//    public $_isAdmin = 0;

    public static function primaryKey(): string
    {
        return 'user_id';
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes()
    {
        return [
            'username',
            'password',
        ];
    }

    public function constructFromArray(array $data): UserModel
    {
        $this->userId = $data['user_id'];
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->isAdmin = $data['is_admin'];
        return $this;
    }

    public function rules()
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'passwordConfirm' => [[self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function insert(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        echo 'masuk <br>';
        return parent::insert();
    }

    public function getUserByUsername($username)
    {
        return $this->findOne(where : ["username" => $username]);
    }

    public function toResponse(): array
    {
        return array(
            'user_id' => $this->_userId,
            'username' => $this->_username,
            'password' => $this->_password,
            'is_admin' => $this->_isAdmin
        );
    }
}
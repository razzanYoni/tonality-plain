<?php

namespace models;

require_once ROOT_DIR . "src/bases/BaseModel.php";

use bases\BaseModel;
use bases\BaseRepository;
use repositories\UserRepository;

class UserModel extends BaseModel
{
    protected $user_id;
    protected $username = '';
    protected $password = '';
    protected $password_confirm = '';

    public function getPassword() {
        return $this->password;
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'password_confirm' => 'Password Confirm'
        ];
    }

    public function constructFromArray(array $data): UserModel
    {
        $this->user_id = $data['user_id'];
        $this->username = $data['username'];
        $this->password = $data['password'];
        return $this;
    }

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => UserRepository::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            'password_confirm' => [[self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function toArray(): array
    {
        return array(
            'username' => $this->username,
            'password' => $this->password,
        );
    }
}
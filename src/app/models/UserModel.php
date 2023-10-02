<?php

namespace models;

use bases\BaseModel;

class UserModel extends BaseModel
{
    private $_userId;
    private $_username;
    private $_password;
    private $_isAdmin;

    public function __construct(array $data)
    {
        $this->constructFromArray($data);
        return $this;
    }

    public function constructFromArray(array $data): UserModel
    {
        $this->_userId = $data['user_id'];
        $this->_username = $data['username'];
        $this->_password = $data['password'];
        $this->_isAdmin = $data['is_admin'];
        return $this;
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
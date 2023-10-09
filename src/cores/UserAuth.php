<?php

namespace cores;

class UserAuth {
    private $user_id;
    private $username;
    private $is_admin;

    public function constructFromArray($array) {
        $this->user_id = $array['user_id'];
        $this->username = $array['username'];
        $this->is_admin = $array['is_admin'];
    }

    public function getUserId() {
        return $this->user_id;
    }
    public function getUsername() {
        return $this->username;
    }

    public function isAdmin() {
        return $this->is_admin;
    }
}
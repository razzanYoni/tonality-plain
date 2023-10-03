<?php

namespace repositories;

use bases\BaseRepository;

class UserRepository extends BaseRepository {
    private static $instance;
    private $table = "users";

    private function __construct() {
        parent::__construct();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new UserRepository();
        }
        return self::$instance;
    }

    public function getById($user_id) {
        return $this->getOne(["user_id" => $user_id]);
    }

    public function getByUsername($username) {
        return $this->getOne(["username" => $username]);
    }
}
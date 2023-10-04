<?php

namespace controllers;

require_once ROOT_DIR . 'src/middlewares/AdminMiddleware.php';

use bases\BaseController;

class AdminSiteController extends BaseController {
    protected static AdminSiteController $instance;
    public function __construct() {
        // jangan lupa tambahin fungsi yang bisa dilakuin user
        $this->registerMiddleware(new \middlewares\AdminMiddleware(['homeAdmin']));
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function homeAdmin()
    {
        return $this->render('homeAdmin', []);
    }

    public function __toString(): string
    {
        return 'AdminSiteController';
    }
}
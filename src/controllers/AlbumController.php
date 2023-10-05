<?php

namespace controllers;

require_once ROOT_DIR . "src/middlewares/AuthMiddleware.php";
require_once ROOT_DIR . "src/middlewares/AdminMiddleware.php";

use bases\BaseController,
    middlewares\AuthMiddleware,
    middlewares\AdminMiddleware;
use cores\Application;

class AlbumController extends BaseController {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware(['album']));
        $this->registerMiddleware(new AdminMiddleware(['albumAdmin']));
    }

    public function album()
    {
        // Method : GET
//        $this->setLayout('main');
        return $this->render('album/home', [
            'name' => Application::$app->loggedUser->getUsername()
        ]);
    }

    public function albumAdmin()
    {
        // Method : GET
//        $this->setLayout('main');
        return $this->render('album/homeAdmin', [
            'name' => Application::$app->loggedUser->getUsername()
        ]);
    }

    public function __toString(): string
    {
        return 'AlbumController';
    }
}
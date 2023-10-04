<?php

namespace middlewares;

use bases\BaseMiddleware;
use cores\Application;
use exceptions;

class AdminMiddleware extends BaseMiddleware {
    protected static AdminMiddleware $instance;
    protected array $actions = [];

    public function __construct($actions = []) {
        $this->actions = $actions;
    }

    public static function getInstance($actions = []) {
        if (self::$instance === null) {
            self::$instance = new AdminMiddleware($actions);
        }
        return self::$instance;
    }

    public function execute()
    {
        if(Application::$app::isAdmin()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                throw new exceptions\ForbiddenException(message: "You don't have permission to access this page", code: 403);
            }
        }
    }
}
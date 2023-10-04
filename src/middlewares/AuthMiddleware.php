<?php

namespace middlewares;

require_once ROOT_DIR . "src/bases/BaseMiddleware.php";

use exceptions\ForbiddenException,
    bases\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    protected static AuthMiddleware $instance;
    protected array $actions = [];

    public function __construct($actions = []) {
        $this->actions = $actions;
    }

    public static function getInstance($actions = []) {
        if (self::$instance === null) {
            self::$instance = new AuthMiddleware($actions);
        }
        return self::$instance;
    }

    public function execute()
    {
        if (\cores\Application::$app::isGuest()) {
            if (empty($this->actions) || in_array(\cores\Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException(message: "You don't have permission to access this page", code: 403);
            }
        }
    }
}
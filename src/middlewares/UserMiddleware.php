<?php

namespace middlewares;

require_once ROOT_DIR . "src/bases/BaseMiddleware.php";
require_once ROOT_DIR . "src/exceptions/ForbiddenException.php";

use exceptions\ForbiddenException,
    bases\BaseMiddleware;

class UserMiddleware extends BaseMiddleware
{
    protected static UserMiddleware $instance;
    protected array $actions = [];

    public function __construct($actions = []) {
        $this->actions = $actions;
    }

    public static function getInstance($actions = []) {
        if (self::$instance === null) {
            self::$instance = new static($actions);
        }
        return self::$instance;
    }

    public function execute()
    {
        if (\cores\Application::$app::isNotUser()) {
            if (empty($this->actions) || in_array(\cores\Application::$app->controller->action, $this->actions)) {
                throw new ForbiddenException(message: "You don't have permission to access this page", code: 403);
            }
        }
    }
}
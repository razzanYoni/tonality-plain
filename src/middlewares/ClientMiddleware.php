<?php

namespace middlewares;

use bases\BaseMiddleware;
use cores\Application;

class ClientMiddleware extends BaseMiddleware
{
    protected static ClientMiddleware $instance;
    protected array $actions = [];
    public function __construct($actions = [])
    {
        $this->actions = $actions;
    }

    public static function getInstance($actions = [])
    {
        if (self::$instance === null) {
            self::$instance = new ClientMiddleware($actions);
        }
        return self::$instance;
    }

    public function execute()
    {
        if(getallheaders()['X-API-KEY'] != $_ENV['API_KEY']) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                http_response_code(403);
                echo json_encode([
                    'message' => "You don't have permission to access this page",
                    'code' => 403
                ]);
                exit;
            }
        }
    }
}
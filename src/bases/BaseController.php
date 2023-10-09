<?php

namespace bases;

use cores\Application;

class BaseController
{
    public string $layout = 'blank';
    public string $action = '';
    protected array $middlewares = [];

    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    public function render($view, $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }


    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function __toString(): string {
        return "Controller";
    }
}
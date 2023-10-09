<?php

namespace cores;

class View
{
    public string $title = '';

    public function renderView($view, array $params)
    {
        $layoutName = Application::$app->layout;
        if (Application::$app->controller) {
            $layoutName = Application::$app->controller->layout;
        }

        $layoutParams = [];
        if (isset($params['layout'])) {
            $layoutParams = $params['layout'];
        }

        $viewParams = [];
        if (isset($params['view'])) {
            $viewParams = $params['view'];
        }

        $viewContent = $this->renderViewOnly($view, $viewParams);
        $layoutContent = $this->renderLayoutOnly($layoutName, $layoutParams);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderViewOnly($view, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."public/views/$view.php";
        return ob_get_clean();
    }

    public function renderLayoutOnly($layout, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."public/views/layouts/$layout.php";
        return ob_get_clean();
    }
}
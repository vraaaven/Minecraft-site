<?php

namespace App\Core;

class View
{
    public string $path;
    public array $route;

    public function __construct(array $route)
    {
        // Проверяем, есть ли в маршруте явно указанное имя вида
        if (isset($route['view'])) {
            $this->path = $route['view'];
        } else {
            $this->path = $route['controller'] . '/' . $route['action'];
        }
        $this->route = $route; // Сохраняем весь маршрут, если понадобится в дальнейшем
    }

    public function render($vars = [], $template = null): void
    {
        $viewName = $template ?? $this->route['view'];

        $viewPath = 'public/views/' . $viewName . '.php';

        if (file_exists($viewPath)) {
            extract($vars);

            ob_start();

            require $viewPath;

            $content = ob_get_clean();

            $headContent = $this->renderStyles($vars['app']);
            $bodyContent = $this->renderScripts($vars['app']);

            $finalOutput = str_replace(
                ['</head>', '</body>'],
                ["$headContent</head>", "$bodyContent</body>"],
                $content
            );

            echo $finalOutput;
        } else {
            Route::errorCode(404);
        }
    }

    private function renderStyles($app): string
    {
        $html = '';
        foreach ($app->getStyles() as $stylePath) {
            $html .= "<link rel='stylesheet' href='{$stylePath}'>" . PHP_EOL;
        }
        return $html;
    }

    private function renderScripts($app): string
    {
        $html = '';
        foreach ($app->getScripts() as $scriptPath) {
            $html .= "<script src='{$scriptPath}'></script>" . PHP_EOL;
        }
        return $html;
    }
}
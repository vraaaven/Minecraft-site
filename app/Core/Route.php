<?php

namespace App\Core;

use App\Core\View;

class Route implements RouteInterface
{
    private array $routes = [];
    private array $params = [];


    public function __construct()
    {
        $arr = require 'app/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params): void
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?<id>\d+)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function match(): bool
    {
        $url = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $this->params[$key] = $match;
                    }
                }
                $this->params = array_merge($this->params, $params);
                $this->params['url'] = '/'.$url;
                return true;
            }
        }
        return false;
    }


    public function run(): void
    {
        if (!$this->match()) {
            $this->errorCode(404);
        }
        $path = 'App\Controllers\\' . ucfirst($this->params['controller']) . 'Controller';
        $action = $this->params['action'];
        if (!class_exists($path) && !method_exists($path, $action)) {
            self::errorCode(404);
        }
        $controller = new $path($this->params);
        $controller->$action();
    }
    public static function errorCode($code): void
    {
        // Создаем контроллер для ошибок
        $errorController = new \App\Controllers\ErrorController(['controller' => 'error','action' => 'index', 'view' => "errors/$code"]);
        $errorController->index($code);
        exit;
    }
}

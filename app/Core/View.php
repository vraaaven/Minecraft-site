<?php

namespace App\Core;

class View
{
    private string $path;

    public function __construct($route)
    {
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($vars = []): void
    {
        extract($vars);
        if (file_exists('public/views/' . $this->path . '.php')) {
            require 'public/views/' . $this->path . '.php';
        } else {
            echo 'вид не найден';
        }
    }
    public function loadCss()
    {
        //НАДО ДЕЛОТЬ!!!!
    }

    public static function errorCode($code): void
    {
        http_response_code($code);
        require 'public/views/errors/' . $code . '.php';
        exit;
    }
}

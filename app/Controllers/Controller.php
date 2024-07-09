<?php

namespace App\Controllers;

use App\Core\View;

abstract class Controller
{
    protected array $route;
    protected object $view;
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
    }
    protected function setCookie(): void
    {
        if (!isset($_COOKIE['id'])) {
            $user_id = uniqid();
            setcookie('id', $user_id);
        }
    }
}

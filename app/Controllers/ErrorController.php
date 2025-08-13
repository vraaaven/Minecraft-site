<?php

namespace App\Controllers;

use App\Core\Route;
use App\Models\User;
use App\Lib\App;

class ErrorController extends Controller
{
    public function index($code): void
    {
        http_response_code($code);
        $this->view->path = 'errors/' . $code;
        $app = new App($this->route);
        $vars = [
            'app' => $app
        ];
        $this->view->render($vars);
    }
}
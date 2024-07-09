<?php

namespace App\Controllers;

use App\Models\Post;
use App\Lib\Component;

class MainController extends Controller
{
    public function index(): void
    {
        $posts = Post::getList(1, 3);
        $components = [
            'menu' => new Component(),
            'footer' => new Component()
        ];
        $vars = [
            "posts" => $posts,
            'count' => Post::getCount(),
            'components' => $components

        ];
        $this->view->render($vars);
    }
}
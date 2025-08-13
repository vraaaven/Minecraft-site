<?php

namespace App\Controllers;

use App\Lib\App;
use App\Models\Post;
use App\Models\User;

class MainController extends Controller
{
    public function index(): void
    {
        $app = new App($this->route);
        $isPlayer = User::isPlayer();
        $posts = Post::getPostsForUser(1,  3, $isPlayer);
        $vars = [
            'data' => [
                "posts" => $posts,
            ],
            'app' => $app
        ];

        $this->view->render($vars);
    }
    public function server(): void
    {
        if (!User::isPlayer()) {
            $this->errorCode('403');
        }
        $app = new App($this->route);
        $vars = [
            'app' => $app
        ];
        $this->view->render($vars);
    }
    public function guides(): void
    {
        $app = new App($this->route);
        $vars = [
            'app' => $app
        ];
        $this->view->render($vars);
    }

}
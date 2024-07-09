<?php

namespace App\Controllers;

use App\Lib\Component;
use App\Lib\Helper;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;

class PostController extends Controller
{
    public function load(): void
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $posts = Helper::formateDate(Post::getList($_POST['page'], 5));
            foreach ($posts as $post) {
                $postsArray[] = [
                    'id' => $post->getField('id'),
                    'name' => $post->getField('announce'),
                    'date' => $post->getField('date'),
                ];
            }
            $result['posts'] = $postsArray;
            echo json_encode($result);
            return;
        }
        $this->list();
    }

    public function list($page = 1): void
    {
        $route = $this->route;
        if (isset($route['id'])) {
            $page = $route['id'];
        }
        $posts = Post::getList(1, $page * 5);
        $components = [
            'news' => new Component(),
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

    public function detail(): void
    {
        $this->setCookie('id');
        $route = $this->route;
        $post = Post::getItem($route["id"]);
        $vars = [
            "post" => $post,
        ];
        $this->view->render($vars);
    }
}

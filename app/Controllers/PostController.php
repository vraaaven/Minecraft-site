<?php

namespace App\Controllers;

use App\Lib\Helper;
use App\Models\Post;
use App\Lib\App;
use App\Models\User;

class PostController extends Controller
{
    public function load(): void
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $isPlayer = User::isPlayer();
            $posts = Helper::formateDate(Post::getPostsForUser($_POST['page'], 5, $isPlayer));
            $postsArray = [];
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

        $app = new App($route);
        $isPlayer = User::isPlayer();
        $posts = Post::getPostsForUser(1, $page * 5, $isPlayer);
        $vars = [
            'data' => [
                "posts" => $posts,
                'count' => Post::getCount()
            ],
            'app' => $app
        ];
        $this->view->render($vars);
    }

    public function detail(): void
    {
        $route = $this->route;

        $post = Post::getItemByCode($route["slug"]);
        if (!$post) {
            $this->redirect('/404');
            return;
        }
        $isPlayer = User::isPlayer();
        if ($post->getField('is_server_post') && !$isPlayer) {
            $this->redirect('/404');
        }
        $app = new App($route);
        $meta = [
            'title' => "{$post->getField('name')} - MageLand",
            'description' => "{$post->getField('announce')}",
            'keywords' => "MageLand, новости",
        ];
        $app->setMeta($meta);
        $vars = [
            'data' => [
                "post" => $post,
            ],
            'app' => $app
        ];
        $this->view->render($vars);
    }
}

<?php

namespace App\Controllers;

use App\Core\Route;
use App\Lib\Helper;
use App\Models\Post;

class AdminController extends Controller
{
    public function list(): void
    {
        $currentPage = isset($this->route['id']) ? intval($this->route['id']) : 1;
        $limit = 1;
        $amount = ceil(Post::getCount(true) / $limit);
        $vars = [
            'postsList' => Post::getList($currentPage, $limit, true),
            'categories' => Post::getCategories(),
            'pagination' => Helper::generatePagination($currentPage, $amount)
        ];
        $this->view->render($vars);
    }

    public function delete(): void
    {
        Post::deletePost($this->route['id']);
        Route::redirect('/admin/');
    }

    public function edit(): void
    {
        $vars = [
            'item' => Post::getItem($this->route['id']),
            'categories' => Post::getCategories(),
        ];
        if (!empty($_POST)) {
            Post::updatePost($this->route['id']);
            Route::redirect('/admin/edit/' . $this->route['id']);
        }
        $this->view->render($vars);
    }

    public function add(): void
    {
        $vars = [
            'categories' => Post::getCategories(),
        ];
        if (!empty($_POST)) {
            Post::addPost();
            Route::redirect('/admin/');
        }
        $this->view->render($vars);
    }
}

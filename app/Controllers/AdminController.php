<?php

namespace App\Controllers;

use App\Lib\App;
use App\Lib\Helper;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{

    private function checkAdminAccess(): void
    {
        if (!$this->isAuthenticated() || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $this->renderAccessDenied();
            exit();
        }
    }

    public function login(): void
    {
        if ($this->isAuthenticated()) {
            if ($_SESSION['is_admin']) {
                $this->redirect('/admin/dashboard');
            } else {
                $this->renderAccessDenied();
                return;
            }
        }
        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'loginProcess' => '/admin/loginProcess'
        ];
        $this->view->render($vars);
    }

    public function loginProcess(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin/dashboard');
        }
        $data = $this->getAndSanitizeLoginData();
        $errors = $this->validateLoginData($data);
        if (!empty($errors)) {
            $this->renderLoginFormWithErrors($data, $errors, '/admin/loginProcess/');
            return;
        }
        $user = User::findByName($data['name']);
        if (!$user || !password_verify($data['password'], $user['password'])) {
            $errors[] = 'Неверный никнейм или пароль.';
            $this->renderLoginFormWithErrors($data, $errors, '/admin/loginProcess/');
            return;
        }
        if (!$user['is_admin']) {
            $errors[] = 'У вас нет прав для доступа в админ-панель.';
            $this->renderLoginFormWithErrors($data, $errors, '/admin/loginProcess/');
            return;
        }
        $this->loginUser($user);
        $this->redirect('/admin/dashboard');
    }

    public function dashboard(): void
    {
        $this->checkAdminAccess();
        $info = [
            'lastUsers' => User::getList(1, 5),
            'totalUsers' => User::getCount(),
        ];
        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'info' => $info
        ];
        $this->view->render($vars);
    }

    private function renderAccessDenied(): void
    {
        http_response_code(403);

        $app = new App($this->route);
        $vars = [
            'app' => $app,
        ];
        $this->view->render($vars, 'admin/access-denied');
    }


    public function posts(): void
    {
        $this->checkAdminAccess();
        $currentPage = isset($this->route['id']) ? intval($this->route['id']) : 1;
        $limit = 10;
        $totalPosts = Post::getCount();
        $totalPages = ceil($totalPosts / $limit);

        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'postsList' => Post::getList($currentPage, $limit),
            'pagination' => Helper::generatePagination($currentPage, $totalPages, '/admin/posts/')
        ];
        $this->view->render($vars);
    }

    public function deletePost(): void
    {
        $this->checkAdminAccess();
        $postId = $this->route['id'] ?? null;

        if (is_numeric($postId)) {
            Post::deletePost((int)$postId);
        }
        $this->redirect('/admin/posts');
    }

    public function editPost(): void
    {
        $this->checkAdminAccess();
        $postId = $this->route['id'] ?? null;

        if (!$postId) {
            $this->redirect('/admin/posts');
            return;
        }

        $post = Post::getItem($postId);

        if (!$post) {
            $this->redirect('/admin/posts');
            return;
        }
        $app = new App($this->route);

        if (!empty($_POST)) {
            Post::updatePost($postId, $_POST);
            $this->redirect('/admin/posts');
        }

        $vars = [
            'app' => $app,
            'item' => $post,
        ];
        $this->view->render($vars);
    }

    public function addPost(): void
    {
        $this->checkAdminAccess();

        $app = new App($this->route);

        if (!empty($_POST)) {
            Post::addPost($_POST);
            $this->redirect('/admin/posts');
        }
        $vars = [
            'app' => $app,
            'item' => null, // Для новой записи
        ];
        $this->view->render($vars);
    }


    //Пользователи

    public function users(): void
    {
        $this->checkAdminAccess();
        $currentPage = isset($this->route['id']) ? intval($this->route['id']) : 1;
        $limit = 10;
        $searchQuery = $_GET['name'] ?? null; // Получаем поисковый запрос
        if ($searchQuery) {
            $totalUsers = User::getCountByName($searchQuery);
            $users = User::searchByName($searchQuery, $currentPage, $limit);
        } else {
            $totalUsers = User::getCount();
            $users = User::getList($currentPage, $limit);
        }
        $baseUrl = '/admin/users/';
        if ($searchQuery) {
            $baseUrl .= '?name=' . urlencode($searchQuery) . '&page=';
        } else {
            $baseUrl .= ':id';
        }
        $totalPages = ceil($totalUsers / $limit);

        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'users' => $users,
            'pagination' => Helper::generatePagination($currentPage, $totalPages, $baseUrl)
        ];
        $this->view->render($vars);
    }

    public function deleteUser(): void
    {
        $this->checkAdminAccess();
        $userId = $this->route['id'] ?? null;
        if ($userId) {
            User::delete($userId);
        }
        $this->redirect('/admin/users');
    }

    public function editUser(): void
    {
        $this->checkAdminAccess();
        $userId = $this->route['id'] ?? null;
        if (!$userId) {
            $this->redirect('/admin/users');
        }
        $user = User::findById($userId);
        if (!empty($_POST)) {
            $data = $_POST;
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                unset($data['password']);
            }

            User::update($userId, $data);
            $this->redirect('/admin/users');
        }

        $error = Helper::showError('Пользователь не найден.');
        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'user' => $user,
            'error' => $error,
        ];
        $this->view->render($vars);
    }

    public function addUser(): void
    {
        $this->checkAdminAccess();

        $meta = [
            'title' => 'Добавление пользователя',
            'description' => 'Страница для добавления нового пользователя в админ-панели.',
            'keywords' => 'админка, пользователь, добавление'
        ];
        $app = new App($meta);

        if (!empty($_POST)) {

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            User::create(
                $_POST['name'],
                $_POST['email'],
                $password,
                $_POST['twitch_name'],
                (int)($_POST['is_player'] ?? 0),
                (int)($_POST['is_admin'] ?? 0)
            );

            $this->redirect('/admin/users');
            return;
        }

        $vars = [
            'app' => $app,
            'user' => [
                'id' => null,
                'name' => '',
                'email' => '',
                'twitch_name' => '',
                'is_player' => 0,
                'is_admin' => 0
            ],
        ];

        $this->view->render($vars);
    }

    //Страницы
    public function pages(): void
    {
        $this->checkAdminAccess();

        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'pagesList' => Page::getList(),
        ];
        $this->view->render($vars);
    }

    public function addPage(): void
    {
        $this->checkAdminAccess();

        $app = new App($this->route);

        if (!empty($_POST)) {
            Page::create($_POST);
            $this->redirect('/admin/pages');
        }

        $vars = [
            'app' => $app,
            'item' => null,
        ];
        $this->view->render($vars);
    }

    public function editPage(): void
    {
        $this->checkAdminAccess();
        $pageId = $this->route['id'] ?? null;

        if (!$pageId) {
            $this->redirect('/admin/pages');
            return;
        }

        $page = Page::getItem($pageId);

        if (!$page) {
            $this->redirect('/admin/pages');
            return;
        }

        if (!empty($_POST)) {
            Page::update($pageId, $_POST);
            $this->redirect('/admin/pages');
        }

        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'item' => $page,
        ];
        $this->view->render($vars);
    }

    public function deletePage(): void
    {
        $this->checkAdminAccess();
        $pageId = $this->route['id'] ?? null;
        if (is_numeric($pageId)) {
            Page::delete((int)$pageId);
        }
        $this->redirect('/admin/pages');
    }
}

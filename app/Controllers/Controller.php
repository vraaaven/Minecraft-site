<?php

namespace App\Controllers;

use App\Core\Route;
use App\Core\View;
use App\Lib\App;

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
    protected  static function redirect($url): void
    {
        header('Location: ' . $url);
        exit;
    }
    //Выход
    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('/');
    }

    // Утилиты для авторизации
    protected function loginUser(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_player'] = $user['is_player'];
        $_SESSION['is_admin'] = $user['is_admin'];
    }
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }
    protected function getAndSanitizeLoginData(): array
    {
        return [
            // Вместо 'email' получаем 'name'
            'name' => htmlspecialchars(trim($_POST['name'] ?? '')),
            'password' => $_POST['password'] ?? '',
        ];
    }

    protected function validateLoginData(array $data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors[] = 'Поле "Имя пользователя" обязательно для заполнения.';
        }
        if (empty($data['password'])) {
            $errors[] = 'Поле "Пароль" обязательно для заполнения.';
        }
        return $errors;
    }
    public function errorCode($code): void
    {
        $errorController = new \App\Controllers\ErrorController(['controller' => 'error','action' => 'index', 'view' => "errors/$code"]);
        $errorController->index($code);
        exit;
    }
    protected function renderLoginFormWithErrors(array $data, array $errors, string $action = '/loginProcess'): void
    {
        $app = new App($this->route);
        $app->addCustomData('errors', $errors);
        $app->addCustomData('old_input', ['name' => $data['name']]);
        $vars = [
            'app' => $app,
            'loginProcess' => $action
        ];
        $this->view->render($vars);
    }
}

<?php

namespace App\Controllers;

use App\Lib\App;
use App\Models\User;

class UserController extends Controller
{
    public function show(): void
    {

        $meta = [
            'title' => 'Профиль пользователя',
            'description' => 'Информация о вашем аккаунте.',
            'keywords' => 'профиль, аккаунт, пользователь'
        ];
        $user = $this->getValidUser();
        $app = new App($meta);
        $app->addCustomData('user', $user);

        $vars = [
            'app' => $app
        ];
        $this->view->render($vars);
    }

    public function edit(): void
    {
        $meta = [
            'title' => 'Редактировароние пользователя',
            'description' => 'Информация о вашем аккаунте.',
            'keywords' => 'профиль, аккаунт, пользователь'
        ];
        $user = $this->getValidUser();
        $app = new App($meta);
        $app->addCustomData('user', $user);
        $app->addCustomData('errors', []);

        $vars = [
            'app' => $app
        ];
        $this->view->render($vars);
    }

    public function update(): void
    {
        $user = $this->getValidUser();
        $data = $this->getAndSanitizeUserData();
        $errors = $this->validateUserData($data, $user['id']);
        if (!empty($errors)) {
            $this->renderEditFormWithErrors($user, $data, $errors);
            return;
        }
        $updateData = [];
        if ($data['name'] !== $user['name']) {
            $updateData['name'] = $data['name'];
        }
        if ($data['twitch_name'] !== $user['twitch_name']) {
            $updateData['twitch_name'] = $data['twitch_name'];
        }
        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (!empty($updateData)) {
            User::update($user['id'], $updateData);
            if (isset($updateData['name'])) {
                $_SESSION['user_name'] = $updateData['name'];
            }
        }

        $this->redirect('/user');
    }

    public function delete(): void
    {
        //Может потом сделаю
    }
    private function getValidUser(): array {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $user = User::findById($userId);

        if (!$user) {
            $this->logout();
            $this->redirect('/login');
        }
        return $user;
    }
    // Вспомогательный метод для рендера формы с ошибками
    private function renderEditFormWithErrors(array $user, array $data, array $errors): void
    {
        $meta = [
            'title' => 'Ошибка редактирования',
            'description' => 'Исправьте ошибки в форме.',
            'keywords' => 'профиль, редактирование, ошибка'
        ];

        $app = new App($meta);
        $app->addCustomData('user', array_merge($user, $data)); // Сохраняем введенные данные
        $app->addCustomData('errors', $errors);

        $vars = [
            'app' => $app
        ];
        $this->view->render($vars, 'user/edit');
    }

    // Утилиты для валидации и очистки данных
    protected function getAndSanitizeUserData(): array
    {
        return [
            'name' => htmlspecialchars(trim($_POST['name'] ?? '')),
            'twitch_name' => htmlspecialchars(trim($_POST['twitch_name'] ?? null)),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
        ];
    }

    protected function validateUserData(array $data, int $userId): array
    {
        $errors = [];
        $user = User::findById($userId);

        if (empty($data['name'])) {
            $errors[] = 'Поле "Имя пользователя" обязательно для заполнения.';
        } elseif ($data['name'] !== $user['name'] && User::findByName($data['name'])) {
            $errors[] = 'Пользователь с таким именем уже существует.';
        }

        if (!empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                $errors[] = 'Пароль должен быть не менее 6 символов.';
            }
            if ($data['password'] !== $data['password_confirm']) {
                $errors[] = 'Пароли не совпадают.';
            }
        }
        return $errors;
    }
}
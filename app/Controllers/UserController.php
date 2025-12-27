<?php

namespace App\Controllers;

use App\Lib\App;
use App\Models\User;
use App\Lib\SkinHelper;

class UserController extends Controller
{
    public function edit(): void
    {
        $user = $this->getValidUser();
        $app = new App($this->route);
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

    public function publicShow(): void
    {
        $userId = $this->route['id'] ?? null;
        $user = $userId ? User::findById((int)$userId) : null;

        if (!$user) {
            $this->redirect('/404');
            return;
        }

        $skinUrl = SkinHelper::getSkinUrl($user['name']);

        $app = new App($this->route);
        $app->addCustomData('user', $user);

        $vars = [
            'app' => $app,
            'skin'=> $skinUrl
        ];
        $this->view->render($vars);
    }
    public function list(): void
    {
        $page = $this->route['id'] ?? 1;
        $limit = 100;

        // Устанавливаем срок жизни кеша: 24 часа
        $cacheLifetimeSeconds = 24 * 3600;

        $players = User::getPlayersList((int)$page, $limit);
        $playersData = [];

        foreach ($players as $player) {
            $skinUrl = $player['skin_url'];
            $currentTime = time();
            $checkedTime = strtotime($player['skin_checked_at'] ?? '2000-01-01'); // Если null, ставим старую дату

            $needsUpdate = empty($skinUrl) ||
                ($currentTime - $checkedTime) > $cacheLifetimeSeconds;

            if ($needsUpdate) {

                $newUrl = SkinHelper::getSkinUrl($player['name']);

                // Формируем данные для обновления
                $updateData = [
                    'skin_checked_at' => date('Y-m-d H:i:s', $currentTime)
                ];

                if ($newUrl && $newUrl !== $skinUrl) {
                    // Если скин найден ИЛИ изменился
                    $updateData['skin_url'] = $newUrl;
                    $skinUrl = $newUrl; // Обновляем переменную для текущего цикла
                } elseif (!$newUrl && !empty($skinUrl)) {
                    // Если скин пропал (новый URL - null, старый был), очищаем URL
                    $updateData['skin_url'] = null;
                    $skinUrl = null;
                } elseif (!$newUrl && empty($skinUrl)) {
                    // Скина не было и нет, просто обновляем время, чтобы не проверять 24 часа
                    // Здесь не нужно ничего делать, просто обновится checked_at ниже
                }

                // Обновляем базу данных
                User::update($player['id'], $updateData);

            }

            $playersData[] = [
                'user' => $player,
                'skinUrl' => $skinUrl // Используем актуальный или кешированный URL
            ];
        }

        $app = new App($this->route);
        $app->addCustomData('playersData', $playersData);

        $vars = ['app' => $app];
        $this->view->render($vars);
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
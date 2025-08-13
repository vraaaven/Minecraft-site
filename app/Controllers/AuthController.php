<?php

namespace App\Controllers;

use App\Core\Route;
use App\Lib\Mailer;
use App\Models\User;
use App\Lib\App;

class AuthController extends Controller
{
    // Логин
    public function login(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/user');
        }
        $app = new App($this->route);
        $vars = [
            'app' => $app,
            'loginProcess' => '/loginProcess/'
        ];
        $this->view->render($vars);
    }

    public function loginProcess(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/');
        }
        $data = $this->getAndSanitizeLoginData();
        $errors = $this->validateLoginData($data);
        if (!empty($errors)) {
            $this->renderLoginFormWithErrors($data, $errors);
            return;
        }

        $user = User::findByName($data['name']);
        if (!$user || !password_verify($data['password'], $user['password'])) {
            $errors[] = 'Неверный никнейм или пароль.';
            $this->renderLoginFormWithErrors($data, $errors);
            return;
        }
        $this->loginUser($user);
        $this->redirect('/');
    }


    // Регистрация
    public function registration(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirect('/');
        }

        $app = new App($this->route);
        $vars = [
            'app' => $app
        ];
        $this->view->render($vars);
    }

    public function registrationProcess(): void
    {
        $data = $this->getAndSanitizeRegistrationData();
        $errors = $this->validateRegistrationData($data);

        if (!empty($errors)) {
            $this->renderRegistrationFormWithErrors($data, $errors);
            return;
        }

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32));

        $userId = User::create(
            $data['name'],
            $data['email'],
            $hashedPassword,
            $token,
            $data['twitch_name']
        );

        if ($userId > 0) {
            if (Mailer::sendConfirmationEmail($data['email'], $token)) {
                $app = new App($this->route);
                $app->addCustomData('message', 'Регистрация прошла успешно! Пожалуйста, проверьте вашу почту для активации аккаунта.');
                $this->view->render(['app' => $app]); // Предполагаемый шаблон с сообщением
            } else {
                $errors[] = 'Не удалось отправить письмо для активации. Попробуйте позже.';
                $this->renderRegistrationFormWithErrors($data, $errors);
            }
        } else {
            $errors[] = 'Не удалось создать пользователя. Попробуйте еще раз.';
            $this->renderRegistrationFormWithErrors($data, $errors);
        }
    }
    public function confirmEmail(): void
    {
        $token = $_GET['token'] ?? null;
        $user = User::findByConfirmationToken($token);

        $app = new App($this->route);

        if ($user) {
            User::confirmUser($user['id']);
            $app->addCustomData('message', 'Ваш аккаунт успешно активирован! Теперь вы можете войти.');
            $this->view->render(['app' => $app], 'info-page');
        } else {
            $app->addCustomData('message', 'Неверный или просроченный токен активации.');
            $this->view->render(['app' => $app], 'info-page');
        }
    }

    private function renderRegistrationFormWithErrors(array $data, array $errors): void
    {
        $app = new App($this->route);
        $app->addCustomData('errors', $errors);
        $app->addCustomData('old_input', $data);
        $vars = [
            'app' => $app,
        ];
        $this->view->render($vars);
    }

    // Утилиты (перемещены в Controller)
    protected function getAndSanitizeRegistrationData(): array
    {
        return [
            'name' => htmlspecialchars(trim($_POST['name'] ?? '')),
            'email' => htmlspecialchars(trim($_POST['email'] ?? '')),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'twitch_name' => htmlspecialchars(trim($_POST['twitch_name'] ?? '')),
        ];
    }

    protected function validateRegistrationData(array $data): array
    {
        $errors = [];
        if (empty($data['name'])) {
            $errors[] = 'Поле "Имя пользователя" обязательно для заполнения.';
        } elseif (User::findByName($data['name'])) {
            $errors[] = 'Пользователь с таким именем уже существует.';
        }
        if (empty($data['email'])) {
            $errors[] = 'Поле "Email" обязательно для заполнения.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Введите корректный Email адрес.';
        } elseif (User::findByEmail($data['email'])) {
            $errors[] = 'Пользователь с таким Email уже зарегистрирован.';
        }
        if (empty($data['password'])) {
            $errors[] = 'Поле "Пароль" обязательно для заполнения.';
        } elseif (strlen($data['password']) < 6) {
            $errors[] = 'Пароль должен быть не менее 6 символов.';
        }
        if ($data['password'] !== $data['password_confirm']) {
            $errors[] = 'Пароли не совпадают.';
        }
        return $errors;
    }
}
<div class="registration-container">
    <?php
    $errors = $component->getData('errors') ?? [];
    $message = $component->getData('message') ?? [];
    $old_input = $component->getData('old_input') ?? [];
    debug($message);
    ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/registrationProcess" method="POST">
        <div>
            <label for="name">Имя пользователя:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($old_input['name'] ?? '') ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($old_input['email'] ?? '') ?>" required>
        </div>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirm">Повторите пароль:</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>
        <div>
            <label for="twitch_name">Twitch ник :</label>
            <input type="text" id="twitch_name" name="twitch_name" value="<?= htmlspecialchars($old_input['twitch_name'] ?? '') ?>">
        </div>
        <button type="submit">Зарегистрироваться</button>
    </form>

    <p>Уже есть аккаунт? <a href="/login/">Войти</a></p>
</div>
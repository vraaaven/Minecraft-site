<div class="login-container">
    <h1>Вход</h1>

    <?php
    $errors = $component->getData('errors') ?? [];
    $old_input = $component->getData('old_input') ?? ['name' => ''];
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

    <form action="<?=$loginProcess?>" method="POST">
        <div>
            <label for="name">Имя пользователя:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($old_input['name'] ?? '') ?>" required>
        </div>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Войти</button>
    </form>
    <p>Ещё нет аккаунта? <a href="/registration/">Зарегистрироваться</a></p>
</div>
<?php

$user = $app->getCustomData('user') ?? [];
$errors = $app->getCustomData('errors') ?? [];
$app->addCss('/public/styles/css/pages/static.css');
?>
<? require_once 'public/layouts/default/start.php'; ?>

<?$app->getComponent('header')->render(); ?>
    <div class="static under-header">
        <h1>Редактирование профиля</h1>
        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/user/update" method="POST">
            <div class="form-group">
                <label for="name">Имя пользователя:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="twitch_name">Twitch ник:</label>
                <input type="text" id="twitch_name" name="twitch_name"
                       value="<?= htmlspecialchars($user['twitch_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Новый пароль:</label>
                <input type="password" id="password" name="password">
                <small>Оставьте пустым, чтобы не менять пароль.</small>
            </div>
            <div class="form-group">
                <label for="password_confirm">Подтверждение пароля:</label>
                <input type="password" id="password_confirm" name="password_confirm">
            </div>
            <button type="submit">Сохранить изменения</button>
        </form>
        <a href="/user/">Отмена</a>
    </div>
<?php $app->getComponent('footer')->render(); ?>
<? require_once 'public/layouts/default/end.php'; ?>
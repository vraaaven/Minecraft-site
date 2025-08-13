<?php require_once 'public/layouts/default/start.php'; ?>
<?php
/** @var array $vars */
$app = $vars['app'] ?? null;
$user = $vars['user'] ?? [];

$isNewUser = empty($user['id']);

$title = $isNewUser ? 'Добавление пользователя' : 'Редактирование пользователя: ' . htmlspecialchars($user['name']);
$actionUrl = $isNewUser ? '/admin/users/add' : '/admin/users/edit/' . htmlspecialchars($user['id']);

$app->addCss('/public/styles/css/pages/admin-form.css');
$app->getComponent('header', [], 'admin')->render();
?>

    <div class="container">
        <div class="admin-form">
            <h1 class="admin-form__title"><?= $title ?></h1>

            <form action="<?= $actionUrl ?>" method="POST" class="admin-form__content">
                <div class="admin-form__group">
                    <label for="name" class="admin-form__label">Имя пользователя:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label for="email" class="admin-form__label">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label for="password" class="admin-form__label">Пароль:</label>
                    <input type="password" id="password" name="password" <?= $isNewUser ? 'required' : '' ?> class="admin-form__input">
                    <?php if (!$isNewUser): ?>
                        <small class="admin-form__hint">Оставьте пустым, чтобы не менять пароль.</small>
                    <?php endif; ?>
                </div>

                <div class="admin-form__group">
                    <label for="twitch_name" class="admin-form__label">Имя на Twitch:</label>
                    <input type="text" id="twitch_name" name="twitch_name" value="<?= htmlspecialchars($user['twitch_name'] ?? '') ?>" class="admin-form__input">
                </div>

                <div class="admin-form__group admin-form__group--checkbox">
                    <input type="hidden" name="is_player" value="0">
                    <input type="checkbox" id="is_player" name="is_player" value="1" <?= ($user['is_player'] ?? 0) ? 'checked' : '' ?>>
                    <label for="is_player" class="admin-form__label">Игрок</label>
                </div>

                <div class="admin-form__group admin-form__group--checkbox">
                    <input type="hidden" name="is_admin" value="0">
                    <input type="checkbox" id="is_admin" name="is_admin" value="1" <?= ($user['is_admin'] ?? 0) ? 'checked' : '' ?>>
                    <label for="is_admin" class="admin-form__label">Администратор</label>
                </div>

                <button type="submit" class="admin-form__btn">
                    <?= $isNewUser ? 'Добавить пользователя' : 'Сохранить изменения' ?>
                </button>
            </form>
        </div>
    </div>

<?php require_once 'public/layouts/default/end.php'; ?>
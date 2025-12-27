<?php
// public/views/user/public.php (Обновленная структура)
$app = $vars['app'];
$user = $app->getCustomData('user');
$skinUrl = $app->getCustomData('skinUrl'); // Убедимся, что получаем skinUrl
$app->addCss('/public/styles/css/pages/static.css');
?>
<? require_once 'public/layouts/default/start.php'; ?>
<?php
if ($app && $user) {
    $app->getComponent('header')->render();
    ?>
    <div class="static user-profile public-profile under-header">
        <h1>Профиль пользователя</h1>

        <div class="user-card">

            <div class="user-card__media">
                <div class="skin-face-clipper" style="--size: 150px">
                    <?php if ($skin): ?>
                        <img src="<?= htmlspecialchars($skin) ?>" class="skin-face-face">
                        <img src="<?= htmlspecialchars($skin) ?>" class="skin-face-helmet">
                    <?php else: ?>
                        <img src="/public/img/default_skin_head.png" alt="Нет скина" class="skin-face-face">
                    <?php endif; ?>
                </div>
            </div>

            <div class="user-card__info">
                <h2 class="user-card__name"><?= htmlspecialchars($user['name']); ?></h2>

                <div class="user-card__rating">
                    <span class="label">Рейтинг:</span>
                    <span class="value rating-value"><?= htmlspecialchars($user['rating'] ?? 0); ?></span>
                </div>

                <div class="user-card__item">
                    <span class="label">Twitch:</span>
                    <span class="value"><?= empty($user['twitch_name']) ? 'Не указан' : htmlspecialchars($user['twitch_name']); ?></span>
                </div>

                <div class="user-card__item">
                    <span class="label">Проходка:</span>
                    <span class="value is-player-<?= $user['is_player'] ? 'yes' : 'no' ?>"><?= ($user['is_player'] ?? false) ? 'Да' : 'Нет'; ?></span>
                </div>

                <?php if ($_SESSION['is_admin'] ?? false): ?>
                    <div class="user-card__item">
                        <span class="label">Админ:</span>
                        <span class="value is-admin-<?= $user['is_admin'] ? 'yes' : 'no' ?>"><?= ($user['is_admin'] ?? false) ? 'Да' : 'Нет'; ?></span>
                    </div>
                <?php endif; ?>

                <div class="user-card__actions">
                    <? if ($_SESSION['user_id'] == $user['id']): ?>
                        <a href="/user/edit/" class="btn-primary">Редактировать</a>
                    <? endif; ?>
                    <a href="/" class="btn-secondary">На главную</a>
                </div>
            </div>

        </div>

    </div>
    <?php $app->getComponent('footer')->render();
}
?>
<? require_once 'public/layouts/default/end.php'; ?>
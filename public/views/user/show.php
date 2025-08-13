<?php
$user = $app->getCustomData('user') ?? null; // Получаем данные пользователя
$app->addCss('/public/styles/css/pages/static.css');
?>
<? require_once 'public/layouts/default/start.php'; ?>
<?php
if ($app && $user) {
    $app->getComponent('header')->render();
    ?>
    <div class="static user-profile under-header">
        <h1>Профиль пользователя</h1>
        <p>Имя: <?= htmlspecialchars($user['name']); ?></p>
        <p>Твич: <?= htmlspecialchars($user['twitch_name']); ?></p>
        <p>Есть проходка?: <?= ($user['is_player'] ?? false) ? 'Да' : 'Нет'; ?></p>
        <a href="/user/edit/">Редактировать</a>
    </div>
    <?php $app->getComponent('footer')->render();
}
?>
<? require_once 'public/layouts/default/end.php'; ?>
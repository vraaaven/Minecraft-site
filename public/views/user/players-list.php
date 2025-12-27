<?php
// public/views/user/players-list.php

$app = $vars['app'];
$playersData = $app->getCustomData('playersData') ?? [];
$app->addCss('/public/styles/css/pages/static.css');
$app->addCss('/public/styles/css/pages/players.css');
?>
<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->getComponent('header')->render();
?>
    <div class="static players-page under-header">
        <h1>Список игроков сервера</h1>

        <div class="players-list-container">
            <?php if (empty($playersData)): ?>
                <p class="empty-list-message">На данный момент игроков с проходкой не найдено.</p>
            <?php endif; ?>

            <?php foreach ($playersData as $data):
                $user = $data['user'];
                $skinUrl = $data['skinUrl'];
                ?>
                <div class="player-card">
                    <div class="player-card__media">
                        <div class="skin-face-clipper" style="--size: 75px">
                            <?php if ($skinUrl): ?>
                                <img src="<?= htmlspecialchars($skinUrl) ?>" class="skin-face-face">
                                <img src="<?= htmlspecialchars($skinUrl) ?>" class="skin-face-helmet">
                            <?php else: ?>
                                <img src="/public/img/default_skin_head.png" alt="Нет скина" class="skin-face-face">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="player-card__info">
                        <div class="player-card__name-block">
                            <a href="/user/<?= $user['id'] ?>/" class="player-card__name">
                                <?= $user['name'] ?>
                            </a>
                            <?php if ($user['is_admin']): ?>
                            <div class="player-card__admin">админ</div>
                            <?php endif; ?>
                        </div>

                        <div class="player-card__rating">
                            <span class="label">Рейтинг:</span>
                            <span class="value rating-value"><?= htmlspecialchars($user['rating'] ?? 0); ?></span>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


<?php $app->getComponent('footer')->render(); ?>
<? require_once 'public/layouts/default/end.php'; ?>
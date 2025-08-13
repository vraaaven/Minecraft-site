<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/dashboard.css');
$app->addJs('/public/styles/js/vendor.js');

$app->getComponent('header', [], 'admin')->render();
?>
<div class="container">
    <div class="dashboard">
        <h1 class="dashboard__title">Сводка по сайту</h1>
        <div class="dashboard__grid">

            <div class="dashboard__card">
                <div class="dashboard__card-header">
                    <h2 class="dashboard__card-title">Пользователи</h2>
                    <span class="dashboard__card-count"><?= htmlspecialchars($info['totalUsers'] ?? 0) ?></span>
                </div>
                <ul class="dashboard__list">
                    <li class="dashboard__list-header">
                        <span>Последние  пользователей</span>
                    </li>
                    <?php if (!empty($info['lastUsers'])): ?>
                        <?php foreach ($info['lastUsers'] as $user): ?>
                            <li class="dashboard__list-item">
                                <a href="/admin/users/edit/<?= htmlspecialchars($user['id']) ?>">
                                    <?= htmlspecialchars($user['name']) ?>
                                </a>
                                <div class="dashboard__list-item-meta"><?= htmlspecialchars($user['email']) ?></div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="dashboard__list-item">Нет пользователей.</li>
                    <?php endif; ?>
                </ul>
                <a href="/admin/users" class="dashboard__card-link">Все пользователи &rarr;</a>
            </div>
        </div>
    </div>
</div>
<? require_once 'public/layouts/default/end.php'; ?>

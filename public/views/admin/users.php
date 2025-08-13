<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/admin-list.css');
$app->addJs('/public/styles/js/vendor.js');

$app->getComponent('header', [], 'admin')->render();
?>
<div class="container">
    <div class="admin-list">
        <div class="admin-list__header">
            <h1 class="admin-list__title">Управление пользователями</h1>
            <a href="/admin/users/add" class="admin-list__add-btn">Добавить пользователя</a>
        </div>
        <form action="/admin/users" method="GET" class="admin-list__search">
            <input type="text" name="name" placeholder="Поиск по имени пользователя..." value="<?= $searchQuery ?? '' ?>" class="admin-list__search-input">
            <button type="submit" class="admin-list__search-btn">Найти</button>
        </form>
        <?php if (!empty($users)): ?>
            <div class="admin-list__table-wrapper">
                <table class="admin-list__table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Twitch</th>
                        <th>Email</th>
                        <th>Статус игрока</th>
                        <th>Статус админа</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['twitch_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['is_player'] ? 'Да' : 'Нет' ?></td>
                            <td><?= $user['is_admin'] ? 'Да' : 'Нет' ?></td>
                            <td class="admin-list__actions">
                                <a href="/admin/users/edit/<?= htmlspecialchars($user['id']) ?>" class="admin-list__action-btn admin-list__action-btn--edit">Редактировать</a>
                                <a href="/admin/users/delete/<?= htmlspecialchars($user['id']) ?>"
                                   class="admin-list__action-btn admin-list__action-btn--delete"
                                   onclick="return confirm('Вы уверены, что хотите удалить пользователя <?= htmlspecialchars($user['name']) ?>?');">
                                    Удалить
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($pagination) && count($pagination)>1): ?>
                <div class="admin-list__pagination">
                    <?php foreach ($pagination as $link): ?>
                        <a href="<?= htmlspecialchars($link['url']) ?>" class="admin-list__pagination-link <?= $link['active'] ? 'admin-list__pagination-link--active' : '' ?>">
                            <?= htmlspecialchars($link['text']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="admin-list__empty">Нет пользователей.</div>
        <?php endif; ?>
    </div>
</div>
<? require_once 'public/layouts/default/end.php'; ?>

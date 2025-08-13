<?php require_once 'public/layouts/default/start.php'; ?>
<?php
$app = $vars['app'] ?? null;
$app->addCss('/public/styles/css/pages/admin-list.css');
$app->getComponent('header', [], 'admin')->render();
?>
    <div class="container">
        <div class="admin-list">
            <div class="admin-list__header">
                <h1 class="admin-list__title">Управление страницами</h1>
                <a href="/admin/pages/add" class="admin-list__add-btn">Добавить страницу</a>
            </div>
            <?php if (!empty($pagesList)): ?>
                <div class="admin-list__table-wrapper">
                    <table class="admin-list__table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>Заголовок</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pagesList as $page): ?>
                            <tr>
                                <td><?= htmlspecialchars($page['id']) ?></td>
                                <td><?= htmlspecialchars($page['url']) ?></td>
                                <td><?= htmlspecialchars($page['title']) ?></td>
                                <td class="admin-list__actions">
                                    <a href="/admin/pages/edit/<?= htmlspecialchars($page['id']) ?>" class="admin-list__action-btn admin-list__action-btn--edit">Редактировать</a>
                                    <a href="/admin/pages/delete/<?= htmlspecialchars($page['id']) ?>"
                                       onclick="return confirm('Вы уверены, что хотите удалить страницу &quot;<?= htmlspecialchars($page['url']) ?>&quot;?');"
                                       class="admin-list__action-btn admin-list__action-btn--delete">Удалить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="admin-list__empty">Нет страниц.</div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once 'public/layouts/default/end.php'; ?>
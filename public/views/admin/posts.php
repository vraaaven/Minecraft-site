<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/admin-list.css');
$app->addJs('/public/styles/js/vendor.js');

$app->getComponent('header', [], 'admin')->render();
?>
<div class="container">
    <div class="admin-list">
        <div class="admin-list__header">
            <h1 class="admin-list__title">Управление новостями</h1>
            <a href="/admin/posts/add" class="admin-list__add-btn">Добавить новость</a>
        </div>

        <?php if (!empty($postsList)): ?>
            <div class="admin-list__table-wrapper">
                <table class="admin-list__table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Дата</th>
                        <th>Новость для игроков</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($postsList as $post): ?>
                        <tr>
                            <td><?= htmlspecialchars($post->getField('id')) ?></td>
                            <td><?= htmlspecialchars($post->getField('name')) ?></td>
                            <td><?= htmlspecialchars($post->getField('date')) ?></td>
                            <td><?= $post->getField('is_server_post') ? 'Да' : 'Нет' ?></td>
                            <td class="admin-list__actions">
                                <a href="/admin/posts/edit/<?= htmlspecialchars($post->getField('id')) ?>"
                                   class="admin-list__action-btn admin-list__action-btn--edit">Редактировать</a>
                                <a href="/admin/posts/delete/<?= htmlspecialchars($post->getField('id')) ?>"
                                   onclick="return confirm('Вы уверены, что хотите удалить пост &quot;<?= htmlspecialchars($post->getField('name')) ?>&quot;?');"
                                   class="admin-list__action-btn admin-list__action-btn--delete">Удалить</a>
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
            <div class="admin-list__empty">Нет новостей.</div>
        <?php endif; ?>
    </div>
</div>
<? require_once 'public/layouts/default/end.php'; ?>

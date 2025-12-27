<?php require_once 'public/layouts/default/start.php'; ?>
<?php
/** @var array $vars */
$app = $vars['app'];
$seasonsList = $vars['seasonsList'] ?? [];

$app->addCss('/public/styles/css/pages/admin-list.css');
$app->addJs('/public/styles/js/vendor.js');

$app->getComponent('header', [], 'admin')->render();
?>
    <div class="container">
        <div class="admin-list">
            <div class="admin-list__header">
                <h1 class="admin-list__title">Управление сезонами</h1>
                <a href="/admin/seasons/add" class="admin-list__add-btn">Добавить сезон</a>
            </div>

            <?php if (!empty($seasonsList)): ?>
                <div class="admin-list__table-wrapper">
                    <table class="admin-list__table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>№ Сезона</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($seasonsList as $season): ?>
                            <tr>
                                <td><?= htmlspecialchars($season['id']) ?></td>
                                <td><strong><?= htmlspecialchars($season['number']) ?></strong></td>
                                <td><?= htmlspecialchars($season['title']) ?></td>
                                <td class="admin-list__actions">
                                    <a href="/admin/seasons/edit/<?= htmlspecialchars($season['id']) ?>"
                                       class="admin-list__action-btn admin-list__action-btn--edit">Редактировать</a>
                                    <a href="/admin/seasons/delete/<?= htmlspecialchars($season['id']) ?>"
                                       onclick="return confirm('Вы уверены, что хотите удалить сезон №<?= htmlspecialchars($season['number']) ?> (<?= htmlspecialchars($season['title']) ?>)? Это также удалит связи с игроками.');"
                                       class="admin-list__action-btn admin-list__action-btn--delete">Удалить</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php
                // Если вы добавите пагинацию позже, этот блок будет работать
                if (!empty($pagination) && count($pagination) > 1):
                    ?>
                    <div class="admin-list__pagination">
                        <?php foreach ($pagination as $link): ?>
                            <a href="<?= htmlspecialchars($link['url']) ?>" class="admin-list__pagination-link <?= $link['active'] ? 'admin-list__pagination-link--active' : '' ?>">
                                <?= htmlspecialchars($link['text']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="admin-list__empty">Сезоны еще не созданы.</div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once 'public/layouts/default/end.php'; ?>
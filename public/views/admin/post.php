<?php require_once 'public/layouts/default/start.php'; ?>
<?php
$app = $vars['app'] ?? null;
$item = $vars['item'] ?? null;
$categories = $vars['categories'] ?? [];

$isNewPost = empty($item);

$title = $isNewPost ? 'Добавление поста' : 'Редактирование поста: ' . htmlspecialchars($item->getField('name'));
$actionUrl = $isNewPost ? '/admin/posts/add' : '/admin/posts/edit/' . htmlspecialchars($item->getField('id'));

$app->addCss('/public/styles/css/pages/admin-form.css');
$app->getComponent('header', [], 'admin')->render();
?>

    <div class="container">
        <div class="admin-form">
            <h1 class="admin-form__title"><?= $title ?></h1>

            <form action="<?= $actionUrl ?>" method="POST" class="admin-form__content">
                <div class="admin-form__group">
                    <label for="name" class="admin-form__label">Название поста:</label>
                    <input type="text" id="name" name="name" value="<?= html_entity_decode($isNewPost ? '' : $item->getField('name')) ?>" required class="admin-form__input">
                </div>

                <div class="admin-form__group">
                    <label for="announce" class="admin-form__label">Анонс:</label>
                    <textarea id="announce" name="announce" rows="4" required class="admin-form__input"><?= html_entity_decode($isNewPost ? '' : $item->getField('announce')) ?></textarea>
                </div>

                <div class="admin-form__group">
                    <label for="text" class="admin-form__label">Текст поста:</label>
                    <textarea id="text" name="detail_text" rows="10" required class="admin-form__input"><?= html_entity_decode($isNewPost ? '' : $item->getField('detail_text')) ?></textarea>
                </div>
                <?php if (!$isNewPost): ?>
                    <div class="admin-form__group">
                        <label class="admin-form__label">Дата создания:</label>
                        <input type="text" value="<?= htmlspecialchars($item->getField('date')) ?>" class="admin-form__input" disabled>
                    </div>
                <?php endif; ?>
                <div class="admin-form__group admin-form__group--checkbox">
                    <input type="hidden" name="is_server_post" value="0">
                    <input type="checkbox" id="is_server_post" name="is_server_post" value="1" <?= (!$isNewPost && $item->getField('is_server_post')) ? 'checked' : '' ?>>
                    <label for="is_server_post" class="admin-form__label">Пост сервера</label>
                </div>

                <button type="submit" class="admin-form__btn">
                    <?= $isNewPost ? 'Добавить пост' : 'Сохранить изменения' ?>
                </button>
            </form>
        </div>
    </div>


<?php require_once 'public/layouts/default/end.php'; ?>
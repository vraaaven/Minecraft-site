<?php require_once 'public/layouts/default/start.php'; ?>
<?php
/** @var array $vars */
$isNewPage = empty($item);

$title = $isNewPage ? 'Добавление страницы' : 'Редактирование страницы: ' . htmlspecialchars($item['url']);
$actionUrl = $isNewPage ? '/admin/pages/add' : '/admin/pages/edit/' . htmlspecialchars($item['id']);
$app->addCss('/public/styles/css/pages/admin-form.css');
$app->getComponent('header', [], 'admin')->render();
?>
    <div class="container">
        <div class="admin-form">
            <h1 class="admin-form__title"><?= $title ?></h1>
            <form action="<?= $actionUrl ?>" method="POST" class="admin-form__content">
                <div class="admin-form__group">
                    <label for="url" class="admin-form__label">URL страницы:</label>
                    <input type="text" id="url" name="url" value="<?= htmlspecialchars($isNewPage ? '' : $item['url']) ?>" required class="admin-form__input">
                </div>
                <div class="admin-form__group">
                    <label for="title" class="admin-form__label">Заголовок (Title):</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($isNewPage ? '' : $item['title']) ?>" required class="admin-form__input">
                </div>
                <div class="admin-form__group">
                    <label for="description" class="admin-form__label">Описание (Description):</label>
                    <textarea id="description" name="description" rows="3" class="admin-form__input"><?= htmlspecialchars($isNewPage ? '' : $item['description']) ?></textarea>
                </div>
                <div class="admin-form__group">
                    <label for="keywords" class="admin-form__label">Ключевые слова (Keywords):</label>
                    <textarea id="keywords" name="keywords" rows="3" class="admin-form__input"><?= htmlspecialchars($isNewPage ? '' : $item['keywords']) ?></textarea>
                </div>
                <button type="submit" class="admin-form__btn">
                    <?= $isNewPage ? 'Добавить страницу' : 'Сохранить изменения' ?>
                </button>
            </form>
        </div>
    </div>
<?php require_once 'public/layouts/default/end.php'; ?>
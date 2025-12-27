<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/admin-list.css');
$app->addCss('/public/styles/css/pages/admin-form.css');
$app->addJs('/public/styles/js/vendor.js');

$app->getComponent('header', [], 'admin')->render();

?>
<?php
$app = $vars['app'];
$item = $vars['item'] ?? [];
$isNew = empty($item['id']);
$selectedPlayers = $vars['selectedPlayers'] ?? [];
$allUsers = $vars['allUsers'] ?? [];
?>
<div class="container">
    <div class="admin-form">
        <h1><?= $isNew ? 'Новый сезон' : 'Редактировать сезон' ?></h1>
        <form method="POST">
            <div class="admin-form__group">
                <label>Номер сезона:</label>
                <input type="number" name="number" value="<?= $item['number'] ?? '' ?>" required class="admin-form__input">
            </div>
            <div class="admin-form__group">
                <label>Название:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required class="admin-form__input">
            </div>
            <div class="admin-form__group">
                <label>Описание (Пересказ):</label>
                <textarea name="description" rows="10" class="admin-form__input"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
            </div>

            <div class="admin-form__group">
                <label>Участники сезона:</label>
                <div class="players-selector" style="max-height: 200px; overflow-y: auto; background: rgba(255,255,255,0.05); padding: 10px; border-radius: 5px;">
                    <?php foreach ($allUsers as $user): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" name="players[]" value="<?= $user['id'] ?>"
                                   id="user_<?= $user['id'] ?>"
                                <?= in_array($user['id'], $selectedPlayers) ? 'checked' : '' ?>>
                            <label for="user_<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit" class="admin-form__btn">Сохранить</button>
        </form>
    </div>
</div>
<? require_once 'public/layouts/default/end.php'; ?>
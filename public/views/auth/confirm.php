<?php
// Получаем объект App из переменных, переданных в рендер

$message = $app->getCustomData('message') ?? 'Произошла ошибка.';

$app->getComponent('header')->render();
?>

    <div class="static">
        <div class="info-block">
            <h1>Подтверждение Email</h1>
            <p><?= htmlspecialchars($message); ?></p>
            <?php if (strpos($message, 'успешно активирован') !== false): ?>
                <a href="/login">Перейти к входу</a>
            <?php else: ?>
                <a href="/">Вернуться на главную</a>
            <?php endif; ?>
        </div>
    </div>

<?php
$app->getComponent('footer')->render();
?>
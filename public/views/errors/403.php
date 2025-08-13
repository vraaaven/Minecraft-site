<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/static.css');
$app->getComponent('header')->render();
?>
    <div class="static under-header">
        <h1>403</h1>
        <div style="padding: 30px">
            <p>Нет доступа.</p>
            <a href="/">Вернуться на главную</a>
        </div>

    </div>
<?php
$app->getComponent('footer')->render();
?>
<? require_once 'public/layouts/default/end.php'; ?>

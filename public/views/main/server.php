<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/static.css');

$app->getComponent('header')->render();
?>
<div class="static under-header">
    <h1>Информация по серверу</h1>
    <div class="static__attention">
            Устанавливаем майна без OptiFine, с ним работать не будет
    </div>
    <? $app->getComponent('how-to-get', ['file' => 'how-to-server'])->render(); ?>
</div>
<? $app->getComponent('footer')->render(); ?>
<? require_once 'public/layouts/default/end.php'; ?>


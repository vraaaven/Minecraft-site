<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/main.css');
$app->getComponent('header')->render();
?>
<div class="main under-header">
    <? $app->getComponent('banner', [], 'main')->render(); ?>
    <div id="more"></div>
    <div class="main__info-block">
        <? $app->getComponent('info-item')->render(); ?>
    </div>
    <? $app->getComponent('how-to-get', ['file' => 'how-to-main'])->render(); ?>
    <? $app->getComponent('news', $data ,'main')->render(); ?>
</div>
<? $app->getComponent('footer')->render(); ?>
<? require_once 'public/layouts/default/end.php'; ?>


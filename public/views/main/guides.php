<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/static.css');


$app->getComponent('header')->render();
?>
<div class="static under-header">
    <h1>Гайды</h1>
    <? $app->getComponent('faq', ['file' => 'how-to-server'])->render(); ?>
</div>
<? $app->getComponent('footer')->render(); ?>
<? require_once 'public/layouts/default/end.php'; ?>


<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->getComponent('header')->render();
?>

    <div class="posts under-header">
        <? $app->getComponent('news', $data, 'detail')->render(); ?>
    </div>

<? $app->getComponent('footer')->render(); ?>
<? require_once 'public/layouts/default/end.php'; ?>
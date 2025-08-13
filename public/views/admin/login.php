<?require_once 'public/layouts/default/start.php'; ?>
<?php $app->addCss('/public/styles/css/pages/static.css');
$loginFormComponent = $app->getComponent('login-form', [
    'errors' => $app->getCustomData('errors') ?? [],
    'old_input' => $app->getCustomData('old_input') ?? ['name' => ''],
    'loginProcess' => $loginProcess
]);
?>
<div class="static">
    <? $loginFormComponent->render(); ?>
</div>
<?require_once 'public/layouts/default/end.php';?>



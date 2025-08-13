<? require_once 'public/layouts/default/start.php'; ?>
<?php
$app->addCss('/public/styles/css/pages/static.css');
?>
<?php
$headerComponent = $app->getComponent('header');
$footerComponent = $app->getComponent('footer');
$loginFormComponent = $app->getComponent('registration-form', [
    'errors' => $app->getCustomData('errors') ?? [],
    'old_input' => $app->getCustomData('old_input') ?? ['name' => '']
]);
?>

<? $headerComponent->render(); ?>
    <div class="static under-header">
        <? $loginFormComponent->render(); ?>
    </div>
<? $footerComponent->render(); ?>

    </div>
<? require_once 'public/layouts/default/end.php'; ?>
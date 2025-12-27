<?php
$app = $vars['app'];
$seasons = $app->getCustomData('seasons') ?? [];
$app->addCss('/public/styles/css/pages/static.css');
$app->addCss('/public/styles/css/pages/seasons.css');
?>

<?php require_once 'public/layouts/default/start.php'; ?>
<?php $app->getComponent('header')->render(); ?>

    <div class="static">
        <h1>История сезонов</h1>

        <div class="seasons">
            <?php if (empty($seasons)): ?>
                <div class="seasons__empty">
                    <p>История еще пишется... Сезонов пока нет.</p>
                </div>
            <?php else: ?>
                <div class="seasons__grid">
                    <?php foreach ($seasons as $s): ?>
                        <section class="seasons__card">
                            <div class="seasons__badge">Сезон <?= $s['number'] ?></div>
                            <div class="seasons__content">
                                <h2 class="seasons__title"><?= htmlspecialchars($s['title']) ?></h2>
                                <p class="seasons__description">
                                    <?= mb_strimwidth(strip_tags(html_entity_decode($s['description'])), 0, 200, "...") ?>
                                </p>
                                <div class="seasons__footer">
                                    <a href="/seasons/<?= $s['id'] ?>" class="seasons__btn">
                                        Читать историю
                                    </a>
                                </div>
                            </div>
                        </section>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $app->getComponent('footer')->render(); ?>
<?php require_once 'public/layouts/default/end.php'; ?>
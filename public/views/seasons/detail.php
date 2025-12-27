<?php
/** @var array $vars */
$app = $vars['app'];
$season = $app->getCustomData('season');
$players = $app->getCustomData('players') ?? [];

$app->addCss('/public/styles/css/pages/static.css');
$app->addCss('/public/styles/css/pages/seasons.css');
$app->addCss('/public/styles/css/pages/lightbox.css');
?>

<?php require_once 'public/layouts/default/start.php'; ?>
<?php $app->getComponent('header')->render(); ?>

    <div class="static under-header">
        <div class="season-detail">
            <article class="season-detail__container">

                <header class="season-detail__header">
                    <div class="season-detail__badge">Архив событий: Сезон <?= $season['number'] ?></div>
                    <h1 class="season-detail__title"><?= html_entity_decode($season['title']) ?></h1>
                </header>

                <div class="season-detail__story-box">
                    <div class="season-detail__story-content">
                        <?= (html_entity_decode($season['description'])) ?>
                    </div>
                </div>

                <div class="season-detail__divider">
                    <span class="season-detail__divider-text">Участники сезона (<?= count($players) ?>)</span>
                </div>

                <section class="season-detail__participants">
                    <div class="season-detail__players-grid">
                        <?php if (!empty($players)): ?>
                            <?php foreach ($players as $player): ?>
                                <div class="season-player-card">
                                    <a href="/user/<?= $player['id'] ?>" class="season-player-card__link">
                                        <div class="season-player-card__media">
                                            <div class="skin-face-clipper" style="--size: 64px">
                                                <img src="<?= $player['skin_url'] ?: '/public/img/default_skin_head.png' ?>" class="skin-face-face">
                                                <img src="<?= $player['skin_url'] ?: '/public/img/default_skin_head.png' ?>" class="skin-face-helmet">
                                            </div>
                                        </div>
                                        <div class="season-player-card__info">
                                            <span class="season-player-card__name"><?= htmlspecialchars($player['name']) ?></span>
                                            <?php if (!empty($player['role']) && $player['role'] !== 'Игрок'): ?>
                                                <span class="season-player-card__role"><?= htmlspecialchars($player['role']) ?></span>
                                            <?php else: ?>
                                                <span class="season-player-card__role">Участник</span>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="season-detail__empty">В этом сезоне пока нет записанных участников.</p>
                        <?php endif; ?>
                    </div>
                </section>
                <a href="/seasons" class="season-detail__back">← Назад к списку</a>
                <?php
                $adjacent = $app->getCustomData('adjacent');
                $prev = $adjacent['prev'];
                $next = $adjacent['next'];
                ?>

                <section class="season-detail__nav season-nav">
                    <div class="season-nav__container">
                        <?php if ($prev): ?>
                            <a href="/seasons/<?= $prev['id'] ?>" class="season-nav__link season-nav__link--prev">
                                <span class="season-nav__label">← Предыдущий</span>
                                <span class="season-nav__name">Сезон <?= $prev['number'] ?>: <?= htmlspecialchars($prev['title']) ?></span>
                            </a>
                        <?php else: ?>
                            <div class="season-nav__placeholder"></div>
                        <?php endif; ?>

                        <?php if ($next): ?>
                            <a href="/seasons/<?= $next['id'] ?>" class="season-nav__link season-nav__link--next">
                                <span class="season-nav__label">Следующий →</span>
                                <span class="season-nav__name">Сезон <?= $next['number'] ?>: <?= htmlspecialchars($next['title']) ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </section>
            </article>
        </div>
    </div>
    <div class="lightbox" id="myLightbox">
        <div class="lightbox__content">
            <span class="lightbox__close-btn">&times;</span>
            <img src="" alt="" class="lightbox__image">
        </div>
    </div>
<?php $app->getComponent('footer')->render(); ?>
<?php require_once 'public/layouts/default/end.php'; ?>
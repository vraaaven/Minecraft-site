<div class="news-main">
    <h2>Новости</h2>
    <div class="news-main__list">
        <?php foreach ($posts as $post) : ?>
        <a href="/news/<?= \App\Lib\Helper::slugify($post->getField('name')) ?>/" class="news-main__item">
            <div class="news-main__item-title"><?= $post->getField('name') ?></div>
            <div class="news-main__item-text">
                <?= $post->getField('announce') ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <a class="news-main__all-news" href="/news">Все новости</a>
</div>

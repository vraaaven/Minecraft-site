<div class="posts-list">
    <div class="posts-list__title-card">
        <h1>Новости</h1>
        <div class="posts-list__title-card-count">Всего новостей: <?= $count ?></div>
    </div>
    <div class="posts-list__cards">
        <?php foreach ($posts as $post) : ?>
            <a href="/news/<?= \App\Lib\Helper::slugify($post->getField('name')) ?>/" class="posts-list__card">
                <img src="/public/images/posts/<?= $post->getField('id') ?>.png" alt="" class="posts-list__image">
                <div class="posts-list__text-block">
                    <div class="posts-list__header-block">
                        <div class="posts-list__name"><?= $post->getField('name') ?></div>
                        <div class="posts-list__date"><?= \App\Lib\Helper::formateDate($post->getField('date')) ?></div>
                    </div>
                    <div class="posts-list__title"><?= $post->getField('announce') ?></div>

                </div>

            </a>
        <?php endforeach; ?>
    </div>
    <div class="posts-list__ajax-button">
        <input type="button" value="Еще новости" id="show-more" data-total="<?= $count ?>">
    </div>
</div>
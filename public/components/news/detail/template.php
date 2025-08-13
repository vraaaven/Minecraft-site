<div class="post-detail">
    <div class="post-detail__header">
        <h1 class="post-detail__title"><?= htmlspecialchars($post->getField('name')) ?></h1>
        <time class="post-detail__date"><?= \App\Lib\Helper::formateDate($post->getField('date')) ?></time>
    </div>
    <div class="post-detail__text">
        <?= $post->getField('detail_text') ?>
    </div>
</div>
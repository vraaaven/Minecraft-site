<?php

require_once('public/views/components/header.php'); ?>
<div class="post__wrapper">
    <div class="post__article" data-id="<?= $post->getField('id') ?>">
        <h1 class="post__title"><?= $post->getField('announce') ?></h1>
        </div>
        <div><?= $post->getField('date') ?></div>
        <div><?= $post->getField('detail_text') ?></div>
    </div>
</div>
<?php require_once('public/views/components/footer.php'); ?>

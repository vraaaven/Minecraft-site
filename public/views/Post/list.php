<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/public/components/header/public/css/styles.css">
    <link rel="stylesheet" href="/public/components/footer/public/css/styles.css">
    <link rel="stylesheet" href="/public/components/news/public/css/styles.css">
    <link rel="stylesheet" href="/public/components/main/css/styles.css">
    <link rel="stylesheet" href="default.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
          rel="stylesheet">
</head>
<body>
<?php $components['menu']->showComponent('header', 'public'); ?>
<div class="container">
    <div class="posts-list">
        <div class="posts-list__title-card">
            <h1>Новости</h1>
            <div class="posts-list__title-card-count"><?= $count ?> статей</div>
        </div>
        <div class="posts-list__cards">
            <?php foreach ($posts as $post) : ?>
                <a href="/detail/<?=$post->getField('id')?>" class="posts-list__card">
                    <img src="/public/images/91f844ec56c6f60a.png" alt="" class="posts-list__image">
                    <div class="posts-list__text-block">
                        <div class="posts-list__title"><?= $post->getField('announce')?></div>
                        <time class="posts-list__date"><?= \App\Lib\Helper::formateDate($post->getField('date'))?></time>
                    </div>

                </a>
            <?php endforeach; ?>
        </div>
        <div class="ajax-button">
            <input type="button" value="Еще новости" id="show-more" data-total="<?= $count ?>">
        </div>
    </div>
</div>
<?php $components['footer']->showComponent('footer', 'public'); ?>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="/public/components/header/public/css/styles.css">
    <link rel="stylesheet" href="/public/components/footer/public/css/styles.css">
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
    <div class="main">
        <div class="main__banner">
            <img src="/public/components/main/images/24122036_08084d7ee2.jpeg" alt="" class="main_banner-image">
            <div class="main__banner-text-container">
                <h1 class="main__banner-headline">FIUGHSAIGFIUSGUFI</h1>
                <div class="main__banner-text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolores et fuga molestiae obcaecati?
                    Adipisci aliquid animi nobis ratione repudiandae! Autem ducimus ipsum molestias totam. Dolor
                    doloremque explicabo natus similique?
                </div>
                <a href="" class="main__banner-reg">Регистрация</a>
            </div>
        </div>
        <div class="main__news-slider">
            <a href="" class="main__news-headline">
                <h2>Новости</h2>
            </a>
            <div class="main__slider">
                <div class="main__slider-item">
                    <a href="" class="main__slider-link">
                        <img src="/public/components/main/images/photo_2024-04-16_11-35-40.jpg" alt=""
                             class="main__slider-img">
                        <div class="main__slider-text">НОВОСТЬ ДАВАЙ УРА</div>
                        <div class="main__slider-date">11.11.2024</div>
                    </a>
                </div>
                <div class="main__slider-item">
                    <a href="" class="main__slider-link">
                        <img src="/public/components/main/images/photo_2024-04-16_11-35-40.jpg" alt=""
                             class="main__slider-img">
                        <div class="main__slider-text">НОВОСТЬ ДАВАЙ УРА</div>
                        <div class="main__slider-date">11.11.2024</div>
                    </a>
                </div>
                <div class="main__slider-item">
                    <a href="" class="main__slider-link">
                        <img src="/public/components/main/images/photo_2024-04-16_11-35-40.jpg" alt="" class="main__slider-img">
                        <div class="main__slider-text">НОВОСТЬ ДАВАЙ УРА</div>
                        <div class="main__slider-date">11.11.2024</div>
                    </a>
                </div>
            </div>
        </div>
        <div class="main__desc">
            <div class="main__desc-item">
                <div class="main__desc-block">
                    <div class="main__desc-headline">FJMSHFISFGUS</div>
                    <div class="main__desc-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi dolorem doloremque eaque earum, esse et eum, eveniet facilis illo obcaecati odio optio porro quo reprehenderit sapiente suscipit totam! Quod, veritatis.</div>
                </div>
                <div class="main__desc-img">
                    <img src="/public/components/main/images/24122036_08084d7ee2.jpeg" alt="">
                </div>
            </div>
            <div class="main__desc-item">
                <div class="main__desc-block">
                    <div class="main__desc-headline">FJMSHFISFGUS</div>
                    <div class="main__desc-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi dolorem doloremque eaque earum, esse et eum, eveniet facilis illo obcaecati odio optio porro quo reprehenderit sapiente suscipit totam! Quod, veritatis.</div>
                </div>
                <div class="main__desc-img">
                    <img src="/public/components/main/images/24122036_08084d7ee2.jpeg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $components['footer']->showComponent('footer', 'public'); ?>
</body>
</html>
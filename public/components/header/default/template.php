<div class="header">
    <div class="header__logo-container">
        <img src="/public/images/logo.webp" alt="">
    </div>
    <div class="header__container" id="mobile-menu">
        <nav>
            <ul class="header__menu">
                <li class="header__menu-item">
                    <a href="/" class="header__menu-link">Главная</a>
                </li>
                <li class="header__menu-item">
                    <a href="/news/" class="header__menu-link">Новости</a>
                </li>
                <li class="header__menu-item">
                    <a href="/guides/" class="header__menu-link">Гайды</a>
                </li>
                <?if (\App\Models\User::isPlayer()):?>
                    <li class="header__menu-item">
                        <a href="/server/" class="header__menu-link">Сервер</a>
                    </li>
                <?endif;?>
            </ul>
        </nav>
        <div class="header__control">
            <?if (isset($_SESSION['user_id'])):?>
                <a href="/user/"><?=$_SESSION['user_name']?></a>
                <a href="/logout">выйти</a>
            <?else:?>
                <a href="/login/">вход</a>
                <a href="/registration/">регистрация</a>
            <?endif;?>
        </div>
    </div>
    <div class="header__burger-btn" id="burger-btn">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </div>
</div>
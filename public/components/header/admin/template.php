<div class="header">
    <div class="header__container">
        <nav>
            <ul class="header__menu">
                <li class="header__menu-item">
                    <a href="/admin/dashboard" class="header__menu-link">Главная</a>
                </li>
                <li class="header__menu-item">
                    <a href="/admin/posts" class="header__menu-link">Новости</a>
                </li>
                <li class="header__menu-item">
                    <a href="/admin/users/" class="header__menu-link">Пользователи</a>
                </li>
                <li class="header__menu-item">
                    <a href="/admin/pages/" class="header__menu-link">Страницы</a>
                </li>
                <li class="header__menu-item">
                    <a href="/" class="header__menu-link">Вернуться на сайт</a>
                </li>
            </ul>
        </nav>
        <div class="header__control">
            <a href="/admin/users/<?= $_SESSION['user_id'] ?>"><?= $_SESSION['user_name'] ?></a>
            <a href="/logout">выйти</a>
        </div>
    </div>
</div>
<div class="main-banner">
    <div class="main-banner__item" style="background:linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(/public/images/banner.webp) no-repeat 50% 85% / cover;">
        <div class="main-banner__container">
            <div class="main-banner__text-container">
                <div class="main-banner__text-title">
                    ДОБРО ПОЖАЛОВАТЬ НА СЕРВЕР <br>
                    <span>MageLand</span>
                </div>
                <div class="main-banner__text">
                    <p>Присоединяйся к нашему серверу, созданному для стримеров Олексы и Вравена!</p>
                    <p>Исследуй мир магии, сражайся с драконами и боссами и стань часть дружного сообщества. Твое
                        приключение начинается здесь!</p>
                </div>
            </div>
            <? if (!isset($_SESSION['user_id'])): ?>
                <a href="" class="main-banner__reg">Регистрация</a>
            <? endif; ?>
        </div>
        <div class="main-banner__more-container">
            <a class="main-banner__more" href="#more">Подробнее</a>
        </div>
    </div>
</div>
<div class="footer">
    <div class="footer__item">
        <div class="footer__menu-container">
            <div class="footer__headline">Ссылки</div>
            <ul class="footer__menu">
                <li class="footer__menu-item">
                    <a href="/" class="footer__menu-link">Главная</a>
                </li>
                <li class="footer__menu-item">
                    <a href="/news/" class="footer__menu-link">Новости</a>
                </li>
                <li class="footer__menu-item">
                    <a href="/guides/" class="footer__menu-link">Гайды</a>
                </li>
                <?if (\App\Models\User::isPlayer()):?>
                <li class="footer__menu-item">
                    <a href="/server/" class="footer__menu-link">Сервер</a>
                </li>
                <?endif;?>
            </ul>
        </div>
    </div>
    <div class="footer__item">
        <div class="footer__socials">
            <div class="footer__headline">Соцсети</div>
            <div class="footer__socials">
                <div class="footer__socials-item">
                    <div class="footer__socials-icon">
                        <img src="/public/images/twitch.png">
                    </div>
                    <a href="https://www.twitch.tv/oleksagompers" class="footer__socials-link" rel="nofollow">OleksaGompers</a>
                </div>
                <div class="footer__socials-item">
                    <div class="footer__socials-icon">
                        <img src="/public/images/twitch.png">
                    </div>
                    <a href="https://www.twitch.tv/vraaaaven" class="footer__socials-link" rel="nofollow">vraaaaven</a>
                </div>
                <div class="footer__socials-item">
                    <div class="footer__socials-icon">
                        <img src="/public/images/tg-icon.png">
                    </div>
                    <a href="https://t.me/+rwdgw65FHtxlMjQy" class="footer__socials-link" rel="nofollow">ТГ Олексы</a>
                </div>
                <div class="footer__socials-item">
                    <div class="footer__socials-icon">
                        <img src="/public/images/tg-icon.png">
                    </div>
                    <a href="https://t.me/+77EG7_ICL-c0MjEy" class="footer__socials-link" rel="nofollow">ТГ Вравена</a>
                </div>
            </div>
        </div>
    </div>
</div>
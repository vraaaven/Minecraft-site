//scroll

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    const mainContent = document.querySelector('.under-header');
    const headerHeight = header.offsetHeight;

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 0) {
            header.classList.add('scroll');
            mainContent.style.marginTop = headerHeight + 'px';
        } else {
            header.classList.remove('scroll');
            mainContent.style.marginTop = '0';
        }
    });

    const accordionItems = document.querySelectorAll('.faq__item');
    if (accordionItems) {
        accordionItems.forEach(item => {
            const question = item.querySelector('.faq__question');
            question.addEventListener('click', () => {
                accordionItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });
                item.classList.toggle('active');
            });
        });
    }

    let sliderInitialized = false;

    function initializeSlider() {
        if (window.innerWidth <= 1100 && !sliderInitialized) {
            $(".slider").slick({
                arrows: true,
                prevArrow:
                    '<i class="slider__arrow slider__arrow--prev"><svg class="icon icon-arrow"><use xlink:href="#icon-arrow"></svg></i>',
                nextArrow:
                    '<i class="slider__arrow slider__arrow--next"><svg class="icon icon-arrow"><use xlink:href="#icon-arrow"></svg></i>',
                dots: true,
                dotsClass: "slider__dots",
                autoplay: true,
                autoplaySpeed: 3000,
                infinite: true, // Use infinite: true for a continuous loop
                adaptiveHeight: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });
            sliderInitialized = true;
        } else if (window.innerWidth > 1100 && sliderInitialized) {
            $(".slider").slick("unslick");
            sliderInitialized = false;
        }
    }

    // Call the function on page load
    initializeSlider();

    // Call the function on window resize
    window.addEventListener('resize', initializeSlider);
});

document.addEventListener('DOMContentLoaded', () => {
    const burgerBtn = document.getElementById('burger-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    burgerBtn.addEventListener('click', () => {
        // Переключаем класс для анимации бургера
        burgerBtn.classList.toggle('is-open');
        // Переключаем класс для показа/скрытия меню
        mobileMenu.classList.toggle('is-open');
    });

    // Опционально: закрытие меню при клике на пункт
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            burgerBtn.classList.remove('is-open');
            mobileMenu.classList.remove('is-open');
        });
    });
});



document.addEventListener('DOMContentLoaded', () => {
    // 1. Проверяем, существует ли главный элемент модалки
    const lightbox = document.getElementById('myLightbox');

    if (lightbox) {
        const lightboxImage = lightbox.querySelector('.lightbox__image');
        const closeBtn = lightbox.querySelector('.lightbox__close-btn');

        // Функция для открытия модалки
        function openLightbox(imageSrc) {
            lightboxImage.src = imageSrc;
            lightbox.classList.add('is-visible');
        }

        // Функция для закрытия модалки
        function closeLightbox() {
            lightbox.classList.remove('is-visible');
        }

        // 2. Проверяем, существуют ли изображения
        const imageElements = document.querySelectorAll('.info-item__img img');
        if (imageElements.length > 0) {
            imageElements.forEach(img => {
                img.addEventListener('click', (e) => {
                    const fullImageSrc = e.target.getAttribute('data-full-image');
                    if (fullImageSrc) {
                        openLightbox(fullImageSrc);
                    }
                });
            });
        }

        // 3. Проверяем, существует ли кнопка закрытия
        if (closeBtn) {
            closeBtn.addEventListener('click', closeLightbox);
        }

        // 4. Добавляем слушатели событий на модалку и документ
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && lightbox.classList.contains('is-visible')) {
                closeLightbox();
            }
        });
    }
});
$(document).ready(function() {
    let header = $('.header');
    window.addEventListener('scroll', function () {
        if (window.pageYOffset > 0) {
            header.addClass('scroll');
        } else {
            header.removeClass('scroll');
        }
    });
})
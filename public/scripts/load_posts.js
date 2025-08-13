$(document).ready(function () {
    let page = 1; //
    let count = $('.posts-list__card').length;
    let limit = $('#show-more').attr('data-total');
    if (count >= limit) {
        $('.ajax-button').hide();
    }
    function loadPosts(page)
    {
        $.ajax({
            url: '/posts/load',
            type: 'POST',
            dataType: 'json',
            data: {page: page},
            success: function (result) {
                result.posts.forEach((element) => {
                    $('.posts-list__cards').append(
                        '<a href="/detail/' + element.id + '" class="posts-list__card">' +
                        '<div class="posts-list__title">' + element.name + '</div>' +
                        '<time class="posts-list__date">' + element.date + '</time>' +
                        '</a>'
                    )
                })
                count = ($('.posts-list__card').length)
                if (count >= limit) {
                    $('.ajax-button').hide();
                }
            },
            error: function (xhr, status, error) {
                console.log('errrrrorrrrr');
            }
        });
    }
    $('body').on('click', '.ajax-button', function () {
        page++;
        history.pushState(null, null, '/posts/' + page);
        loadPosts(page); // загружаем посты
    });
});
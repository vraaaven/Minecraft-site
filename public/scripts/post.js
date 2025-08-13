$(document).ready(function () {
    $('body').on('click', '.js_set_reaction', function () {
        let id = $('.post__article').data('id');
        let type = $(this).data('type')
        $.ajax({
            url: '/detail/reactions',
            type: 'POST',
            dataType: 'json',
            data: {id: id, type: type},
            success: function (result) {
                $('.js-like').text(result.likes);
                $('.js-dislike').text(result.dislikes);
            }
        })
    });
})
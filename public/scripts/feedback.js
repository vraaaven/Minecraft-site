$(document).ready(function () {
    $('#js-feedback').on('submit', function (e) {
        let data = new FormData(this)
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (result) {
                if (result.status == 'success') {
                    console.log(result)
                    $('.feedback').append('<div class="feedback__message-sended">' +
                        '<div class="feedback__message-field">ФИО: ' + result.data.name + '</div>' +
                        '<div class="feedback__message-field"> Адрес: ' + result.data.address + '</div>' +
                        '<div class="feedback__message-field"> email: ' + result.data.email + '</div>' +
                        '<div class="feedback__message-field"> Телефон: ' + result.data.phone + '</div>' +
                        '</div>'
                    );
                }
                if (result.status == 'error') {
                    alert('ОШИБКА')
                }
            }
        });
        $("#form").trigger('reset');
        e.preventDefault();
    });
})
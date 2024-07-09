<?php

require_once('public/views/components/header.php'); ?>
<div class="feedback">
    <form action="/feedback/send" method="post" id="js-feedback" class="feedback__form">
        <div class="feedback__submit-btn-container">
            <input type="text" class="feedback__form-field" name="name" placeholder="ФИО *" required>
            <input type="text" class="feedback__form-field" name="address" placeholder="адрес *" required>
            <input type="tel" class="feedback__form-field" id="phone" name="phone" placeholder="телефон *" required>
            <input type="email" class="feedback__form-field" name="email" placeholder="email *" required>
            <input type="submit" value="Отправить" class="feedback__submit-btn">
        </div>
    </form>

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.js"
        type="text/javascript"></script>
<script>
    $("#phone").mask("+7(999)999-99-99");
</script>
<script src="/public/scripts/feedback.js"></script>
<?php require_once('public/views/components/footer.php'); ?>

<?php
// App/Lib/Mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function sendConfirmationEmail(string $to, string $token): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your-email@gmail.com'; // Ваш email
            $mail->Password   = 'your-password';   // Ваш пароль или App-пароль
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Настройки письма
            $mail->setFrom('noreply@dev.stream', 'Dev Stream');
            $mail->addAddress($to);

            // Содержание письма
            $activationLink = "http://dev.stream/confirm-email?token=" . urlencode($token);
            $mail->isHTML(false); // Указываем, что письмо будет в виде простого текста
            $mail->Subject = 'Подтверждение регистрации';
            $mail->Body    = "Привет! Чтобы активировать ваш аккаунт, пожалуйста, перейдите по следующей ссылке:\n\n" . $activationLink;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
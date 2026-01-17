<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php'; // Composer autoload

function sendVerificationEmail($toEmail, $body)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abdallahkhoder59@gmail.com';        // Mailtrap username
        $mail->Password = 'zybwjdhexwpxczgs';           // Mailtrap password / API token
        $mail->SMTPSecure = 'tls';                        // Encryption
        $mail->Port = 587;                          // Port

        // Sender & Recipient
        $mail->setFrom('abdallahkhoder59@gmail.com', 'paintball.world');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Email verification for paintBall';


        $mail->Body = $body;

        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log error or handle it
        return false;
    }
}
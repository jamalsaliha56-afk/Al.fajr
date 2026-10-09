<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function sendAdminAlert($subject, $message)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // Yahan apni Gmail
        $mail->Username   = 'jamalsaliha56@gmail.com';

        // Yahan Gmail App Password
        $mail->Password   = 'ojfykezugvbvgffc';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom(
            'jamalsaliha56@gmail.com',
            'Al.fajr'
        );

        // Jis email par notification chahiye
        $mail->addAddress(
            'jamalsaliha56@gmail.com'
        );

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}
?>
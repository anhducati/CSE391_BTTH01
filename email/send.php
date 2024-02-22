<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server hostname
    $mail->SMTPAuth = true;
    $mail->Username = 'anhducati1406@gmail.com'; // Your SMTP username
    $mail->Password = 'iyfjhhjggiuovugg'; // Your SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->CharSet="UTF-8";
    // Recipients
    $mail->setFrom('anhducati1406@gmail.com', 'Duong Anh');
    $mail->addAddress('anhducati.211@gmail.com');
   // $mail->AddAttachment('upload/LSD-TN.pdf' , 'LSD-TN.pdf');
    // Content
    $mail->isHTML(true);
    $mail->Subject = '[CSE485] ';
    $mail->Body    = 'Test mail ';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Error: ', $mail->ErrorInfo;
}
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

interface EmailServerInterface {
	public function sendEmail($to, $subject, $message);
}

class EmailSender {
    private $emailServer;

    public function __construct(EmailServerInterface $emailServer) {
        $this->emailServer = $emailServer;
    }

    public function send($to, $subject, $message) {
        $this->emailServer->sendEmail($to, $subject, $message);
    }
}
class MyEmailServer implements EmailServerInterface {
    public function sendEmail($to,$user,$token) {
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
                    $mail->addAddress($to);
                    
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Xác thực tài khoản của bạn';
                    $mail->Body    = '<p>Vui lòng nhấp vào liên kết sau để xác thực tài khoản của bạn:</p><p><a href="http://localhost/BTTH03/index.php?controller=member&action=active&user='.$user.'&token='.$token.'">http://localhost/BTTH03/index.php?controller=member&action=active&user='.$user.'&token='.$token.'</a></p>';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo 'Message could not be sent. Error: ', $mail->ErrorInfo;
                }
    }
}

?>
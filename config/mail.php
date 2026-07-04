<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();

$mail->Host = $_ENV['MAIL_HOST'];

$mail->SMTPAuth = true;

$mail->Username = $_ENV['MAIL_USERNAME'];

$mail->Password = $_ENV['MAIL_PASSWORD'];

$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port = $_ENV['MAIL_PORT'];

$mail->CharSet = 'UTF-8';

$mail->setFrom(
    $_ENV['MAIL_FROM'],
    $_ENV['MAIL_FROM_NAME']
);

return $mail;
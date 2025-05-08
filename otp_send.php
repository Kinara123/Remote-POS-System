<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './PHPMailer/src/Exception.php';
require_once './PHPMailer/src/PHPMailer.php';
require_once './PHPMailer/src/SMTP.php';

// Instantiation and passing [ICODE]true[/ICODE] enables exceptions
$mail = new PHPMailer;

try {
  //Server settings
  $mail->SMTPDebug = 0; // Enable verbose debug output
  $mail->isSMTP(); // Set mailer to use SMTP
  $mail->Host = 'litwebtech.com;'; // Specify main and backup SMTP servers
  $mail->SMTPAuth = true; // Enable SMTP authentication
  $mail->Username = 'test@litwebtech.com'; // SMTP username
  $mail->Password = '*$f6C8cDn(R^'; // SMTP password
  $mail->SMTPSecure = 'tls'; // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted
  $mail->Port = 587; // TCP port to connect to

  //Recipients
  $mail->setFrom('test@litwebtech.com', 'SHIBE POS Secure System');
  if (!isset($l_name)) {
    $l_name = $email;
  }
  $mail->addAddress($email, $l_name);

  $mail->isHTML(true); // Set email format to HTML
  $mail->Subject = 'OTP PASSWORD';
  $mail->Body = $otp;
  $mail->AltBody = $otp;

  $mail->send();
  $sent = true;
} catch (Exception $e) {
  $sent = false;
}

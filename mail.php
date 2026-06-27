<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
$env = parse_ini_file(__DIR__ . '/.env');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output SMTP::DEBUG_SERVER
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $env['MAIL_HOST'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $env['MAIL_USERNAME'];                     //SMTP username
    $mail->Password   = $env['MAIL_PASSWORD'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = $env['MAIL_PORT'];                                    //TCP port to connect to; use 587/465 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS / PHPMailer::ENCRYPTION_SMTPS`

    //Recipients
    $mail->setFrom($env['MAIL_USERNAME'], "VittaVeda Website");
    $mail->addReplyTo($email, $firstName . " " . $lastName);
    $mail->addAddress("yash.panhale.syncedge@gmail.com"); //aryan.shirodkar.syncedge@gmail.com
    $mail->Subject = "New Consultation Request Received";
    $mail->isHTML(true);
    $mail->Body = "
        <h2>New Consultation Request</h2>

        <p>A new consultation request has been submitted through the website.</p>

        <hr>

        <b>Name:</b> $firstName $lastName <br>

        <b>Email:</b> $email <br>

        <b>Phone:</b> $phone <br>

        <b>Service:</b> $category <br>

        <b>Message:</b><br>

        $message

        <hr>

        <b>Submitted On:</b> " . date("d-m-Y h:i:s A");
    $mail->send();
    $mail->clearAddresses();
    $mail->clearReplyTos();

    $mail->setFrom($env['MAIL_USERNAME'], "VittaVeda");
    $mail->addAddress($email, $firstName . " " . $lastName);
    $mail->Subject = "Thank You for Contacting VittaVeda";
    $mail->Body = "
        <h2>Thank You for Contacting VittaVeda!</h2>

        <p>Dear <b>$firstName</b>,</p>

        <p>Thank you for reaching out to VittaVeda. We have successfully received your consultation request.</p>

        <p>Our team will review your request and get in touch with you as soon as possible.</p>

        <p>
        For any queries, feel free to contact us.
        </p>

        <p>
        Regards,<br>
        <b>Team VittaVeda</b>
        </p>
        ";
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
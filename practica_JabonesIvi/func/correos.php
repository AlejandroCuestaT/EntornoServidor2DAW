<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
//MIRAR SPL
spl_autoload_register(function ($a) {

});
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function configuracion()
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Mailer = ("SMTP");
        $mail->Host = 'localhost';
        $mail->SMTPAuth = false;
        $mail->Username = ''; // CORREO
        $mail->Password = ''; // PASS
        $mail->Port = 25;//PUERTO DE ENTRADA

        return $mail;
    } catch (Exception $e) {
        return null;
    }
}

function enviarCorreoHTML($destinatario, $nombre, $asunto, $cuerpo)
{
    $mail = configuracion();
    if (!$mail)
        return false;
    try {
        $mail->addAddress($destinatario);
        $mail->isHTML(true);
        $mail->Subject = $asunto;

        $mail->Body = $cuerpo;
        echo $mail->send();
    } catch (\Throwable $th) {
        return false;
    }
}
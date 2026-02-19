<?php
function enviarEmail($email, $asunto, $body, $attach)
{
    require './PHPMailer-master/src/Exception.php';
    require './PHPMailer-master/src/PHPMailer.php';
    require './PHPMailer-master/src/SMTP.php';
    $recipients = $email;
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Mailer = "SMTP";
    $mail->SMTPAuth = true;
    $mail->isHTML(true);
    $mail->SMTPAutoTLS = false;
    $mail->Port = 25;
    $mail->CharSet = 'UTF-8';
    $mail->Host = "localhost";
    $mail->Username = "alex@mail.es";
    $mail->Password = "12345678";
    $mail->setFrom('alex@mail.es');

    if (isset($attach)) {
        $mail->addAttachment($attach);
    }

    if (is_array($email)) {
        foreach ($recipients as $email) {
            $mail->addAddress($email);
        }
    } else {
        $mail->addAddress($email);
    }
    $mail->Subject = $asunto;
    $mail->Body = $body;

    if (!$mail->send()) {
        echo $mail->ErrorInfo;
    } else {
        
        echo 'El mensaje ha sido enviado correctamente. <br> Revise su bandeja de entrada.';
        echo '<br>';
        echo "<strong><a href='home.php'>Home</a></strong>";
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    enviarEmail($_POST['destinatario'], $_POST['asunto'], $_POST['mensaje'], '');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="margin-top: 30px; border: 1px solid #ccc; padding: 20px;">
    <h3>Enviar Correo de Prueba</h3>
    <form action="enviarMail.php" method="post">
        <label>Destinatario:</label><br>
        <input type="email" name="destinatario" required placeholder="correo@ejemplo.com"><br><br>
        
        <label>Asunto:</label><br>
        <input type="text" name="asunto" required placeholder="Prueba de examen"><br><br>
        
        <label>Mensaje:</label><br>
        <textarea name="mensaje" rows="4" required></textarea><br><br>
        
        <button type="submit" name="enviar">Enviar Email</button>
    </form>
</div>
</body>
</html>




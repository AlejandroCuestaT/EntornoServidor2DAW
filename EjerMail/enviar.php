<?php
// Recogemos los datos del formulario usando $_POST
// Usamos el operador ternario (condición ? si_verdadero : si_falso) para evitar errores si está vacío
$email_destino = $_POST['destinatario_email'];
$asunto        = $_POST['tema'];
$texto_mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : "Sin mensaje";
$imagen        = $_POST['imagen'];

// --- CONSTRUCCIÓN DEL CORREO (HTML) --- [cite: 11]

// Empezamos a crear el cuerpo del mensaje usando código HTML
$cuerpo = "<html><body>";
$cuerpo .= "<h2>Hola estimado cliente</h2>";
$cuerpo .= "<p>Tienes un nuevo mensaje de nuestra empresa:</p>";

// Añadimos el texto que escribió el usuario en un recuadro bonito
$cuerpo .= "<div style='border:1px solid #ccc; padding:10px; background-color:#f9f9f9;'>";
$cuerpo .= "<p>" . nl2br($texto_mensaje) . "</p>"; // nl2br convierte los saltos de línea en <br>
$cuerpo .= "</div>";

// Lógica: Si ha seleccionado una imagen, la incluimos [cite: 18]
if (!empty($imagen)) {
    // NOTA: Para correos reales, la imagen debe estar alojada en un servidor real (http://midominio.com/img...)
    // Aquí simulamos que la imagen se enlaza desde nuestra web local.
    $ruta_imagen = "http://localhost/tu_proyecto/img/" . $imagen;
    $cuerpo .= "<h3>Te enviamos esta postal:</h3>";
    $cuerpo .= "<img src='$ruta_imagen' alt='Imagen adjunta' width='300'>";
}

$cuerpo .= "<p>Saludos cordiales,<br>Tu Empresa</p>";
$cuerpo .= "</body></html>";


// --- CABECERAS (HEADERS) OBLIGATORIAS PARA HTML ---
// Esto es vital. Sin esto, el correo se vería como código fuente puro (<html><body>...)
$headers  = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

// Cabeceras adicionales (quién lo envía)
$headers .= "From: Empresa <no-reply@empresa.com>" . "\r\n";


// --- ENVÍO DEL CORREO ---
// La función mail devuelve TRUE si se aceptó para envío, FALSE si falló.
$resultado = mail($email_destino, $asunto, $cuerpo, $headers);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Envío</title>
</head>
<body>
    <center>
        <?php if ($resultado): ?>
            <h1 style="color: green;">¡Correo enviado con éxito!</h1>
            <p>Se envió a: <?php echo $email_destino; ?></p>
        <?php else: ?>
            <h1 style="color: red;">Error al enviar</h1>
            <p>Comprueba que tienes configurado un servidor SMTP (como Mercury o Sendmail) en tu XAMPP.</p>
        <?php endif; ?>

        <a href="index.php">Volver a enviar otro correo</a>
    </center>
</body>
</html>
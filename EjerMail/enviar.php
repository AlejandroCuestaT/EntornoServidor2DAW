<?php
//Establezco conexion
$conexion = mysqli_connect("localhost", "alex", "1234", "ejercicio_mail");

//Recojo las datos por POST
$idCliente = $_POST['idCliente'];
$tema       = $_POST['tema'];
$mensaje = $_POST['mensaje'];
$foto       = $_POST['foto'];

//Hacemos la query de la id en concreto y recogemos los datos del cliente
$query = "SELECT nombre, apellidos, email FROM clientes WHERE id = $idCliente";
$resultado = mysqli_query($conexion, $query);
$cliente = mysqli_fetch_assoc($resultado);

//Recogemos el correo del cliente
$destinatario = $cliente['email'];
$nombre = $cliente['nombre'] . " " . $cliente['apellidos'];

//Texto del asunto
$asunto = "From: Empresa de Alex <alex@scarlatti.com>\r\n";

//Texto del cuerpo
$cuerpo = "<html><body>";
$cuerpo .= "<h1>Hola " . $nombre . "</h1>";
$cuerpo .= "<h3>Tema: " . $tema . "</h3>";
$cuerpo .= "<p>" . $mensaje . "</p>";

//Si no esta vacia la foto, se enseña
if (!empty($foto)) {
    $cuerpo .= "<p><img src='IMG/" . $foto . "' width='200'></p>";
}

$cuerpo .= "<p>Desde Alex SL queriamos agradecerte tu trabajo y compromiso, sigue asi :)</p>";
$cuerpo .= "</body></html>";

//Enviamos el correo si el puerto 25 esta levantado y el correo existe
if (mail($destinatario, $tema, $cuerpo, $asunto)) {
    echo "<h1>Resultado del envío</h1>";
    echo "<p>El correo ha sido capturado por el servidor local para: " . $destinatario . "</p>";
} else {
    echo "<h1>Error</h1>";
    echo "<p>Asegúrate de que Test Mail Server Tool esté abierto en el puerto 25.</p>";
}

echo "<br><a href='index.php'>Volver a la página inicial</a>";

mysqli_close($conexion);
?>
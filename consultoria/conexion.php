<?php
// Datos de conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$bd   = "consultoria_db";

// Conectamos
$con = mysqli_connect($host, $user, $pass, $bd);

// Si falla la conexión, paramos
if (!$con) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
?>

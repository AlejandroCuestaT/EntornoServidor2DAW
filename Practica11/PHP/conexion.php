<?php

$servidor = "localhost";
$usuario = "web"; 
$password = "1234";  
$bbdd = "inmobiliaria";

$conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

if (!$conexion) {
    die("Fallo la conexión: " . mysqli_connect_error());
}
?>
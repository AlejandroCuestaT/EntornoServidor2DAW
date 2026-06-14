<?php

$servidor = "localhost";
$base_datos = "consultoria_db";
$usuario = "root";
$contrasena = "";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die("Error al conectar con la base de datos: " . $error->getMessage());
}
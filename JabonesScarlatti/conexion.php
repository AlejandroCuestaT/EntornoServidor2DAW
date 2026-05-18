<?php
// Conexión a la base de datos jabones con PDO
// Igual que en la práctica de cursoscp - cambia user/pass si hace falta
$conn = new PDO('mysql:host=localhost;dbname=jabones;charset=utf8', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
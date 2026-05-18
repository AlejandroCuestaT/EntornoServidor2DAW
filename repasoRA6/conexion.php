<?php
try {
    $conn = new PDO('mysql:host=localhost;dbname=examen_ra6;charset=utf8', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error crítico de conexión en el sistema.");
}
?>
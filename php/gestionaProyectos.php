<?php
    include 'funciones.php';
    session_start();

    $email = $_SESSION['email'];

    $rol = recogeRol($email);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <li><?php if(!isset($_SESSION['email'])): ?><a href="login.php">Recoge Gastos</a><?php else: ?><a href="gastos.php">Recoge Gastos</a><?php endif; ?></li>
        <li><a href="sobrecoste.php">Proyectos con Sobrecoste</a></li>
        <li><a href="eficientes.php">Proyectos Eficientes</a></li>
        <li><?php if(!isset($_SESSION['email']) || $rol !== 'JEFE_PROYECTO'): ?><a href="login.php">Asignar Proyecto</a><?php else: ?><a href="gastos.php">Asignar Proyecto</a><?php endif; ?></li>
    </ul>
    <a href="login.php">Login</a>
</body>
</html>
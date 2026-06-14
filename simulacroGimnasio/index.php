<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION["nombre"];
$tipo = $_SESSION["tipo_usuario"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Gym - Control</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 40px; color: #333; }
        .menu { background: white; padding: 20px; max-width: 500px; margin: 0 auto; border: 1px solid #ccc; }
        h1 { font-size: 20px; color: #28a745; }
        ul { padding-left: 20px; }
        li { margin-bottom: 10px; }
        a { color: #28a745; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .logout { display: inline-block; margin-top: 20px; color: red; }
    </style>
</head>
<body>

<div class="menu">
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?></h1>
    <p>Rol: <strong><?= htmlspecialchars($tipo) ?></strong></p>
    <hr>

    <h3>Secciones del examen:</h3>
    <ul>
        <?php if ($tipo === 'SOCIO'): ?>
            <li><a href="ejercicio1.php">Ejercicio 1: Registrar Pagos Múltiples de Suplementos</a></li>
        <?php endif; ?>

        <?php if ($tipo === 'ENTRENADOR'): ?>
            <li><a href="ejercicio4.php">Ejercicio 4: Control de Aforos y Modificación de Capacidad</a></li>
            <li><a href="ejercicio5.php">Ejercicio 5: Inscripción Manual de Socios a Clases</a></li>
        <?php endif; ?>
        
        <li><a href="ejercicio3.php">Ejercicio 3: Historial de Clases de Éxito (Público)</a></li>
    </ul>

    <a href="logout.php" class="logout">Cerrar Sesión</a>
</div>

</body>
</html>
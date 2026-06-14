<?php
session_start();

if (!isset($_SESSION["id_empleado"])) {
    header("Location: login.php");
    exit;
}

$nombre = $_SESSION["nombre"];
$tipo = $_SESSION["tipo_empleado"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Consultoría</title>
    <style>
        body { font-family: sans-serif; background: #ff; padding: 40px; color: #333; }
        .menu { background: white; padding: 20px; max-width: 500px; margin: 0 auto; border: 1px solid #ccc; }
        h1 { font-size: 20px; color: #0056b3; }
        ul { padding-left: 20px; }
        li { margin-bottom: 10px; }
        a { color: #0056b3; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .logout { display: inline-block; margin-top: 20px; color: red; }
    </style>
</head>
<body>

<div class="menu">
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?></h1>
    <p>Rol: <strong><?= htmlspecialchars($tipo) ?></strong></p>
    <hr>

    <h3>Operaciones disponibles:</h3>
    <ul>
        <?php if ($tipo === 'INFORMATICO'): ?>
            <li><a href="ejercicio1.php">Ejercicio 1: Registrar Gastos de Proyectos</a></li>
        <?php endif; ?>

        <?php if ($tipo === 'JEFE_PROYECTO'): ?>
            <li><a href="ejercicio4.php">Ejercicio 4: Listado de Proyectos con Sobrecoste</a></li>
            <li><a href="ejercicio5.php">Ejercicio 5: Asignación de Empleados a Proyectos</a></li>
        <?php endif; ?>
        
        <li><a href="ejercicio3.php">Ejercicio 3: Listado de Proyectos más Eficientes (Público)</a></li>
    </ul>

    <a href="logout.php" class="logout">Cerrar Sesión</a>
</div>

</body>
</html>
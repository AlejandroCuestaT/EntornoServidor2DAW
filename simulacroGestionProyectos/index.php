<?php
session_start();
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}
$nombre = $_SESSION["nombre"];
$rol = $_SESSION["rol"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 40px; color: #333; }
        .menu { background: white; padding: 30px; max-width: 600px; margin: 0 auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #007bff; font-size: 24px; }
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 15px; background: #e9ecef; padding: 10px; border-radius: 5px; }
        a { color: #0056b3; text-decoration: none; font-weight: bold; display: block; }
        a:hover { text-decoration: underline; }
        .logout { display: inline-block; margin-top: 20px; color: white; background: #dc3545; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
<div class="menu">
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?></h1>
    <p>Perfil de acceso: <strong><?= htmlspecialchars($rol) ?></strong></p>
    <hr>
    <h3>Operaciones disponibles:</h3>
    <ul>
        <?php if ($rol === 'EMPLEADO'): ?>
            <li><a href="imputar_horas.php">Imputar horas</a></li>
            <li><a href="cancelar_fichaje.php">Cancelar Fichaje</a></li>
        <?php endif; ?>

        <?php if ($rol === 'DIRECTOR'): ?>
            <li><a href="ajustar_presupuestos.php">Ajustar Presupuestos</a></li>
            <li><a href="eliminar_proyecto.php">Eliminar Proyecto</a></li>
        <?php endif; ?>
        
        <li><a href="informe_coste.php">Informe de Costes</a></li>
    </ul>
    <a href="logout.php" class="logout">Cerrar Sesión</a>
</div>
</body>
</html>
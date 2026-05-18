<?php
session_start();
if (!isset($_SESSION['cliente'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Área Cliente</title>
</head>
<body>
    <h1>Bienvenido a la Tienda</h1>
    <p>Hola, <?php echo htmlspecialchars($_SESSION['cliente']); ?>. Este es tu panel de cliente.</p>
    <p><a href="logout.php" style="color:red;">Cerrar Sesión</a></p>
</body>
</html>
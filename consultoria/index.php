<?php
session_start();

// Si no hay sesión activa, al login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú - Consultoría</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1>Bienvenido, <?= $_SESSION["nombre"] ?></h1>
        <p>Tipo de usuario: <strong><?= $_SESSION["tipo"] ?></strong></p>

        <nav>
            <ul>
                <!-- Ejercicio 2: solo informáticos pueden cargar gastos -->
                <?php if ($_SESSION["tipo"] == "INFORMATICO"): ?>
                    <li><a href="ejercicios/gastos.php">Registrar gastos</a></li>
                <?php endif; ?>

                <!-- Ejercicio 3: cualquiera puede ver proyectos eficientes -->
                <li><a href="ejercicios/eficientes.php">Proyectos más eficientes</a></li>

                <!-- Ejercicio 4: cualquiera puede ver sobrecoste -->
                <li><a href="ejercicios/sobrecoste.php">Proyectos con sobrecoste</a></li>

                <!-- Ejercicio 5: solo jefes de proyecto asignan empleados -->
                <?php if ($_SESSION["tipo"] == "JEFE_PROYECTO"): ?>
                    <li><a href="ejercicios/asignar.php">Asignar empleados a proyectos</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <a href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>

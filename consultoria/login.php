<?php
session_start();
require_once "conexion.php";

$error = "";

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass  = $_POST["pass"];

    // Buscamos el empleado con ese email y contraseña
    $sql = "SELECT * FROM empleado WHERE email = '$email' AND pass = '$pass' AND estado = 1";
    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        // Login correcto, guardamos datos en sesión
        $empleado = mysqli_fetch_assoc($resultado);
        $_SESSION["id"]     = $empleado["id_empleado"];
        $_SESSION["nombre"] = $empleado["nombre"];
        $_SESSION["tipo"]   = $empleado["tipo_empleado"];

        // Redirigimos al menú principal
        header("Location: index.php");
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Consultoría</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="caja-login">
        <h2>Consultoría - Acceso</h2>

        <?php if ($error != ""): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="pass" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>

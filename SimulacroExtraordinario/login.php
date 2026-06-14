<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (!empty($email) && !empty($pass)) {
        $consulta = $conexion->prepare("SELECT id_empleado, nombre, tipo_empleado, pass FROM empleado WHERE email = :email");
        $consulta->execute(["email" => $email]);
        $empleado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($empleado && $pass === $empleado["pass"]) {
            $_SESSION["id_empleado"] = $empleado["id_empleado"];
            $_SESSION["nombre"] = $empleado["nombre"];
            $_SESSION["tipo_empleado"] = $empleado["tipo_empleado"];

            header("Location: index.php");
            exit;
        } else {
            $error = "El email o la contraseña son incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Consultoría</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; padding: 50px; }
        .contenedor { background: white; padding: 20px; max-width: 300px; margin: 0 auto; border: 1px solid #ccc; }
        .campo { margin-bottom: 15px; }
        .campo label { display: block; margin-bottom: 5px; }
        .campo input { width: 100%; padding: 5px; box-sizing: border-box; }
        .boton { width: 100%; padding: 8px; background: #0056b3; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Inicio de Sesión</h2>
    
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="campo">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="campo">
            <label>Contraseña:</label>
            <input type="password" name="pass" required>
        </div>
        <button type="submit" class="boton">Entrar</button>
    </form>
</div>

</body>
</html>
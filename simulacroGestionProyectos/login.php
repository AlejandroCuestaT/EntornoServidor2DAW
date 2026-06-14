<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (!empty($email) && !empty($pass)) {
        $consulta = $conexion->prepare("SELECT id_usuario, nombre, rol, pass FROM usuarios WHERE email = :email");
        $consulta->execute(["email" => $email]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        //Si el usuario existe y coincide con la contraseña
        if ($usuario && $pass === $usuario["pass"]) {
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            header("Location: index.php");
            exit;
        } else {
            $error = "Credenciales incorrectas.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; background: #e9ecef; padding: 50px; }
        .login-box { background: white; padding: 20px; max-width: 320px; margin: 0 auto; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .campo { margin-bottom: 15px; }
        .campo label { display: block; margin-bottom: 5px; font-weight: bold; }
        .campo input { width: 100%; padding: 8px; box-sizing: border-box; }
        .boton { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; font-weight: bold; }
        .error { color: #dc3545; margin-bottom: 15px; font-weight: bold; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Login</h2>
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
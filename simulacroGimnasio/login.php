<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    if (!empty($email) && !empty($pass)) {
        $consulta = $conexion->prepare("SELECT id_usuario, nombre, tipo_usuario, pass FROM usuario WHERE email = :email");
        $consulta->execute(["email" => $email]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $pass === $usuario["pass"]) {
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];

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
    <title>Login - Gimnasio</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; padding: 50px; }
        .contenedor { background: white; padding: 20px; max-width: 300px; margin: 0 auto; border: 1px solid #ccc; }
        .campo { margin-bottom: 15px; }
        .campo label { display: block; margin-bottom: 5px; }
        .campo input { width: 100%; padding: 5px; box-sizing: border-box; }
        .boton { width: 100%; padding: 8px; background: #28a745; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Acceso Gimnasio</h2>
    
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
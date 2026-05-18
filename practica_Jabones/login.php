<?php
require_once 'funciones.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['user'];
    $pass = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM CLIENTES WHERE email = ?");
    $stmt->execute([$email]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    if($fila && password_verify($pass, $fila['password'])) {
        $_SESSION['email'] = $fila['email'];
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['tipo'] = $fila['tipo'];
        redirigir('jabonescarlatti.php');
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Jabones Scarlatti</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); width: 350px; }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .btn-entrar { background: #007bff; color: white; border: none; padding: 14px; width: 100%; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 25px; font-weight: bold; }
        .btn-entrar:hover { background: #0056b3; }
        .error { color: red; text-align: center; margin-top: 15px; }
        .registro { text-align: center; margin-top: 20px; }
        .registro a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
<div class="login-card">
    <h2>Jabones Scarlatti</h2>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <label>Email:</label>
        <input type="text" name="user" placeholder="tu@email.com" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn-entrar">Iniciar Sesión</button>
    </form>
    <div class="registro">
        <a href="registro.php">Registrarse</a> | <a href="jabonescarlatti.php">Ver productos</a>
    </div>
</div>
</body>
</html>
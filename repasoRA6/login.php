<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f4; }
        .box { background: white; padding: 25px; border: 1px solid #ccc; border-radius: 5px; width: 300px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: blue; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="box">
    <h2>Iniciar Sesión</h2>
    
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red; font-weight: bold;">' . htmlspecialchars($_SESSION['error']) . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <form action="validarLogin.php" method="POST">
        <div class="form-group">
            <label>Usuario:</label>
            <input type="text" name="user" required placeholder="admin">
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required placeholder="admin123">
        </div>
        <button type="submit" name="login">Entrar</button>
    </form>
</div>

</body>
</html>
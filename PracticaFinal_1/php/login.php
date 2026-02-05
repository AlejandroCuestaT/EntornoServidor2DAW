<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Empresa Cuesta</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); width: 350px; }
        h2 { text-align: center; color: #333; margin-bottom: 25px; }
        label { display: block; margin-top: 15px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .btn-entrar { background: #007bff; color: white; border: none; padding: 14px; width: 100%; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 25px; font-weight: bold; }
        .btn-entrar:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>PRACTICA FINAL 1</h2>
    <form action="validarLogin.php" method="post">
        <label>Usuario / Correo:</label>
        <input type="text" name="user" placeholder="Admin o Email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login" class="btn-entrar">Iniciar Sesión</button>
    </form>
</div>

</body>
</html>
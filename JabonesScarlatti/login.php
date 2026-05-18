<!DOCTYPE html>
<!-- LOGIN.PHP - Apartado A: Autenticación de usuarios (admin y clientes registrados) -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - JabonesScarlatti</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Georgia', serif;
            background: #2c1810;
            display: flex; justify-content: center; align-items: center; min-height: 100vh;
        }
        .card {
            background: #fdf8f4;
            padding: 45px 40px;
            border-radius: 8px;
            width: 380px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo h1 { font-size: 26px; color: #2c1810; }
        .logo p { color: #7a5c44; font-size: 13px; margin-top: 4px; }
        label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-top: 18px; }
        input {
            width: 100%; padding: 11px; margin-top: 5px;
            border: 1px solid #c4a882; border-radius: 4px;
            font-size: 14px; background: white;
        }
        input:focus { outline: none; border-color: #2c1810; }
        .btn {
            width: 100%; padding: 13px;
            background: #2c1810; color: white; border: none;
            border-radius: 4px; font-size: 15px; cursor: pointer;
            margin-top: 25px; font-family: 'Georgia', serif;
            transition: background 0.2s;
        }
        .btn:hover { background: #5a3020; }
        .error {
            background: #fde8e8; color: #c0392b;
            border: 1px solid #e74c3c;
            padding: 10px 14px; border-radius: 4px;
            font-size: 13px; margin-bottom: 15px;
        }
        .registro-link {
            text-align: center; margin-top: 20px;
            font-size: 13px; color: #7a5c44;
        }
        .registro-link a { color: #2c1810; font-weight: bold; }
        .volver { display: block; text-align: center; margin-top: 12px; font-size: 13px; color: #999; text-decoration: none; }
        .volver:hover { color: #2c1810; }
    </style>
</head>
<body>

<div class="card">
    <div class="logo">
        <h1>🧼 JabonesScarlatti</h1>
        <p>Acceso a clientes y administradores</p>
    </div>

    <?php
    session_start();
    // Mostrar error si lo hay
    if (isset($_SESSION['error_login'])) {
        echo '<div class="error">' . htmlspecialchars($_SESSION['error_login']) . '</div>';
        unset($_SESSION['error_login']);
    }
    ?>

    <form action="validarLogin.php" method="POST">
        <label>Email / Usuario admin:</label>
        <input type="text" name="user" placeholder="tu@email.com o admin" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login" class="btn">Iniciar Sesión</button>
    </form>

    <div class="registro-link">
        ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
    </div>
    <a href="index.php" class="volver">← Ver tienda sin registrarse</a>
</div>

</body>
</html>
<?php
require_once 'funciones.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $cp = $_POST['cp'];
    $telefono = $_POST['telefono'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO CLIENTES (email, nombre, direccion, ciudad, cp, telefono, password) VALUES (?,?,?,?,?,?,?)");
    try {
        $stmt->execute([$email, $nombre, $direccion, $ciudad, $cp, $telefono, $pass]);
        redirigir('login.php');
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro - Jabones Scarlatti</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; margin: 0; padding: 40px; display: flex; justify-content: center; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); width: 450px; }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 12px; font-weight: bold; color: #555; }
        input, textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .btn { background: #007bff; color: white; border: none; padding: 12px; width: 100%; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 20px; }
        .btn:hover { background: #0056b3; }
        .error { color: red; text-align: center; }
        .volver { text-align: center; margin-top: 15px; }
        .volver a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
<div class="card">
    <h2>Registro de cliente</h2>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Nombre completo:</label>
        <input type="text" name="nombre" required>
        <label>Dirección:</label>
        <input type="text" name="direccion" required>
        <label>Ciudad:</label>
        <input type="text" name="ciudad" required>
        <label>Código Postal:</label>
        <input type="text" name="cp" required>
        <label>Teléfono:</label>
        <input type="text" name="telefono" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn">Registrarse</button>
    </form>
    <div class="volver"><a href="jabonescarlatti.php">Volver a la tienda</a></div>
</div>
</body>
</html>
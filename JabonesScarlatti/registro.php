<?php
// REGISTRO.PHP - Formulario de registro de nuevos clientes
// RA6: Validaciones antes de insertar en BBDD, contraseña hasheada con password_hash
session_start();

$errores = "";
$nombre = $email = $direccion = $cp = $tlfn = "";

if (isset($_POST['registrar'])) {
    $nombre    = trim($_POST['nombre']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $password2 = trim($_POST['password2']);
    $direccion = trim($_POST['direccion']);
    $cp        = trim($_POST['cp']);
    $tlfn      = trim($_POST['tlfn']);

    // --- VALIDACIONES ---
    if (empty($nombre))    $errores .= "<li>El nombre es obligatorio.</li>";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errores .= "<li>El email no es válido.</li>";
    if (empty($password))  $errores .= "<li>La contraseña es obligatoria.</li>";
    if ($password !== $password2) $errores .= "<li>Las contraseñas no coinciden.</li>";
    if (empty($direccion)) $errores .= "<li>La dirección es obligatoria.</li>";
    if (!preg_match('/^\d{5}$/', $cp))  $errores .= "<li>El código postal debe tener 5 dígitos.</li>";
    if (!preg_match('/^[0-9]{9}$/', $tlfn)) $errores .= "<li>El teléfono debe tener 9 dígitos.</li>";

    if ($errores == "") {
        include_once("conexion.php");
        try {
            // Verificar que el email no exista ya
            $check = $conn->prepare("SELECT email FROM clientes WHERE email = :email");
            $check->execute([':email' => $email]);
            if ($check->fetch()) {
                $errores .= "<li>Ese email ya está registrado. <a href='login.php'>Inicia sesión</a>.</li>";
            } else {
                // RA6: Seguridad - guardar contraseña hasheada, nunca en texto plano
                $passHash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO clientes (email, nombre, direccion, CP, Tlfn, password)
                        VALUES (:email, :nombre, :dir, :cp, :tlfn, :pass)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':email'  => $email,
                    ':nombre' => $nombre,
                    ':dir'    => $direccion,
                    ':cp'     => $cp,
                    ':tlfn'   => $tlfn,
                    ':pass'   => $passHash
                ]);

                // Iniciar sesión automáticamente tras el registro
                $_SESSION['email_cliente'] = $email;
                $_SESSION['nombre_cliente'] = $nombre;
                header("Location: index.php");
                exit;
            }
        } catch (PDOException $e) {
            $errores .= "<li>Error al guardar: " . $e->getMessage() . "</li>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - JabonesScarlatti</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Georgia', serif; background: #2c1810; padding: 30px 20px; }
        .card {
            background: #fdf8f4; padding: 40px; border-radius: 8px;
            max-width: 480px; margin: 0 auto;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }
        h2 { color: #2c1810; margin-bottom: 25px; text-align: center; }
        label { display: block; font-size: 13px; font-weight: bold; color: #555; margin-top: 15px; }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
            width: 100%; padding: 10px; margin-top: 5px;
            border: 1px solid #c4a882; border-radius: 4px; font-size: 14px;
        }
        input:focus { outline: none; border-color: #2c1810; }
        .error-zone {
            background: #fde8e8; color: #c0392b;
            border: 1px solid #e74c3c;
            padding: 12px 16px; border-radius: 4px; margin-bottom: 15px; font-size: 13px;
        }
        .btn {
            width: 100%; padding: 13px; background: #2c1810; color: white;
            border: none; border-radius: 4px; font-size: 15px; cursor: pointer;
            margin-top: 25px; font-family: 'Georgia', serif; transition: background 0.2s;
        }
        .btn:hover { background: #5a3020; }
        .volver { display: block; text-align: center; margin-top: 15px; font-size: 13px; color: #7a5c44; text-decoration: none; }
        .volver:hover { color: #2c1810; }
        .fila2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
    </style>
</head>
<body>
<div class="card">
    <h2>🧼 Crear Cuenta</h2>

    <?php if ($errores != ""): ?>
        <div class="error-zone"><strong>Errores:</strong><ul style="margin-top:5px"><?php echo $errores; ?></ul></div>
    <?php endif; ?>

    <form action="registro.php" method="POST">
        <label>Nombre completo:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

        <label>Email (será tu usuario):</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <div class="fila2">
            <div>
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label>Repetir contraseña:</label>
                <input type="password" name="password2" required>
            </div>
        </div>

        <label>Dirección de entrega:</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>" required>

        <div class="fila2">
            <div>
                <label>Código Postal:</label>
                <input type="text" name="cp" maxlength="5" value="<?php echo htmlspecialchars($cp); ?>" required>
            </div>
            <div>
                <label>Teléfono:</label>
                <input type="tel" name="tlfn" maxlength="9" placeholder="600123456" value="<?php echo htmlspecialchars($tlfn); ?>" required>
            </div>
        </div>

        <button type="submit" name="registrar" class="btn">Registrarme</button>
    </form>

    <a href="login.php" class="volver">¿Ya tienes cuenta? Inicia sesión</a>
</div>
</body>
</html>
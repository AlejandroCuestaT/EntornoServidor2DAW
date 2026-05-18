<?php
require '../func/bdlogic.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $passRaw = $_POST['pass'] ?? '';

    // CORRECCIÓN 2: Paréntesis en DateTime
    $hoy = (new DateTime())->format('Y-m-d');
    try {
        $usuario = obtenerDatos('usuarios', ['email' => $email, 'password_hash' => $passRaw]);
        // var_dump($usuario->fetchAll());
        // echo 'delvolvi la info';
        if ($usuario->rowCount() > 0) {
            //llego con los datos del usuario,
            $usuarioBD = $usuario->fetchAll();
            $_SESSION['usuarioLogin'] = $usuarioBD[0];
            if ($usuarioBD[0]['rol'] == 'admin') {
                header('Location: ..\views\vistaAdmin.php');
            } else if ($usuarioBD[0]['rol'] == 'cliente') {
                $_SESSION['usuarioLogin']['carritoLogin'] = obtenerDatos('cesta', ['email' => $_SESSION['usuarioLogin']['email']])->fetchAll()[0];
                header('Location: ..\views\vistaUsuario.php');
            }
        } else {
            echo 'datos incorrectos de inicio de session';
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }

}




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>

<body>
    <form method="post" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="pass" required>
        <br>
        <input type="submit" value="Enviar">
    </form>
    <a href="..\views\vistaUsuario.php">Iniciar sesion mas tarde</a>
</body>

</html>
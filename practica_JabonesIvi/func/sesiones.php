<?php
// sesiones.php

function loginSession($datosLogin)
{
    // Asegúrate de que la sesión esté activa antes de escribir
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['usuarioLogin'] = $datosLogin;
}

function logout()
{
    // 1. Asegurar que tenemos acceso a la sesión para borrarla
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Limpiar todas las variables de sesión
    $_SESSION = array();


    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // 4. Destruir el archivo de sesión en el servidor
    session_destroy();

    // 5. Redirección con ruta absoluta (evita fallos de ../)
    // Es mejor usar una ruta basada en la raíz si es posible
    header("Location: ../views/vistaUsuario.php");
    exit();
}

function validarLogueado()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['usuarioLogin'])) {
        header("Location : ../src/login.php");
        exit();
    }
}
?>
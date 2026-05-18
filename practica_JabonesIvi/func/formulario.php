<?php
// 1. SIEMPRE lo primero para evitar el Warning de Undefined $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function crearToken()
{
    // Usaremos siempre 'token_csrf' para ser consistentes
    if (empty($_SESSION['token_csrf'])) {
        $_SESSION['token_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['token_csrf'];
}

function validar_token()
{
    // Corregido el nombre de la variable de sesión a 'token_csrf'
    if (!isset($_POST['token_csrf']) || !isset($_SESSION['token_csrf']) || $_POST['token_csrf'] !== $_SESSION['token_csrf']) {
        die("Error de validación de seguridad (CSRF).");
    }
    // Opcional: borrar el token tras usarlo para que sea de un solo uso
    unset($_SESSION['token_csrf']);
}

// Lógica de login
if (!isset($_SESSION['login'])) {
    $inputs = array(
        'usuario' => '',
        'pass' => ''
    );

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuario'])) {
        validar_token();

        $inputs['usuario'] = $_POST['usuario'] ?? '';
        $inputs['pass'] = $_POST['pass'] ?? '';

        // Aquí deberías validar contra BD, esto es solo un ejemplo:
        if (!empty($inputs['usuario']) && !empty($inputs['pass'])) {
            $_SESSION['login'] = uniqid();
            header("Location: informacion.php");
            exit();
        }
    }
} else {
    // Si ya estás logueado y entras aquí, te manda a información
    // OJO: Asegúrate de que no estás incluyendo este archivo en informacion.php 
    // o crearás un bucle infinito de redirecciones.
    // header('Location: informacion.php'); 
    // exit();
}

function opciones($tabla, $dato)
{
    // Asegúrate de que obtenerDatos esté disponible
    $pintaje = obtenerDatos($tabla, [], $dato)->fetchAll();
    if (count($pintaje) == 0) {
        return null;
    }

    foreach ($pintaje as $value) {
        // Accedemos directamente al valor de la columna pedida
        $valor = $value[$dato];
        echo "<option value=\"$valor\">$valor</option>";
    }
}
function rellenarCampos(&$input, $array)
{
    foreach ($input as $name => $value) {
        $valorRecibido = $array[$name] ?? null;

        if ($valorRecibido === "true") {
            $input[$name] = true;
        } elseif ($valorRecibido === "false") {
            $input[$name] = false;
        } else {
            $input[$name] = trim($valorRecibido ?? '');
        }
    }
}
function campRequerido($datos, $obligatorios)
{
    $errores = array();

    foreach ($obligatorios as $campo) {
        // Si el campo no existe en datos o está vacío (y no es el número 0)
        if (!isset($datos[$campo]) || ($datos[$campo] === '' && $datos[$campo] !== '0')) {
            $errores[$campo] = "El campo $campo es obligatorio.";
        }
    }

    return $errores;
}
?>
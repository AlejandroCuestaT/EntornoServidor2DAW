<?php
// VALIDARLOGIN.PHP - RA6: Verifica credenciales con consultas preparadas (seguridad contra SQL injection)
session_start();
include_once("conexion.php");

if (!isset($_POST['login'])) {
    header("Location: login.php");
    exit;
}

$user = trim($_POST['user']);
$password = trim($_POST['password']);

if (empty($user) || empty($password)) {
    $_SESSION['error_login'] = "Rellena todos los campos.";
    header("Location: login.php");
    exit;
}

try {
    // 1. Comprobar si es administrador (tabla admin)
    $sqlAdmin = "SELECT * FROM admin WHERE usuario = :user AND password = :pass";
    $stmtAdmin = $conn->prepare($sqlAdmin);
    $stmtAdmin->execute([':user' => $user, ':pass' => $password]);
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['admin'] = $admin['usuario'];
        header("Location: admin.php");
        exit;
    }

    // 2. Comprobar si es cliente registrado (tabla clientes)
    // El cliente se identifica por email y contraseña
    $sqlCliente = "SELECT * FROM clientes WHERE email = :email AND password = :pass";
    $stmtCliente = $conn->prepare($sqlCliente);
    $stmtCliente->execute([':email' => $user, ':pass' => $password]);
    $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $_SESSION['email_cliente'] = $cliente['email'];
        $_SESSION['nombre_cliente'] = $cliente['nombre'];
        header("Location: index.php");
        exit;
    }

    // 3. Credenciales incorrectas
    $_SESSION['error_login'] = "Credenciales incorrectas. Inténtalo de nuevo.";
    header("Location: login.php");
    exit;

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>
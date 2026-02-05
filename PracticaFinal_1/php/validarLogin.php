<?php
session_start();
include_once("conexion.php");

// Inicializamos la variable de error
$error = "";

if (isset($_POST['login'])) {
    // Recogemos y limpiamos mínimamente los datos
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);

    // Validación simple en PHP: campos no vacíos
    if (empty($user) || empty($password)) {
        $_SESSION['error_login'] = "Por favor, rellena todos los campos.";
        header("Location: login.php");
        exit;
    }

    try {
        // 1. Consulta en la tabla admin
        $sqlAdmin = "SELECT * FROM admin WHERE usuario = :user AND password = :pass";
        $stmtAdmin = $conn->prepare($sqlAdmin);
        $stmtAdmin->execute([':user' => $user, ':pass' => $password]);
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION['admin'] = $admin['usuario'];
            header("Location: admin.php");
            exit;
        }

        // 2. Consulta en la tabla solicitantes
        $sqlSol = "SELECT * FROM solicitantes WHERE correo = :correo AND password = :pass";
        $stmtSol = $conn->prepare($sqlSol);
        $stmtSol->execute([':correo' => $user, ':pass' => $password]);
        $solicitante = $stmtSol->fetch(PDO::FETCH_ASSOC);

        if ($solicitante) {
            $_SESSION['solicitante'] = $solicitante['dni'];
            header("Location: listaSolicitantes.php");
            exit;
        }

        // 3. Si llega aquí, es que no existe en ninguna tabla
        $_SESSION['error_login'] = "Credenciales incorrectas. Inténtalo de nuevo.";
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
} else {
    // Si alguien intenta entrar a este archivo sin pasar por el POST
    header("Location: login.php");
    exit;
}
?>
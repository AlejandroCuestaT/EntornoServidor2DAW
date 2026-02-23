<?php
session_start();
include_once("conexion.php");

$error = "";

if (isset($_POST['login'])) {


    $user = trim($_POST['user']);
    $password = trim($_POST['password']);

    if (empty($user) || empty($password)) {
        $_SESSION['error_login'] = "Por favor, rellena todos los campos.";
        header("Location: login.php");
        exit;
    }

    try {
        $sqlLogin = "SELECT * FROM usuarios WHERE username = :user AND password = :pass";
        $stmtLogin = $conn->prepare($sqlLogin);
        $stmtLogin->execute([':user' => $user, ':pass' => $password]);
        $login = $stmtLogin->fetch(PDO::FETCH_ASSOC);

        if ($login) {
            $_SESSION['id_usuario'] = $login['id_usuario'];
            header("Location: homeAdmin.php");
            exit;
        }

        $_SESSION['error'] = "Credenciales incorrectas. Inténtalo de nuevo.";
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit;
}
?>
<?php
session_start();
include_once("conexion.php");

$error = "";

if (isset($_POST['login'])) {
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
            die("Error de seguridad: Token no válido.");
        }
    }


    $user = trim($_POST['user']);
    $password = trim($_POST['password']);

    if (empty($user) || empty($password)) {
        $_SESSION['error_login'] = "Por favor, rellena todos los campos.";
        header("Location: login.php");
        exit;
    }

    try {
        $sqlLogin = "SELECT * FROM login WHERE user = :user AND password = :pass";
        $stmtLogin = $conn->prepare($sqlLogin);
        $stmtLogin->execute([':user' => $user, ':pass' => $password]);
        $login = $stmtLogin->fetch(PDO::FETCH_ASSOC);

        if ($login) {
            $_SESSION['user'] = $login['user'];
            header("Location: home.php");
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
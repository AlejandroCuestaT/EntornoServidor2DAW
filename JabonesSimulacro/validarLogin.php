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
        // Tu consulta idéntica, buscando en la tabla 'usuario' que creaste
        $sqlLogin = "SELECT * FROM usuario WHERE user = :user AND pass = :pass";
        $stmtLogin = $conn->prepare($sqlLogin);
        $stmtLogin->execute([':user' => $user, ':pass' => $password]);
        $login = $stmtLogin->fetch(PDO::FETCH_ASSOC);

        if ($login) {
            // Evaluamos tu columna 'rol' para saber a dónde mandarlo
            if ($login['rol'] == 'admin') {
                $_SESSION['admin'] = $login['user']; // Guarda el nombre en sesión
                header("Location: admin.php");       // Redirige al panel de admin
                exit;
            } else {
                $_SESSION['cliente'] = $login['user']; // Guarda el email en sesión
                header("Location: tienda.php");      // Redirige a la tienda (Apartado B)
                exit;
            }
        }

        // Si las credenciales fallan, usa tu variable de sesión 'error' original de login.php
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
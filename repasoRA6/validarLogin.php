<?php
session_start();
include_once("conexion.php");

if (isset($_POST['login'])) {
    $user = trim($_POST['user']);
    $password = trim($_POST['password']);

    if (empty($user) || empty($password)) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: login.php");
        exit;
    }

    try {
        // Consulta blindada con marcadores
        $sql = "SELECT * FROM usuario WHERE user = :user AND pass = :pass";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user' => $user,
            ':pass' => $password
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if ($row['rol'] === 'admin') {
                $_SESSION['admin'] = $row['user'];
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION['cliente'] = $row['user'];
                header("Location: tienda.php"); // Vista simple si no es admin
                exit;
            }
        }

        $_SESSION['error'] = "Credenciales incorrectas.";
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        die("Error en el proceso de autenticación.");
    }
} else {
    header("Location: login.php");
    exit;
}
?>
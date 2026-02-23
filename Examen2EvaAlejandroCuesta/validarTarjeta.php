<?php
session_start();
include_once("conexion.php");

$error = "";

if (isset($_POST['login'])) {
    $tarjeta = trim($_POST['tarjeta']);

    if (empty($tarjeta)) {
        $_SESSION['error_login'] = "Por favor, rellena todos los campos.";
        header("Location: index.php");
        exit;
    }

    try {
        $sqlTarjeta = "SELECT * FROM citas WHERE tarjeta_paciente = :tarjeta_paciente";
        $stmtTarjeta = $conn->prepare($sqlTarjeta);
        $stmtTarjeta->execute([':tarjeta_paciente' => $tarjeta]);
        $tarjeta = $stmtTarjeta->fetch(PDO::FETCH_ASSOC);

        if ($tarjeta) {
            $_SESSION['tarjeta'] = $tarjeta['tarjeta_paciente'];
            header("Location: mostrarConsulta.php");
            exit;
        }

        $_SESSION['error'] = "Credenciales incorrectas. Inténtalo de nuevo.";
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit;
}
?>
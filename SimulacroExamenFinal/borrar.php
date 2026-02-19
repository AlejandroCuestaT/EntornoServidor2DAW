<?php
session_start();
include_once("conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_borrar'])) {
    $userParaEliminar = $_POST['user_borrar'];

    try {
        // Borramos usando el campo 'user' en el WHERE
        $sql = "DELETE FROM login WHERE user = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':usuario' => $userParaEliminar]);

        header("Location: home.php?msg=Usuario eliminado");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: home.php");
}
?>
<?php
session_start();
include_once("conexion.php");

//Borra la fila en caso de que exista
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_borrar'])) {
    $userParaEliminar = $_POST['user_borrar'];

    try {
        $sql = "DELETE FROM citas WHERE hora = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':usuario' => $userParaEliminar]);

        header("Location: homeAdmin.php?msg=Usuario eliminado");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: home.php");
}
?>
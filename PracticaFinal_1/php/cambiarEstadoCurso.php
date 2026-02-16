<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = $_GET['id'];
    $nuevoEstado = $_GET['estado'];

    try {
        $sql = "UPDATE cursos SET abierto = :estado WHERE codigo = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':estado' => $nuevoEstado,
            ':id' => $id
        ]);
        
        header("Location: admin.php");
        exit;
    } catch (PDOException $e) {
        die("Error al actualizar el curso: " . $e->getMessage());
    }
} else {
    header("Location: admin.php");
    exit;
}
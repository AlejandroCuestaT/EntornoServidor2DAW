<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM cursos WHERE codigo = :id");
        $stmt->execute([':id' => $id]);
        header("Location: admin.php");
    } catch (PDOException $e) {
        die("Error al eliminar el curso: " . $e->getMessage());
    }
}
<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['admin']) || !isset($_POST['idCurso'])) {
    header("Location: login.php");
    exit;
}

$idCurso = $_POST['idCurso'];
$dnis = isset($_POST['dnis']) ? $_POST['dnis'] : [];

try {
    $conn->beginTransaction();

    // 1. Opcional: Resetear admitidos previos para este curso por si el baremo cambió
    $reset = $conn->prepare("UPDATE solicitudes SET admitido = 0 WHERE codigocurso = :id");
    $reset->execute([':id' => $idCurso]);

    // 2. Marcar como admitidos (1) a los seleccionados
    if (!empty($dnis)) {
        // Creamos una cadena de interrogaciones (?,?,?) para el IN
        $placeholders = implode(',', array_fill(0, count($dnis), '?'));
        $sql = "UPDATE solicitudes SET admitido = 1 
                WHERE codigocurso = ? AND dni IN ($placeholders)";
        
        $stmt = $conn->prepare($sql);
        
        // Combinamos el ID del curso con el array de DNIs para los parámetros
        $params = array_merge([$idCurso], $dnis);
        $stmt->execute($params);
    }

    $conn->commit();
    header("Location: verAdmitidos.php?id=$idCurso&msg=actualizado");
    exit;

} catch (PDOException $e) {
    $conn->rollBack();
    die("Error al actualizar admitidos: " . $e->getMessage());
}
?>
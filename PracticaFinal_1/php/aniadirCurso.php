<?php
session_start();
include_once("conexion.php");

// Seguridad: solo admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $plazas = $_POST['numeroplazas'];
    $plazo  = $_POST['plazoinscripcion'];
    $abierto = isset($_POST['abierto']) ? 1 : 0;

    try {
        // No incluimos 'codigo' porque es AI (Auto_Increment)
        $sql = "INSERT INTO cursos (nombre, abierto, numeroplazas, plazoinscripcion) 
                VALUES (:nom, :abi, :pla, :fec)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nom' => $nombre,
            ':abi' => $abierto,
            ':pla' => $plazas,
            ':fec' => $plazo
        ]);
        
        // Redirigir al panel tras el éxito
        header("Location: admin.php");
        exit;
    } catch (PDOException $e) {
        die("Error al insertar el curso: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Curso</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .formulario { width: 350px; border: 1px solid black; padding: 15px; background-color: #f9f9f9; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="number"], input[type="date"] { width: 95%; padding: 5px; }
        .btn-guardar { margin-top: 15px; padding: 5px 10px; cursor: pointer; background: #fff; border: 1px solid black; }
        .btn-guardar:hover { background: #eee; }
        .volver { display: block; margin-bottom: 15px; text-decoration: none; color: blue; font-size: 14px; }
    </style>
</head>
<body>

    <h1>Nuevo Registro de Curso</h1>
    <a href="admin.php" class="volver">← Volver al Panel de Administración</a>

    <div class="formulario">
        <form action="aniadirCurso.php" method="POST">
            <label>Nombre del Curso:</label>
            <input type="text" name="nombre" required>

            <label>Número de Plazas:</label>
            <input type="number" name="numeroplazas" value="20" required>

            <label>Plazo de Inscripción:</label>
            <input type="date" name="plazoinscripcion" required>

            <label style="margin-top: 15px;">
                <input type="checkbox" name="abierto" checked> Activar curso inmediatamente
            </label>

            <input type="submit" name="guardar" value="Crear Curso" class="btn-guardar">
        </form>
    </div>

</body>
</html>
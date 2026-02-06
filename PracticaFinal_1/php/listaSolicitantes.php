<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['solicitante'])) {
    header("Location: login.php");
    exit;
}

$dni_usuario = $_SESSION['solicitante'];

try {
    $sql = "SELECT * FROM cursos WHERE abierto = 1";
    $stmt = $conn->query($sql);
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos Disponibles</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px; border: 1px solid black; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { 
            padding: 3px 6px; 
            text-decoration: none; 
            color: black; 
            border: 1px solid black;
            font-size: 12px;
            background: #fff;
        }
        .btn:hover { background: #ddd; }
        .links-superior { margin-bottom: 20px; }
    </style>
</head>
<body>

    <h1>Bienvenido/a, Solicitante (DNI: <?php echo htmlspecialchars($dni_usuario); ?>)</h1>
    
    <div class="links-superior">
        <a href="misCursosAdmitidos.php" class="btn">Ver mis cursos admitidos</a>
        <a href="logout.php" class="btn" style="color: red;">Cerrar Sesión</a>
    </div>

    <h3>Cursos disponibles para inscripción</h3>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre del Curso</th>
                <th>Plazas</th>
                <th>Fecha Límite</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?php echo $curso['codigo']; ?></td>
                <td><?php echo htmlspecialchars($curso['nombre']); ?></td>
                <td><?php echo $curso['numeroplazas']; ?></td>
                <td><?php echo $curso['plazoinscripcion']; ?></td>
                <td>
                    <a href="inscribir.php?cod=<?php echo $curso['codigo']; ?>" class="btn">Inscribirse</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
<?php
session_start();
include_once("conexion.php");

// Verificación de seguridad: solo admins
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

try {
    // Consultar todos los cursos
    $sql = "SELECT * FROM cursos";
    $stmt = $conn->query($sql);
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al recuperar cursos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Cursos</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        .btn { padding: 8px 12px; border-radius: 4px; text-decoration: none; color: white; font-weight: bold; }
        .btn-activar { background: #28a745; }
        .btn-desactivar { background: #dc3545; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.9em; }
        .bg-success { background: #d4edda; color: #155724; }
        .bg-danger { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin']); ?></h1>
    <h3>Gestión de Cursos</h3>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre del Curso</th>
                <th>Plazas</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?php echo $curso['codigo']; ?></td>
                <td><?php echo htmlspecialchars($curso['nombre']); ?></td>
                <td><?php echo $curso['numeroplazas']; ?></td>
                <td>
                    <?php if ($curso['abierto'] == 1): ?>
                        <span class="status-badge bg-success">Abierto</span>
                    <?php else: ?>
                        <span class="status-badge bg-danger">Cerrado</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($curso['abierto'] == 1): ?>
                        <a href="cambiarEstadoCurso.php?id=<?php echo $curso['codigo']; ?>&estado=0" class="btn btn-desactivar">Desactivar</a>
                    <?php else: ?>
                        <a href="cambiarEstadoCurso.php?id=<?php echo $curso['codigo']; ?>&estado=1" class="btn btn-activar">Activar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="logout.php">Cerrar Sesión</a>

</body>
</html>
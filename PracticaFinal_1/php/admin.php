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
    <title>Administración</title>
    <style>
        body { 
            font-family: sans-serif; 
            margin: 20px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            padding: 8px; 
            border: 1px solid black; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        /* Botones tipo enlace básico */
        .btn { 
            padding: 3px 6px; 
            text-decoration: none; 
            color: black; 
            border: 1px solid black;
            font-size: 12px;
            background: #fff;
            margin-right: 8px; /* Separación entre botones */
        }
        .btn:hover {
            background: #ddd;
        }
        /* Colores para los estados */
        .status-abierto { 
            color: green; 
            font-weight: bold; 
        }
        .status-cerrado { 
            color: red; 
            font-weight: bold; 
        }
    </style>
</head>
<body>

    <h1>Administración de Cursos</h1>
    <p>Usuario: <?php echo htmlspecialchars($_SESSION['admin']); ?></p>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Curso</th>
                <th>Plazas</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?php echo $curso['codigo']; ?></td>
                <td><?php echo htmlspecialchars($curso['nombre']); ?></td>
                <td><?php echo $curso['numeroplazas']; ?></td>
                <td>
                    <?php if ($curso['abierto']): ?>
                        <span class="status-abierto">Abierto</span>
                    <?php else: ?>
                        <span class="status-cerrado">Cerrado</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="cambiarEstadoCurso.php?id=<?php echo $curso['codigo']; ?>&estado=<?php echo $curso['abierto'] ? '0' : '1'; ?>" class="btn">
                        <?php echo $curso['abierto'] ? 'Desactivar' : 'Activar'; ?>
                    </a>

                    <a href="verAdmitidos.php?id=<?php echo $curso['codigo']; ?>" class="btn">Admitidos</a>

                    <a href="eliminarCurso.php?id=<?php echo $curso['codigo']; ?>" class="btn" onclick="return confirm('¿Borrar curso?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="aniadirCurso.php" class="btn">Añadir Nuevo Curso</a>
    
    <br><br>

    <a href="login.php">Cerrar Sesión</a>

</body>
</html>
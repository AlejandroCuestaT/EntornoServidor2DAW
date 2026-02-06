<?php
session_start();
include_once("conexion.php");

// Seguridad: solo usuarios logueados
if (!isset($_SESSION['solicitante'])) {
    header("Location: login.php");
    exit;
}

$dni = $_SESSION['solicitante'];

try {
    // Consulta: unimos cursos y solicitudes donde el usuario esté ADMITIDO
    $sql = "SELECT c.nombre, s.fechasolicitud 
            FROM solicitudes s
            INNER JOIN cursos c ON s.codigocurso = c.codigo
            WHERE s.dni = :dni AND s.admitido = 1";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute([':dni' => $dni]);
    $admitidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos</title>
    <style>
        /* Estilo muy básico: solo blanco y negro */
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid black; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #eeeeee; 
        }
        .volver {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: black;
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>

    <h1>Mis Cursos Admitidos</h1>
    <p>DNI: <?php echo htmlspecialchars($dni); ?></p>

    <a href="listaSolicitantes.php" class="volver">Volver al listado</a>

    <?php if (count($admitidos) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre del Curso</th>
                    <th>Fecha de Solicitud</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admitidos as $curso): ?>
                <tr>
                    <td><?php echo htmlspecialchars($curso['nombre']); ?></td>
                    <td><?php echo $curso['fechasolicitud']; ?></td>
                    <td><strong>ADMITIDO</strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes cursos admitidos todavía.</p>
    <?php endif; ?>

</body>
</html>
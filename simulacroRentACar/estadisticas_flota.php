<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

function obtenerEstadisticasFlota($conexion) {
    $consulta = $conexion->prepare("
        SELECT 
            marca, 
            COUNT(id_vehiculo) AS total_vehiculos, 
            AVG(precio_dia) AS precio_medio, 
            MAX(precio_dia) AS tarifa_maxima
        FROM vehiculos
        GROUP BY marca
    ");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

$estadisticas = obtenerEstadisticasFlota($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas de la Flota</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #17a2b8; color: white; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Informe Estadístico por Marca</h2>
    <p>Resumen analítico de las tarifas base de los vehículos de la empresa, agrupados por fabricante.</p>

    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Total de Vehículos</th>
                <th>Precio Medio / Día</th>
                <th>Tarifa Máxima / Día</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estadisticas as $stat): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($stat['marca']) ?></strong></td>
                    <td><?= $stat['total_vehiculos'] ?> unidades</td>
                    <td><?= number_format($stat['precio_medio'], 2) ?> €</td>
                    <td><?= number_format($stat['tarifa_maxima'], 2) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
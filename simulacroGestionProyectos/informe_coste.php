<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit;
}

$consulta = $conexion->prepare("
    SELECT 
        p.id_proyecto,
        p.nombre,
        p.estado,
        p.presupuesto_maximo,
        p.gasto_acumulado,
        COUNT(f.id_fichaje) AS num_fichajes,
        IFNULL(SUM(f.horas), 0) AS total_horas
    FROM proyectos p
    LEFT JOIN fichajes f ON p.id_proyecto = f.id_proyecto
    GROUP BY p.id_proyecto, p.nombre, p.estado, p.presupuesto_maximo, p.gasto_acumulado
    ORDER BY p.gasto_acumulado DESC
");
$consulta->execute();
$informe = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Costes</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; color: #333; }
        .contenedor { max-width: 1000px; margin: 0 auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        h2 { color: #007bff; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dee2e6; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f8f9fa; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-activo { background: #d4edda; color: #155724; }
        .badge-inactivo { background: #e2e3e5; color: #383d41; }
        .progreso-contenedor { background: #e9ecef; border-radius: 4px; height: 15px; width: 100%; position: relative; margin-top: 4px; }
        .progreso-barra { background: #28a745; height: 100%; border-radius: 4px; transition: width 0.3s; }
        .progreso-barra.alerta { background: #dc3545; }
        .volver { display: inline-block; margin-top: 25px; text-decoration: none; color: #007bff; font-weight: bold; }
        .text-muted { color: #6c757d; font-size: 13px; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Informe Analítico de Costes por Proyecto</h2>
    
    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Estado</th>
                <th>Nº Fichajes</th>
                <th>Total Horas</th>
                <th>Gasto / Presupuesto Máximo</th>
                <th>% Consumido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($informe as $p): 
                $porcentaje = $p['presupuesto_maximo'] > 0 ? ($p['gasto_acumulado'] / $p['presupuesto_maximo']) * 100 : 0;
                $clase_alerta = $porcentaje >= 90 ? 'alerta' : '';
            ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                    <td>
                        <?php if ($p['estado'] === 'ACTIVO'): ?>
                            <span class="badge badge-activo">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-inactivo">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $p['num_fichajes'] ?></td>
                    <td><?= number_format($p['total_horas'], 1) ?> h</td>
                    <td>
                        <strong><?= number_format($p['gasto_acumulado'], 2) ?> €</strong> 
                        <span class="text-muted">/ <?= number_format($p['presupuesto_maximo'], 2) ?> €</span>
                    </td>
                    <td>
                        <strong><?= number_format($porcentaje, 1) ?>%</strong>
                        <div class="progreso-contenedor">
                            <div class="progreso-barra <?= $clase_alerta ?>" style="width: <?= min($porcentaje, 100) ?>%"></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
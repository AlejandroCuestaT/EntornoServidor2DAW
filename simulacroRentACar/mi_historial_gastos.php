<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'CLIENTE') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$consulta_total = $conexion->prepare("
    SELECT IFNULL(SUM(coste_total), 0) AS gasto_total 
    FROM reservas 
    WHERE id_usuario = :id_usuario
");
$consulta_total->execute(["id_usuario" => $id_usuario]);
$total_gastado = $consulta_total->fetchColumn();

$consulta_detalles = $conexion->prepare("
    SELECT r.fecha_inicio, r.fecha_fin, r.coste_total, v.marca, v.modelo 
    FROM reservas r
    INNER JOIN vehiculos v ON r.id_vehiculo = v.id_vehiculo
    WHERE r.id_usuario = :id_usuario
    ORDER BY r.fecha_inicio DESC
");
$consulta_detalles->execute(["id_usuario" => $id_usuario]);
$historial = $consulta_detalles->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Gastos</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 700px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        .caja-total { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .caja-total h2 { margin: 0; font-size: 28px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #6c757d; color: white; }
        .vacio { padding: 15px; background: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Mi Historial de Gastos</h2>

    <div class="caja-total">
        <p>Dinero total invertido en alquileres:</p>
        <h2><?= number_format($total_gastado, 2) ?> €</h2>
    </div>

    <h3>Desglose de Reservas:</h3>
    
    <?php if (empty($historial)): ?>
        <p class="vacio">Todavía no has realizado ninguna reserva con nosotros.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Fechas</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historial as $h): ?>
                    <tr>
                        <td><?= htmlspecialchars($h['marca'] . " " . $h['modelo']) ?></td>
                        <td><?= $h['fecha_inicio'] ?> / <?= $h['fecha_fin'] ?></td>
                        <td><?= $h['coste_total'] ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
<?php
require_once "conexion.php";

function devuelveOcupacion($conexion) {
    $consulta = $conexion->prepare("
        SELECT c.id_clase, c.nombre, c.capacidad_max, COUNT(r.id_reserva) AS total_reservas
        FROM clases c
        LEFT JOIN reservas r ON c.id_clase = r.id_clase
        WHERE c.estado = 'INACTIVO'
        GROUP BY c.id_clase, c.nombre, c.capacidad_max
    ");
    $consulta->execute();
    $clases = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $clases_llenas = [];
    foreach ($clases as $clase) {
        if ($clase["capacidad_max"] > 0 && $clase["total_reservas"] == $clase["capacidad_max"]) {
            $clases_llenas[] = $clase;
        }
    }

    return $clases_llenas;
}

$clases_exito = devuelveOcupacion($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases de Éxito</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 30px; }
        .contenedor { max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        .vacio { padding: 15px; background: #f9f9f9; border: 1px dashed #777; }
        .volver { display: block; margin-top: 20px; color: #28a745; text-decoration: none; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Historial de Clases con Éxito de Asistencia</h2>
    <p>Clases inactivas que completaron el 100% de su aforo disponible.</p>

    <?php if (empty($clases_exito)): ?>
        <p class="vacio">No hay clases inactivas que hayan completado el 100% de su aforo en este momento.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Clase</th>
                    <th>Nombre de la Clase</th>
                    <th>Capacidad Máxima</th>
                    <th>Total Reservas Realizadas</th>
                    <th>Estado de Ocupación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clases_exito as $clase): ?>
                    <tr>
                        <td><?= htmlspecialchars($clase["id_clase"]) ?></td>
                        <td><?= htmlspecialchars($clase["nombre"]) ?></td>
                        <td><?= $clase["capacidad_max"] ?> plazas</td>
                        <td><?= $clase["total_reservas"] ?> reservas</td>
                        <td><strong>100% Lleno</strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html> 
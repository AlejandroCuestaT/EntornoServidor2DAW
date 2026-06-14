<?php
require_once "conexion.php";

function devuelveEficiencia($conexion) {
    $consulta = $conexion->prepare("
        SELECT p.id_proyecto, p.nombre, p.presupuesto, IFNULL(SUM(t.num_horas), 0) AS total_horas
        FROM proyectos p
        LEFT JOIN trabajar t ON p.id_proyecto = t.id_proyecto
        WHERE p.estado = 'INACTIVO'
        GROUP BY p.id_proyecto, p.nombre, p.presupuesto
    ");
    $consulta->execute();
    $proyectos = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if (empty($proyectos)) {
        return [];
    }

    $proyectos_calculados = [];
    $menor_coste = null;

    foreach ($proyectos as $proy) {
        if ($proy["total_horas"] > 0) {
            $coste_por_hora = $proy["presupuesto"] / $proy["total_horas"];
            $proy["coste_hora"] = $coste_por_hora;
            $proyectos_calculados[] = $proy;

            if ($menor_coste === null || $coste_por_hora < $menor_coste) {
                $menor_coste = $coste_por_hora;
            }
        }
    }

    $proyectos_mas_eficientes = [];
    foreach ($proyectos_calculados as $proy) {
        if ($proy["coste_hora"] == $menor_coste) {
            $proyectos_mas_eficientes[] = $proy;
        }
    }

    return $proyectos_mas_eficientes;
}

$proyectos_eficientes = devuelveEficiencia($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos Más Eficientes</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 30px; }
        .contenedor { max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        .vacio { padding: 15px; background: #f9f9f9; border: 1px dashed #777; }
        .volver { display: block; margin-top: 20px; color: #0056b3; text-decoration: none; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Proyectos Finalizados con Máxima Eficiencia</h2>
    <p>Se muestran los proyectos que han supuesto el menor coste por hora de trabajo invertida.</p>

    <?php if (empty($proyectos_eficientes)): ?>
        <p class="vacio">No se encontraron proyectos finalizados o registrados con horas de trabajo en el sistema.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Proyecto</th>
                    <th>Presupuesto Final</th>
                    <th>Total Horas</th>
                    <th>Coste por Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos_eficientes as $proy): ?>
                    <tr>
                        <td><?= htmlspecialchars($proy["id_proyecto"]) ?></td>
                        <td><?= htmlspecialchars($proy["nombre"]) ?></td>
                        <td><?= number_format($proy["presupuesto"], 2, ',', '.') ?> €</td>
                        <td><?= $proy["total_horas"] ?> horas</td>
                        <td><strong><?= number_format($proy["coste_hora"], 2, ',', '.') ?> €/h</strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html>
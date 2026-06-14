<?php
// Este ejercicio NO requiere autenticación, cualquiera puede verlo
require_once "../conexion.php";

// Función que calcula la eficiencia de un proyecto
// Eficiencia = Coste por hora de trabajo = presupuesto_final / horas_totales
// Cuanto menor sea el coste por hora, más eficiente es el proyecto
function devuelveEficiencia($presupuesto, $horas) {
    // Evitamos dividir entre cero
    if ($horas == 0) return null;
    return $presupuesto / $horas;
}

// Obtenemos todos los proyectos finalizados (INACTIVO) con sus datos
// Necesitamos: presupuesto final (presupuesto), horas totales invertidas (suma de num_horas)
$sql = "SELECT p.id_proyecto, p.nombre, p.cliente, p.presupuesto,
               SUM(t.num_horas) AS horas_totales
        FROM proyectos p
        INNER JOIN trabajar t ON p.id_proyecto = t.id_proyecto
        WHERE p.estado = 'INACTIVO'
        GROUP BY p.id_proyecto, p.nombre, p.cliente, p.presupuesto";

$resultado = mysqli_query($con, $sql);

// Guardamos los proyectos y calculamos su eficiencia
$proyectos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $eficiencia = devuelveEficiencia($fila["presupuesto"], $fila["horas_totales"]);
    $fila["eficiencia"] = $eficiencia;
    $proyectos[] = $fila;
}

// Ordenamos de menor a mayor eficiencia (menor coste/hora = más eficiente)
usort($proyectos, function($a, $b) {
    return $a["eficiencia"] <=> $b["eficiencia"];
});

// Buscamos el valor máximo de eficiencia (el mejor, el más eficiente)
$max_eficiencia = null;
if (!empty($proyectos)) {
    $max_eficiencia = $proyectos[0]["eficiencia"]; // el primero es el más eficiente
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos Eficientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="contenedor">
    <h2>Proyectos más eficientes</h2>
    <p>Se muestran los proyectos finalizados ordenados por eficiencia (menor coste por hora = más eficiente).</p>

    <?php if (empty($proyectos)): ?>
        <p>No hay proyectos finalizados.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Cliente</th>
                <th>Presupuesto (€)</th>
                <th>Horas totales</th>
                <th>Eficiencia (€/hora)</th>
                <th>Mejor eficiencia</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($proyectos as $p): ?>
            <tr>
                <td><?= $p["nombre"] ?></td>
                <td><?= $p["cliente"] ?></td>
                <td><?= number_format($p["presupuesto"], 2) ?></td>
                <td><?= $p["horas_totales"] ?></td>
                <td><?= number_format($p["eficiencia"], 2) ?></td>
                <!-- Marcamos el proyecto con máxima eficiencia -->
                <td><?= ($p["eficiencia"] == $max_eficiencia) ? "✔ Más eficiente" : "" ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <a class="volver" href="../index.php">← Volver al menú</a>
</div>
</body>
</html>

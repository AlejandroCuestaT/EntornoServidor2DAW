<?php
// Cualquiera puede ver este listado, no hace falta login
// Pero si es jefe de proyecto puede modificar el presupuesto
session_start();
require_once "../conexion.php";

$mensaje = "";

// Si se envió el formulario de modificar presupuesto (solo jefe de proyecto)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "JEFE_PROYECTO") {
    $id_proyecto    = $_POST["id_proyecto"];
    $nuevo_presupuesto = $_POST["nuevo_presupuesto"];

    $sql_update = "UPDATE proyectos SET presupuesto = $nuevo_presupuesto WHERE id_proyecto = $id_proyecto";
    mysqli_query($con, $sql_update);

    $mensaje = "<p class='ok'>Presupuesto actualizado correctamente.</p>";
}

// Obtenemos los proyectos activos con el total de gastos cargados
$sql = "SELECT p.id_proyecto, p.nombre, p.cliente, p.presupuesto, p.fecha_fin,
               COALESCE(SUM(g.importe), 0) AS total_gastos
        FROM proyectos p
        LEFT JOIN gastos g ON p.id_proyecto = g.id_proyecto
        WHERE p.estado = 'ACTIVO'
        GROUP BY p.id_proyecto, p.nombre, p.cliente, p.presupuesto, p.fecha_fin";

$resultado = mysqli_query($con, $sql);

$proyectos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    // El saldo restante es lo que queda del presupuesto
    $fila["saldo_restante"] = $fila["presupuesto"] - $fila["total_gastos"];

    // Tiene sobrecoste si los gastos superaron el presupuesto
    $fila["sobrecoste"] = ($fila["total_gastos"] > $fila["presupuesto"]);

    $proyectos[] = $fila;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sobrecoste de Proyectos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="contenedor">
    <h2>Proyectos activos - Situación presupuestaria</h2>

    <?= $mensaje ?>

    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Cliente</th>
                <th>Presupuesto (€)</th>
                <th>Total gastos (€)</th>
                <th>Saldo restante (€)</th>
                <th>Fecha fin</th>
                <th>Estado</th>
                <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "JEFE_PROYECTO"): ?>
                    <th>Modificar presupuesto</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($proyectos as $p): ?>
            <!-- Si tiene sobrecoste, pintamos la fila en rojo -->
            <tr <?= $p["sobrecoste"] ? 'class="sobrecoste"' : '' ?>>
                <td><?= $p["nombre"] ?></td>
                <td><?= $p["cliente"] ?></td>
                <td><?= number_format($p["presupuesto"], 2) ?></td>
                <td><?= number_format($p["total_gastos"], 2) ?></td>
                <td><?= number_format($p["saldo_restante"], 2) ?></td>
                <td><?= $p["fecha_fin"] ?></td>
                <td><?= $p["sobrecoste"] ? "<strong style='color:red'>SOBRECOSTE</strong>" : "OK" ?></td>

                <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "JEFE_PROYECTO"): ?>
                <td>
                    <!-- Mini formulario para cambiar el presupuesto -->
                    <form method="POST" style="display:flex; gap:5px;">
                        <input type="hidden" name="id_proyecto" value="<?= $p["id_proyecto"] ?>">
                        <input type="number" step="0.01" name="nuevo_presupuesto" 
                               value="<?= $p["presupuesto"] ?>" style="width:100px">
                        <button type="submit">Guardar</button>
                    </form>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($proyectos)): ?>
        <p>No hay proyectos activos.</p>
    <?php endif; ?>

    <a class="volver" href="../index.php">← Volver al menú</a>
</div>
</body>
</html>

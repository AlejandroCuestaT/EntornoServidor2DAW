<?php
session_start();
require_once "conexion.php";

$es_jefe = isset($_SESSION["id_empleado"]) && $_SESSION["tipo_empleado"] === 'JEFE_PROYECTO';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_presupuesto"])) {
    if ($es_jefe) {
        $id_proyecto = $_POST["id_proyecto"];
        $nuevo_presupuesto = $_POST["nuevo_presupuesto"];

        if (!empty($id_proyecto) && !empty($nuevo_presupuesto)) {
            $actualizacion = $conexion->prepare("UPDATE proyectos SET presupuesto = :presupuesto WHERE id_proyecto = :id_proyecto");
            $actualizacion->execute([
                "presupuesto" => $nuevo_presupuesto,
                "id_proyecto" => $id_proyecto
            ]);
            $mensaje = "El presupuesto se ha actualizado correctamente.";
        }
    }
}

$consulta = $conexion->prepare("
    SELECT p.id_proyecto, p.nombre, p.presupuesto, IFNULL(SUM(g.importe), 0) AS total_gastos
    FROM proyectos p
    LEFT JOIN gastos g ON p.id_proyecto = g.id_proyecto
    WHERE p.estado = 'ACTIVO'
    GROUP BY p.id_proyecto, p.nombre, p.presupuesto
");
$consulta->execute();
$proyectos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos con Sobrecoste</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 30px; }
        .tabla-contenedor { max-width: 950px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        .sobrecoste { background: #ffcccc; color: #b30000; font-weight: bold; }
        .formulario-edicion { display: inline; }
        .entrada-presupuesto { width: 90px; padding: 3px; }
        .boton-modificar { background: #e0e0e0; border: 1px solid #777; padding: 3px 8px; cursor: pointer; }
        .alerta-exito { color: green; font-weight: bold; margin-bottom: 15px; }
        .volver { display: block; margin-top: 20px; color: #0056b3; text-decoration: none; }
    </style>
</head>
<body>

<div class="tabla-contenedor">
    <h2>Listado de Proyectos Activos y su Situación Presupuestaria</h2>

    <?php if (isset($mensaje)): ?>
        <p class="alerta-exito"><?= $mensaje ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Presupuesto Inicial</th>
                <th>Gastos Totales</th>
                <th>Saldo Restante</th>
                <th>Situación</th>
                <?php if ($es_jefe): ?>
                    <th>Modificar Presupuesto</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proyectos as $proy): ?>
                <?php 
                $saldo = $proy["presupuesto"] - $proy["total_gastos"];
                $tiene_sobrecoste = $saldo < 0;
                ?>
                <tr class="<?= $tiene_sobrecoste ? 'sobrecoste' : '' ?>">
                    <td><?= htmlspecialchars($proy["nombre"]) ?></td>
                    <td><?= number_format($proy["presupuesto"], 2, ',', '.') ?> €</td>
                    <td><?= number_format($proy["total_gastos"], 2, ',', '.') ?> €</td>
                    <td><?= number_format($saldo, 2, ',', '.') ?> €</td>
                    <td><?= $tiene_sobrecoste ? "Sobrecoste" : "Ok" ?></td>
                    
                    <?php if ($es_jefe): ?>
                        <td>
                            <form action="ejercicio4.php" method="POST" class="formulario-edicion">
                                <input type="hidden" name="id_proyecto" value="<?= $proy["id_proyecto"] ?>">
                                <input type="number" step="0.01" name="nuevo_presupuesto" value="<?= $proy["presupuesto"] ?>" class="entrada-presupuesto" required>
                                <button type="submit" name="actualizar_presupuesto" class="boton-modificar">Guardar</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html>
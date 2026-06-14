<?php
session_start();
require_once "conexion.php";

$es_entrenador = isset($_SESSION["id_usuario"]) && $_SESSION["tipo_usuario"] === 'ENTRENADOR';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_capacidad"])) {
    if ($es_entrenador) {
        $id_clase = $_POST["id_clase"];
        $nueva_capacidad = $_POST["nueva_capacidad"];

        if (!empty($id_clase) && isset($nueva_capacidad)) {
            $actualizacion = $conexion->prepare("UPDATE clases SET capacidad_max = :capacidad_max WHERE id_clase = :id_clase");
            $actualizacion->execute([
                "capacidad_max" => $nueva_capacidad,
                "id_clase" => $id_clase
            ]);
            $mensaje = "El aforo de la clase se ha actualizado correctamente.";
        }
    }
}

$consulta = $conexion->prepare("
        SELECT c.id_clase, c.nombre, c.capacidad_max, COUNT(r.id_reserva) AS plazas_ocupadas
        FROM clases c
        LEFT JOIN reservas r ON c.id_clase = r.id_clase
        WHERE c.estado = 'ACTIVO'
        GROUP BY c.id_clase, c.nombre, c.capacidad_max
");
$consulta->execute();
$clases = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Aforos</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 30px; }
        .tabla-contenedor { max-width: 950px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background: #f2f2f2; }
        .lleno { background: #ffcccc; color: #b30000; font-weight: bold; }
        .formulario-edicion { display: inline; }
        .entrada-capacidad { width: 70px; padding: 3px; }
        .boton-modificar { background: #e0e0e0; border: 1px solid #777; padding: 3px 8px; cursor: pointer; }
        .alerta-exito { color: green; font-weight: bold; margin-bottom: 15px; }
        .volver { display: block; margin-top: 20px; color: #28a745; text-decoration: none; }
    </style>
</head>
<body>

<div class="tabla-contenedor">
    <h2>Estado de Ocupación de Clases Activas</h2>

    <?php if (isset($mensaje)): ?>
        <p class="alerta-exito"><?= $mensaje ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Clase</th>
                <th>Capacidad Máxima</th>
                <th>Plazas Ocupadas</th>
                <th>Plazas Libres</th>
                <th>Estado</th>
                <?php if ($es_entrenador): ?>
                    <th>Acción (Modificar Aforo)</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clases as $clase): ?>
                <?php 
                $libres = $clase["capacidad_max"] - $clase["plazas_ocupadas"];
                $esta_lleno = $libres <= 0;
                ?>
                <tr class="<?= $esta_lleno ? 'lleno' : '' ?>">
                    <td><?= htmlspecialchars($clase["nombre"]) ?></td>
                    <td><?= $clase["capacidad_max"] ?> plazas</td>
                    <td><?= $clase["plazas_ocupadas"] ?> inscritos</td>
                    <td><?= $libres < 0 ? 0 : $libres ?></td>
                    <td><?= $esta_lleno ? "Completo" : "Disponible" ?></td>
                    
                    <?php if ($es_entrenador): ?>
                        <td>
                            <form action="ejercicio4.php" method="POST" class="formulario-edicion">
                                <input type="hidden" name="id_clase" value="<?= $clase["id_clase"] ?>">
                                <input type="number" min="0" name="nueva_capacidad" value="<?= $clase["capacidad_max"] ?>" class="entrada-capacidad" required>
                                <button type="submit" name="actualizar_capacidad" class="boton-modificar">Alterar</button>
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
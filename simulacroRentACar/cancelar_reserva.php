<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'CLIENTE') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancelar"])) {
    $id_reserva = $_POST["id_reserva"];
    $id_vehiculo = $_POST["id_vehiculo"];

    try {
        $conexion->beginTransaction();

        $borrar = $conexion->prepare("DELETE FROM reservas WHERE id_reserva = :id_reserva AND id_usuario = :id_usuario");
        $borrar->execute([
            "id_reserva" => $id_reserva,
            "id_usuario" => $id_usuario
        ]);

        $liberar = $conexion->prepare("UPDATE vehiculos SET estado = 'DISPONIBLE' WHERE id_vehiculo = :id_vehiculo");
        $liberar->execute(["id_vehiculo" => $id_vehiculo]);

        $conexion->commit();
        $exito = "Reserva cancelada con éxito y vehículo liberado.";
    } catch (Exception $e) {
        $conexion->rollBack();
        $error = "No se pudo cancelar la reserva. Inténtelo de nuevo.";
    }
}

$consulta = $conexion->prepare("
    SELECT r.id_reserva, r.fecha_inicio, r.fecha_fin, r.coste_total, v.id_vehiculo, v.marca, v.modelo, v.matricula
    FROM reservas r
    INNER JOIN vehiculos v ON r.id_vehiculo = v.id_vehiculo
    WHERE r.id_usuario = :id_usuario AND r.estado = 'ACTIVA'
");
$consulta->execute(["id_usuario" => $id_usuario]);
$mis_reservas = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 850px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #dc3545; color: white; }
        .boton-cancelar { background: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; font-weight: bold; border-radius: 3px; }
        .error { color: red; font-weight: bold; }
        .exito { color: green; font-weight: bold; }
        .vacio { padding: 15px; background: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 4px; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Mis Reservas Activas</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <?php if (empty($mis_reservas)): ?>
        <p class="vacio">No tienes ninguna reserva activa en este momento.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Matrícula</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Coste Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mis_reservas as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['marca'] . " " . $r['modelo']) ?></td>
                        <td><?= htmlspecialchars($r['matricula']) ?></td>
                        <td><?= $r['fecha_inicio'] ?></td>
                        <td><?= $r['fecha_fin'] ?></td>
                        <td><?= $r['coste_total'] ?> €</td>
                        <td>
                            <form action="cancelar_reserva.php" method="POST">
                                <input type="hidden" name="id_reserva" value="<?= $r['id_reserva'] ?>">
                                <input type="hidden" name="id_vehiculo" value="<?= $r['id_vehiculo'] ?>">
                                <button type="submit" name="cancelar" class="boton-cancelar" onclick="return confirm('¿Seguro que quieres cancelar esta reserva?')">Cancelar Reserva</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
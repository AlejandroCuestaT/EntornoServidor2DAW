<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'CLIENTE') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

$consulta_coches = $conexion->prepare("SELECT id_vehiculo, marca, modelo, precio_dia FROM vehiculos WHERE estado = 'DISPONIBLE'");
$consulta_coches->execute();
$vehiculos = $consulta_coches->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_vehiculo = $_POST["id_vehiculo"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    $timestamp_inicio = strtotime($fecha_inicio);
    $timestamp_fin = strtotime($fecha_fin);

    if ($timestamp_fin <= $timestamp_inicio) {
        $error = "Error: La fecha de fin debe ser posterior a la fecha de inicio.";
    } else {
        $dias_alquiler = ($timestamp_fin - $timestamp_inicio) / 86400; //Son los segundos que tiene 1 dia
        
        $consulta_precio = $conexion->prepare("SELECT precio_dia FROM vehiculos WHERE id_vehiculo = :id_vehiculo");
        $consulta_precio->execute(["id_vehiculo" => $id_vehiculo]);
        $precio_dia = $consulta_precio->fetchColumn();

        $coste_total = $dias_alquiler * $precio_dia;

        try {
            $conexion->beginTransaction();

            $insertar_reserva = $conexion->prepare("
                INSERT INTO reservas (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, coste_total, estado) 
                VALUES (:id_usuario, :id_vehiculo, :fecha_inicio, :fecha_fin, :coste_total, 'ACTIVA')
            ");
            $insertar_reserva->execute([
                "id_usuario" => $id_usuario,
                "id_vehiculo" => $id_vehiculo,
                "fecha_inicio" => $fecha_inicio,
                "fecha_fin" => $fecha_fin,
                "coste_total" => $coste_total
            ]);

            $actualizar_vehiculo = $conexion->prepare("UPDATE vehiculos SET estado = 'ALQUILADO' WHERE id_vehiculo = :id_vehiculo");
            $actualizar_vehiculo->execute(["id_vehiculo" => $id_vehiculo]);

            $conexion->commit();
            
            $exito = "Reserva confirmada. Total a pagar: " . number_format($coste_total, 2) . " € por $dias_alquiler días.";
            
            $consulta_coches->execute();
            $vehiculos = $consulta_coches->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $conexion->rollBack();
            $error = "Error al procesar la reserva. Inténtelo de nuevo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Reserva</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .formulario { background: white; padding: 20px; max-width: 400px; border-radius: 5px; border: 1px solid #ccc; }
        .campo { margin-bottom: 15px; }
        .campo label { display: block; margin-bottom: 5px; font-weight: bold; }
        .campo select, .campo input { width: 100%; padding: 8px; box-sizing: border-box; }
        .boton { width: 100%; padding: 10px; background: #28a745; color: white; border: none; font-weight: bold; cursor: pointer; }
        .exito { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .volver { display: block; margin-top: 15px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="formulario">
    <h2>Reservar Vehículo</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <form action="nueva_reserva.php" method="POST">
        <div class="campo">
            <label>Vehículo Disponible:</label>
            <select name="id_vehiculo" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($vehiculos as $v): ?>
                    <option value="<?= $v['id_vehiculo'] ?>">
                        <?= htmlspecialchars($v['marca'] . " " . $v['modelo']) ?> (<?= $v['precio_dia'] ?> €/día)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo">
            <label>Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" required>
        </div>
        <div class="campo">
            <label>Fecha Fin:</label>
            <input type="date" name="fecha_fin" required>
        </div>
        <button type="submit" class="boton">Confirmar Reserva</button>
    </form>
    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
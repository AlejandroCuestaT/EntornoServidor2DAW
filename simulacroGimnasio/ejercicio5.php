<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"] !== 'ENTRENADOR') {
    header("Location: index.php");
    exit;
}

$consulta_socios = $conexion->prepare("SELECT u.id_usuario, u.nombre, u.apellidos FROM usuario u INNER JOIN socio s ON u.id_usuario = s.id_usuario");
$consulta_socios->execute();
$socios = $consulta_socios->fetchAll(PDO::FETCH_ASSOC);

$consulta_clases = $conexion->prepare("SELECT id_clase, nombre FROM clases WHERE estado = 'ACTIVO'");
$consulta_clases->execute();
$clases = $consulta_clases->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $id_clase = $_POST["id_clase"];
    $fecha_reserva = $_POST["fecha_reserva"];

    if (!empty($id_usuario) && !empty($id_clase) && !empty($fecha_reserva)) {
        
        $busca_usuario = $conexion->prepare("SELECT tipo_usuario FROM usuario WHERE id_usuario = :id_usuario");
        $busca_usuario->execute(["id_usuario" => $id_usuario]);
        $usuario_val = $busca_usuario->fetch(PDO::FETCH_ASSOC);

        $busca_clase = $conexion->prepare("SELECT capacidad_max FROM clases WHERE id_clase = :id_clase");
        $busca_clase->execute(["id_clase" => $id_clase]);
        $clase_val = $busca_clase->fetch(PDO::FETCH_ASSOC);

        if ($usuario_val["tipo_usuario"] === 'ENTRENADOR') {
            $error = "No se puede inscribir a un usuario cuyo rol en el sistema sea Entrenador.";
        }

        if (!isset($error)) {
            $cuenta_reservas = $conexion->prepare("SELECT COUNT(*) FROM reservas WHERE id_clase = :id_clase AND fecha_reserva = :fecha_reserva");
            $cuenta_reservas->execute([
                "id_clase" => $id_clase,
                "fecha_reserva" => $fecha_reserva
            ]);
            $total_actual = $cuenta_reservas->fetchColumn();

            if ($total_actual >= $clase_val["capacidad_max"]) {
                $error = "No se puede realizar la reserva si la clase ya ha alcanzado su capacidad máxima de aforo.";
            }
        }

        if (!isset($error)) {
            $comprueba_duplicado = $conexion->prepare("SELECT COUNT(*) FROM reservas WHERE id_usuario = :id_usuario AND id_clase = :id_clase AND fecha_reserva = :fecha_reserva");
            $comprueba_duplicado->execute([
                "id_usuario" => $id_usuario,
                "id_clase" => $id_clase,
                "fecha_reserva" => $fecha_reserva
            ]);

            if ($comprueba_duplicado->fetchColumn() > 0) {
                $error = "Un socio no puede disponer de dos reservas para la misma clase exactamente en la misma fecha.";
            }
        }

        if (!isset($error)) {
            try {
                $insercion = $conexion->prepare("INSERT INTO reservas (id_usuario, id_clase, fecha_reserva) VALUES (:id_usuario, :id_clase, :fecha_reserva)");
                $insercion->execute([
                    "id_usuario" => $id_usuario,
                    "id_clase" => $id_clase,
                    "fecha_reserva" => $fecha_reserva
                ]);
                $exito = "Socio inscrito en la clase exitosamente.";
            } catch (PDOException $e) {
                $error = "Error al tramitar la reserva en la base de datos.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción Manual de Socios</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 40px; }
        .formulario-contenedor { max-width: 450px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        .campo { margin-bottom: 15px; }
        .campo label { display: block; margin-bottom: 5px; font-weight: bold; }
        .campo select, .campo input { width: 100%; padding: 6px; box-sizing: border-box; }
        .boton-enviar { width: 100%; padding: 10px; background: #e0e0e0; border: 1px solid #777; cursor: pointer; font-weight: bold; }
        .mensaje-error { color: red; font-weight: bold; margin-bottom: 15px; }
        .mensaje-exito { color: green; font-weight: bold; margin-bottom: 15px; }
        .volver { display: block; margin-top: 20px; color: #28a745; text-decoration: none; }
    </style>
</head>
<body>

<div class="formulario-contenedor">
    <h2>Inscribir Socio en Clase</h2>

    <?php if (isset($error)): ?>
        <p class="mensaje-error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($exito)): ?>
        <p class="mensaje-exito"><?= $exito ?></p>
    <?php endif; ?>

    <form action="ejercicio5.php" method="POST">
        <div class="campo">
            <label>Seleccionar Socio:</label>
            <select name="id_usuario" required>
                <option value="">-- Elige un socio --</option>
                <?php foreach ($socios as $soc): ?>
                    <option value="<?= $soc["id_usuario"] ?>"><?= htmlspecialchars($soc["nombre"] . " " . $soc["apellidos"]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label>Seleccionar Clase Activa:</label>
            <select name="id_clase" required>
                <option value="">-- Elige una clase --</option>
                <?php foreach ($clases as $clase): ?>
                    <option value="<?= $clase["id_clase"] ?>"><?= htmlspecialchars($clase["nombre"]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label>Fecha de la Sesión:</label>
            <input type="date" name="fecha_reserva" value="<?= date('Y-m-d') ?>" required>
        </div>

        <button type="submit" class="boton-enviar">Formalizar Inscripción</button>
    </form>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html>
<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_empleado"]) || $_SESSION["tipo_empleado"] !== 'JEFE_PROYECTO') {
    header("Location: index.php");
    exit;
}

$consulta_empleados = $conexion->prepare("SELECT id_empleado, nombre, apellidos FROM empleado");
$consulta_empleados->execute();
$empleados = $consulta_empleados->fetchAll(PDO::FETCH_ASSOC);

$consulta_proyectos = $conexion->prepare("SELECT id_proyecto, nombre FROM proyectos WHERE estado = 'ACTIVO'");
$consulta_proyectos->execute();
$proyectos = $consulta_proyectos->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST["id_empleado"];
    $id_proyecto = $_POST["id_proyecto"];
    $num_horas = $_POST["num_horas"];
    $fecha_trabajo = $_POST["fecha_trabajo"];

    if (!empty($id_empleado) && !empty($id_proyecto) && !empty($num_horas) && !empty($fecha_trabajo)) {
        
        $busca_empleado = $conexion->prepare("SELECT tipo_empleado, fecha_contratacion FROM empleado WHERE id_empleado = :id_empleado");
        $busca_empleado->execute(["id_empleado" => $id_empleado]);
        $empleado = $busca_empleado->fetch(PDO::FETCH_ASSOC);

        $busca_proyecto = $conexion->prepare("SELECT fecha_fin FROM proyectos WHERE id_proyecto = :id_proyecto");
        $busca_proyecto->execute(["id_proyecto" => $id_proyecto]);
        $proyecto = $busca_proyecto->fetch(PDO::FETCH_ASSOC);

        if ($empleado["tipo_empleado"] === 'JEFE_PROYECTO') {
            $error = "Cada proyecto solo puede tener asignado un jefe de proyecto.";
        } 
        
        if (!isset($error) && $empleado["fecha_contratacion"] >= $proyecto["fecha_fin"]) {
            $error = "El empleado no puede ser asignado si su fecha de contratación es posterior o igual a la fecha de fin del proyecto.";
        }

        if (!isset($error)) {
            $comprueba_asignacion = $conexion->prepare("SELECT COUNT(*) FROM trabajar WHERE id_empleado = :id_empleado AND id_proyecto = :id_proyecto");
            $comprueba_asignacion->execute([
                "id_empleado" => $id_empleado,
                "id_proyecto" => $id_proyecto
            ]);
            
            if ($comprueba_asignacion->fetchColumn() > 0) {
                $error = "Este empleado ya se encuentra asignado a este proyecto actualmente.";
            }
        }

        if (!isset($error)) {
            try {
                $insercion = $conexion->prepare("INSERT INTO trabajar (id_empleado, id_proyecto, num_horas, fecha_trabajo) VALUES (:id_empleado, :id_proyecto, :num_horas, :fecha_trabajo)");
                $insercion->execute([
                    "id_empleado" => $id_empleado,
                    "id_proyecto" => $id_proyecto,
                    "num_horas" => $num_horas,
                    "fecha_trabajo" => $fecha_trabajo
                ]);
                $exito = "Empleado asignado al proyecto exitosamente.";
            } catch (PDOException $e) {
                $error = "Error al tramitar la asignación en la base de datos.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignación de Empleados</title>
    <style>
        body { font-family: sans-serif; background: #fff; padding: 40px; }
        .formulario-contenedor { max-width: 450px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        .campo { margin-bottom: 15px; }
        .campo label { display: block; margin-bottom: 5px; font-weight: bold; }
        .campo select, .campo input { width: 100%; padding: 6px; box-sizing: border-box; }
        .boton-enviar { width: 100%; padding: 10px; background: #e0e0e0; border: 1px solid #777; cursor: pointer; font-weight: bold; }
        .mensaje-error { color: red; font-weight: bold; margin-bottom: 15px; }
        .mensaje-exito { color: green; font-weight: bold; margin-bottom: 15px; }
        .volver { display: block; margin-top: 20px; color: #0056b3; text-decoration: none; }
    </style>
</head>
<body>

<div class="formulario-contenedor">
    <h2>Asignar Empleado a Proyecto</h2>

    <?php if (isset($error)): ?>
        <p class="mensaje-error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (isset($exito)): ?>
        <p class="mensaje-exito"><?= $exito ?></p>
    <?php endif; ?>

    <form action="ejercicio5.php" method="POST">
        <div class="campo">
            <label>Seleccionar Empleado:</label>
            <select name="id_empleado" required>
                <option value="">-- Elige un empleado --</option>
                <?php foreach ($empleados as $emp): ?>
                    <option value="<?= $emp["id_empleado"] ?>"><?= htmlspecialchars($emp["nombre"] . " " . $emp["apellidos"]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label>Seleccionar Proyecto Activo:</label>
            <select name="id_proyecto" required>
                <option value="">-- Elige un proyecto --</option>
                <?php foreach ($proyectos as $proy): ?>
                    <option value="<?= $proy["id_proyecto"] ?>"><?= htmlspecialchars($proy["nombre"]) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo">
            <label>Horas de Trabajo Asignadas:</label>
            <input type="number" name="num_horas" min="1" max="120" required>
        </div>

        <div class="campo">
            <label>Fecha de Incorporación:</label>
            <input type="date" name="fecha_trabajo" value="<?= date('Y-m-d') ?>" required>
        </div>

        <button type="submit" class="boton-enviar">Formalizar Asignación</button>
    </form>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html>
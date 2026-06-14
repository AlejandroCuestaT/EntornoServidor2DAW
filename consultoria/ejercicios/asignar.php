<?php
session_start();
require_once "../conexion.php";

// Solo pueden entrar jefes de proyecto
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "JEFE_PROYECTO") {
    header("Location: ../login.php");
    exit();
}

$mensaje = "";

// Si se envió el formulario de asignación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST["id_empleado"];
    $id_proyecto = $_POST["id_proyecto"];

    // --- VERIFICACIONES ---

    // 1. El empleado no puede estar ya en ese proyecto
    $check1 = "SELECT * FROM trabajar WHERE id_empleado = $id_empleado AND id_proyecto = $id_proyecto";
    if (mysqli_num_rows(mysqli_query($con, $check1)) > 0) {
        $mensaje = "<p class='error'>Ese empleado ya trabaja en este proyecto.</p>";
    } else {
        // 2. La fecha de contratación debe ser anterior a la fecha de fin del proyecto
        $sql_check2 = "SELECT e.fecha_contratacion, p.fecha_fin
                       FROM empleado e, proyectos p
                       WHERE e.id_empleado = $id_empleado AND p.id_proyecto = $id_proyecto";
        $res2   = mysqli_query($con, $sql_check2);
        $datos  = mysqli_fetch_assoc($res2);

        if ($datos["fecha_contratacion"] >= $datos["fecha_fin"]) {
            $mensaje = "<p class='error'>La fecha de contratación del empleado no es anterior a la fecha de fin del proyecto.</p>";
        } else {
            // 3. Verificamos que no se asigna un jefe cuando ya hay uno
            // Primero vemos el tipo del empleado a asignar
            $sql_tipo = "SELECT tipo_empleado FROM empleado WHERE id_empleado = $id_empleado";
            $res_tipo = mysqli_query($con, $sql_tipo);
            $tipo     = mysqli_fetch_assoc($res_tipo)["tipo_empleado"];

            if ($tipo == "JEFE_PROYECTO") {
                // Comprobamos si el proyecto ya tiene un jefe asignado en trabajar
                // En realidad el jefe de proyecto está en proyectos.id_jefe_proyecto
                // pero según el enunciado también puede aparecer en trabajar
                $check3 = "SELECT e.tipo_empleado FROM trabajar t
                           INNER JOIN empleado e ON t.id_empleado = e.id_empleado
                           WHERE t.id_proyecto = $id_proyecto AND e.tipo_empleado = 'JEFE_PROYECTO'";
                if (mysqli_num_rows(mysqli_query($con, $check3)) > 0) {
                    $mensaje = "<p class='error'>Este proyecto ya tiene un jefe de proyecto asignado.</p>";
                }
            }

            // Si no hubo error, insertamos en trabajar
            if ($mensaje == "") {
                $sql_insert = "INSERT INTO trabajar (id_empleado, id_proyecto, num_horas, fecha_trabajo)
                               VALUES ($id_empleado, $id_proyecto, 0, CURDATE())";
                mysqli_query($con, $sql_insert);
                $mensaje = "<p class='ok'>Empleado asignado al proyecto correctamente.</p>";
            }
        }
    }
}

// Obtenemos los empleados informáticos disponibles (activos)
$sql_empleados = "SELECT id_empleado, nombre, apellidos FROM empleado WHERE estado = 1 AND tipo_empleado = 'INFORMATICO'";
$empleados = mysqli_query($con, $sql_empleados);

// Obtenemos los proyectos activos
$sql_proyectos = "SELECT id_proyecto, nombre FROM proyectos WHERE estado = 'ACTIVO'";
$proyectos = mysqli_query($con, $sql_proyectos);

// Obtenemos las asignaciones actuales para mostrarlas
$sql_asignaciones = "SELECT e.nombre, e.apellidos, p.nombre AS proyecto, t.num_horas
                     FROM trabajar t
                     INNER JOIN empleado e ON t.id_empleado = e.id_empleado
                     INNER JOIN proyectos p ON t.id_proyecto = p.id_proyecto
                     ORDER BY p.nombre, e.apellidos";
$asignaciones = mysqli_query($con, $sql_asignaciones);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Empleados</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="contenedor">
    <h2>Asignar empleado a proyecto</h2>

    <?= $mensaje ?>

    <form method="POST">
        <label>Empleado (informático):</label>
        <select name="id_empleado" required>
            <option value="">-- Selecciona empleado --</option>
            <?php while ($e = mysqli_fetch_assoc($empleados)): ?>
                <option value="<?= $e["id_empleado"] ?>">
                    <?= $e["nombre"] . " " . $e["apellidos"] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Proyecto:</label>
        <select name="id_proyecto" required>
            <option value="">-- Selecciona proyecto --</option>
            <?php while ($p = mysqli_fetch_assoc($proyectos)): ?>
                <option value="<?= $p["id_proyecto"] ?>"><?= $p["nombre"] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Asignar</button>
    </form>

    <!-- Mostramos las asignaciones actuales -->
    <h3 style="margin-top:30px">Asignaciones actuales</h3>
    <table>
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Proyecto</th>
                <th>Horas</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($a = mysqli_fetch_assoc($asignaciones)): ?>
            <tr>
                <td><?= $a["nombre"] . " " . $a["apellidos"] ?></td>
                <td><?= $a["proyecto"] ?></td>
                <td><?= $a["num_horas"] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a class="volver" href="../index.php">← Volver al menú</a>
</div>
</body>
</html>

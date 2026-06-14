<?php
session_start();
require_once "../conexion.php";

// Solo pueden entrar informáticos
if (!isset($_SESSION["id"]) || $_SESSION["tipo"] != "INFORMATICO") {
    header("Location: ../login.php");
    exit();
}

$id_empleado = $_SESSION["id"];
$mensaje = "";

// Obtenemos los proyectos en los que trabaja este informático
$sql_proyectos = "SELECT p.id_proyecto, p.nombre 
                  FROM proyectos p
                  INNER JOIN trabajar t ON p.id_proyecto = t.id_proyecto
                  WHERE t.id_empleado = $id_empleado";
$proyectos = mysqli_query($con, $sql_proyectos);

// Leemos las categorías del fichero CATEGORIAS.txt
$categorias = [];
if (file_exists("../CATEGORIAS.txt")) {
    $categorias = file("../CATEGORIAS.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// Si no hay categorías en el fichero ponemos unas por defecto
if (empty($categorias)) {
    $categorias = ["Transporte", "Hotel", "Dietas", "Material", "Otros"];
}

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hayError = false;

    // Recorremos los proyectos enviados (pueden ser varios)
    foreach ($_POST["id_proyecto"] as $i => $id_proyecto) {
        // Si no se rellenó importe, saltamos este proyecto
        if (empty($_POST["importe"][$i])) {
            continue;
        }

        $importe     = $_POST["importe"][$i];
        $descripcion = $_POST["descripcion"][$i];
        $categoria   = $_POST["categoria"][$i];
        $fecha       = $_POST["fecha"][$i];
        $comprobante = $_POST["comprobante"][$i];

        // Verificamos que el empleado realmente trabaja en ese proyecto (seguridad)
        $check = "SELECT * FROM trabajar WHERE id_empleado = $id_empleado AND id_proyecto = $id_proyecto";
        $res   = mysqli_query($con, $check);

        if (mysqli_num_rows($res) == 0) {
            $mensaje = "<p class='error'>No puedes cargar gastos en un proyecto en el que no trabajas.</p>";
            $hayError = true;
            break;
        }

        // Insertamos el gasto
        $sql_insert = "INSERT INTO gastos (id_empleado, id_proyecto, fecha_gasto, categoria, descripcion, importe, comprobante)
                       VALUES ($id_empleado, $id_proyecto, '$fecha', '$categoria', '$descripcion', $importe, '$comprobante')";
        mysqli_query($con, $sql_insert);
    }

    if (!$hayError) {
        $mensaje = "<p class='ok'>Gastos registrados correctamente.</p>";
    }
}

// Nombre del empleado para mostrarlo
$sql_nombre = "SELECT nombre, apellidos FROM empleado WHERE id_empleado = $id_empleado";
$res_nombre = mysqli_query($con, $sql_nombre);
$empleado   = mysqli_fetch_assoc($res_nombre);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Gastos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="contenedor">
    <h2>Gastos</h2>
    <p><strong>EMPLEADO:</strong> <?= $empleado["nombre"] . " " . $empleado["apellidos"] ?></p>

    <?= $mensaje ?>

    <form method="POST">
    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Importe</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Fecha</th>
                <th>Comprobante</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Guardamos los proyectos para mostrar una fila por cada uno
        $lista_proyectos = [];
        while ($p = mysqli_fetch_assoc($proyectos)) {
            $lista_proyectos[] = $p;
        }

        foreach ($lista_proyectos as $i => $p):
        ?>
            <tr>
                <td>
                    <!-- Campo oculto con el id del proyecto -->
                    <input type="hidden" name="id_proyecto[]" value="<?= $p["id_proyecto"] ?>">
                    <strong><?= $p["nombre"] ?></strong>
                </td>
                <td><input type="number" step="0.01" name="importe[]" placeholder="0.00"></td>
                <td><input type="text" name="descripcion[]"></td>
                <td>
                    <select name="categoria[]">
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat ?>"><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="date" name="fecha[]"></td>
                <td><input type="text" name="comprobante[]" placeholder="archivo.pdf"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($lista_proyectos)): ?>
        <p class="error">No tienes proyectos asignados actualmente.</p>
    <?php else: ?>
        <button type="submit">Registrar gastos</button>
    <?php endif; ?>
    </form>

    <a class="volver" href="../index.php">← Volver al menú</a>
</div>
</body>
</html>

<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_empleado"]) || $_SESSION["tipo_empleado"] !== 'INFORMATICO') {
    header("Location: index.php");
    exit;
}

$id_empleado = $_SESSION["id_empleado"];
$nombre_completo = $_SESSION["nombre"];

$consulta_proyectos = $conexion->prepare("
    SELECT p.id_proyecto, p.nombre 
    FROM proyectos p
    INNER JOIN trabajar t ON p.id_proyecto = t.id_proyecto
    WHERE t.id_empleado = :id_empleado
");
$consulta_proyectos->execute(["id_empleado" => $id_empleado]);
$proyectos = $consulta_proyectos->fetchAll(PDO::FETCH_ASSOC);

$categorias = ["Transporte", "Hotel", "Manutención", "Material", "Otros"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["gastos"])) {
    $conexion->beginTransaction();
    
    try {
        $consulta_insertar = $conexion->prepare("
            INSERT INTO gastos (id_empleado, id_proyecto, fecha_gasto, categoria, descripcion, importe, comprobante)
            VALUES (:id_empleado, :id_proyecto, :fecha_gasto, :categoria, :descripcion, :importe, :comprobante)
        ");

        foreach ($_POST["gastos"] as $id_proyecto => $datos) {
            if (!empty($datos["importe"])) {
                $consulta_insertar->execute([
                    "id_empleado" => $id_empleado,
                    "id_proyecto" => $id_proyecto,
                    "fecha_gasto" => $datos["fecha_gasto"],
                    "categoria" => $datos["categoria"],
                    "descripcion" => $datos["descripcion"],
                    "importe" => $datos["importe"],
                    "comprobante" => $datos["comprobante"]
                ]);
            }
        }

        $conexion->commit();
        $mensaje_exito = "Todos los gastos se han registrado correctamente.";
    } catch (Exception $error) {
        $conexion->rollBack();
        $mensaje_error = "Hubo un error al guardar los gastos: " . $error->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carga de Gastos</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #fff; }
        .formulario-gastos { max-width: 900px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        .cabecera { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .fila-proyecto { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px dashed #ccc; }
        .nombre-proyecto { font-weight: bold; display: inline-block; width: 150px; }
        .campo { display: inline-block; margin-right: 10px; }
        .campo label { font-size: 12px; display: block; }
        .campo input, .campo select { padding: 3px; }
        .boton-guardar { background: #e0e0e0; border: 1px solid #777; padding: 5px 15px; cursor: pointer; display: block; margin-top: 20px; }
        .exito { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .volver { display: block; margin-top: 20px; color: #0056b3; text-decoration: none; }
    </style>
</head>
<body>

<div class="formulario-gastos">
    <div class="cabecera">
        <h2>GASTOS</h2>
        <p><strong>EMPLEADO:</strong> <?= htmlspecialchars($nombre_completo) ?></p>
    </div>

    <?php if (isset($mensaje_exito)): ?>
        <p class="exito"><?= $mensaje_exito ?></p>
    <?php endif; ?>

    <?php if (isset($mensaje_error)): ?>
        <p class="error"><?= $mensaje_error ?></p>
    <?php endif; ?>

    <?php if (empty($proyectos)): ?>
        <p>Actualmente no estás asignado a ningún proyecto activo para cargar gastos.</p>
    <?php else: ?>
        <form action="ejercicio1.php" method="POST">
            
            <?php foreach ($proyectos as $proyecto): ?>
                <div class="fila-proyecto">
                    <span class="nombre-proyecto"><?= htmlspecialchars($proyecto["nombre"]) ?>:</span>
                    
                    <div class="campo">
                        <label>Importe:</label>
                        <input type="number" step="0.01" name="gastos[<?= $proyecto["id_proyecto"] ?>][importe]">
                    </div>

                    <div class="campo">
                        <label>Descripción:</label>
                        <input type="text" name="gastos[<?= $proyecto["id_proyecto"] ?>][descripcion]">
                    </div>

                    <div class="campo">
                        <label>Categoría:</label>
                        <select name="gastos[<?= $proyecto["id_proyecto"] ?>][categoria]">
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat ?>"><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label>Fecha:</label>
                        <input type="date" name="gastos[<?= $proyecto["id_proyecto"] ?>][fecha_gasto]" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="campo">
                        <label>Comprobante:</label>
                        <input type="text" name="gastos[<?= $proyecto["id_proyecto"] ?>][comprobante]">
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit" class="boton-guardar">Registrar gastos</button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html>
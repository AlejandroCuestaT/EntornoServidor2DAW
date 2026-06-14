<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'DIRECTOR') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $id_proyecto = $_POST["id_proyecto"];
    $nuevo_presupuesto = $_POST["nuevo_presupuesto"];

    $consulta_gasto = $conexion->prepare("SELECT gasto_acumulado FROM proyectos WHERE id_proyecto = :id");
    $consulta_gasto->execute(["id" => $id_proyecto]);
    $gasto_actual = $consulta_gasto->fetchColumn();

    if ($nuevo_presupuesto <= 0) {
        $error = "Error: El presupuesto debe ser un importe mayor que 0.";
    } elseif ($nuevo_presupuesto < $gasto_actual) {
        $error = "Error: No puedes asignar un presupuesto de " . number_format($nuevo_presupuesto, 2) . " € porque el proyecto ya ha gastado " . number_format($gasto_actual, 2) . " €.";
    } else {
        $actualizar = $conexion->prepare("UPDATE proyectos SET presupuesto_maximo = :presupuesto WHERE id_proyecto = :id");
        $actualizar->execute([
            "presupuesto" => $nuevo_presupuesto,
            "id" => $id_proyecto
        ]);
        $exito = "Presupuesto actualizado con éxito.";
    }
}

$consulta = $conexion->prepare("SELECT id_proyecto, nombre, presupuesto_maximo, gasto_acumulado, estado FROM proyectos");
$consulta->execute();
$proyectos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ajustar Presupuestos</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        .form-linea { display: flex; gap: 10px; align-items: center; }
        .input-precio { width: 100px; padding: 5px; }
        .boton { background: #ffc107; border: none; padding: 6px 12px; cursor: pointer; font-weight: bold; border-radius: 3px; }
        .boton:hover { background: #e0a800; }
        .error { padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; font-weight: bold; }
        .exito { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; font-weight: bold; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Presupuesto de proyectos</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Estado</th>
                <th>Gasto Acumulado</th>
                <th>Presupuesto Máximo Actual</th>
                <th>Modificar Presupuesto (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proyectos as $p): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                    <td><?= htmlspecialchars($p['estado']) ?></td>
                    <td><?= number_format($p['gasto_acumulado'], 2) ?> €</td>
                    <td><?= number_format($p['presupuesto_maximo'], 2) ?> €</td>
                    <td>
                        <form action="ajustar_presupuestos.php" method="POST" class="form-linea">
                            <input type="hidden" name="id_proyecto" value="<?= $p['id_proyecto'] ?>">
                            <input type="number" step="0.01" name="nuevo_presupuesto" class="input-precio" value="<?= $p['presupuesto_maximo'] ?>" required>
                            <button type="submit" name="actualizar" class="boton">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
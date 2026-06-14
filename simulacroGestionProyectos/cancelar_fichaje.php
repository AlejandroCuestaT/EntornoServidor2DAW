<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'EMPLEADO') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancelar"])) {
    $id_fichaje = $_POST["id_fichaje"];

    try {
        $consulta_fichaje = $conexion->prepare("SELECT id_proyecto, coste_fichaje FROM fichajes WHERE id_fichaje = :id_fichaje AND id_usuario = :id_usuario");
        $consulta_fichaje->execute([
            "id_fichaje" => $id_fichaje,
            "id_usuario" => $id_usuario
        ]);
        $fichaje = $consulta_fichaje->fetch(PDO::FETCH_ASSOC);

        if ($fichaje) {
            $id_proyecto = $fichaje['id_proyecto'];
            $coste_a_restar = $fichaje['coste_fichaje'];

            $conexion->beginTransaction();

            $borrar = $conexion->prepare("DELETE FROM fichajes WHERE id_fichaje = :id_fichaje");
            $borrar->execute(["id_fichaje" => $id_fichaje]);

            $restar_gasto = $conexion->prepare("
                UPDATE proyectos 
                SET gasto_acumulado = gasto_acumulado - :coste 
                WHERE id_proyecto = :id_proyecto
            ");
            $restar_gasto->execute([
                "coste" => $coste_a_restar,
                "id_proyecto" => $id_proyecto
            ]);

            $conexion->commit();
            $exito = "Fichaje cancelado correctamente. Se han devuelto " . number_format($coste_a_restar, 2) . " € al presupuesto del proyecto.";
        } else {
            $error = "No se ha encontrado el fichaje o no tienes permisos para cancelarlo.";
        }

    } catch (Exception $e) {
        $conexion->rollBack();
        $error = "Error al cancelar el fichaje: " . $e->getMessage();
    }
}

$consulta = $conexion->prepare("
    SELECT f.id_fichaje, f.fecha, f.horas, f.coste_fichaje, p.nombre AS nombre_proyecto 
    FROM fichajes f
    INNER JOIN proyectos p ON f.id_proyecto = p.id_proyecto
    WHERE f.id_usuario = :id_usuario
    ORDER BY f.fecha DESC
");
$consulta->execute(["id_usuario" => $id_usuario]);
$fichajes = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cancelar Fichajes</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        .boton-cancelar { background: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; font-weight: bold; border-radius: 3px; }
        .boton-cancelar:hover { background: #c82333; }
        .error { padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; font-weight: bold; }
        .exito { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; font-weight: bold; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; font-weight: bold; }
        .sin-datos { text-align: center; color: #6c757d; font-style: italic; padding: 20px; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Mis Fichajes Registrados</h2>
    <p>Aquí puedes consultar tus horas imputadas y cancelar cualquier fichaje erróneo. Al hacerlo, el coste se reintegrará al presupuesto del proyecto.</p>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Proyecto</th>
                <th>Horas Imputadas</th>
                <th>Coste Total</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($fichajes)): ?>
                <tr>
                    <td colspan="5" class="sin-datos">No has registrado ningún fichaje todavía.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($fichajes as $f): ?>
                    <tr>
                        <td><?= date("d/m/Y", strtotime($f['fecha'])) ?></td>
                        <td><strong><?= htmlspecialchars($f['nombre_proyecto']) ?></strong></td>
                        <td><?= number_format($f['horas'], 1) ?> h</td>
                        <td><?= number_format($f['coste_fichaje'], 2) ?> €</td>
                        <td>
                            <form action="cancelar_fichaje.php" method="POST">
                                <input type="hidden" name="id_fichaje" value="<?= $f['id_fichaje'] ?>">
                                <button type="submit" name="cancelar" class="boton-cancelar" 
                                        onclick="return confirm('¿Estás seguro de que deseas cancelar este fichaje? Se restarán las horas y el coste del proyecto.')">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
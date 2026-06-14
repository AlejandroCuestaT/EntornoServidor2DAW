<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'EMPLEADO') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_proyecto = $_POST["id_proyecto"];
    $horas = $_POST["horas"];
    $fecha = date("Y-m-d");

    if (!empty($id_proyecto) && !empty($horas)) {

        $tarifas = $conexion->prepare("SELECT tarifa_hora FROM usuarios WHERE id_usuario = :id_usuario");
        $tarifas->execute(["id_usuario" => $id_usuario]);
        $tarifa = $tarifas->fetchColumn();

        $coste = $horas * $tarifa;

        $consulta_presu = $conexion->prepare("SELECT presupuesto_maximo, gasto_acumulado FROM proyectos WHERE id_proyecto = :id_proyecto");
        $consulta_presu->execute(["id_proyecto" => $id_proyecto]);
        $datos_proyecto = $consulta_presu->fetch(PDO::FETCH_ASSOC);

        $futuro_gasto = $datos_proyecto['gasto_acumulado'] + $coste;

        if ($futuro_gasto > $datos_proyecto['presupuesto_maximo']) {
            $error = "Error: Imputar estas horas superaría el presupuesto máximo del proyecto.";
        } else {

            try {
                $conexion->beginTransaction();

                $insertar_fichaje = $conexion->prepare("
                    INSERT INTO fichajes (id_usuario, id_proyecto, fecha, horas, coste_fichaje) 
                    VALUES (:id_usuario, :id_proyecto, :fecha, :horas, :coste_fichaje)
                ");
                $insertar_fichaje->execute([
                    "id_usuario" => $id_usuario,
                    "id_proyecto" => $id_proyecto,
                    "fecha" => $fecha,
                    "horas" => $horas,
                    "coste_fichaje" => $coste
                ]);

                $actualizar_proyecto = $conexion->prepare("
                    UPDATE proyectos 
                    SET gasto_acumulado = gasto_acumulado + :coste_fichaje 
                    WHERE id_proyecto = :id_proyecto
                ");
                $actualizar_proyecto->execute([
                    "coste_fichaje" => $coste,
                    "id_proyecto" => $id_proyecto
                ]);
        
                $conexion->commit();
                $exito = "Horas imputadas correctamente. Coste añadido al proyecto: $coste €";

            } catch (Exception $e) {
                $conexion->rollBack();
                $error = "Error al guardar el fichaje.";
            }
        }
    }
}

$consulta_proyectos = $conexion->prepare("SELECT id_proyecto, nombre, presupuesto_maximo, gasto_acumulado FROM proyectos WHERE estado = 'ACTIVO'");
$consulta_proyectos->execute();
$proyectos = $consulta_proyectos->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Imputar horas</title>
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
    <h2>Imputar horas</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <form action="imputar_horas.php" method="POST">
        <div class="campo">
            <label>Proyectos activos:</label>
            <select name="id_proyecto" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($proyectos as $p): ?>
                    <option value="<?= $p['id_proyecto'] ?>">
                        <?= htmlspecialchars($p['nombre']) ?> (<?= $p['presupuesto_maximo'] ?> presupuesto máximo)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo">
            <label>Horas imputadas</label>
            <input type="number" step="0.5" name="horas" min="0.5" required>
        </div>
        <button type="submit" class="boton">Confirmar horas</button>
    </form>
    <a href="index.php" class="volver">← Volver al panel</a>
</div>

</body>
</html>
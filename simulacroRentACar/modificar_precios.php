<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'ADMIN') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $id_vehiculo = $_POST["id_vehiculo"];
    $nuevo_precio = $_POST["nuevo_precio"];

    if ($nuevo_precio <= 0) {
        $error = "Error: El precio por día debe ser mayor que 0.";
    } else {
        $actualizar = $conexion->prepare("UPDATE vehiculos SET precio_dia = :precio WHERE id_vehiculo = :id");
        $actualizar->execute([
            "precio" => $nuevo_precio,
            "id" => $id_vehiculo
        ]);
        $exito = "Precio actualizado correctamente.";
    }
}

$consulta = $conexion->prepare("SELECT id_vehiculo, matricula, marca, modelo, precio_dia, estado FROM vehiculos");
$consulta->execute();
$vehiculos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Precios</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #007bff; color: white; }
        .form-linea { display: flex; gap: 10px; }
        .input-precio { width: 80px; padding: 5px; }
        .boton { background: #ffc107; border: none; padding: 6px 12px; cursor: pointer; font-weight: bold; border-radius: 3px; }
        .error { color: red; font-weight: bold; }
        .exito { color: green; font-weight: bold; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Gestión de Precios de la Flota</h2>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th>Precio Actual</th>
                <th>Modificar Precio (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehiculos as $v): ?>
                <tr>
                    <td><?= htmlspecialchars($v['matricula']) ?></td>
                    <td><?= htmlspecialchars($v['marca'] . " " . $v['modelo']) ?></td>
                    <td><?= htmlspecialchars($v['estado']) ?></td>
                    <td><?= $v['precio_dia'] ?> €</td>
                    <td>
                        <form action="modificar_precios.php" method="POST" class="form-linea">
                            <input type="hidden" name="id_vehiculo" value="<?= $v['id_vehiculo'] ?>">
                            <input type="number" step="0.01" name="nuevo_precio" class="input-precio" value="<?= $v['precio_dia'] ?>" required>
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
<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"] !== 'SOCIO') {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION["id_usuario"];
$nombre_socio = $_SESSION["nombre"];

$servicios_extras = [
    "Nutrición Personalizada",
    "Alquiler de Toallas Mensual",
    "Acceso Zona VIP / SPA",
    "Bono de Fisioterapia"
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pagos"])) {
    $conexion->beginTransaction();

    try {
        $consulta_insertar = $conexion->prepare("
            INSERT INTO pagos (id_usuario, fecha_pago, concepto, importe)
            VALUES (:id_usuario, :fecha_pago, :concepto, :importe)
        ");

        foreach ($_POST["pagos"] as $pago) {
            if (!empty($pago["importe"]) && $pago["importe"] > 0) {
                $consulta_insertar->execute([
                    "id_usuario" => $id_usuario,
                    "fecha_pago" => date('Y-m-d'),
                    "concepto" => $pago["concepto"],
                    "importe" => $pago["importe"]
                ]);
            }
        }

        $conexion->commit();
        $mensaje_exito = "Todos los pagos extras se han procesado y registrado correctamente.";
    } catch (Exception $error) {
        $conexion->rollBack();
        $mensaje_error = "Error crítico al procesar la pasarela de pagos: " . $error->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contratación de Suplementos</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #fff; }
        .formulario-pagos { max-width: 700px; margin: 0 auto; border: 1px solid #000; padding: 20px; }
        .cabecera { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .fila-servicio { margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px dashed #ccc; }
        .nombre-servicio { font-weight: bold; display: inline-block; width: 250px; }
        .campo { display: inline-block; }
        .campo label { font-size: 12px; display: block; }
        .campo input { padding: 3px; width: 100px; }
        .boton-pagar { background: #e0e0e0; border: 1px solid #777; padding: 5px 15px; cursor: pointer; display: block; margin-top: 20px; font-weight: bold; }
        .exito { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .volver { display: block; margin-top: 20px; color: #28a745; text-decoration: none; }
    </style>
</head>
<body>

<div class="formulario-pagos">
    <div class="cabecera">
        <h2>CONTRATACIÓN DE SERVICIOS EXTRAS</h2>
        <p><strong>SOCIO:</strong> <?= htmlspecialchars($nombre_socio) ?></p>
    </div>

    <?php if (isset($mensaje_exito)): ?>
        <p class="exito"><?= $mensaje_exito ?></p>
    <?php endif; ?>

    <?php if (isset($mensaje_error)): ?>
        <p class="error"><?= $mensaje_error ?></p>
    <?php endif; ?>

    <form action="ejercicio1.php" method="POST">
        
        <?php foreach ($servicios_extras as $indice => $servicio): ?>
            <div class="fila-servicio">
                <span class="nombre-servicio"><?= $servicio ?></span>
                
                <input type="hidden" name="pagos[<?= $indice ?>][concepto]" value="<?= $servicio ?>">
                
                <div class="campo">
                    <label>Importe (€):</label>
                    <input type="number" step="0.01" min="0" name="pagos[<?= $indice ?>][importe]" placeholder="0.00">
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="boton-pagar">Proceder al Pago</button>
    </form>

    <a href="index.php" class="volver">← Volver al menú</a>
</div>

</body>
</html>
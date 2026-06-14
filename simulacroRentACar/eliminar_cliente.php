<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'ADMIN') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])) {
    $id_usuario = $_POST["id_usuario"];

    try {
        $borrar = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = :id AND rol = 'CLIENTE'");
        $borrar->execute(["id" => $id_usuario]);
        $exito = "Cliente eliminado del sistema correctamente.";
    } catch (PDOException $e) {
        if ($e->getCode() == "23000") {
            $error = "Error: No se puede eliminar a este cliente porque tiene facturación activa o reservas en el histórico.";
        } else {
            $error = "Error inesperado al eliminar el usuario.";
        }
    }
}

$consulta = $conexion->prepare("SELECT id_usuario, nombre, email FROM usuarios WHERE rol = 'CLIENTE'");
$consulta->execute();
$clientes = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Clientes</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 750px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #212529; color: white; }
        .boton-eliminar { background: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; font-weight: bold; border-radius: 3px; }
        .error { padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; font-weight: bold; margin-bottom: 15px; }
        .exito { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; font-weight: bold; margin-bottom: 15px; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Baja de Clientes del Sistema</h2>
    <p>Panel de administración para eliminar cuentas de clientes. Las cuentas con reservas asociadas están protegidas por integridad.</p>

    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <?php if (isset($exito)) echo "<div class='exito'>$exito</div>"; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><?= $c['id_usuario'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td>
                        <form action="eliminar_cliente.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id_usuario" value="<?= $c['id_usuario'] ?>">
                            <button type="submit" name="eliminar" class="boton-eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar permanentemente a este cliente?')">Dar de Baja</button>
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
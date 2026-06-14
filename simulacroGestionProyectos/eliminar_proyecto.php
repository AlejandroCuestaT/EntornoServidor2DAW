<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] !== 'DIRECTOR') {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["desactivar"])) {
    $id_proyecto = $_POST["id_proyecto"];

    $desactivar = $conexion->prepare("UPDATE proyectos SET estado = 'INACTIVO' WHERE id_proyecto = :id");
    $desactivar->execute(["id" => $id_proyecto]);
    
    $exito = "El proyecto ha sido cambiado a estado INACTIVO. Ya no aparecerá para imputar horas.";
}

$consulta = $conexion->prepare("SELECT id_proyecto, nombre, estado, gasto_acumulado FROM proyectos");
$consulta->execute();
$proyectos = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Desactivar Proyectos</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f9; padding: 30px; }
        .contenedor { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #dc3545; color: white; }
        .boton-desactivar { background: #dc3545; color: white; border: none; padding: 6px 12px; cursor: pointer; font-weight: bold; border-radius: 3px; }
        .boton-desactivar:disabled { background: #6c757d; cursor: not-allowed; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-activo { background: #d4edda; color: #155724; }
        .badge-inactivo { background: #e2e3e5; color: #383d41; }
        .error { padding: 10px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; font-weight: bold; }
        .exito { padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; font-weight: bold; }
        .volver { display: block; margin-top: 20px; text-decoration: none; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Dar de baja proyectos (Borrado Lógico)</h2>
        
    <?php if (isset($exito)) echo "<p class='exito'>$exito</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Proyecto</th>
                <th>Gasto Acumulado</th>
                <th>Estado Actual</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($proyectos as $p): ?>
                <tr>
                    <td><?= $p['id_proyecto'] ?></td>
                    <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                    <td><?= number_format($p['gasto_acumulado'], 2) ?> €</td>
                    <td>
                        <?php if ($p['estado'] === 'ACTIVO'): ?>
                            <span class="badge badge-activo">Activo</span>
                        <?php else: ?>
                            <span class="badge badge-inactivo">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="eliminar_proyecto.php" method="POST">
                            <input type="hidden" name="id_proyecto" value="<?= $p['id_proyecto'] ?>">
                            <button type="submit" name="desactivar" class="boton-desactivar" 
                                    <?= $p['estado'] === 'INACTIVO' ? 'disabled' : '' ?>
                                    onclick="return confirm('¿Estás seguro de que quieres pasar este proyecto a INACTIVO?')">
                                Desactivar
                            </button>
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
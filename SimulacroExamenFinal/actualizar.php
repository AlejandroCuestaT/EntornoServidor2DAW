<?php
session_start();
include("conexion.php");

$errores = array();
$datos = null;

// 1. BUSCAR USUARIO
if (isset($_REQUEST['dni']) && !empty($_REQUEST['dni'])) {
    $dni_buscado = $_REQUEST['dni'];
    $stmt = $conn->prepare("SELECT * FROM usuarios_registro WHERE dni = :dni");
    $stmt->execute([':dni' => $dni_buscado]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);
}

// 2. LÓGICA DE VALIDACIÓN
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_actualizar'])) {
    if (empty($_POST['nombre'])) $errores['nombre'] = "Dime tu nombre";
    if (empty($_POST['apellidos'])) $errores['apellidos'] = "Faltan los apellidos";
    if (!preg_match('/^[0-9]{9}$/', $_POST['telefono'])) $errores['telefono'] = "Deben ser 9 números";
    
    if (empty($errores)) {
        include("actualizarFormulario.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Usuario</title>
    <link rel="stylesheet" href="css/formStyle.css">
</head>
<body>
    <div class="caja-form">
        <h3>Actualizar Usuario</h3>
        
        <form action="actualizar.php" method="GET" style="margin-bottom:20px; border-bottom:1px solid #ccc; padding-bottom:10px;">
            <label>DNI del usuario a editar:</label>
            <input type="text" name="dni" value="<?= isset($_GET['dni']) ? htmlspecialchars($_GET['dni']) : '' ?>" placeholder="12345678X">
            <button type="submit">Cargar Datos</button>
        </form>

        <?php if ($datos): ?>
        <form action="actualizar.php" method="post">
            
            <input type="hidden" name="dni" value="<?= $datos['dni'] ?>">

            <div class="campo-input">
                <label>Nombre *</label>
                <input type="text" name="nombre" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : $datos['nombre'] ?>">
                <?php if (isset($errores['nombre'])) echo "<span class='error-msg'>".$errores['nombre']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Apellidos *</label>
                <input type="text" name="apellidos" value="<?= isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : $datos['apellidos'] ?>">
                <?php if (isset($errores['apellidos'])) echo "<span class='error-msg'>".$errores['apellidos']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Teléfono *</label>
                <input type="text" name="telefono" value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : $datos['telefono'] ?>">
                <?php if (isset($errores['telefono'])) echo "<span class='error-msg'>".$errores['telefono']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Cargo</label>
                <select name="cargo">
                    <option value="profesor" <?= $datos['cargo'] == 'profesor' ? 'selected' : '' ?>>Profesor</option>
                    <option value="director" <?= $datos['cargo'] == 'director' ? 'selected' : '' ?>>Director</option>
                    <option value="jefeEstudios" <?= $datos['cargo'] == 'jefeEstudios' ? 'selected' : '' ?>>Jefe de estudios</option>
                </select>
            </div>

            <div class="zona-check">
                <label><input type="checkbox" name="esCargo" value="1" <?= $datos['es_cargo'] ? 'checked' : '' ?>> Cargo</label>
                <label><input type="checkbox" name="coordinador" value="1" <?= $datos['es_tic'] ? 'checked' : '' ?>> TIC</label>
                <label><input type="checkbox" name="pbilib" value="1" <?= $datos['es_bilingue'] ? 'checked' : '' ?>> Bilingüe</label>
            </div> 

            <button type="submit" name="btn_actualizar" id="boton-enviar">Guardar Cambios</button>
        </form>
        <?php elseif(isset($_GET['dni'])): ?>
            <p style="color:red; text-align:center;">Usuario no encontrado.</p>
        <?php endif; ?>
    </div>
    <p style="text-align:center;"><a href="home.php">Volver al inicio</a></p>
</body>
</html>
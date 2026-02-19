<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Datos</title>
    <link rel="stylesheet" href="css/formStyle.css">
</head>

<?php
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['dni'])) {
        $errores['dni'] = "El DNI es obligatorio";
    } elseif (!preg_match('/^[0-9]{8}[A-Z]$/', $_POST['dni'])) {
        $errores['dni'] = "Formato: 12345678X";
    }

    if (empty($_POST['nombre'])) $errores['nombre'] = "Dime tu nombre";
    if (empty($_POST['apellidos'])) $errores['apellidos'] = "Faltan los apellidos";
    
    if (!preg_match('/^[0-9]{9}$/', $_POST['telefono'])) {
        $errores['telefono'] = "Deben ser 9 números";
    }

    if (empty($_POST['correo'])) $errores['correo'] = "El correo es necesario";

    if (!preg_match('/^[0-9]{8}$/', $_POST['codigoCentro'])) {
        $errores['codigoCentro'] = "Son 8 números";
    }

    if (empty($_POST['nGrupo'])) $errores['nGrupo'] = "Falta el grupo";
}
?>

<body>

    <div class="caja-form">
        <h3>Registro de Usuario</h3>
        
        <form action="formulario.php" method="post">

            <div class="campo-input">
                <label>DNI *</label>
                <input type="text" name="dni" value="<?= isset($_POST['dni']) ? htmlspecialchars($_POST['dni']) : '' ?>">
                <?php if (isset($errores['dni'])) echo "<span class='error-msg'>".$errores['dni']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Nombre *</label>
                <input type="text" name="nombre" value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '' ?>">
                <?php if (isset($errores['nombre'])) echo "<span class='error-msg'>".$errores['nombre']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Apellidos *</label>
                <input type="text" name="apellidos" value="<?= isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : '' ?>">
                <?php if (isset($errores['apellidos'])) echo "<span class='error-msg'>".$errores['apellidos']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Teléfono *</label>
                <input type="text" name="telefono" value="<?= isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : '' ?>">
                <?php if (isset($errores['telefono'])) echo "<span class='error-msg'>".$errores['telefono']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Email</label>
                <input type="email" name="correo" value="<?= isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '' ?>">
                <?php if (isset($errores['correo'])) echo "<span class='error-msg'>".$errores['correo']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Contraseña</label>
                <input type="password" name="passw">
            </div>

            <div class="campo-input">
                <label>Código Centro *</label> 
                <input type="text" name="codigoCentro" value="<?= isset($_POST['codigoCentro']) ? htmlspecialchars($_POST['codigoCentro']) : '' ?>">
                <?php if (isset($errores['codigoCentro'])) echo "<span class='error-msg'>".$errores['codigoCentro']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Nombre del Grupo *</label>
                <input type="text" name="nGrupo" value="<?= isset($_POST['nGrupo']) ? htmlspecialchars($_POST['nGrupo']) : '' ?>">
                <?php if (isset($errores['nGrupo'])) echo "<span class='error-msg'>".$errores['nGrupo']."</span>"; ?>
            </div>

            <div class="campo-input">
                <label>Cargo</label>
                <select name="cargo">
                    <option value="profesor">Profesor</option>
                    <option value="director">Director</option>
                    <option value="jefeEstudios">Jefe de estudios</option>
                </select>
            </div>

            <div class="campo-input">
                <label>Fecha Nacimiento</label>
                <input type="date" name="fechaN" value="<?= isset($_POST['fechaN']) ? $_POST['fechaN'] : '' ?>">
            </div> 

            <div class="zona-check">
                <label><input type="checkbox" name="esCargo" value="1"> Cargo</label>
                <label><input type="checkbox" name="coordinador" value="1"> TIC</label>
                <label><input type="checkbox" name="pbilib" value="1"> Bilingüe</label>
            </div> 

            <button type="submit" id="boton-enviar">Enviar Formulario</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errores)) { 
    // Si la validación es correcta, llamamos al archivo que inserta
    include("insertarFormulario.php");
    
    // Importante: detenemos el script para que no se vuelva a mostrar el formulario vacío debajo
    exit(); 
}
        ?>
    </div>

    <p style="text-align:center;"><a href="index.php">Volver al inicio</a></p>

</body>
</html>
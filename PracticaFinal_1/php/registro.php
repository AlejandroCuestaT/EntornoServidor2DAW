<?php
include("../validaciones/validarEmail.php");
include("../validaciones/validarFecha.php");
include("../validaciones/validarTelefono.php");
include("calculoPuntos.php");

//Inicializacion de variables
$errores = "";
$dni = $apellidos = $nombre = $telefono = $correo = $password = "";
$codcen = $nomgrupo = $fechaalt = $especialidad = $situacion = $nombrecargo = "";
$coordinadortic = $grupotic = $pbilin = $cargo = "";

if (isset($_POST['aceptar'])) {
    
    $dni = $_POST['dni'];
    $apellidos = $_POST['apellidos'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $codcen = $_POST['codcen'];
    $nomgrupo = $_POST['nomgrupo'];
    $fechaalt = $_POST['fechaalt']; //
    $especialidad = $_POST['especialidad'];
    $situacion = $_POST['situacion']; //
    $nombrecargo = $_POST['nombrecargo']; //
    
    $coordinadortic = isset($_POST['coordinadortic']) ? "checked" : ""; //
    $grupotic = isset($_POST['grupotic']) ? "checked" : "";  //
    $pbilin = isset($_POST['pbilin']) ? "checked" : ""; //
    $cargo = isset($_POST['cargo']) ? "checked" : "";

    // --- VALIDACIONES ---
    
    if ($dni == "") { $errores .= "<li>El DNI es obligatorio.</li>"; }
    if ($nombre == "") { $errores .= "<li>El Nombre es obligatorio.</li>"; }
    if ($password == "") { $errores .= "<li>La contraseña es obligatoria.</li>"; }

    if (!validarEmail($correo)) { 
        $errores .= "<li>El correo electrónico no es válido.</li>"; 
    }

    if (!validarTelefono($telefono)) { 
        $errores .= "<li>El teléfono no cumple el formato (ej: 623456789).</li>"; 
    }

    $fecha_formateada = date("d/m/Y", strtotime($fechaalt));
    if ($fechaalt == "" || !validarFecha($fecha_formateada)) { 
        $errores .= "<li>La fecha de nacimiento no es válida (DD/MM/AAAA).</li>"; 
    }

    if ($errores == "") {
    $datosUsuario = [
        'coordinadortic' => $coordinadortic,
        'grupotic' => $grupotic,
        'pbilin' => $pbilin,
        'nombrecargo' => $nombrecargo,
        'situacion' => $situacion,
        'fechaalt' => $fecha_formateada
    ];

    $puntos = calcularPuntos($datosUsuario);

    $datosCompletos = [
        'dni'            => $dni,
        'apellidos'      => $apellidos,
        'nombre'         => $nombre,
        'telefono'       => $telefono,
        'correo'         => $correo,
        'password'       => $password,
        'codcen'         => $codcen,
        'coordinadortic' => isset($_POST['coordinadortic']) ? 1 : 0,
        'grupotic'       => isset($_POST['grupotic']) ? 1 : 0,
        'pbilin'         => isset($_POST['pbilin']) ? 1 : 0,
        'cargo'          => isset($_POST['cargo']) ? 1 : 0,
        'nomgrupo'       => $nomgrupo,
        'nombrecargo'    => $nombrecargo,
        'situacion'      => $situacion,
        'fechaalt'       => $fechaalt, 
        'especialidad'   => $especialidad,
        'puntos'         => $puntos
    ];

    include("insertarRegistro.php");
    insertarRegistro($datosCompletos);
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Registro</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: black; padding: 20px; }
        .container { background: white; padding: 30px; max-width: 500px; margin: auto; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.5); }
        h2 { text-align: center; color: #333; margin-top: 0; }
        label { display: block; font-weight: bold; margin-top: 15px; color: #444; }
        input[type="text"], input[type="password"], input[type="email"], input[type="date"], select {
            width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #bbb; border-radius: 6px; box-sizing: border-box;
        }
        .error-zone { background: #fff0f0; color: #b00; padding: 15px; border-left: 5px solid #d00; margin-bottom: 20px; border-radius: 4px; }
        .chk-row { margin: 12px 0; display: flex; align-items: center; }
        .chk-row input { margin-right: 12px; transform: scale(1.2); }
        .btn-submit { background: #28a745; color: white; border: none; padding: 14px; width: 100%; border-radius: 6px; cursor: pointer; font-size: 17px; margin-top: 20px; font-weight: bold; }
        .btn-submit:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Registro de Usuario</h2>

    <?php if ($errores != ""): ?>
        <div class="error-zone">
            <strong>Se han encontrado errores:</strong>
            <ul style="margin-top: 5px;"><?php echo $errores; ?></ul>
        </div>
    <?php endif; ?>

    <form action="registro.php" method="post">
        
        <label>DNI:</label>
        <input type="text" name="dni" value="<?php echo $dni; ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>">

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $apellidos; ?>">

        <label>Teléfono:</label>
        <input type="text" name="telefono" placeholder="Ej: 600123456" maxlength="9" value="<?php echo $telefono; ?>">

        <label>Correo Electrónico:</label>
        <input type="email" name="correo" value="<?php echo $correo; ?>">

        <label>Password:</label>
        <input type="password" name="password">

        <label>Fecha Alta (fechaalt):</label>
        <input type="date" name="fechaalt" value="<?php echo $fechaalt; ?>">

        <label>Código Centro (codcen):</label>
        <input type="text" name="codcen" value="<?php echo $codcen; ?>">

        <label>Especialidad:</label>
        <input type="text" name="especialidad" value="<?php echo $especialidad; ?>">

        <label>Situación:</label>
        <select name="situacion">
            <option value="">-- Seleccione --</option>
            <option value="activo" <?php if($situacion=="activo") echo "selected"; ?>>Activo</option>
            <option value="inactivo" <?php if($situacion=="inactivo") echo "selected"; ?>>Inactivo</option>
        </select>

        <label>Nombre del Cargo:</label>
        <select name="nombrecargo">
            <option value="">-- Seleccione --</option>
            <option value="director" <?php if($nombrecargo=="director") echo "selected"; ?>>Director</option>
            <option value="jefeDeEstudios" <?php if($nombrecargo=="jefeDeEstudios") echo "selected"; ?>>Jefe de Estudios</option>
            <option value="secretario" <?php if($nombrecargo=="secretario") echo "selected"; ?>>Secretario</option>
            <option value="jefeDeDepartamento" <?php if($nombrecargo=="jefeDeDepartamento") echo "selected"; ?>>Jefe De Departamento</option>
        </select>

        <label>Nombre del Grupo (nomgrupo):</label>
        <input type="text" name="nomgrupo" value="<?php echo $nomgrupo; ?>">

        <div class="chk-row">
            <input type="checkbox" name="coordinadortic" <?php echo $coordinadortic; ?>> Coordinador TIC
        </div>
        <div class="chk-row">
            <input type="checkbox" name="grupotic" <?php echo $grupotic; ?>> Grupo TIC
        </div>
        <div class="chk-row">
            <input type="checkbox" name="pbilin" <?php echo $pbilin; ?>> Programa Bilingüe
        </div>
        <div class="chk-row">
            <input type="checkbox" name="cargo" <?php echo $cargo; ?>> Tiene Cargo
        </div>

        <button type="submit" name="aceptar" class="btn-submit">Registrar Ahora</button>
    </form>
</div>

</body>
</html>
<?php
include("conexion.php");

try {
    // Preparamos la consulta usando la variable $conn del include
    $sql = "INSERT INTO usuarios_registro 
            (dni, nombre, apellidos, telefono, correo, password, codigo_centro, nombre_grupo, cargo, fecha_nacimiento, es_cargo, es_tic, es_bilingue) 
            VALUES (:dni, :nom, :ape, :tel, :cor, :passw, :cod, :gru, :car, :fec, :esc, :est, :esb)";
    
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':dni'  => $_POST['dni'],
        ':nom'  => $_POST['nombre'],
        ':ape'  => $_POST['apellidos'],
        ':tel'  => $_POST['telefono'],
        ':cor'  => $_POST['correo'],
        ':passw' => $_POST['passw'],
        ':cod'  => $_POST['codigoCentro'],
        ':gru'  => $_POST['nGrupo'],
        ':car'  => $_POST['cargo'],
        ':fec'  => $_POST['fechaN'],
        ':esc'  => isset($_POST['esCargo']) ? 1 : 0,
        ':est'  => isset($_POST['coordinador']) ? 1 : 0,
        ':esb'  => isset($_POST['pbilib']) ? 1 : 0
    ]);

    echo "<div class='exito'>¡Registro insertado correctamente en la base de datos!</div>";
    echo "<p><a href='formulario.php'>Registrar otro usuario</a></p>";

} catch (PDOException $e) {
    echo "<b style='color:red'>Error al insertar:</b> " . $e->getMessage();
}
?>
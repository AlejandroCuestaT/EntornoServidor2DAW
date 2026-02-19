<?php
// ejecutarActualizar.php
include("conexion.php");

try {
    $sql = "UPDATE usuarios_registro SET 
            nombre = :nom, 
            apellidos = :ape, 
            telefono = :tel, 
            cargo = :car, 
            es_cargo = :esc, 
            es_tic = :est, 
            es_bilingue = :esb 
            WHERE dni = :dni";
    
    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':nom'  => $_POST['nombre'],
        ':ape'  => $_POST['apellidos'],
        ':tel'  => $_POST['telefono'],
        ':car'  => $_POST['cargo'],
        ':esc'  => isset($_POST['esCargo']) ? 1 : 0,
        ':est'  => isset($_POST['coordinador']) ? 1 : 0,
        ':esb'  => isset($_POST['pbilib']) ? 1 : 0,
        ':dni'  => $_POST['dni'] 
    ]);

    echo "<div class='exito'>¡Usuario actualizado correctamente!</div>";
    echo "<p style='text-align:center;'><a href='actualizar.php'>Volver a buscar</a></p>";

} catch (PDOException $e) {
    echo "<b style='color:red'>Error:</b> " . $e->getMessage();
}
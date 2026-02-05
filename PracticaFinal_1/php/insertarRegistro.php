<?php
include_once("conexion.php");

function insertarRegistro($datos) {
    global $conn; 

    try {
        $sql = "INSERT INTO solicitantes (
                    dni, apellidos, nombre, telefono, correo, password, 
                    codcen, coordinadortic, grupotic, nomgrupo, pbilin, 
                    cargo, nombrecargo, situacion, fechaalt, especialidad, puntos
                ) VALUES (
                    :dni, :apellidos, :nombre, :telefono, :correo, :password, 
                    :codcen, :coordinadortic, :grupotic, :nomgrupo, :pbilin, 
                    :cargo, :nombrecargo, :situacion, :fechaalt, :especialidad, :puntos
                )";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':dni'            => $datos['dni'],
            ':apellidos'      => $datos['apellidos'],
            ':nombre'         => $datos['nombre'],
            ':telefono'       => $datos['telefono'],
            ':correo'         => $datos['correo'],
            ':password'       => $datos['password'],
            ':codcen'         => $datos['codcen'],
            ':coordinadortic' => $datos['coordinadortic'],
            ':grupotic'       => $datos['grupotic'],
            ':nomgrupo'       => $datos['nomgrupo'],
            ':pbilin'         => $datos['pbilin'],
            ':cargo'          => $datos['cargo'],
            ':nombrecargo'    => $datos['nombrecargo'],
            ':situacion'      => $datos['situacion'],
            ':fechaalt'       => $datos['fechaalt'],
            ':especialidad'   => $datos['especialidad'],
            ':puntos'         => $datos['puntos']
        ]);

        enviarCorreoConfirmacion($datos['correo'], $datos['nombre'], $datos['puntos'], $datos['especialidad']);

        echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>";
        echo "<h1 style='color:green;'>¡Registro Guardado y Correo Enviado!</h1>";
        echo "<p>Usuario: <b>" . htmlspecialchars($datos['nombre']) . "</b> insertado con <b>" . $datos['puntos'] . "</b> puntos.</p>";
        echo "<br><a href='registro.php' style='text-decoration:none; background:#28a745; color:white; padding:10px 20px; border-radius:5px;'>Volver al Formulario</a>";
        echo "</div>";

    } catch (PDOException $e) {
        echo "<div style='color:red; text-align:center; padding:20px;'>";
        echo "<h3>Error al insertar:</h3>" . $e->getMessage();
        echo "</div>";
    }
}

function enviarCorreoConfirmacion($emailDestino, $nombreUsuario, $puntos, $especialidad) {
    $asunto = "Confirmacion de Registro - " . $nombreUsuario;
    $mensaje = "Hola " . $nombreUsuario . ",\r\n\r\n"
             . "Tu registro se ha completado correctamente.\r\n"
             . "Detalles:\r\n"
             . "- Puntos obtenidos: " . $puntos . "\r\n"
             . "- Especialidad: " . $especialidad . "\r\n\r\n"
             . "Gracias por registrarte.";

    $headers = "From: no-reply@empresaCuesta.com\r\n";
    return mail($emailDestino, $asunto, $mensaje, $headers);
}
?>
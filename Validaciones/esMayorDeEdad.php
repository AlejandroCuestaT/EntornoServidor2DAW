<?php 
// Comprueba que sea mayor de 18
function esMayorDeEdad($fechaNacimiento) {
    $fechaNormalizada = str_replace(['/', '.'], '-', $fechaNacimiento);

    $fecha = DateTime::createFromFormat('d-m-Y', $fechaNormalizada);

    if (!$fecha) {
        return false;
    }

    $hoy = new DateTime();

    $edad = $hoy->diff($fecha)->y;

    return $edad >= 18;
}
?>
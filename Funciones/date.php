<?php
    //Fecha de hoy
    $hoy = new DateTime();

    //Formatear la salida
    echo $hoy->format('Y/m/d H:i:s');

    $expira = new DateTime('2026-05-20');

    //Diferencia entre los dos días en días
    $diferencia = $hoy->diff($expira);
    echo "Faltan ".$diferencia->days." días";

    //Diferencia entre los dos días con meses y días
    echo $diferencia->format('%m meses y %d días');

    $intervalo = new DateInterval('P7D');
    $hoy->add($intervalo); //Suma 7 días a la fecha
    echo $hoy->format('Y-m-d');
?>
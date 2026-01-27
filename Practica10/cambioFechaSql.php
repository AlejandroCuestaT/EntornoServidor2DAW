<?php 
    //fecha actual
    $fechaActual= new DateTime('now');
    //Recoge el dia del mes
    $dia = $fechaActual->format("d");

    //Recoge el mes en numero
    $mes= $fechaActual->format("n");

    //Recoge el año
    $anio = $fechaActual->format("Y");

    $fechaSql = $anio."/".$mes."/".$dia;

    echo $fechaSql;
?>
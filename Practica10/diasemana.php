<?php 
$dias_semana = array(
    "Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"
);

$fechaActual= new DateTime('now');

//Recoge el dia de la semana en numero
$dia_semana = $fechaActual->format("w");
$dia_semana = $dias_semana[$dia_semana-1];

echo 'Hoy es '.$dia_semana;

?>
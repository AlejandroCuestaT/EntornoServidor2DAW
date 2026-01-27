<?php 
$dia_semana='';
$dia='';
$mes='';
$anio='';
$hora='';

$dias_semana = array(
    "Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"
);

$meses = array(
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
);

//fecha actual
$fechaActual= new DateTime('now');
echo "\n".$fechaActual->format('Y-m-d')."<br><br>";

$fecha_tardia = new DateTime('now');
//fecha en una semana
$fecha_tardia->add(new DateInterval('P1W'));
echo "\n".$fecha_tardia->format('Y-m-d')."<br><br>";

//Recoge el dia de la semana en numero
$dia_semana = $fechaActual->format("w");
$dia_semana = $dias_semana[$dia_semana-1];

//Recoge el dia del mes
$dia = $fechaActual->format("j");

//Recoge el mes en numero
$mes= $fechaActual->format("n");
$mes = $meses[$mes-1];

//Recoge el año
$anio = $fechaActual->format("Y");

//Recoge la hora
$hora = $fechaActual->format("H:i");

echo $dia_semana.", ".$dia." de ".$mes." de ".$anio.". A las ".$hora;








?>
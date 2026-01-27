<?php 

$nuevaFecha = new DateTime('2011-01-25');

//--------------------- ADD --------------------------

//Para añadir fecha obligatoriamente tiene que ir la P delante
//Se le añade 1 año, 3 meses y 10 dias
$nuevaFecha->add(new DateInterval('P1Y3M10D'));
echo "\n".$nuevaFecha->format('Y-m-d'); //Esto imprime 2011-02-04

echo "<br><br>";

//Si quieres añadirle horas obligatoriamente hay que añadir la T a partir del tiempo
//añade 10 horas, 4 minutos y 3 segundos
$nuevaFecha->add(new DateInterval('PT10H4M3S'));
echo "\n".$nuevaFecha->format('Y-m-d H:i:s');

echo "<br><br>";

//--------------------- SUB --------------------------

//Devuelve la fecha menos 6 horas, 3 minutos y 1 segundo
$nuevaFecha->sub(new DateInterval('PT6H3M1S')); 
echo "\n".$nuevaFecha->format('Y-m-d H:i:s');

echo "<br><br>";

//--------------------- DIFF --------------------------

$fecha1 = new DateTime('2011-01-01');
$fecha2 = new DateTime('2011-05-03');
$intervalo = $fecha1->diff($fecha2);

//Para formatear intervalos siempre hay que poner el %
//%R te pone un + si es positivo y - si es negativo [ Con r si es positivo no pone el + ]
//%a te dice el dia total de dias de diferencia

echo "\n" . $intervalo->format('%R%a días'); //Imprime 122 días


?>
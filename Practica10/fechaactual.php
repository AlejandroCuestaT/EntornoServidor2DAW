<?php 
$fechaActual= new DateTime('now');

//Muestra el dia de la semana
echo $fechaActual->format("l");

echo '<br><br>';

echo $fechaActual->format("l,d")."rd of ".$fechaActual->format("F Y H:i:s");

echo '<br><br>';

echo $fechaActual->format("l,d")." de ".$fechaActual->format("F")." de ".$fechaActual->format("Y H:i:s");

echo '<br><br>';

echo $fechaActual->format("F d, Y, H:i");

echo '<br><br>';

echo $fechaActual->format("d.m.y");

echo '<br><br>';

echo $fechaActual->format("m, d, Y");

echo '<br><br>';

echo $fechaActual->format("Ydm");

echo '<br><br>';

echo 'It is the '.$fechaActual->format("d").'rd day.';

?>
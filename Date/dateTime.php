<?php
//Ponemos la zona horaria de madrid por defecto SIEMPRE
//date_default_timezone_set("America/Barbados");
//date_default_timezone_set("Europe/Madrid");

$nuevaFecha = new DateTime();
echo $nuevaFecha->format("Y-m-d H:i:s");
echo "<br><br>";

//Con now da la fecha actual
$hoy = new DateTime('now');
echo "\n" . $hoy->format("Y-m-d H:i:s");
echo "<br><br>";

//Con yesterday te da la fecha de ayer con hora 00:00:00
$ayer = new DateTime('yesterday');
echo "\n" . $ayer->format("Y-m-d H:i:s");
echo "<br><br>";

//Con tomorrow te da la fecha de mañana con hora 00:00:00
$maniana = new DateTime('tomorrow');
echo "\n" . $maniana->format("Y-m-d H:i:s");
?>
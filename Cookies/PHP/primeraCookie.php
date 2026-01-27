<?php
$nombre = 'cookie2';
$valor = 'Segunda cadena de cookie, solo guardo texto';
//Si no se pone la fecha de expiracion la cookie desaparece
//cuando se cierra el navegador
$fecha_expiracion_un_anio = time()+60*60*24*365; //expira en un anio
$fecha_expiracion_un_minuto =  time()+60; //expira en un minuto
$path = 'localhost/ejercicios/Cookies'; //tiene que ser absoluta desde localhost
$dominio = '';
$segura = '';
$httponly = '';

setcookie($nombre, $valor, $fecha_expiracion_un_minuto, $path);

?>
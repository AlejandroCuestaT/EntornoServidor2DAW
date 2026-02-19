<?php
include ('soporte.php');
include ('cinta_video.php');

$sop1 = new Soporte('El titulo', 'El numero', 'El precio');

$cint1 = new cinta_video('tit1', 'tit2', 'tit3', 'tit4');

$soportes = array($sop1, $cint1);

foreach($soportes as $valor){
    $valor -> imprime_caracteristicas();
}

?>
<?php

function incrementarContador(){
$fichero = fopen('../TXT/visitas.txt', 'r+');
if (!$fichero)
    //Te da error y termina el programa si no existe el fichero en esa ruta
die("ERROR: no se ha podido abrir el fichero de datos");
$cont = fread($fichero,8);
echo 'Esta es la visita numero: '.$cont.'<br>';
$cont = intval($cont) + 1;
rewind($fichero);
fwrite($fichero, $cont);
fclose($fichero);
}

incrementarContador();



?>
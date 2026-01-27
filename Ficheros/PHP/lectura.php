<?php
$fichero = fopen('subeFicheroMultiple_v2.php', 'r');

if (!$fichero)
    //Te da error y termina el programa si no existe el fichero en esa ruta
die("ERROR: no se ha podido abrir el fichero de datos");

//!feof significa mientras no sea la ultima linea, porque siempre es eof
while(!feof($fichero)){
    //fget lee una linea
    echo fgets($fichero) . '<br>';
}


fclose($fichero);
?>
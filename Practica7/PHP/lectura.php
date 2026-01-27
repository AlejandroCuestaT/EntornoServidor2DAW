<?php
$fichero = fopen('../../Ficheros/PHP/subeFicheroMultiple_v2.php', 'r');
$ficheroVacio = fopen('../TXT/fich_salida.txt', 'w+');
if (!$fichero)
    //Te da error y termina el programa si no existe el fichero en esa ruta
die("ERROR: no se ha podido abrir el fichero de datos");


//!feof significa mientras no sea la ultima linea, porque siempre es eof
while(!feof($fichero)){
    
    $linea = fgets($fichero);
    fputs($ficheroVacio,$linea);

}

echo 'El tamaño en bytes es: '.filesize('../TXT/fich_salida.txt');

fclose($fichero);
fclose($ficheroVacio);

?>
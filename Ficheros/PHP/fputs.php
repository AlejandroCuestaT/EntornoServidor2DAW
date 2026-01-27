<?php
$fichero = fopen('../APUNTES/prueba.txt', 'a+');

if (!$fichero)
    //Te da error y termina el programa si no existe el fichero en esa ruta
die("ERROR: no se ha podido abrir el fichero de datos");


fputs($fichero,"otra linea \n");

rewind($fichero);

while(!feof($fichero)){
    //fget lee una linea
    echo fgets($fichero) . '<br>';
}
//Ciero porque ya he escrito y el puntero esta al final
fclose($fichero);

//Reabro con permisos solo de lectura para leer desde el principio
$fichero = fopen('../APUNTES/prueba.txt', 'r');

while(!feof($fichero)){
    //fget lee una linea
    echo fgets($fichero) . '<br>';
}

fclose($fichero);

?>
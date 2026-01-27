<?php 
$fichero = fopen('../APUNTES/fopen.txt', 'r');

if (!$fichero)
    //Te da error y termina el programa si no existe el fichero en esa ruta
die("ERROR: no se ha podido abrir el fichero de datos");

echo 'EJEMPLO CON GET: <br>';
//!feof significa mientras no sea la ultima linea, porque siempre es eof
while(!feof($fichero)){
    //fget lee una linea
    echo fgets($fichero) . '<br>';
}

echo '<br><br>';

echo 'EJEMPLO CON FILE: <br>';
//NO se usa, siempre fget
//Esto coge todo el fichero en una linea con file
$file = file('../APUNTES/fopen.txt');
foreach ($file as $linea){
    echo $linea;
}

echo '<br><br>';

echo 'EJEMPLO CON FILE_GET_CONTENTS: <br>';
//Esto hace lo mismo que $file sin el foreach
echo file_get_contents('../APUNTES/fopen.txt');

echo '<br><br>';
echo 'EJEMPLO CON FILE DE LA UPM: <br>';

$file2 = file('http://www.upm.es');
foreach ($file2 as $linea){
    echo $linea;
}

fclose($fichero);
?>
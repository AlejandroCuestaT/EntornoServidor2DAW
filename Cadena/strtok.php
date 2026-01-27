<?php
$string = "Esto es\tun ejemplo\ncadena";

//Separa la primera palabra de la frase con el delimitador
$tok = strtok($string, " \n\t");

//Va mostrando las siguientes mientras detecte el limitador
while ($tok !== false) {
    echo "$tok <br>";
    $tok = strtok(" \n\t");
}
?>
<?php 

$a = array('1.10', 12.4, 1.13);

//Valor a buscar, array donde buscar, si quieres true o false
if (in_array('12.4', $a, true)) {
echo "'12.4' Encontrado con chequeo STRICT\n";}

if (in_array(1.13, $a, true)) {
echo "1.13 Encontrado con chequeo STRICT\n";}

?>
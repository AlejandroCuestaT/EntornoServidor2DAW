<?php 
//Array_keys
//Array values

//Preg_grep sirve para buscar coincidencias en un array
$arrayAbc = ['abc', 'abcc', 'abccc', 'abcccc', 'abccccc'];
$validacion = preg_grep('/abc{2}/', $arrayAbc);
print_r($validacion);

//Revisa que contenga una c,luego num de 0 a 9, de 2 a 6, AN o R 
// y al final una o
$arrayVal = ['12A', 'c12Ao', 'c12A', 'c66Ro', 'aaaabb@bbb'];
$validacion2 = preg_grep('/c[0-9][2-6][ANR]o/', $arrayVal);

echo '<br>';
print_r($validacion2);

//Con esta negacion hace que de inicio ( ^ ) a fin ( $ ) n veces ( * ) 
//mire si hay un @ y si hay que no lo coja
$validacion3 = preg_grep('/^[^@]*$/', $arrayVal);

echo '<br>';
print_r($validacion3);

?>
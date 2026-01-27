<?php 
$vec = array(10,6,7,8,23,1,2,5);
$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//Aqui no duelvelve un array nuevo, lo que hace es modificar el que 
//le estas pasando
//$res devuelve lo que elimina
$res = array_splice($col,1,2,array('dos','tres'));

//Los elementos eliminados son sustituidos 
//por un solo elemento, en este caso 'a'
print_r($col);
?>
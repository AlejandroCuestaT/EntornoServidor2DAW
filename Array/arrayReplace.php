<?php 
$matriz_destino=array('altura'=>185,'peso'=>85);
$matriz_origen=array('pelo'=>'moreno','peso'=>95);
//Remplaza si la clave es identica, si no lo añade
var_dump(array_replace($matriz_destino, $matriz_origen));
?>
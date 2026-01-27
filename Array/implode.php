<?php 
$vec = array(10,6,7,8,23,1,2,5);
$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//Recoge todo el array y te lo pone junto con el linitador, en este caso ','
$res = implode(' , ', $col);

print_r($res);
?>
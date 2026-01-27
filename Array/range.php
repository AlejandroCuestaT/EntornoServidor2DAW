<?php 
$vec = array(10,6,7,8,23,1,2,5);
$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//Da la vuelta al array, ultimo pasa a primero, 
//penultimos a segundo y viceversa
$res = array_reverse($col);

print_r($res);
echo '<br> <br>';

shuffle($vec);

print_r($vec);
?>
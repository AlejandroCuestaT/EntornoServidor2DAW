<?php 
$vec = array(10,6,7,8,23,1,2,5);
$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//sort ordena el array, en este caso alfabeticamente
echo 'SORT <br>';
$res = sort($col);
print_r($col);
echo '<br><br>';

//ordena el array, en este caso numericamente
echo 'SORT <br>';
$res1 = sort($vec);
print_r($vec);

echo '<br><br>';

$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//rsort ordena de mayor a menor
echo 'RSORT <br>';
$res2 = rsort($col);
print_r($col);
echo '<br><br>';

$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//asort ordena el array respetando la clave y el valor
echo 'ASORT <br>';
$res3 = asort($col);
print_r($col);
echo '<br><br>';

$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//arsort ordena el array en orden inverso respetando la clave y el valor
echo 'ARSORT <br>';
$res4 = arsort($col);
print_r($col);
echo '<br><br>';

$col = array('cero' => 'azul', 'uno' => 'verde', 'rojo','amarillo','marron','blanco');

//asort ordena el array mirando las claves respetando la clave y el valor
echo 'KSORT <br>';
$res4 = ksort($col);
print_r($col);
echo '<br><br>';


?>
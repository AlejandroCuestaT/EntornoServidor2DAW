
<?php 
$vec = array(10,6,7,8,23,1,2,5);
$col = array('azul', 'verde', 'rojo','amarillo','marron','blanco');

//Devuelve un nuevo array modificado con los parametros necesarios
$res = array_slice($col,0,-3);

print_r($res);
?>
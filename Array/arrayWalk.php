<?php 
function aFarenheit(&$valor,$clave){
$valor=(($valor*1.38)+32).'F';
}
$temperatura = array(
    "Madrid"=> "25",
    "Cordoba"=> "35",
    "Sevilla"=> "40",
    "Zaragoza"=> "15",

);
print_r($temperatura);
echo '<br><br>';

array_walk($temperatura,'aFarenheit');

print_r($temperatura);
?>
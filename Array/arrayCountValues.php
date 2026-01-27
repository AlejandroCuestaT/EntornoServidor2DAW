<?php 
$matriz = array(1, "hola", 1, "mundo", "hola");
$arrayCount = array_count_values($matriz); // devuelve array(1=>2,"hola"=>2,"mundo"=>1)
print_r($arrayCount);
?>
<?php
$texto = "El sol brilla y el sol calienta";

// Buscar la última posición de "sol"
$ultima_pos = strrpos($texto, "sol");
echo $ultima_pos; // Resultado: 19 (segunda ocurrencia)
echo '<br>';
// Buscar desde la posición 10
$ultima_desde_10 = strrpos($texto, "sol", 10);
echo $ultima_desde_10; // Resultado: 19
echo '<br>';
// Buscar una palabra que no existe
$no_existe = strrpos($texto, "luna");
var_dump($no_existe); // Resultado: bool(false)
?>
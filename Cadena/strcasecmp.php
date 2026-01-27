<?php
// Comparación que NO distingue mayúsculas/minúsculas
$resultado1 = strcasecmp("Hola", "HOLA");
echo $resultado1; // Resultado: 0 (iguales)
echo '<br>';
$resultado2 = strcasecmp("PHP", "php");
echo $resultado2; // Resultado: 0 (iguales)
echo '<br>';
$resultado3 = strcasecmp("Manzana", "manzana");
echo $resultado3; // Resultado: 0 (iguales)
echo '<br>';
$resultado4 = strcasecmp("abc", "ABCd");
echo $resultado4; // Resultado: -1 ("abc" es menor que "ABCd")
?>
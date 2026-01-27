<?php
$texto = "Aprendiendo PHP con ejemplos prácticos";

// Buscar la posición de "PHP"
$posicion = strpos($texto, "PHP");
echo $posicion; // Resultado: 12 (empieza en el carácter 12)
echo '<br>';
// Buscar "ejemplos" a partir de la posición 15
$posicion2 = strpos($texto, "ejemplos", 15);
echo $posicion2; // Resultado: 20
echo '<br>';
// Buscar algo que no existe
$no_existe = strpos($texto, "Python");
var_dump($no_existe); // Resultado: bool(false)
?>
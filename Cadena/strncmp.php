<?php
// Compara sólo los primeros n caracteres
$resultado1 = strncmp("Programar", "Programa", 7);
echo $resultado1; // Resultado: 0 (iguales en los primeros 7 caracteres)
echo '<br>';
$resultado2 = strncmp("Paco", "Paca", 3);
echo $resultado2; // Resultado: 0 (iguales en "Pac")
echo '<br>';
$resultado3 = strncmp("Paco", "Paca", 4);
echo $resultado3; // Resultado: 1 (diferentes - "o" vs "a" en la posición 4)
echo '<br>';
$resultado4 = strncmp("JavaScript", "Java", 4);
echo $resultado4; // Resultado: 0 (iguales en "Java")
?>
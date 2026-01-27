<?php
// Comparación exacta (distingue mayúsculas/minúsculas)
$resultado1 = strcmp("Hola", "Hola");
echo $resultado1; // Resultado: 0 (iguales)
echo '<br>';
$resultado2 = strcmp("Hola", "hola");
echo $resultado2; // Resultado: -1 (diferentes - "H" vs "h")
echo '<br>';
$resultado3 = strcmp("Zapato", "Arbol");
echo $resultado3; // Resultado: 1 ("Z" > "A")
echo '<br>';
$resultado4 = strcmp("abc", "abcd");
echo $resultado4; // Resultado: -1 ("abc" es menor que "abcd")
?>
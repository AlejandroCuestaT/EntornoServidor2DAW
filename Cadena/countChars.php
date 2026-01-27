<?php 
$cad = 'Solo los ingleses usan cinco letras para notar 18 vocales. 
        La mayoría de las lenguas usan tantos letras como vocales distintos.';

//Devuelve un array con el codigo ASCII de los valores que 
//aparecen 1 vez y cuantas veces aparecen        
print_r( count_chars($cad, $mode = 1));    
echo '<br>';
echo '<br>';     

//Devuelve un string de todos los valores que 
// aparecen una vez minimo ordenado por ASCII
print_r( count_chars($cad, $mode = 3));   
echo '<br>';
echo strlen($cad);     
?>
<?php 
$cad = 'Solo los ingleses usan cinco letras para notar 18 vocales. 
        La mayoría de las lenguas usan tantos letras como vocales distintos.';

//Añade - cada 10 caracteres
echo chunk_split($cad, 10, '-');        
?>
<?php 
$cad = 'Solo los ingleses usan cinco letras para notar 18 vocales. 
        La mayoría de las lenguas usan tantos letras como vocales distintos.';

//Rellena hasta la longitud que has puesto con el caracter indicado        
echo str_pad($cad, 150, '_', STR_PAD_BOTH), PHP_EOL;        
?>
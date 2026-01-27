<?php 
$cad = 'aaaa@aaa.com';
//Si da true lo imprime
echo filter_var($cad, FILTER_VALIDATE_EMAIL);
?>
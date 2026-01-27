<?php 
$alumnos = array('alumno1', 'alumno2', 'alumno3', 'alumno4', 'alumno5');

//Conseguimos los 3 primeros alumnos con slice
$alumnos3 = array_slice($alumnos,0,3);
print_r($alumnos3);
echo '<br>';
$alumnos2 = array_slice($alumnos,3,2);
print_r($alumnos2);
echo '<br><br>';

//Eliminamod los primeros 3 alumnos y lo guardamos en una variable
//asi tenemos los 3 primeros en una variable y los otros en otra
$res = array_splice($alumnos,0,3);

print_r($res);
echo '<br>';
print_r($alumnos);
?>

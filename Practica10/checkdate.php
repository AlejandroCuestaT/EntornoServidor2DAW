<?php 
 function esBisiesto($anio){
    if(($anio%4 == 0) && (($anio % 100 != 0) || $anio % 400 == 0)){
        return true;
    }
    return false;
 }

 $anio1 = 2007;
 $anio2 = 2008;

 if(esBisiesto($anio1)){
    echo $anio1.' Si es bisiesto';
 }else{
    echo $anio1.' No es bisiesto';
 }

 echo'<br><br>';

 if(esBisiesto($anio2)){
    echo $anio2.' Si es bisiesto';
 }else{
    echo $anio2.' No es bisiesto';
 }

?>
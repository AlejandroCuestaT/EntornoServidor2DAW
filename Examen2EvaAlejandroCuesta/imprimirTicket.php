<?php

//Crea un string que consta de 3 letras y 1 numero
 function imprimirTicket(){
    $listaLetras = array('A','B','C','D','E','F','G','H','I','J','K');
    $listaNum = array(1,2,3,4,5,6,7,8,9,0);

    $cita = array();
    $valCita = '';

    for($i=0;$i<3;$i++){
    $num = array_rand($listaLetras, 1);

    array_push($cita, $listaLetras[$num]);

    }

    $num = array_rand($listaNum, 1);

    array_push($cita, $listaNum[$num]);


    $valCita .= $cita[0];
    $valCita .= $cita[1];
    $valCita .= $cita[2];
    $valCita .= $cita[3];

    return $valCita;
 }


?>
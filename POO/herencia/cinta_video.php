<?php

class cinta_video extends soporte{
private $duracion;
function __construct($tit,$num,$precio,$duracion){
parent::__construct($tit,$num,$precio);
$this->duracion=$duracion;
}
function imprime_caracteristicas(){
echo "<br> Pelicula en VHS: <br>";
parent::imprime_caracteristicas();
echo "<br>Duracion: ".$this->duracion;
}
}

?>
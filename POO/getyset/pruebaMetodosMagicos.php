<?php

$obj = new Objeto(1, "objeto1", "prueba1@ejemplo.com");
$p = clone $obj;
echo $p->id; //2
$p->nombre = "nombre cambiado";
echo $p->nombre; //nombre cambiado
Echo $obj->nombre;

?>
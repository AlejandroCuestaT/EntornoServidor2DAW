<?php

spl_autoload_register(function ($clase) {
    $fullpath = strtolower($clase) . ".php";

    if (file_exists($fullpath)) {
        require_once($fullpath);
    }
});

$obj = new Objeto(1, "objeto1", "prueba1@ejemplo.com");
$p = clone $obj;
echo $p->id; //2
echo "<br>";
$p->nombre = "nombre cambiado";
echo $p->nombre; //nombre cambiado
echo "<br>";
echo $obj->nombre;

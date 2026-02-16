<?php

class Cabecera {
    public $cabecera;

    public function __construct($texto)
    {
        $this->cabecera = $texto;
    }

    public function mostrar() {
        echo "<h1>" . $this->cabecera . "</h1>";
    }

}

?>
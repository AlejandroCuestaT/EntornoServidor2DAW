<?php

class Soporte {
    private $tit;
    private $num;
    private $precio;

    public function __construct($tit,$num,$precio)
    {
        $this->tit = $tit;
        $this->num = $num;
        $this->precio = $precio;
    }

    public function imprime_caracteristicas(){
        echo "<br>Titulo: ".$this->tit;
        echo "<br>Numero: ".$this->num;
        echo "<br>Precio: ".$this->precio;
    }

}

?>
<?php

class Cuerpo {
    public $cuerpo;

    public function __construct()
    {
        
    }

    public function insertarParrafo($texto) {
        $this->cuerpo = $texto;
        
        echo "<h1>" . $this->cuerpo . "</h1>";
    }

}

?>
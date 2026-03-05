<?php

require_once 'Documento.php';

class Libro extends Documento{

    //Tiene que ser protegido porque si no no puedo usar este atributo con
    //los getters y setters del padre
    protected $anioPublicacion;
    
    public function __construct($codigo = null, $titulo = null, $anioPublicacion = 0) {
        parent::__construct($codigo,$titulo);
        $this->anioPublicacion = $anioPublicacion;
    }

    public function __toString() {
        return parent::__toString() . " - " . $this->anioPublicacion;
    }
}
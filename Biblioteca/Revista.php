<?php

require_once('Documento.php');

class Revista extends Documento {
    public function __construct($codigo = null, $titulo = null) {
        parent::__construct($codigo,$titulo);
    }


    public function plazoPrestamo(){
        return parent::plazoPrestamo() / 3;
    }
}
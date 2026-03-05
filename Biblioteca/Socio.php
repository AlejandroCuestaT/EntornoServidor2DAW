<?php

require_once 'Usuario.php';

class Socio extends Usuario{
    protected const MAX_PRESTAMOS_SOCIOS = 20;
    protected const LIMITE_PRESTAMOS_SOCIOS = 30;


    public function __construct($dni = null, $nombre = null) {
        //Se usa self con las constantes que no se pueden variar de ninguna manera
        parent::__construct($dni,$nombre,self::MAX_PRESTAMOS_SOCIOS,self::LIMITE_PRESTAMOS_SOCIOS);
    }

    public function __toString() {
        return parent::__toString() . " | Socio";
    }

}
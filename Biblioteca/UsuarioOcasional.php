<?php

require_once 'Usuario.php';

class UsuarioOcasional extends Usuario{
    protected const MAX_PRESTAMOS_USUARIOS = 2;
    protected const LIMITE_PRESTAMOS_USUARIOS = 15;

    public function __construct($dni = null, $nombre = null) {
        //Se usa self con las constantes que no se pueden variar de ninguna manera
        parent::__construct($dni,$nombre,self::MAX_PRESTAMOS_USUARIOS,self::LIMITE_PRESTAMOS_USUARIOS);
    }


    public function __toString() {
        return parent::__toString() . " | Usuario";
    }


}
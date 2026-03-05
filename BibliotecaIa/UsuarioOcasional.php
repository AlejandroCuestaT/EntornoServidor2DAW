<?php
// UsuarioOcasional.php
class UsuarioOcasional extends Usuario {
    private const MAX_PRESTAMOS_A_USUARIOS_O = 2;
    private const LIMITE_PRESTAMOS_A_USUARIOS_O = 15;

    public function __construct($dni = null, $nom = null) {
        parent::__construct($dni, $nom, self::MAX_PRESTAMOS_A_USUARIOS_O, self::LIMITE_PRESTAMOS_A_USUARIOS_O);
    }

    public function __toString() {
        return parent::__toString() . " Usuario Ocasional";
    }
}
?>
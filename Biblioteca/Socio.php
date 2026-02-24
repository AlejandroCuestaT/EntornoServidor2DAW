<?php
// Socio.php
class Socio extends Usuario {
    private const MAX_PRESTAMOS_A_SOCIOS = 20;
    private const LIMITE_PRESTAMOS_A_SOCIOS = 30;

    public function __construct($dni = null, $nom = null) {
        parent::__construct($dni, $nom, self::MAX_PRESTAMOS_A_SOCIOS, self::LIMITE_PRESTAMOS_A_SOCIOS);
    }

    public function __toString() {
        return parent::__toString() . " Socio";
    }
}
?>
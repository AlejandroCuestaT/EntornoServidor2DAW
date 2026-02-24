<?php
class Revista extends Documento {
    public function __construct($cod = null, $til = null) {
        parent::__construct($cod, $til);
    }

    public function plazoPrestamo() {
        return (int)(parent::plazoPrestamo() / 3);
    }
}
?>
<?php
class Documento {
    protected $codigo;
    protected $titulo;
    protected $prestadoA;

    public function __construct($cod = null, $til = null) {
        $this->codigo = $cod;
        $this->titulo = $til;
        $this->prestadoA = null;
    }

    public function estaPrestado() {
        return $this->prestadoA !== null;
    }

    public function prestaAUsuario($user) {
        if ($this->prestadoA !== null) {
            echo "Prestado a " . $this->prestadoA->getNombre() . PHP_EOL;
        } else {
            $this->prestadoA = $user;
            $user->añadeDocumentoPrestado($this);
        }
    }

    public function devuelve() {
        if ($this->prestadoA !== null) {
            $this->prestadoA->eliminaDocumentoPrestado($this->codigo);
            $this->prestadoA = null;
        }
    }

    public function plazoPrestamo() {
        if ($this->prestadoA !== null) {
            return $this->prestadoA->plazoPrestamoDocumento();
        }
        return -1;
    }

    public function getCodigo() { return $this->codigo; }
    public function setCodigo($codigo) { $this->codigo = $codigo; }
    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }
    public function getPrestadoA() { return $this->prestadoA; }
    public function setPrestadoA($prestadoA) { $this->prestadoA = $prestadoA; }

    public function __toString() {
        $nombrePrestado = $this->prestadoA ? $this->prestadoA->getNombre() : "Nadie";
        return "Código: " . $this->codigo . " Título: " . $this->titulo . " Prestado a: " . $nombrePrestado . "\n";
    }
}
?>
<?php
class Usuario {
    protected $DNI;
    protected $nombre;
    protected $prestamos;
    protected $maxPrestamos;
    protected $limitePrestamos;

    public function __construct($dni = null, $nom = null, $maxP = 0, $lP = 0) {
        $this->DNI = $dni;
        $this->nombre = $nom;
        $this->prestamos = []; // Array dinámico
        $this->maxPrestamos = $maxP;
        $this->limitePrestamos = $lP;
    }

    public function alcanzadoLimitePrestamos() {
        return count($this->prestamos) >= $this->maxPrestamos;
    }

    public function añadeDocumentoPrestado($doc) {
        if (!$this->alcanzadoLimitePrestamos()) {
            if (!$doc->estaPrestado()) {
                $this->prestamos[] = $doc; // Añade al final del array
            }
        }
    }

    public function eliminaDocumentoPrestado($codigo) {
        $pos = $this->buscaDocumentoPrestado($codigo);
        if ($pos !== -1) {
            array_splice($this->prestamos, $pos, 1); // Elimina y reindexa el array
        } else {
            echo "El documento con código " . $codigo . " no está prestado\n";
        }
    }

    public function buscaDocumentoPrestado($codigo) {
        foreach ($this->prestamos as $index => $doc) {
            if ($doc->getCodigo() === $codigo) {
                return $index;
            }
        }
        return -1;
    }

    public function getDNI() { return $this->DNI; }
    public function setDNI($DNI) { $this->DNI = $DNI; }
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function getMaxPrestamos() { return $this->maxPrestamos; }
    public function setMaxPrestamos($maxPrestamos) { $this->maxPrestamos = $maxPrestamos; }
    public function plazoPrestamoDocumento() { return $this->limitePrestamos; }
    public function setLimitePrestamos($limitePrestamos) { $this->limitePrestamos = $limitePrestamos; }

    public function __toString() {
        return "DNI: " . $this->DNI . " Nombre: " . $this->nombre . " Préstamos: " . count($this->prestamos);
    }
}
?>
<?php

class Usuario{
    protected $dni;
    protected $nombre;
    protected $prestamos; //Array de Documentos
    protected $maxPrestamos;
    protected $limitePrestamos;
    protected $numPrestamos;

    public function __construct($dni = null, $nombre = null, $maxPrestamos = 0, $limitePrestamos = 1){
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->maxPrestamos = $maxPrestamos;
        $this->limitePrestamos = $limitePrestamos;
        $this->numPrestamos = 0;
        $this->prestamos = array();
    }

    //Funciones

    //Si numero de prestamos es mayor o igual a el maximo de prestamos devuelve true
    public function alcanzadoLimiteDePrestamos(){
        if($this->numPrestamos >= $this->maxPrestamos){
            return true;
        }
        return false;
    }

    //Aniade documento si no alcanza el limite
    public function aniadeDocumentoPrestado($doc){
        if (!$this->alcanzadoLimiteDePrestamos()) {
            if (!$doc->estaPrestado()) {
                $this->prestamos[$this->numPrestamos] = $doc;
                $this->numPrestamos++;
            }
        }
    }

    //Elimina el documento prestado y le quira una el numero de prestamos
    public function eliminaDocumentoPrestado($codigo) {
        $pos = $this->buscaDocumentoPrestado($codigo);
        if ($pos !== -1) {
        array_splice($this->prestamos, $pos, 1);

        $this->numPrestamos--;
        } else {
            echo "El documento con código " . $codigo . " no está prestado por este usuario.<br>";
        }
    }

    //
    public function buscaDocumentoPrestado($codigo) {
    foreach ($this->prestamos as $i => $doc) {
        if ($doc->codigo === $codigo) {
            return $i;
        }
    }
        return -1;
    }

    //Retorna el limite del Prestamo
    public function plazoPrestamoDocumento() {
        return $this->limitePrestamos;
    }

    //Getters y Setters magicos
    public function __get($atr) {
        if (property_exists($this, $atr)) {
            return $this->$atr;
        }
    }

    public function __set($atr, $val) {
        if (property_exists($this, $atr)) {
            $this->$atr = $val;
        }
    }

    //toString magico
    public function __toString() {
    return "Nombre: " . $this->nombre . 
           " | DNI: " . $this->dni . 
           " | Prestamos Maximos: " . $this->maxPrestamos . 
           " | Limite de prestamos: " . $this->limitePrestamos . 
           " | Prestamos actuales: " . $this->numPrestamos;
}
    
}
<?php

class Documento {
    protected $codigo;
    protected $titulo;
    protected $prestadoA; //Objeto usuario

    //Pongo el = null para que pueda no pasarme parametros, solo codigo
    //o codigo y titulo
    public function __construct($codigo = null, $titulo = null) {
        $this->codigo = $codigo;
        $this->titulo = $titulo;
        $this->prestadoA = null;
    }

    //Funciones

    //Si prestadoA no esta nulo, devuelve true
    public function estaPrestado(){
        if($this -> prestadoA!=null){
            return true;
        }
        return false;
    }

    //Si esta ya prestado avisa y si no recoge el objeto usuario
    public function prestaAUsuario($user) {
        if ($this->prestadoA !== null) {
            echo "Documento prestado a: " . $this->prestadoA->nombre . "<br>";
        } else {
            $this->prestadoA = $user;
            
            $user->aniadeDocumentoPrestado($this);
        }
    }

    //Elimina el usuario de prestadoA
    public function devuelve(){
        $this->prestadoA->eliminaDocumentoPrestado($this->codigo);
        $this->prestadoA = null;
    }

    //Manda a la funcion plazoPrestamoDocumento
    public function plazoPrestamo(){
        if ($this->prestadoA !== null) {
            return $this->prestadoA->plazoPrestamoDocumento();
        }
        return -1;
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

    //Metodo magico, se llama haciendo echo del objeto que quieras
    public function __toString() {
        return "Documento: " . $this->codigo . " - " . $this->titulo;
    }

}
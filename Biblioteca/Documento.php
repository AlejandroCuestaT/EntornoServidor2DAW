<?php

class Documento {
    private $codigo;
    private $titulo;
    private $prestadoA;

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

    $documento = new Documento("1", "Doc1"); 
      
    //Llamada a metodo magico toString
    echo $documento;
    echo '<br><br>';

    //Llamada a metodo magico get
    echo $documento->codigo;
    echo '<br><br>';

    //Llamada a metodo magico set
    $documento->titulo="Pinta y colorea";

    //Miramos que el setter ha cambiado el titulo
    echo $documento;

    $documento2 = new Documento(); 
    echo $documento2;
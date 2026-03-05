<?php

class Usuario{
    private $dni;
    private $nombre;
    private $prestamos;
    private $maxPrestamos;
    private $limitePrestamos;
    private $numPrestamos;

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

$usuario = new Usuario("12345678Z", "Pepe Perez", 5, 10);

echo $usuario;
echo '<br><br>';
echo "El DNI del usuario es: " . $usuario->dni;
echo '<br><br>';
$usuario->nombre = "Jose Perez";
echo "Usuario tras el cambio: " . $usuario;
echo '<br><br>';
$usuario2 = new Usuario(); 
echo $usuario2;
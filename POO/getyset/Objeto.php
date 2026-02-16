<?php

class Objeto
{
    private $id;
    private $nombre;
    private $email;
    function __construct($id, $nombre, $email)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
    }
    function __clone()
    {
        $this->id = ++$this->id;
    }
    public function __toString()
    {
        return $this->id . "  " . $this->nombre . "  " . $this->email;
    }
    public function __set($var, $valor)
    {
        if (property_exists(__CLASS__, $var)) {
            $this->$var = $valor;
        } else {
            echo "No existe el atributo $var.";
        }
    }
    public function __get($var)
    {
        if (property_exists(__CLASS__, $var)) {
            return $this->$var;
        }
        return null;
    }
}

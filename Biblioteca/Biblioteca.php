<?php

class Biblioteca{

    private $usuarios; //Array usuarios
    private $documentos; //Array documentos
    private const MAX_USUARIOS = 50;
    private $numUsuarios;
    private const MAX_DOCUMENTOS = 200;
    private $numDocumentos;

    public function __construct() {
        
    $this->usuarios = array();
    $this->documentos = array();
    $this->numUsuarios = 0;
    $this->numDocumentos = 0;

    }

    //Funciones

    public function aniadeDocumento($documento){
    if($documento != null){
        if ($this->numDocumentos < self::MAX_DOCUMENTOS) {
            $this->documentos[] = $documento;
            $this->numDocumentos++;
        } else {
            echo "Error: Se ha alcanzado el límite máximo de documentos (" . self::MAX_DOCUMENTOS . ").<br>";
        }
    }
}

    public function aniadeUsuario($usuario){
    if($usuario != null){
        if ($this->numUsuarios < self::MAX_USUARIOS) {
            $this->usuarios[] = $usuario;
            $this->numUsuarios++;
        } else {
            echo "Error: No se pueden registrar más usuarios (Límite: " . self::MAX_USUARIOS . ").<br>";
        }
    }
}

    //Busca el documento y lo devuelve
    public function buscaDocumento($codigo) {
    foreach ($this->documentos as $doc) {
        if ($doc->codigo === $codigo) {
            return $doc;
        }
    }
    return null;
}

    //Devuelve true si el dni existe en algun usuario
    public function buscaUsuario($dni) {
        foreach ($this->usuarios as $usu) {
            if ($usu->dni === $dni) {
                return true;
            }
        }
        return false;
    }

    //Llama a prestaAUsuario
    public function prestaDocumento($doc, $user) {
    if ($this->buscaUsuario($user->dni)) {
        
        if ($this->buscaDocumento($doc->codigo) !== null) {
            
            $doc->prestaAUsuario($user);
            
        }
    }
}

    //Llama a la funcion devolver si esta prestado
    public function devuelveDocumento($doc) {
        if ($doc->estaPrestado()) {
            $doc->devuelve();
        } else {
            echo "Este documento no esta prestado <br>";
        }
    }

    //Busca un documento por el titulo y si existe lo devuelve
    public function buscaDocumentos($texto) {
        foreach ($this->documentos as $doc) {
            if (str_contains($doc->titulo, $texto)) {
                return $doc;
            }
        }
        return null;
    }

    public function muestraInformePrestamos() {
    echo "<h2>Informe prestamos</h2>";
    
        foreach ($this->documentos as $doc) {
            if ($doc->estaPrestado()) {
                echo $doc . "<br>";
            }
        }
    }
}
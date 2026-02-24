<?php
class Biblioteca {
    private $usuarios;
    private $documentos;
    private const MAX_USUARIOS = 50;
    private const MAX_DOCUS = 200;

    public function __construct() {
        $this->usuarios = [];
        $this->documentos = [];
    }

    public function aniadeDocumento($doc) {
        if ($doc !== null && count($this->documentos) < self::MAX_DOCUS) {
            $this->documentos[] = $doc;
        }
    }

    public function aniadeUsuario($user) {
        if ($user !== null && count($this->usuarios) < self::MAX_USUARIOS) {
            $this->usuarios[] = $user;
        }
    }

    public function buscaDocumento($codigo) {
        foreach ($this->documentos as $doc) {
            if ($doc->getCodigo() === $codigo) {
                return $doc;
            }
        }
        return null;
    }

    public function buscaUsuario($dni) {
        foreach ($this->usuarios as $user) {
            if ($user->getDNI() === $dni) {
                return true;
            }
        }
        return false;
    }

    public function prestaDocumento($doc, $user) {
        if ($this->buscaUsuario($user->getDNI())) {
            $documento = $this->buscaDocumento($doc->getCodigo());
            if ($documento !== null) {
                $documento->prestaAUsuario($user);
            }
        }
    }

    public function devuelveDocumento($doc) {
        if ($doc->estaPrestado()) {
            $doc->devuelve();
        } else {
            echo "Documento con código: " . $doc->getCodigo() . " no estaba prestado\n";
        }
    }

    public function buscaDocumentos($texto) {
        foreach ($this->documentos as $doc) {
            // Equivalente a indexOf(...) != -1
            if (strpos($doc->getTitulo(), $texto) !== false) {
                return $doc;
            }
        }
        return null;
    }

    public function muestraInformePrestamos() {
        foreach ($this->documentos as $doc) {
            if ($doc->estaPrestado()) {
                echo $doc . "\n";
            }
        }
    }
}
?>
<?php

spl_autoload_register(function ($clase) {
    $fullpath = "model/".strtolower($clase).".php";

    if(file_exists($fullpath)){
        require_once($fullpath);
    }
});
    class Pagina {
        private $cabecera;
        private $cuerpo;
        private $pie;
        public function __construct($texto1,$texto2){
            $this->cabecera=new Cabecera($texto1);
            $this->cuerpo=new Cuerpo();
            $this->pie=new Pie($texto2);
        }

        private $obj1 = new Pie("obj1");
        private $obj2 = clone($obj1);

        public function insertarCuerpo($texto){
            $this->cuerpo->insertarParrafo($texto);
        }
        
    }



?>

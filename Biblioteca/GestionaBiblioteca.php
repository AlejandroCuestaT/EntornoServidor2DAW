<?php

require_once 'Usuario.php';
require_once 'Socio.php';
require_once 'UsuarioOcasional.php';
require_once 'Documento.php';
require_once 'Libro.php';
require_once 'Revista.php';
require_once 'Biblioteca.php';

$atenea = new Biblioteca();

$l1 = new Libro("001", "Leyendas", 1850);
$atenea->aniadeDocumento($l1);

$l2 = new Libro("002", "El Quijote", 1590);
$atenea->aniadeDocumento($l2);

$r1 = new Revista("003", "National Geography");
$atenea->aniadeDocumento($r1);

$juan = new Socio("123456", "Juan");
$atenea->aniadeUsuario($juan);
$atenea->aniadeUsuario(new UsuarioOcasional("76434555", "Pedro"));

$atenea->devuelveDocumento($l1);
$atenea->prestaDocumento($l1, $juan);
$atenea->prestaDocumento($r1, $juan);

$atenea->muestraInformePrestamos();
?>
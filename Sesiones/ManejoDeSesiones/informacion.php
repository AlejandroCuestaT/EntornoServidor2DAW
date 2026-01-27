<?php 
session_start();
function borrarSesion(){
$_SESSION=array();
Setcookie(session_name(),"",time()-3600);
Session_destroy();
}

if(isset($_GET['borrar'])) {
    borrarSesion();
    header('Location: acreditacion.php');
}

echo '<h1><a href="?borrar=true">Borrar sesión</a></h1>';
echo '<h1><a href="acreditacion.php"> Sin Borrar sesion </a></h1>';


?>
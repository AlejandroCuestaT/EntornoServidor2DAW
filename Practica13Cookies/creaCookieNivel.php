<?php
$nombre = $_POST['nombre'];
$contenido = $_POST['contenido'];
$nivel = $_POST['nivel'];
$path = '/ejercicios/Practica13Cookies/';

switch($nivel){
    case 'nivel0':
        break;
    case 'nivel1':
        $path = '/ejercicios/Practica13Cookies/Nivel1/';
        break;
    case 'nivel2':
        $path = '/ejercicios/Practica13Cookies/Nivel1/Nivel2/';
        break;
    case 'nivel3':
        $path = '/ejercicios/Practica13Cookies/Nivel1/Nivel2/Nivel3/';
        break;    
    default:
        echo 'Fatal error';  
        break;          
}

    setcookie($nombre, $contenido, 0, $path);
    


header("Location: index.html");
?>
<?php

//En el inicio del formulario que quiero proteger
if(!isset($_SESSION['token'])){
        $_SESSION['token'] = uniqid();
    } 

    $token = $_SESSION['token'];

    //Ultima linea del formulario
    <input type="hidden" name="token" value="<?php echo $token; ?>">


    //En la validacion del formulario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
            die("Error de seguridad: Token no válido.");
        }

    }

?>
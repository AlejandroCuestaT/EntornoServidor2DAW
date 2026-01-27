<?php
session_start();

//Te redirige si ya hay un usuario y una contraseña
if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
    header('Location: informacion.php');
}

$user = "";
$password = "";

$errores = array(
    'vfUser' => false,
    'vfPassword' => false
);

//------------------- VALIDACIONES ----------------------

if(isset($_POST['user'])){
    $user = $_POST['user'];
    //Trim para que quite espacios
    if(!empty(trim($user))){ //Verifico usuario
        $errores['vfUser'] = true;
        echo "Usuario correcto";
    }
}

if(isset($_POST['password'])){
    $pass = $_POST['password'];
    $pass_length = strlen($pass);
    if($pass_length >= 5 && $pass_length <= 12){ //Verifico password
        $errores['vfPassword'] = true;
        echo "Password correcta";
    }
}



if (isset($_POST['aceptar'])) {
    if(in_array(false, $errores)){ //Hay algun dato mal introducido
        echo 'Algun dato mal introducido';
    }else{ //Si todos los datos estan bien introducidos
        $_SESSION['user'] = $user;
        $_SESSION['password'] = $password;
        header('Location: informacion.php');
    }
} else {

    echo '<h1> Inicio de sesion </h1>';
    echo '<br><br>';
    echo "<form action='acreditacion.php' method='post' enctype='multipart/form-data'>";
    echo 'Usuario : <input type="text" name="user" value=' . $user . '>';
    echo '<br>';
    echo 'Password : <input type="password" name="password" value=' . $password . '>';
    echo '<br>';
    echo '<input type="submit" name="aceptar" value="aceptar">';
    echo '</form>';
}


?>
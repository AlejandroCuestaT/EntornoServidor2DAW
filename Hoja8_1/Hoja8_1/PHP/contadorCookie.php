<?php
if(isset($_COOKIE['contador'])){
    $nombre = 'contador';
    $valor = ($_COOKIE['contador'] + 1);
    $fecha_expiracion = time()+60*60*24*365; //1 anio de expiracion
    $path = 'localhost/ejercicios/Hoja8_1';

    setcookie($nombre,$valor,$fecha_expiracion,$path);
    echo $_COOKIE['contador'];
    echo '<br>';
    print_r($_COOKIE);
}else{
    $nombre = 'contador';
    $valor = 0;
    $fecha_expiracion = time()+60*60*24*365; //1 anio de expiracion
    $path = 'localhost/ejercicios/Hoja8_1';

    setcookie($nombre,$valor,$fecha_expiracion,$path);
}
?>
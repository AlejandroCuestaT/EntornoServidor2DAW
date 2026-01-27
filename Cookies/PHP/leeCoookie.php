<?php
if(isset($_COOKIE['cookie2'])){
    echo $_COOKIE['cookie2'];
}else{
    echo 'No hay cookie2, ya ha expirado';
}

echo '<br><br>';
foreach($_COOKIE as $nombre => $valor){

    echo '<br>'.$nombre.': '.$valor;
}

echo '<br><br>';
print_r($_SERVER['HTTP_COOKIE']);

?>
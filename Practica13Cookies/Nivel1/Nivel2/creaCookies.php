<?php
$nombre = 'CookieNivel2';
$valor = 'Cookie nivel 2 autogenerada';

setcookie($nombre,$valor);

header("Location: ../../index.html");
?>
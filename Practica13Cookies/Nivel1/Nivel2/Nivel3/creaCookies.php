<?php
$nombre = 'CookieNivel3';
$valor = 'Cookie nivel 3 autogenerada';

setcookie($nombre,$valor);

header("Location: ../../../index.html");
?>
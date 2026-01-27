<?php
$nombre = 'CookieNivel1';
$valor = 'Cookie nivel 1 autogenerada';

setcookie($nombre,$valor);

header("Location: ../index.html");
?>
<?php
session_start();
// Comprobamos si la cookie existe para evitar errores
if (isset($_COOKIE['miCookie'])) {
    echo "El valor de la cookie es: " . $_COOKIE['miCookie'];
} else {
    echo "La cookie no existe o ha expirado.";
}
?>
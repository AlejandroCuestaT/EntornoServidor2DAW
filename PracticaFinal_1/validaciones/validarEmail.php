<?php
function validarEmail($email)
{
    $reg = "#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})$#i";
    return preg_match($reg, $email);
}
//ejemplo:
/*

if (validarEmail("info@educacionit.com")) {
    echo "email valido";
} else {
    echo "email invalido";
}

*/


?>
<?php
function validarFortalezaPassword($password) {
  return preg_match("/^.*(?=.{6,})(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$/", $password);
}
//ejemplo:
//La contraseña necesita:
//Ser de minimo 6 caracteres
//Tener minimo una mayuscula
//Tener un numero
if(validarFortalezaPassword("Alexxxx")){
    echo "<p style='color: green;'>Password fuerte</p>";
} else {
    echo "<p style='color: red;'>Password débil</p>";
}

?>
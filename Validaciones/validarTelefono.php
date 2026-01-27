<?php
function validarTelefono($numero){
  $reg = "#^\(?\d{2}\)?[\s\.-]?\d{4}[\s\.-]?\d{4}$#";
  return preg_match($reg, $numero);
}
//ejemplo:
if(validarTelefono("(11)-4328-0457")){
  echo "telefono valido";
} else {
  echo "telefono invalido";
}

?>
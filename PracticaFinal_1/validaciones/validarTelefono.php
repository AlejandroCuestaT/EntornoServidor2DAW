<?php
function validarTelefono($numero){
  // La expresión #^[0-9]{9}$# significa:
  // ^      -> empezar aquí
  // [0-9]  -> cualquier número del 0 al 9
  // {9}    -> exactamente 9 veces
  // $      -> terminar aquí
  $reg = "#^[0-9]{9}$#";
  return preg_match($reg, $numero);
}

/* // Ejemplo de uso:
if(validarTelefono("600123456")){
  echo "teléfono válido";
} else {
  echo "teléfono inválido";
}
*/
?>
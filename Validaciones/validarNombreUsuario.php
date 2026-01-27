<?php
function validarUsuario($nombre) {
  return preg_match("#^[a-z][\da-z_]{6,22}[a-z\d]\$#i", $nombre);
}
//ejemplo:
if(validarUsuario("EducacionIT")){
  echo "usuario valido";
} else {
  echo "usuario invalido";

}

?>
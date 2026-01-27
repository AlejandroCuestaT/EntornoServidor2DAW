<?php
function validarFecha($fecha){
  $sep = "[\/\-\.]";
  $req = "#^(((0?[1-9]|1\d|2[0-8]){$sep}(0?[1-9]|1[012])|(29|30){$sep}(0?[13456789]|1[012])|31{$sep}(0?[13578]|1[02])){$sep}(19|[2-9]\d)\d{2}|29{$sep}0?2{$sep}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";
  return preg_match($req, $fecha);
}
//ejemplo:
if(validarFecha("05/01/2011")){
  echo "fecha valida";
} else {
  echo "fecha invalida";
}

?>
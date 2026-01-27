<?php
function validarIP($ip){
  $val_0_to_255 = "(25[012345]|2[01234]\d|[01]?\d\d?)";
  $reg = "#^($val_0_to_255\.$val_0_to_255\.$val_0_to_255\.$val_0_to_255)$#";
  return preg_match($reg, $ip, $matches);
}
//ejemplo:
if(validarIP("190.210.132.55")){
  echo "IP valida";
} else {
  echo "IP invalida";
}

?>
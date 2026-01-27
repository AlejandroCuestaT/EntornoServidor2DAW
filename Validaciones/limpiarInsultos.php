<?php
function limpiarInsultos($string){
  function prep_regexp_array(&$item){
    $item = "#$item#i";
  }
  function stars($matches){
    return substr($matches[0], 0, 1).str_repeat("*", strlen($matches[0])-1);
  }
  $swears = array("tonto", "idiota"); //palabras a bloquear
  array_walk($swears, "prep_regexp_array");
  return preg_replace_callback($swears, "stars", $string);
}
//ejemplo:
echo limpiarInsultos("Juan es un idiota");
?>
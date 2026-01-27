<?php
function convertirURL($url){
  $host = "([a-z\d][-a-z\d]*[a-z\d]\.)+[a-z][-a-z\d]*[a-z]";
  $port = "(:\d{1,})?";
  $path = "(\/[^?<>\#\"\s]+)?";
  $query = "(\?[^<>\#\"\s]+)?";
  $reg = "#((ht|f)tps?:\/\/{$host}{$port}{$path}{$query})#i";
  return preg_replace($reg, "<a href='$1'>$1</a>", $url);
}
//ejemplo:
echo convertirURL("visita https://www.educacionit.com");
?>
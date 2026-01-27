<?php 
//Asi no detecta el cambio de linea
echo "foo isn't\n bar";
echo '<br>';
//cCon esto conseguimos que el navegador SI lea el \n para cambiar de linea
echo nl2br("foo isn't\n bar");
?>
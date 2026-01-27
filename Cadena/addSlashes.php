<?php
$cad = "O'Reilly";
//Añade \ a los simbolos que nos pueden llegar a molestar como ' " /
echo addslashes($cad);
echo '<br><br>';

//Vuelve a quitar los \ para recuperar la informacion inicial
echo stripslashes($cad);
?>
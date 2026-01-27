<?php
session_start();
if(isset($_SESSION['contador'])){
$_SESSION['contador']++;
}else{
$_SESSION['contador'] = 1;

}
?>
<html>
<a href="contador2.php">Página que muestra el contador</a>
</html>
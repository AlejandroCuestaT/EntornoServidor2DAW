<?php
session_start();
Unset($_SESSION['contador']);
// $_SESSION=array(); para borrar todas las vars de sesión
Setcookie(session_name(),"",time()-3600);
Session_destroy();
?>
<html>
<body>
Sesión terminada
</body>
</html>

<?php
 if(isset($_COOKIE['userPassword'])){ //Si existe la cookie userPassword

    $userPassword = explode(' ',$_COOKIE['userPassword']);
    $user = $userPassword[0];
    $password = $userPassword[1];
        echo "<h1>Bienvenido: ".$user."</h1>";
        echo "<br><br><br>";
        echo "<form action='inicioSesionCookie.php' method='post' enctype='multipart/form-data'>";
        echo "Usuario: <input type='text' name='usuario' value='".$user."'>";
        echo "<br><br>";
        echo "Clave: <input type='password' name='password' value='".$password."'>";
        echo "<br><br>";
        echo "<input type='submit' name='cerrarSesion' value='Cerrar Sesion'>";
        echo "<input type='submit' name='aceptar' value='aceptar'>";
        echo "</form>";
    if(isset($_POST['cerrarSesion'])){
        
        cerrarSesion();
    }

    if(isset($_POST['aceptar'])){ //Si dan al boton enviar creo la cookie y redireciono
        
        crearCookie($_POST['usuario'], $_POST['password']);
    
        
    }
 }else{ //Si no existe la cookie userPassword
    if(isset($_POST['aceptar'])){ //Si dan al boton enviar creo la cookie y redireciono
        
        crearCookie($_POST['usuario'], $_POST['password']);
    
        
    }else{ //Si no han dado al boton enviar
        echo "<form action='inicioSesionCookie.php' method='post' enctype='multipart/form-data'>";
        echo "Usuario: <input type='text' name='usuario'>";
        echo "<br><br>";
        echo "Clave: <input type='password' name='password'>";
        echo "<br><br>";
        echo "<input type='submit' name='aceptar' value='aceptar'>";
        echo "</form>";
    }
 }

 function crearCookie($user, $password){
    $userPassword = $user. ' '.$password;
    $nombre = 'userPassword';
    $valor = $userPassword;
    $fecha_expiracion = time()+60*60*24*365; //1 anio de expiracion
    $path = 'localhost/ejercicios/Hoja8_1';

    setcookie($nombre,$valor,$fecha_expiracion,$path);

    header("Location: inicioSesionCookie.php");
 }

 function cerrarSesion(){
    $nombre = 'userPassword';
    $valor = '';
    $fecha_expiracion = time() - 3600;
    $path = 'localhost/ejercicios/Hoja8_1';

    setcookie($nombre,$valor,$fecha_expiracion,$path);

    header("Location: inicioSesionCookie.php");
 }
?>
<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'funcionesE.php';

    if(!isset($_SESSION['token'])){
        $_SESSION['token'] = uniqid();
    } 
    
    $token = $_SESSION['token'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){                
        if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
            die("Error de seguridad: Token no válido.");
        }

        //Recuperamos los parametros del formulario
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        $conn = conectar('cursoscp','victor','1234');

        if(login($usuario, $password, $conn)){
            header('Location: inicio.php');
            exit();
        }

            
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosLogin.css">
    <title>Login</title>
</head>
<body>
    <div id="formulario">
        <form action="login.php" method="POST">          
            <input type="hidden" name="token" value="<?php echo $token; ?>">                     
            <h3>Login</h3>
            <div class="form-group"> 
                <label>Nombre de usuario</label>
                <input type="text" name="usuario" class="input" required>
            </div>
            <div class="form-group"> 
                <label>Contraseña</label>
                <input type="password" name="contraseña" class="input" required>
            </div>       
            <input type="submit" value="Login" class="input">
        </form>
        <?php
            if(isset($errores['login'])){
                echo "<h4>" . htmlspecialchars($errores['login']) . "</h4>";
            }
        ?>
    </div>
</body>
</html>
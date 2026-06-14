<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include 'conectar.php';
    include 'funciones.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){                
        $email = $_POST['email'];
        $pass = $_POST['contraseña'];

        if(login($email, $pass)){
            header('Location: gestionaProyectos.php');
            exit();
        }else{
            header('Location: login.php');
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
            <h3>Login</h3>
            <div class="form-group"> 
                <label>Email</label>
                <input type="email" name="email" class="input" required>
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
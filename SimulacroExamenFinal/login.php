<?php
    session_start();

    if(!isset($_SESSION['token'])){
        $_SESSION['token'] = uniqid();
    } 

    $token = $_SESSION['token'];
?>

<html>

<head>
    <link rel="stylesheet" href="css/loginStyle.css">
</head>

<div id="formulario">
        <form action="validarLogin.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <h3>Login</h3>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<p style="color: red; font-weight: bold;">' . $_SESSION['error'] . '</p>';
                
                unset($_SESSION['error']); 
            }
        ?>
            <div class="form-group"> 
                <label for="">Nombre de usuario</label>
                <input type="text" name="user" class="input">
            </div>

            <div class="form-group"> 
                <label for="">Contraseña</label>
                <input type="password" name="password" class="input">
            </div>
            <button type="submit" name="login" id="submit">Iniciar Sesión</button>
        </form>
        
    </div>

</html>





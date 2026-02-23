<?php
    session_start();
?>

<html>

<head>
    <link rel="stylesheet" href="css/loginStyle.css">
</head>

<div id="formulario">
        <form action="validarLogin.php" method="post">
            <h3>Login Medico</h3>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<p style="color: red; font-weight: bold;">' . $_SESSION['error'] . '</p>';
                
                unset($_SESSION['error']); 
            }
        ?>
            <div class="form-group"> 
                <label for="">Nombre de usuario</label>
                <input type="text" name="user" class="input" placeholder="admin">
            </div>

            <div class="form-group"> 
                <label for="">Contraseña</label>
                <input type="password" name="password" class="input" placeholder="admin123">
            </div>
            <button type="submit" name="login" id="submit">Iniciar Sesión</button>
            <button id="submit"><a href='index.php'>Inicio</button>

        </form>
        
    </div>

</html>





<?php
    include 'funciones.php';
    session_start();

    if(!isset($_SESSION['email'])){
        header('Location: gestionaProyectos.php');
    }
    
    $email = $_SESSION['email'];
    $proyectosEmpleado = recogeProyectosEmpleado($email);
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="gastos.php" method="post">
        <?php
            foreach($proyectosEmpleado as $p){
                $nombreProyecto = recogeProyectosNombre($p['id_proyecto']);
                echo ' ' . $nombreProyecto['nombre'] . '<br>Importe <input type="text" name="importe" id="importe"><br>
                    Descripcion <input type="text" name="descripcion" id="descripcion"><br>
                    Categoria <select name="categoria" id="categoria">
                        <option value="1">1</option>
                        <option value="2">3</option>
                        <option value="3">3</option>
                    </select><br>
                    Fecha: <input type="text" name="fecha" id="fecha"><br>
                    Comprobante: <input type="file" name="comprobante" id="comprobante"><br><br>';
            }
            
            

        ?>
        

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
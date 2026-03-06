<?php
    session_start();
    include 'funcionesE.php';
    function eliminarCampo($dni, $con){             
        $consulta = "delete from solicitudes where dni = ?";
        $stmt = $con->prepare($consulta);
        return $stmt->execute([$dni]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $conn = conectar('cursoscp', 'victor', '1234');
        $dni = $_POST['dni'];
        echo $dni;
        try{    
            if(eliminarCampo($dni, $conn)){
                echo "Eliminado con exito";
            }else{
                echo "Ha ocurrido un error al eliminar";
            }
        }catch(PDOException $e){
            echo "Ha ocurrido el siguiente error" . $e->getMessage();
        }
    ?>
</body>
</html>
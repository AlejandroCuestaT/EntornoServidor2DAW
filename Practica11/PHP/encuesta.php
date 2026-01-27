<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta</title>
    <style>
        body{
            text-align: center;
        }
    </style>
    
</head>
<body>

    <h1>Encuesta</h1>

    <?php
    include("conexion.php");

    if (isset($_POST['votar'])) {

        $respuesta = $_POST['respuesta']; 

        $sql = "UPDATE votos SET $respuesta = $respuesta + 1 WHERE id = 1";
        
        if (mysqli_query($conexion, $sql)) {
            echo "<p>Su voto ha sido registrado.</p>";
            echo "<a href='encuestaResultado.php'>Ver resultados</a>";
        }
    } else {
    ?>
        <p>¿Cree ud. que el precio de la vivienda seguirá subiendo al ritmo actual?</p>
        
        <form action="encuesta.php" method="POST">
            <input type="radio" name="respuesta" value="votosSi" checked> Sí <br>
            <input type="radio" name="respuesta" value="votosNo"> No <br><br>
            
            <input type="submit" name="votar" value="votar">
        </form>
        
        <br>
        <a href="encuestaResultado.php">Ver resultados</a>
    <?php
    }
    mysqli_close($conexion);
    ?>

</body>
</html>
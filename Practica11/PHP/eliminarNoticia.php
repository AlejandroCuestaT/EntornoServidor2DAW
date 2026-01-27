<?php
include("conexion.php");

if (isset($_GET['id'])) {
    

    $id = $_GET['id'];

    $sql = "DELETE FROM noticias WHERE id = $id";


    if (mysqli_query($conexion, $sql)) {
        echo "Noticia borrada correctamente.";
    } else {
        echo "No se pudo borrar la consulta";
    }

} else {
    echo "No hay noticia que borrar";
}

mysqli_close($conexion);

echo "<br><br>";

echo "<a href='consultaNoticias.php'>Volver a la lista de noticias</a>";
?>
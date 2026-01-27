<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Noticia</title>
</head>
<body>

<h1>Nueva Noticia</h1>

<form action="insertarNoticias.php" method="POST">
    
    <label>Título: </label>
    <br>
    <input type="text" name="titulo" required>
    
    <br><br>

    <label>Texto: </label>
    <br>
    <textarea name="texto" required></textarea>
    <br><br>

    <label>Categoria: </label>
    <br>
    <select name="categoria">
        <option value="promociones">Promociones</option>
        <option value="ofertas">Ofertas</option>
        <option value="costas">Costas</option>
    </select>
    
    <br><br>

    <label>Imagen: </label>
    <br>
    <input type="text" name="imagen"><br><br>

    <input type="submit" name="enviar" value="Insertar Noticia">
</form>

<?php

if (isset($_POST['enviar'])) {

    include("conexion.php");

    $titulo = $_POST['titulo'];
    $texto  = $_POST['texto'];
    $categoria  = $_POST['categoria'];
    $imagen = $_POST['imagen'];
    
    $fecha = date("Y-m-d");


    $sql = "INSERT INTO noticias (titulo, texto, categoria, fecha, imagen) 
            VALUES ('$titulo', '$texto', '$categoria', '$fecha', '$imagen')";

    if (mysqli_query($conexion, $sql)) {
        echo "La noticia ha sido añadida:<br>";
        echo "<ul>";
            echo "<li>Título: $titulo</li>";
            echo "<li>Texto: $texto</li>";
            echo "<li>Categoría: $categoria</li>";
            echo "<li>Fecha: $fecha</li>";
            echo "<li>Imagen: $imagen</li>";
        echo "</ul>";
        
        echo "<a href='consultaNoticias.php'>Ver todas las noticias</a>";

    } else {
        echo "Error al insertar: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>

</body>
</html>
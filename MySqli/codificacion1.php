<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "alex", "1234", "biblioteca");

if ($_POST) {
    // Recogemos los datos del formulario
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];

    // 4. Indicamos conexión UTF-8 para insertar (los datos vienen del form en UTF-8) 
    mysqli_set_charset($conexion, 'latin1');
    

    $sql = "INSERT INTO libros (titulo, autor) VALUES ('$titulo', '$autor')";
    
    if (mysqli_query($conexion, $sql)) {
        echo "<h1>Libro guardado con éxito</h1>";
        echo "El ID del libro es: " . mysqli_insert_id($conexion) . "<br>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

// 5. Ampliar para mostrar el listado de todos los libros 
echo "<h2>Listado de libros</h2>";

// Para que los acentos se vean bien al MOSTRAR en un archivo ANSI, 
// cambiamos el charset de la conexión a latin1 
mysqli_set_charset($conexion, 'latin1');

$resultado = mysqli_query($conexion, "SELECT * FROM libros");

echo "<table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
        </tr>";

while ($fila = mysqli_fetch_assoc($resultado)) {
    if($fila == 3){
        utf8_encode($fila);
    }
    echo "<tr>";
    echo "<td>" . $fila['id'] . "</td>";
    echo "<td>" . $fila['titulo'] . "</td>";
    echo "<td>" . $fila['autor'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Formulario de Libros</title>
</head>
<body>
    <hr>
    <h2>Añadir nuevo libro</h2>
    <form action="codificacion1.php" method="POST">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>
        
        <label for="autor">Autor:</label><br>
        <input type="text" id="autor" name="autor" required><br><br>
        
        <input type="submit" value="Enviar Datos">
    </form>
</body>
</html>
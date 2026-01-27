<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de noticias</title>
    <style>
        body { text-align: center; }
        table, th, td { 
            border: 1px solid black; border-collapse: collapse; padding: 5px; 
            margin: 0 auto; 
        }
        th { background-color: #cccccc; }
        .filtro { margin-bottom: 20px; padding: 10px; }
        /* Estilo para la navigacion de paginacion */
        .paginacion { margin-top: 20px; }
        .paginacion a { padding: 5px; border: 1px solid #ccc; text-decoration: none; margin: 2px; }
        .paginacion strong { padding: 5px; background-color: #ddd; }
    </style>
</head>
<body>

<h1>Consulta de noticias</h1>

<p><a href="insertarNoticias.php">Insertar nueva noticia</a></p>
<p><a href="encuesta.php">Encuesta votos</a></p>

<div class="filtro">
    <form action="consultaNoticias.php" method="POST">
        <label>Mostrar noticias de la categoría:</label>
        <select name="categoriaSeleccionada">
            <option value="todas">Todas</option>
            <option value="promociones">Promociones</option>
            <option value="ofertas">Ofertas</option>
            <option value="costas">Costas</option>
        </select>
        <input type="submit" name="filtro" value="Actualizar">
    </form>
</div>

<?php
include("conexion.php");
include("funcionPaginacion.php");

// 1. Query base
$sql = "SELECT * FROM noticias";

// 2. Aplicamos filtro si existe
if (isset($_POST['filtro'])) {
    $categoria = $_POST['categoriaSeleccionada'];
    if ($categoria != "todas") {
        $sql = "SELECT * FROM noticias WHERE categoria = '$categoria'";
    }
}

// 3. Obtenemos datos paginados
$datosPaginados = paginacion($conexion, $sql);

// 4. Pintamos la tabla pasándole el archivo de borrado para crear la columna
pintarListadoCompleto($datosPaginados, 'eliminarNoticia.php');

mysqli_close($conexion);
?>

</body>
</html>
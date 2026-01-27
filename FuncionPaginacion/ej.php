<?php
include 'funcionPaginacion.php'; //funcion de paginacion
// 1. Conexión y Query
$conn = mysqli_connect("localhost", "alex", "1234", "jardineria");
if (!$conn) die("Error de conexión: " . mysqli_connect_error());

$query = "SELECT * FROM productos";

// 2. Llamamos a la lógica para obtener los datos ($p)
$listaPaginaActual = paginacion($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Modular Completo</title>
    <style>

        h1{
            text-align: center;
            font-size: 45px;
        }

        p{
            text-align: center;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .paginacion a, .paginacion strong {
            display: inline-block;
            border: 1px solid black;
            padding: 3px 6px;
            margin-right: 4px;
            text-decoration: none;
            color: black;
        }
        
        .paginacion strong {
            background-color: #ccc;
        }
</style>
</head>
<body>

    <h1>Gestión de Jardinería</h1>
    
    <p><strong><?php echo $listaPaginaActual['total']; ?></strong> registros totales.</p>

    <?php pintarListadoCompleto($listaPaginaActual); ?>

</body>

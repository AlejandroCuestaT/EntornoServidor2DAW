<?php

session_start();

//Creacion de cookie


$valorAleatorio = rand(1000, 9999);

setcookie("miCookie", $valorAleatorio, time() + 3600, "localhost\GitHub\EntornoServidor2DAW\SimulacroExamenFinal");



//Fin creacion de cookie

include_once("conexion.php");
include("paginacionPdoEliminar.php");

//Miramos que la sesion este ya creada
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$query = 'SELECT * from login';
$listaPaginaActual = paginacion($conn, $query);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Login</title>
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

    <h1>Gestión de Login</h1>
    
    <p><strong><?php echo $listaPaginaActual['total']; ?></strong> registros totales.</p>

    <?php pintarListadoCompleto($listaPaginaActual); ?>

    <h4><a href="showCookie.php">Show Cookie</a></h4>

    <br>

    <h4><a href="enviarMail.php">Enviar Mail</a></h4>

    <br>

    <h4><a href="formulario.php">Registrar usuario</a></h4>

    <br>

    <h4><a href="actualizar.php">Actualizar Usuario</a></h4>

</body>
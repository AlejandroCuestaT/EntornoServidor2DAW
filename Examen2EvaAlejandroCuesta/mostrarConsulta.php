<?php
session_start();

include_once("conexion.php");
include("imprimirTicket.php");
include("paginacionPdo.php");

//recojo la tarjeta con la sesion
$tarjeta = $_SESSION['tarjeta'];

//Recojo los datos que coincidan con esa tarjeta
$query = 'SELECT * from citas WHERE tarjeta_paciente='.$tarjeta;
$listaPaginaActual = paginacion($conn, $query);
$cita = '';

//Si existe alguna coincidencia, llama a la funcion imprimirTicket()
if($listaPaginaActual['total'] > 0){
    $cita = imprimirTicket();
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestion de citas</title>
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

    <h1>Gestión de citas</h1>
    <h1> Bienvenido, aqui tienes tu codigo de cita:  <?php echo $cita ?> </h1>
</body>

<?php
//Lleva a mostrar cita
echo "<h1><a href='mostrarTicket.php?ticket=$cita'> Mostrar Ticket Completo </a> </h1>";
echo "<h1><a href='index.php'> Inicio </a> </h1>";


?>
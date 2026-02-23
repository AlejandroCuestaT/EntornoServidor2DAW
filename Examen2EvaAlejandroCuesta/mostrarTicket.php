<?php
session_start();

include_once("conexion.php");
include("imprimirTicket.php");
include("paginacionPdo.php");

$ticket = $_GET['ticket'];
$tarjeta = $_SESSION['tarjeta'];

//Enseña las citas con la coincidencia de tarjeta
$query = 'SELECT * from citas WHERE tarjeta_paciente='.$tarjeta ;
$listaPaginaActual = paginacion($conn, $query);

$datos = $listaPaginaActual['datos']->fetch(PDO::FETCH_ASSOC);

//Creamos cookie de la cita
$datosCookie = 'COOKIE TICKET: <br> Ticket: '.$ticket. ' <br> Hora: ' .$datos['hora']. ' <br> Id Medico: '. $datos['id_medico']. ' <br> Tarjeta Paciente ' .$datos['tarjeta_paciente'];
setcookie("ticket", $datosCookie, time() + 3600, "localhost/ejercicios/Examen2EvaAlejandroCuesta");

//printeo la cookie para verificar que funciona
//print_r($_COOKIE['ticket']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Ticket</title>
</head>
<body>
    <h1> TICKET: <?php  echo $ticket ?> </h1>
    <h2> Hora: <?php echo $datos['hora'] ?> </h2>
    <h3> Id Medico: <?php echo $datos['id_medico'] ?> </h3>
    <h4>Tarjeta Paciente: <?php echo $datos['tarjeta_paciente'] ?></h4>
</body>
</html>
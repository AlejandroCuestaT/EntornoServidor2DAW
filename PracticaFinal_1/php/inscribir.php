<?php
session_start();
include_once("conexion.php");

if (!isset($_SESSION['solicitante'])) {
    die("Error: No hay una sesión activa. Por favor, haz login de nuevo.");
}

if (!isset($_GET['cod'])) {
    die("Error: No se ha especificado el código del curso.");
}

$dni = $_SESSION['solicitante'];
$cod_curso = $_GET['cod'];
$fecha_hoy = date("Y-m-d");

try {
    $sql = "INSERT INTO solicitudes (dni, codigocurso, fechasolicitud, admitido) 
            VALUES (:dni, :cod, :fecha, 0)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':dni'   => $dni,
        ':cod'   => $cod_curso,
        ':fecha' => $fecha_hoy
    ]);

    echo "<h1>Inscripción realizada con éxito</h1>";
    echo "<p>Ya puedes ver este curso en tu lista de solicitudes.</p>";
    echo "<a href='listaSolicitantes.php'>Volver al listado</a>";

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<h1>Aviso</h1>";
        echo "<p>Ya estás inscrito en este curso anteriormente.</p>";
        echo "<a href='listaSolicitantes.php'>Volver al listado</a>";
    } else {
        echo "<h1>Error técnico</h1>";
        echo "Detalles: " . $e->getMessage();
    }
}
?>
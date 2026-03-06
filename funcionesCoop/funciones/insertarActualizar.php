<?php
session_start();
include 'funcionesE.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

function insertarSolicitud($DNI, $codigoCurso, $fecha, $admitido, $con)
{
    $consulta = "Insert into solicitudes values (?, ?, ?, ?)";
    $stmt = $con->prepare($consulta);
    return $stmt->execute([$DNI, $codigoCurso, $fecha, $admitido]);
}

function actualizarDNI($dniViejo, $dniNuevo, $con)
{
    $consulta = "UPDATE solicitudes SET dni = ? where dni = ?";
    $stmt = $con->prepare($consulta);
    return $stmt->execute([$dniNuevo,$dniViejo]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InsertarActualizar</title>
</head>

<body>
    <?php
    //Conexion con base de datos
    $conn = conectar('cursoscp', 'victor', '1234');
    //Campos insertar
    if (isset($_POST['dni'])) {
        $dni = $_POST['dni'];
        $codigo = $_POST['codigocurso'];
        $fecha = $_POST['fechasolicitud'];
        $admitido = $_POST['admitido'];
        try {
            if (insertarSolicitud($dni, $codigo, $fecha, $admitido, $conn)) {
                echo "Insertado con éxito";
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido el siguiente error" . $e->getMessage();
        }
    }
    if (isset($_POST['dniAntiguo'])) {
        //Campo actualizar
        $dniViejo = $_POST['dniAntiguo'];
        $dniNuevo = $_POST['dniNuevo'];
        try {
            if (actualizarDNI($dniViejo, $dniNuevo,  $conn)) {
                echo "DNI actualizado con éxito";
            }
        } catch (PDOException $e) {
            echo "Ha ocurrido el siguiente error" . $e->getMessage();
        }
    }

    ?>
</body>

</html>
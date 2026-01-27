<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de la Encuesta</title>
    <style>
        body { text-align: center; }
        table { margin: 0 auto; border: 1px solid #000; padding: 20px; }
        /* Estilo para las barritas */
        .barra {
            height: 20px;
            background-color: blue;
        }
    </style>
</head>
<body>

<h1>Encuesta. Resultados de la votación</h1>

<?php
include("conexion.php");

//Recojo los datos de la bbdd
$sql = "SELECT * FROM votos WHERE id = 1";
$resultado = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_assoc($resultado);

$si = $fila['votosSi'];
$no = $fila['votosNo'];
$total = $si + $no;

//Calculamos los porcentajes
$porcentajeSi = round(($si / $total) * 100, 2);
$porcentajeNo = round(($no / $total) * 100, 2);

echo "<p>Respuesta a la pregunta: ¿Cree ud. que el precio de la vivienda seguirá subiendo al ritmo actual?</p>";

echo "<table>";
    echo "<tr>";
        echo "<td>Sí:</td>";
        echo "<td>$si votos</td>";
        echo "<td>($porcentajeSi %)</td>";
        echo "<td width='200' align='left'>";
            // Dibujamos la barra usando el porcentaje como ancho
            echo "<div class='barra' style='width: " . $porcentajeSi . "%;'></div>";
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>No:</td>";
        echo "<td>$no votos</td>";
        echo "<td>($porcentajeNo %)</td>";
        echo "<td width='200' align='left'>";
            echo "<div class='barra' style='width: " . $porcentajeNo . "%; background-color: red;'></div>";
        echo "</td>";
    echo "</tr>";
echo "</table>";

echo "<p>Número total de votos : $total</p>";
echo "<p><a href='encuesta.php'>Volver a votar</a></p>";
echo "<p><a href='consultaNoticias.php'>Volver a la consulta</a></p>";

mysqli_close($conexion);
?>

</body>
</html>
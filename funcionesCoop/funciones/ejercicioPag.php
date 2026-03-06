<?php
    include 'funcionesE.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginacion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Consulta noticias</h2>
    <table>
    <?php
        //Iniciamos la conexion con base de datos
        $conn = conectar('cursoscp','victor','1234');
        //Llamamos a la función de paginación que nos devuelve un array con los resultados, el total de las páginas y la página actual
        $paginar = paginacion($conn,'solicitudes', 3);

        $resultados = $paginar['datos'];
        $totalPaginas  = $paginar['totalPaginas'];
        $paginaActual = $paginar['paginaActual'];

        //Solo cambiarían los campos th y los campos td a la hora de llamar a la función
        echo "
                <thead>
                    <tr>
                        <th>dni</th>
                        <th>codigoCurso</th>
                        <th>FechaSolicitud</th>
                        <th>admitido</th>   
                    <tr>   
                </thead>
            </tr>";
        foreach ($resultados as $solicitud){
            echo "<tr>
                    <td>{$solicitud['dni']}</td>
                    <td>{$solicitud['codigocurso']}</td>
                    <td>{$solicitud['fechasolicitud']}</td>
                    <td>{$solicitud['admitido']}</td>
                  </tr>";
        }
        echo "</table>";
        echo "<div id='botonesPag'>";
            if($paginaActual>1){
                echo "<button class='botonPagina'><a href='?pagina=".($paginaActual-1)."' style='text-decoration: none; color: white;'>Anterior</a></button>";
            }
            for ($i=1; $i<=$totalPaginas; $i++){
                echo "<button class='botonPagina''><a href='?pagina=$i' style='text-decoration: none; color: white;'>$i</a></button>";
            }
            if($paginaActual<$totalPaginas){
                echo "<button class='botonPagina'><a href='?pagina=".($paginaActual+1)."' style='text-decoration: none;  color: white;'>Siguiente</a></button>";
            }
        echo "</div>";
        echo "</div>";
    ?>
</body>
</html>
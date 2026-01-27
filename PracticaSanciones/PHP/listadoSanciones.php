<html>
    <head>
        <style>
        h1 {
            color: blue;
            text-align: center;
        }

        h3 {
            color: blue;
            text-align: center;
        }

        .linea {
            border-bottom: 5px solid blue;
        }

        table{
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        td {
            color: blue;
            text-align: center;
        }

        tr{
            text-align: center;
        }
    </style>
    </head>

    <?php
    echo '<h3> Lista de sanciones </h3>';
    echo '<table>';
        

        $fichero = fopen('../TXT/AlumnosSancionados.txt', 'r');
        $alumnos = array();

        if (!$fichero)
            //Te da error y termina el programa si no existe el fichero en esa ruta
            die("ERROR: no se ha podido abrir el fichero de datos");


            echo "<form action='insertarApercibimiento.php' method='post' enctype='multipart/form-data'>";
            while (($linea = fgets($fichero)) !== false) {
            $linea = trim($linea);
            $arrayLinea = explode(',', $linea);
            echo '<tr>';
            echo '<td>'. $arrayLinea[0] . '</td>';
            echo '<td>'. $arrayLinea[1] . '</td>';
            echo '<td>'. $arrayLinea[2] . '</td>';
            echo '<td>'. $arrayLinea[3] . '</td>';
            echo '<td>'. $arrayLinea[4] . '</td>';
            echo '<td>'. $arrayLinea[5] . '</td>';
            
            echo '</tr>';

        }
        fclose($fichero);


        echo '</form>';
    ?>
</html>
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

        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        td {
            color: blue;
            text-align: center;
        }

        tr {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php

    echo '<h1> Agenda </h1>';
    echo '<h1 class="linea"></h1>';

    echo '<table>';
    $fichero = fopen('../TXT/fagenda.txt', 'r');

    if (!$fichero)
        //Te da error y termina el programa si no existe el fichero en esa ruta
        die("ERROR: no se ha podido abrir el fichero de datos");


    while (($linea = fgets($fichero)) !== false) {
        $linea = trim($linea);
        $arrayLinea = explode(',', $linea);
        echo '<tr>';
        echo '<td>' . $arrayLinea[0] . '</td>';
        echo '<td>' . $arrayLinea[1] . '</td>';
        echo '<td>' . $arrayLinea[2] . '</td>';
        echo '<td>' . $arrayLinea[3] . '</td>';
        echo '<td>' . $arrayLinea[4] . '</td>';

        echo '</tr>';

    }
    fclose($fichero);
    echo '</table>';

    echo '<h3><a href="gestionaAgenda.php">Inicio</a></h3>';
    ?>
</body>

</html>
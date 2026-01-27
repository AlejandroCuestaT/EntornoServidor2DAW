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

    if (isset($_POST['enviar'])) { //Cuando se pulsa enviar
    


        function buscarUsuario($nombre)
        {
            $fichero = fopen('../TXT/fagenda.txt', 'r');

            if (!$fichero)
                //Te da error y termina el programa si no existe el fichero en esa ruta
                die("ERROR: no se ha podido abrir el fichero de datos");


            while (($linea = fgets($fichero)) !== false) {
                $linea = trim($linea);
                $arrayLinea = explode(',', $linea);
                $nombreArray = $arrayLinea[0];

                echo '<table>';

                if ($nombre == $nombreArray) {
                    echo '<tr>';
                    echo '<td>' . $arrayLinea[0] . '</td>';
                    echo '<td>' . $arrayLinea[1] . '</td>';
                    echo '<td>' . $arrayLinea[2] . '</td>';
                    echo '<td>' . $arrayLinea[3] . '</td>';
                    echo '<td>' . $arrayLinea[4] . '</td>';

                    echo '</tr>';

                }

                echo '</table>';
            }
        }

        $nombre = '';

        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
        }

        buscarUsuario($nombre);



    } else { //Primera vez formulario
    
        echo '<form action="obtenerContacto.php" method="post" enctype="multipart/form-data">';
        echo '<table>';
        echo '<tr>';
        echo '<td> Nombre de contacto: </td>';
        echo '<td><input type="text" name="nombre"</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>';
        echo '<input type="submit" name="enviar" value="enviar">';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '</form>';
    }
    ?>
</body>

</html>
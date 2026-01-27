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


    echo '<h1> Gestion de sanciones </h1>';
    echo '<h1 class="linea"></h1>';

    if (isset($_POST['actualizar'])) {

        $id = $_POST['id'];

        


        $fichero = fopen('../TXT/AlumnosSancionados.txt', 'a+');
        if (!$fichero)
            //Te da error y termina el programa si no existe el fichero en esa ruta
            die("ERROR: no se ha podido abrir el fichero de datos");

        $auxiliar = fopen('../TXT/auxiliar.txt', 'w+');
        if (!$auxiliar)
            //Te da error y termina el programa si no existe el fichero en esa ruta
            die("ERROR: no se ha podido abrir el fichero de datos");    

        while (!feof($fichero)) {
            $linea = fgets($fichero);
            $partes = explode(',', $linea);
            $numero = (int) $partes[0];

            if ($id == $numero) {
                if ($_POST['actualizar'] == 'finalizar') {

                    $lineaSobre = $partes[0].','.$partes[1].','.$partes[2].','.$partes[3].','.$partes[4].',C';

                    fwrite($auxiliar, $lineaSobre);
                }

                if ($_POST['actualizar'] == 'enProceso') {
                    $lineaSobre = $partes[0].','.$partes[1].','.$partes[2].','.$partes[3].','.$partes[4].',EP';

                    fwrite($auxiliar, $lineaSobre);
                }
            }else{
                $lineaSobre = $partes[0].','.$partes[1].','.$partes[2].','.$partes[3].','.$partes[4].','.$partes[5];

                    fwrite($auxiliar, $lineaSobre);
            }
        }
        //print_r($_POST);


        fclose($fichero);
        fclose($auxiliar);
        rename("../TXT/auxiliar.txt", "../TXT/AlumnosSancionados.txt");
        header('Location: ejecutaSancion.php');
    }

    if (isset($_POST['enviar'])) {


        echo '<h3> Lista de sanciones </h3>';
        echo '<table>';




        $fichero = fopen('../TXT/AlumnosSancionados.txt', 'r');
        $alumnos = array();

        if (!$fichero)
            //Te da error y termina el programa si no existe el fichero en esa ruta
            die("ERROR: no se ha podido abrir el fichero de datos");


        while (($linea = fgets($fichero)) !== false) {
            $linea = trim($linea);
            $arrayLinea = explode(',', $linea);
            $alumno = $_POST['alumno'];
            $_POST['id'] = $arrayLinea[0];

            echo '<tr>';
            if ($alumno == $arrayLinea[1]) {
                echo '<td>' . $arrayLinea[0] . '</td>';
                echo '<td>' . $arrayLinea[1] . '</td>';
                echo '<td>' . $arrayLinea[2] . '</td>';
                echo '<td>' . $arrayLinea[3] . '</td>';
                echo '<td>' . $arrayLinea[4] . '</td>';
                echo '<td>' . $arrayLinea[5] . '</td>';


                echo "<form action='ejecutaSancion.php' method='post' enctype='multipart/form-data'>";
                echo '<input type="hidden" name="id" value="' . $arrayLinea[0] . '">';

                if ($arrayLinea[5] == 'P') {
                    echo '<td><input type="submit" name="actualizar" value="enProceso"></td>';
                } elseif ($arrayLinea[5] == 'EP') {
                    echo '<td><input type="submit" name="actualizar" value="finalizar"></td>';
                } else {
                    echo '<td> Completado </td>';
                }
            }
        }
        fclose($fichero);
        echo '</form>';


        echo '</tr>';

        echo '</table>';
        echo '<h3><a href="sanciona.php"> Volver al indice </a></h3>';

    } else {

        echo "<form action='ejecutaSancion.php' method='post' enctype='multipart/form-data'>";
        echo '<table>';
        echo '<tr>';
        echo '<td> Alumno apercibido: </td>';
        echo '<td>';
        echo '<select name="alumno"';


        //Abro el fichero y muestro uno por uno el alumno
        $fichero = fopen('../TXT/AlumnosSancionados.txt', 'r');
        $alumnos = array();

        if (!$fichero)
            //Te da error y termina el programa si no existe el fichero en esa ruta
            die("ERROR: no se ha podido abrir el fichero de datos");


        while (($linea = fgets($fichero)) !== false) {
            $linea = trim($linea);
            $lineaNombre = explode(',', $linea);
            $nombre = $lineaNombre[1];  

            if (!in_array($nombre, $alumnos)) {
                echo '<option value="' . $lineaNombre[1] . '">' . $lineaNombre[1] . '</option>';
                $alumnos[] = $nombre;
            }
        }

        fclose($fichero);
        echo '</select>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td> <input type="submit" name="enviar" value="Lista Sanciones"> </td>';

        echo '</tr>';
        echo '</table>';
        echo '<h3><a href="sanciona.php"> Volver al indice </a></h3>';
        echo '</form>';
    }




    ?>
</body>

</html>
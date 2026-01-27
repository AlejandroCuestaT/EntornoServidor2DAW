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

    if (isset($_POST['enviar'])) { //Si le dio a enviar
    
        $vfArray = array(
            'nombreVf' => false,
            'profesionVf' => false,
            'nacimientoVf' => false,
            'telefonoVf' => false
        );
        $nombre = '';
        $telefono = '';
        $profesion = '';
        $nacimiento = '';
        $archivo = '1.jpg';

        //================ FUNCIONES ================
    
        function validarFecha($fecha)
        {
            $sep = "[\/\-\.]";
            $req = "#^(((0?[1-9]|1\d|2[0-8]){$sep}(0?[1-9]|1[012])|(29|30){$sep}(0?[13456789]|1[012])|31{$sep}(0?[13578]|1[02])){$sep}(19|[2-9]\d)\d{2}|29{$sep}0?2{$sep}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";
            return preg_match($req, $fecha);
        }

        //================ /FUNCIONES ================
    

        //================ VALIDACIONES ================
        //Nombre no esta vacio
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            if (!empty($nombre)) {
                $vfArray['nombreVf'] = true;
            }
        }

        //Si no esta vacio lo recojo
        if (isset($_POST['telefono'])) {
            $telefono = $_POST['telefono'];
            $telefono = trim($telefono);
            if (empty($telefono)) {
                $vfArray['telefonoVf'] = true;
            }

            if (strlen($telefono) == 9) {
                $vfArray['telefonoVf'] = true;
            }
        } else {
            $vfArray['telefonoVf'] = true;
        }

        //Profesion no esta vacio
        if (isset($_POST['profesion'])) {
            $profesion = $_POST['profesion'];
            if (!empty($profesion)) {
                $vfArray['profesionVf'] = true;
            }
        }

        //Fecha nacimiento tiene formato YYYY-MM-DD
        if (isset($_POST['nacimiento'])) {
            $nacimiento = $_POST['nacimiento'];
            if (validarFecha($nacimiento)) {
                $vfArray['nacimientoVf'] = true;
            }
        }



        //================ /VALIDACIONES ================
    
        //================ REPINTADO ================
    
        if (in_array(false, $vfArray)) { //Si algun campo obligatorio esta mal
    
            echo '<h1> Agenda </h1>';
            echo '<h1 class="linea"></h1>';

            echo '<form action="nuevoContacto.php" method="post" enctype="multipart/form-data">';
            echo '<table>';
            echo '<tr>';
            //Repint nombre
            if ($vfArray['nombreVf'] == false) {

                echo '<td> Nombre de contacto: </td>';
                echo '<td><input type="text" name="nombre"</td>';
                echo '<span style="color:red;"> Nombre no puede estar vacio </span>';

            } else {
                echo '<td> Nombre de contacto: </td>';
                echo '<td><input type="text" name="nombre" value="' . $nombre . '"</td>';
                echo '<span style="color:green;"> ✓ </span>';

            }
            echo '</tr>';

            //Repint telefono
            echo '<tr>';
            if ($vfArray['telefonoVf'] == false) {
                echo '<td> Telefono: </td>';
                echo '<td><input type="text" name="telefono"</td>';
                echo '<span style="color:red;"> Telefono debe estar vacio o 9 digitos </span>';


            } else {
                echo '<td> Telefono: </td>';
                echo '<td><input type="text" name="telefono" value="' . $telefono . '"</td>';
                echo '<span style="color:green;"> ✓ [Campo no obligatorio]</span>';
            }
            echo '</tr>';

            $fichero = fopen('../TXT/fprofesiones.txt', 'r');

            if (!$fichero)
                //Te da error y termina el programa si no existe el fichero en esa ruta
                die("ERROR: no se ha podido abrir el fichero de datos");

            echo '<tr>';
            echo '<td> Profesion: </td>';
            echo '<td>';
            echo '<select name="profesion" value="' . $profesion . '">';
            while (!feof($fichero)) {
                $linea = fgets($fichero);
                $linea = trim($linea);

                echo '<option value="' . $linea . '">' . $linea . '</option>';
            }
            if ($vfArray['profesionVf'] == false) {
                echo '<span style="color:red;"> Campo obligatorio </span>';

            } else {
                echo '<span style="color:green;"> ✓</span>';

            }
            echo '</td>';

            echo '</select>';
            echo '</tr>';
            fclose($fichero);

            echo '<tr>';
            if ($vfArray['nacimientoVf'] == false) {

                echo '<td> Fecha Nacimiento: [DD-MM-YYYY]</td>';
                echo '<td><input type="text" name="nacimiento">';
                echo '<span style="color:red;"> Fecha no valida </span>';
                echo '</td>';
            } else {
                echo '<td> Fecha Nacimiento: [DD-MM-YYYY]</td>';
                echo '<td><input type="text" name="nacimiento" value="' . $nacimiento . '">';
                echo '<span style="color:green;"> ✓ </span>';
                echo '</td>';
            }
            echo '</tr>';

            echo '<tr>';
            echo '<td>Imagen:</td>';
            echo '<td><input type="file" name="imagen"></td>';
            echo '</tr>';




            echo '<tr>';
            echo '<td>';
            echo '<input type="submit" name="enviar" value="enviar">';
            echo '</td>';
            echo '</tr>';

            echo '</table>';
            echo '</form>';

            echo '<h3><a href="gestionaAgenda.php">Inicio</a></h3>';


        } else { //Todos los datos bien
            $telefono = trim($telefono);

            $fichero = fopen('../TXT/fagenda.txt', 'a+');

            $telefonoVf = false;


            if (!$fichero)
                //Te da error y termina el programa si no existe el fichero en esa ruta
                die("ERROR: no se ha podido abrir el fichero de datos");

            while (($linea = fgets($fichero)) !== false) {
                $linea = trim($linea);
                $arrayLinea = explode(',', $linea);
                $nombreFichero = $arrayLinea[0];

                if ($nombre == $nombreFichero) { //Verifica si existe el nombre
    
                } else {
                    if (empty($telefono)) { //Si no existe el telefono, error de creacion
                    } else {
                        $cadena = "\n" . $nombre . ',' . $telefono . ',' . $archivo . ',' . $profesion . ',' . $nacimiento;
                        fwrite($fichero, $cadena);
                        $telefonoVf = true;

                    }
                }



            }

            if ($telefonoVf) {
                echo '<h3> Contacto creado exitosamente </h3>';
            } else {
                echo '<h3>Telefono no indicado, error en la creacion de contacto</h3>';

            }





            echo '<h3><a href="gestionaAgenda.php">Inicio</a></h3>';

            fclose($fichero);
        }


    } else { //Primera vez del formulario
        echo '<h1> Agenda </h1>';
        echo '<h1 class="linea"></h1>';

        echo '<form action="nuevoContacto.php" method="post" enctype="multipart/form-data">';
        echo '<table>';
        echo '<tr>';
        echo '<td> Nombre de contacto: </td>';
        echo '<td><input type="text" name="nombre"</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td> Telefono: </td>';
        echo '<td><input type="text" name="telefono"</td>';
        echo '</tr>';

        $fichero = fopen('../TXT/fprofesiones.txt', 'r');

        if (!$fichero)
            //Te da error y termina el programa si no existe el fichero en esa ruta
            die("ERROR: no se ha podido abrir el fichero de datos");

        echo '<tr>';
        echo '<td> Profesion: </td>';
        echo '<td>';
        echo '<select name="profesion">';
        while (!feof($fichero)) {
            $linea = fgets($fichero);
            $linea = trim($linea);

            echo '<option value="' . $linea . '">' . $linea . '</option>';
        }
        echo '</td>';

        echo '</select>';
        echo '</tr>';
        fclose($fichero);

        echo '<tr>';
        echo '<td> Fecha Nacimiento: [DD-MM-YYYY]</td>';
        echo '<td><input type="text" name="nacimiento"></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Imagen:</td>';
        echo '<td><input type="file" name="imagen"></td>';
        echo '</tr>';




        echo '<tr>';
        echo '<td>';
        echo '<input type="submit" name="enviar" value="enviar">';
        echo '</td>';
        echo '</tr>';

        echo '</table>';
        echo '</form>';

        echo '<h3><a href="gestionaAgenda.php">Inicio</a></h3>';

    }
    ?>
</body>

</html>
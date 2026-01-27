<html>

<head>
    <style>
        h1 {
            margin-top: 20px;
            color: blue;
            text-align: center
        }

        h3 {
            margin-top: 20px;
            color: blue;
            text-align: center
        }

        .linea {
            margin-top: 20px;
            border-bottom: 10px solid blue;
        }

        .azul {
            color: blue;
        }

        table{
            margin: auto;
        }

        .rojo {
            color: red;
        }

        td{
            color: blue;
        }

        tr{
            height: 70px;
        }
    </style>
</head>

<body>
    <?php
    $permisos = array();

    $fichero = fopen('../TXT/permisos.txt', 'r');

    if (!$fichero)
        //Te da error y termina el programa si no existe el fichero en esa ruta
        die("ERROR: no se ha podido abrir el fichero de datos");


    while (!feof($fichero)) {
        $linea = fgets($fichero);
        $permisos[] = $linea;

    }

    fclose($fichero);
    ?>

    <h1>GESTION DE LA MOVILIDAD</h1>
    <h1 class="linea"></h1>
</body>

<?php

if (isset($_POST['enviar'])) { //Si existe enviar

    if (isset($_POST['permiso'])) { //Si existe algun permiso
        echo '<form action="aniadirGestion.php" method="post" enctype="multipart/form-data">';

        //Necesito un hidden para no perder el valor permiso
        echo '<input type="hidden" name="permiso" value="' . $_POST['permiso'] . '">';

        echo '<h3>Permiso para: ' . $_POST['permiso'] . '</h3>';
        
        echo '<table>';

        echo '<tr>';
        echo '<td> Matricula: </td>';
        echo '<td><input type="text" name="matricula" required></td>';
        //Trim obligatorio para que quite espacios
        if(trim($_POST['permiso']) == 'Taxi'){
            echo '<td style="padding-left:40px;"> Nombre: </td>';
            echo '<td><input type="text" name="nombre" required></td>';
        }
        echo '</tr>';

        echo '<tr>';
        echo '<td> Fecha inicio: </td>';
        echo '<td><input type="date" name="fechaInicio" required></td>';
        echo '<td style="padding-left:40px;"> Fecha fin: : </td>';
        echo '<td><input type="date" name="fechaFin" required></td>';
        echo '</tr>';

        echo '<tr>';
        if(trim($_POST['permiso']) == 'Residentes y Hoteles' || trim($_POST['permiso']) == 'AutobusesEMT'){
            echo '<td> Direccion: </td>';
            echo '<td><input type="text" name="direccion" required></td>';
            echo '<td style="padding-left:40px;"> Justificante: : </td>';
            echo '<td><input type="file" name="justificante"></td>';
        }else{
            echo '<td> Justificante: : </td>';
            echo '<td><input type="file" name="justificante"></td>';
        }
        
        
        echo '</tr>';

        echo '<tr>';
        echo '<td><input type="submit" name="enviar" value="enviar"></td>';
        echo '</tr>';

        
        echo '</table>';
        echo '</form>';


        


    } else { //Si deja la opcion permiso vacio
        echo '<form action="gestionMovilidad.php" method="post" enctype="multipart/form-data">';
        echo '<table>';
        echo '<tr>';
        echo '<td>Tipo de permiso: </td>';
        echo '<td>';
        echo '<SELECT MULTIPLE SIZE="3" NAME="permiso">';
        foreach ($permisos as $permiso) {
            echo '<OPTION VALUE="' . $permiso . '">' . $permiso . '</OPTION>';
        }
        echo '</SELECT>';
        
        echo '<span class="rojo"> Debes asignar algun permiso </span>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';

        echo '<td>';
        echo '<input type="submit" name="enviar" value="enviar">';        
        echo '</td>';
        echo '</tr>';

        echo '</table>';
        echo '</form>';
    }

} else { //Primera vez del formulario mostrando solo el tipo de permiso
    echo '<form action="gestionMovilidad.php" method="post" enctype="multipart/form-data">';
    echo '<table>';
    echo '<tr>';
    echo '<td>Tipo de permiso: </td>';
    echo '<td>';
    echo '<SELECT MULTIPLE SIZE="3" NAME="permiso">';
    foreach ($permisos as $permiso) {
        echo '<OPTION VALUE="' . $permiso . '">' . $permiso . '</OPTION>';
    }
    echo '</SELECT>';
    
    echo '</td>';
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

</html>
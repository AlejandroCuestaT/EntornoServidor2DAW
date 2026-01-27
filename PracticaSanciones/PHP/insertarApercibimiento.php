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
if(isset($_POST['enviar'])) {

    //Variable primer numero para siguiente alumno sancionado
    $numero = 0;

    $fichero = fopen('../TXT/AlumnosSancionados.txt', 'a+');
    if (!$fichero)
    //Te da error y termina el programa si no existe el fichero en esa ruta
    die("ERROR: no se ha podido abrir el fichero de datos");

    while(!feof($fichero)){
        $linea = fgets($fichero);
        $partes = explode(',', $linea);
        $numero = (int)$partes[0];   
    }

    $nombre = $_POST['alumno'];
    $fecha = (new DateTime())->format('d/m/Y');
    $falta = $_POST['falta'];
    $sancion = $_POST['sancion'];
    $alumnoSancionado = "\n".($numero+1).','.$nombre.','.$fecha.','.$falta.','.$sancion.',P';
    fwrite($fichero, $alumnoSancionado);
    fclose($fichero);  
    header('Location: sanciona.php');  

}else{

    echo '<h1> Gestion de sanciones </h1>';
    echo '<h1 class="linea"></h1>';
    echo "<form action='insertarApercibimiento.php' method='post' enctype='multipart/form-data'>";
    echo '<table>';
    echo '<tr>';
    echo '<td> Alumno apercibido: </td>';
    echo '<td>';
    echo '<select name="alumno">';


    //Abro el fichero y muestro uno por uno el alumno
    $fichero = fopen('../TXT/Alumnos.txt', 'r');

    if (!$fichero)
        //Te da error y termina el programa si no existe el fichero en esa ruta
        die("ERROR: no se ha podido abrir el fichero de datos");


    while (($linea = fgets($fichero))!== false) {
        $linea = trim($linea);
        $nombre = explode(',',$linea);
        echo '<option value="'.$nombre[0].'">'.$linea.'</option>';

    }

    fclose($fichero);
    echo '</select>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td> Tipo de falta: </td>';
    echo '<td> <input type="radio" name="falta" value="L" checked> Leve <input type="radio" name="falta" value="G"> Grave <input type="radio" name="falta" value="MG"> Muy Grave</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td> Sancion: </td>';
    echo '<td> <input type="text" name="sancion" required> </td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td> <input type="submit" name="enviar" value="enviar"> </td>';        

    echo '</tr>';
    echo '</table>';
    echo '</form>';

}
?>

</html>
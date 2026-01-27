<?php
$linea = '';

if(isset($_POST['permiso'])){
    $opcion = trim($_POST['permiso']);
    switch($opcion){
        case 'Residentes y Hoteles':
            $fichero = fopen('../TXT/residentesYHoteles.txt', 'a+');
            $linea = $_POST['matricula'] . ' ' . $_POST['fechaInicio'] . ' ' . $_POST['fechaFin'] . ' ' . $_POST['direccion'];
            if (!$fichero)
                die("ERROR: no se ha podido abrir el fichero de datos");
            fputs($fichero,"\n".$linea);
            fclose($fichero);
            break;
        case 'AutobusesEMT':
            $fichero = fopen('../TXT/vehiculosEMT.txt', 'a+');
            $linea = $_POST['matricula'] . ' ' . $_POST['fechaInicio'] . ' ' . $_POST['fechaFin'] . ' ' . $_POST['direccion'];
            if (!$fichero)
                die("ERROR: no se ha podido abrir el fichero de datos");
            fputs($fichero,"\n".$linea);
            fclose($fichero);
            break; 
        case 'Taxi':
            $fichero = fopen('../TXT/taxis.txt', 'a+');
            $linea = $_POST['matricula'] . ' ' . $_POST['nombre'] . ' ' . $_POST['fechaInicio'] . ' ' . $_POST['fechaFin'];
            if (!$fichero)
                die("ERROR: no se ha podido abrir el fichero de datos");
            fputs($fichero,"\n".$linea);
            fclose($fichero);
            break;
        case 'Servicios':
            $fichero = fopen('../TXT/servicios.txt', 'a+');
            $linea = $_POST['matricula'] . ' ' . $_POST['fechaInicio'] . ' ' . $_POST['fechaFin'];
            if (!$fichero)
                die("ERROR: no se ha podido abrir el fichero de datos");
            fputs($fichero,"\n".$linea);
            fclose($fichero);
            break;  
        case 'Logistica':
            $fichero = fopen('../TXT/logistica.txt', 'a+');
            $linea = $_POST['matricula'] . ' ' . $_POST['fechaInicio'] . ' ' . $_POST['fechaFin'];
            if (!$fichero)
                die("ERROR: no se ha podido abrir el fichero de datos"); 
            fputs($fichero,"\n".$linea);
            fclose($fichero);
            break;                
    }
}
?>
<html>
    <head>
        <style>
        h1 {
            margin-top: 20px;
            color: blue;
            text-align: center
        }

        h2 {
            margin-top: 20px;
            color: green;
            text-align: center
        }

        h3 {
            margin-top: 20px;
            text-align: center
        }

        .linea {
            margin-top: 20px;
            border-bottom: 10px solid blue;
        }
        </style>
    </head>

    <body>
    <h1>GESTION DE LA MOVILIDAD</h1>
    <h1 class="linea"></h1>

    <h2>PETICION INGRESADA CON EXITO</h2>
    <h3><a href="movilidad.php">Volver al menu</a></h3>
    </body>
</html>
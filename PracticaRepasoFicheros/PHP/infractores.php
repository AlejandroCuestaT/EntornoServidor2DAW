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
            text-align: center;
            color: blue
        }

        h3 {
            margin-top: 20px;
            text-align: center;
            color: blue
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

    <?php
    $vehiculos = array();

    $ficheroVehiculos = fopen('../TXT/vehiculos.txt', 'r');
    if (!$ficheroVehiculos)
        //Te da error y termina el programa si no existe el fichero en esa ruta
        die("ERROR: no se ha podido abrir el fichero de datos");


    while (!feof($ficheroVehiculos)) {
        $linea = fgets($ficheroVehiculos);
        $vehiculos[] = $linea;

    }

    fclose($ficheroVehiculos);

    $arrayLogistica = recogerDatos('logistica');
    $arrayResidentesYHoteles = recogerDatos('residentesYHoteles');
    $arrayServicios = recogerDatos('servicios');
    $arrayTaxis = recogerDatos('taxis');
    $arrayVehiculosEMT = recogerDatos('vehiculosEMT');

    $comprobar = array_merge($arrayLogistica, $arrayResidentesYHoteles, $arrayServicios, $arrayTaxis, $arrayVehiculosEMT);


    //MATRICULAS DE LOS TXT
    $matriculas = array();

    foreach($comprobar as $linea){ //Recojo en un array solo las matriculas
        $matricula = explode(' ', $linea)[0];
        $matriculas[] = $matricula;
    }

    //MATRICULAS DE VEHICULOS.TXT
    $matriculasVehiculos = array();

    foreach($vehiculos as $linea){ //Recojo en un array solo las matriculas
        $matricula = explode(' ', $linea)[0];
        $matriculasVehiculos[] = $matricula;
    }

    //COCHES ELECTRICOS
    $vehiculosElectricos = array();
    foreach($vehiculos as $linea){
        if(str_ends_with(trim($linea), 'electrico')){ //Miro si la ultima palabra de la cadena es 'electrico'
            $vehiculosElectricos[] = $linea;
        }
    }

    //MATRICULAS COCHES ELECTRICOS
    $matriculasElectricos = array();

    foreach($vehiculosElectricos as $linea){ //Recojo en un array solo las matriculas
        $matricula = explode(' ', $linea)[0];
        $matriculasElectricos[] = $matricula;
    }

    //ARRAY DE LOS INFRACTORES
    $infractores = array();
    //Excluyo los que tienen permisos
    $infractores = array_diff($matriculasVehiculos, $matriculas);
    //Excluyo los electricos
    $infractores = array_diff($infractores, $matriculasElectricos);

    //Cojo toda la linea de los infractores, no solo las matriculas
    $lineaInfractores = array();
    foreach ($vehiculos as $linea) {
        $partes = explode(' ', $linea);
        $matricula = $partes[0];
        
        // Comparar si está en infractores
        if (in_array($matricula, $infractores)) {
            $lineaInfractores[] = $linea;
        }
    }


    echo'<h2> INFRACTORES </h2>';
    foreach($lineaInfractores as $infractor){
        echo '<h3>'.$infractor.'</h3>';
    }



    

    function recogerDatos($nombre){ //Con el nombre abre el fichero y devuelve un array con las lineas
        $array = array();
        $fichero = fopen('../TXT/'.$nombre.'.txt', 'r');
        if (!$fichero)
            die("ERROR: no se ha podido abrir el fichero de datos");


        while (!feof($fichero)) {
            $linea = fgets($fichero);
            $array[] = $linea;

        }
    

    fclose($fichero);
    return $array;
    }
    
    ?>
    </body>
</html>
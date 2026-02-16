<?php
    //Calcula los puntos al registrar un usuario con el algoritmo de la practica
    function calcularPuntos($datosUsuario){
        $puntos = 0;


        $coordinadortic = $datosUsuario['coordinadortic'];
        $grupotic = $datosUsuario['grupotic'];
        $pbilin = $datosUsuario['pbilin'];
        $nombrecargo = $datosUsuario['nombrecargo'];
        $situacion = $datosUsuario['situacion'];
        $fechaalt = $datosUsuario['fechaalt'];

        if (isset($coordinadortic) && $coordinadortic != "") {
            $puntos += 4;
        }

        if (isset($grupotic) && $grupotic != "") {
            $puntos += 3;
        }

        if (isset($pbilin) && $pbilin != "") {
            $puntos += 3;
        }

        if (isset($nombrecargo)){
            switch($nombrecargo){
                case 'director':
                    $puntos += 2;
                    break;
                case 'jefeDeEstudios':
                    $puntos += 2;
                    break;  
                case 'secretario':
                    $puntos += 2;
                    break;  
                case 'jefeDeDepartamento':
                    $puntos += 1;
                    break;          
            }
        }

        if ($situacion == "activo") {
            $puntos += 1;
        }

        if(calcularAntiguedad($fechaalt)){
            $puntos += 1;
        }

        

        return $puntos;


    }

    //Calcula la antiguedad comparando la fecha de alta y la de hoy
    function calcularAntiguedad($fechaalt){

        $fecha = DateTime::createFromFormat('d/m/Y', $fechaalt);

        if (!$fecha){
            return false;
        } 
        
        $fechaActual = new DateTime();

        $diferencia = $fechaActual->diff($fecha);

        $anioDiff = $diferencia->y;

        if($anioDiff > 15){
            return true;
        }else{
            return false;
        }

        
    }
?>
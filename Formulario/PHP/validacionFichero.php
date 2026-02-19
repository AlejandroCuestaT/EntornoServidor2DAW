<?php
    $nombre = '';
    $password = '';
    $sexo = '';
    $fechaNacimiento = '';
    $paises = array();
    $check = '';
    $comentario = '';

    $vfArray = array(
    'nombreVf'=> false,
    'passwordVf'=> false,
    'sexoVf'=> false,
    'formatoFechaNacimientoVf'=> false,
    'esMayorDeEdad'=> false,
    'paisVf'=> false,
    'checkVf'=> false
    );

    //Compruebo si el nombre no esta vacio
    if(isset($_POST['nombre'])){
        $nombre = $_POST['nombre'];
       if(!empty($nombre)){
        $vfArray['nombreVf'] = true;
       }
    }

    //Compruebo contrasenia entre 6 y 12 caracteres
    if(isset($_POST['password'])){
        $password = $_POST['password'];
        if(strlen($password)>=6 && strlen($password)<=12){
            
            $vfArray['passwordVf'] = true;
        }
    }

    //Compruebo que algun sexo este marcado
    if(isset($_POST['sexo'])){
        $sexo = $_POST['sexo'];
        $vfArray['sexoVf'] = true;
        
    }

    //Comprueba formato de fecha
    function validarFecha($fecha){
        $sep = "[\/\-\.]";
        $req = "#^(((0?[1-9]|1\d|2[0-8]){$sep}(0?[1-9]|1[012])|(29|30){$sep}(0?[13456789]|1[012])|31{$sep}(0?[13578]|1[02])){$sep}(19|[2-9]\d)\d{2}|29{$sep}0?2{$sep}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";
        return preg_match($req, $fecha);
    }

    // Comprueba que sea mayor de 18
    function esMayorDeEdad($fechaNacimiento) {
        $fechaNormalizada = str_replace(['/', '.'], '-', $fechaNacimiento);

        $fecha = DateTime::createFromFormat('d-m-Y', $fechaNormalizada);

        if (!$fecha) {
            return false;
        }

        $hoy = new DateTime();

        $edad = $hoy->diff($fecha)->y;

        return $edad >= 18;
    }



    //Compruebo el formato de fecha nacimiento y si es mayor de 18 
    if(isset($_POST['fechaNacimiento'])){
        $fechaNacimiento = $_POST['fechaNacimiento'];
        if(validarFecha($fechaNacimiento)){
            $vfArray['formatoFechaNacimientoVf'] = true;
            if(esMayorDeEdad($fechaNacimiento)){
                $vfArray['esMayorDeEdad'] = true;
            }
        }
    }

    //Compruebo que algun pais este marcado
    //Nota: Aunque en html paises[] sea array aqui no se ponen los [] y lo detecta como array
    if(isset($_POST['paises'])){
        $paises = $_POST['paises'];
        $vfArray['paisVf'] = true;
    }

    //Compruebo que el check este marcado
    if(isset($_POST['check'])){
        $check = $_POST['check'];
        $vfArray['checkVf'] = true;
    }

    //Si hay comentario lo recojo
    if(isset($_POST['comentario'])){
        $comentario = $_POST['comentario'];
    }


    // -----------------------  REPINT  -----------------------

    //Verifico si algun campo es erroneo
    if(in_array(false, $vfArray)){
        echo "<form action='../PHP/validacionFichero.php' method='post' enctype='multipart/form-data'>";

        //Repint nombre
        if($vfArray['nombreVf'] == false){
            echo "Nombre: <input type='text' name='nombre' style='border: 2px solid red;'>";
            echo '<span style="color:red;"> Nombre no puede estar vacio </span>';
        }else{
            echo "Nombre: <input type='text' name='nombre' value=$nombre style='border: 2px solid green;'>";
            //Tick verde
            echo '<span style="color:green;"> ✓ </span>';
        }

        echo "<br><br>";

        //Repint password
        if($vfArray['passwordVf'] == false){
            echo "Clave: <input type='password' name='password' style='border: 2px solid red'>";
            echo '<span style="color:red;"> Entre 6 y 12 caracteres </span>';
        }else{
            echo "Clave: <input type='password' name='password' value=$password style='border: 2px solid green;'>";
            echo '<span style="color:green;"> ✓ </span>';
        }

        echo "<br><br>";

        // Repint sexo
        echo "Genero:";
        if($vfArray['sexoVf'] == false){
            echo "<INPUT TYPE='radio' NAME='sexo' VALUE='Mujer'> Mujer";
            echo "<INPUT TYPE='radio' NAME='sexo' VALUE='Hombre'> Hombre";
            echo '<span style="color:red;"> Selecciona un género </span>';
        }else{
            echo "<INPUT TYPE='radio' NAME='sexo' VALUE='Mujer' ".($sexo=='Mujer'?'checked':'')." style='accent-color: green;'> Mujer";
            echo "<INPUT TYPE='radio' NAME='sexo' VALUE='Hombre' ".($sexo=='Hombre'?'checked':'')." style='accent-color: green;'> Hombre";
            echo '<span style="color:green;"> ✓ </span>';
        }

        echo "<br><br>";

        //Repint fecha de nacimiento
        echo "Fecha nacimiento:";
        if($vfArray['formatoFechaNacimientoVf'] == false){
            echo "<input type='text' name='fechaNacimiento' style= 'border: 2px solid red'>";
            echo '<span style="color:red;"> Formato de fecha [dd/mm/yyyy] </span>';
        }elseif($vfArray['esMayorDeEdad'] == false){
            echo "<input type='text' name='fechaNacimiento' style= 'border: 2px solid red'>";
            echo '<span style="color:red;"> Tienes que ser mayor de edad </span>';
        }else{
            echo "<input type='text' name='fechaNacimiento' value=$fechaNacimiento style= 'border: 2px solid green'>";
            echo '<span style="color:green;"> ✓ </span>';
        }

        echo "<br><br>";

        //Repint pais
        echo "Pais:";
        if($vfArray['paisVf'] == false){
            echo "<SELECT MULTIPLE SIZE='4' NAME='paises[ ]' style= 'border: 2px solid red'>";
            echo "<OPTION VALUE='espania'>Espania</OPTION>";
            echo "<OPTION VALUE='francia'>Francia</OPTION>";
            echo "<OPTION VALUE='alemania'>Alemania</OPTION>";
            echo "<OPTION VALUE='holanda'>Holanda</OPTION>";
            echo "</SELECT>";
            echo '<span style="color:red;"> Seleciona una opcion </span>';
        }else{
            //Duda value para que mantenga la opcion 
            echo "<SELECT MULTIPLE SIZE='4' NAME='paises[ ]' style= 'border: 2px solid green'>";
            echo "<OPTION VALUE='espania'>Espania</OPTION>";
            echo "<OPTION VALUE='francia'>Francia</OPTION>";
            echo "<OPTION VALUE='alemania'>Alemania</OPTION>";
            echo "<OPTION VALUE='holanda'>Holanda</OPTION>";
            echo "</SELECT>";
            echo '<span style="color:green;"> ✓ </span>';
        }
        
        echo "<br><br>";

        //Repint check
        echo "¿Aceptas los terminos?";
        if($vfArray['checkVf'] == false){
            echo "<INPUT TYPE='checkbox' NAME='check' VALUE='OK' style= 'border: 2px solid red'>";
            echo '<span style="color:red;"> Debes aceptar los terminos </span>';
        }else{
            echo "<INPUT TYPE='checkbox' NAME='check' VALUE='OK' style= 'border: 2px solid green' checked>";
            echo '<span style="color:green;"> ✓ </span>';
        }
        echo "<br><br>";

        //Repint comentario
        echo "Comentario:";
        echo "<TEXTAREA COLS='50' ROWS='4' NAME='comentario'>$comentario";
        echo "</TEXTAREA>";
        echo "<br><br>";
        echo "Foto:";
        echo "INPUT TYPE='file' NAME='fichero'>";
        echo "<br><br>";
        echo "<input type='submit' name='aceptar' value='aceptar'>";
        echo "</form>";
    }else{
        
    
        echo 'Nombre: '.$nombre.'<br>';
        echo 'Clave Segura <br>';
        echo 'Sexo: '.$sexo.'<br>';
        echo 'Fecha Nacimiento: '.$fechaNacimiento.'<br>';
        print_r($paises);
        echo '<br> Terminos aceptados <br>';

        //Si hay comentario, que lo muestre
        if(!empty($comentario)){
            echo 'Comentario : '.$comentario.'<br>';
        }else{
            echo 'Sin comentario <br>';
        }

    }
?>
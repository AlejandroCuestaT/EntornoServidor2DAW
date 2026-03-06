<html>

<head>
    <title>Validaciones</title>
</head>

<body>
    <?php
    //Validación de nombre de usuario
    echo '<br>';
    function validarUsuario($nombre)
    {
        return preg_match("#^[a-z][\da-z_]{6,22}[a-z\d]\$#i", $nombre);
    }
    //ejemplo:
    if (validarUsuario("EducacionIT")) {
        echo "usuario valido";
    } else {
        echo "usuario invalido";
    }
    ?>
    <?php
    //Validación de una dirección de email
    echo '<br>';
    function validarEmail($email)
    {
        $reg = "#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9$])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})$#i";
        return preg_match($reg, $email);
    }
    //ejemplo:
    if (validarEmail("info$@educacionit.com")) {
        echo "email valido";
    } else {
        echo "email invalido";
    }
    ?>
    <?php
    //Validación de una fecha
    echo '<br>';
    function validarFecha($fecha)
    {
        $sep = "[\/\-\.]";
        $req = "#^(((0?[1-9]|1\d|2[0-8]){$sep}(0?[1-9]|1[012])|(29|30){$sep}(0?[13456789]|1[012])|31{$sep}(0?[13578]|1[02])){$sep}(19|[2-9]\d)\d{2}|29{$sep}0?2{$sep}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";
        return preg_match($req, $fecha);
    }
    //ejemplo:
    if (validarFecha("05/01/2011")) {
        echo "fecha valida";
    } else {
        echo "fecha invalida";
    }
    ?>
    <?php
    echo '<br>';
    //Validación de una contraseña entre 6 y 16 caracteres
    function validar_clave($clave){
        $regu ='/^[a-z0-9_$-]{6,18}$/';
        return preg_match($regu,$clave);
    }
    if (validar_clave("contrasena1")){
        echo "contraseña valida";
    }else{
        echo "contraseña inválida";
    }

    //Validamos que el campo del DNI no este vacío
        if(empty($_POST['dni'])){
            $errores['dni'] = "<h4 style='color:red'>El campo DNI no puede estar vacío</h4>";
        }
        //Validamos que el campo del DNI tenga el formato correcto
        if (!preg_match('/^[0-9]{8}[A-Z]$/', $_POST['dni'])) {
            $errores['dni'] = "<h4 style='color:red'>Introduce un DNI con formato válido</h4>";
        }


        //Validamos que el campo del nombre no este vacío
        if(empty($_POST['nombre'])){
            $errores['nombre'] = "<h4 style='color:red'>El campo nombre no puede estar vacío</h4>";
        }
        //Validamos que el campo de los apellidos no este vacío
        if(empty($_POST['apellidos'])){
            $errores['apellidos'] = "<h4 style='color:red'>El campo apellido no puede estar vacío</h4>";
        }

        //Validamos que el numero de telefono solo pueda contener 9 numeros
        if (!preg_match('/^[0-9]{9}$/', $_POST['telefono'])) {
            $errores['telefono'] = "<h4 style='color:red'>Introduce un telefono con formato válido</h4>";
        }

        
        //Validamos que el correo no este vacío
        if(empty($_POST['correo'])){
            $errores['correo']= "<h4 style='color:red'>El campo no puede estar vacío</h4>";
        }
        //Validamos que el codigo del centro sean 8 digitos numericos
        if (!preg_match('/^[0-9]{8}$/', $_POST['codigoCentro'])) {
            $errores['codigoCentro'] = "<h4 style='color:red'>Introduce un formato válido para el código del centro </h4>";
        }
        //Comprobamos que el campo no este vacio
        if(empty($_POST['nGrupo'])){
            $errores['nGrupo'] = "<h4 style='color:red'>El campo no puede estar vacío</h4>";
        }
    
    ?>
</body>

</html>
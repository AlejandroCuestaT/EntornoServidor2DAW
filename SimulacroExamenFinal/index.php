<!DOCTYPE html>
<html>
<head>
    
</head>
<body>
    <form action='../PHP/index.php' method='post' enctype='multipart/form-data'>
        Nombre:
        <input type='text' name='nombre'>
        <br><br> 

        Clave: <input type='password' name='password'>

        <br><br>
        
        Genero:
        <INPUT TYPE='radio' NAME='sexo' VALUE='Mujer'> Mujer
        <INPUT TYPE='radio' NAME='sexo' VALUE='Hombre'> Hombre

        <br><br>

        Fecha nacimiento: 
        <input type='text' name='fechaNacimiento'>

        <br><br>
        
        Pais:
        <SELECT MULTIPLE SIZE='4' NAME='paises[ ]'>
        <OPTION VALUE='espania'>Espania</OPTION>
        <OPTION VALUE='francia'>Francia</OPTION>
        <OPTION VALUE='alemania'>Alemania</OPTION>
        <OPTION VALUE='holanda'>Holanda</OPTION>
        </SELECT>

        <br><br>

        ¿Aceptas los terminos?
        <INPUT TYPE='checkbox' NAME='check' VALUE='OK'>

        <br><br>

        Comentario:
        <TEXTAREA COLS='50' ROWS='4' NAME='comentario'>
        
        </TEXTAREA>

        <br><br>

        Foto:
        <INPUT TYPE='file' NAME='fichero'>

        <br><br>
        <input type='submit' name='aceptar' value='aceptar'>
    </form>
</body>
</html>
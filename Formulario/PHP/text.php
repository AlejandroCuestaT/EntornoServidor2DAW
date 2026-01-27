<!DOCTYPE html>
<html>
<head>

</head>
<body>
    
    <form action="text.php" method="post">
        <!--
        FORM INDISPENSABLE PARA HACER FORMULARIOS, marcando en 
        action el php donde se encuentra
        -->
        <input type="text" name="cadena" value="valor por defecto" size="20">
        <input type="submit" name="aceptar" value="aceptar">
    </form>

    <?php 
    //Ejemplo haciendo el html y el php en el mismo fichero
    if (isset($_POST['aceptar'])){
        echo 'La cadena es: '.$_POST['cadena'];
        
    }
        
    ?>
</body>
</html>
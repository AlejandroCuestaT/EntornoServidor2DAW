<?php
//Ver nombre del fichero subido
echo "name:" . $_FILES['imagen']['name'] . "<br>";
//Nombre temporal del fichero para que sea unico
echo "tmp_name:" . $_FILES['imagen']['tmp_name'] . "<br>";
//Tamanio del archivo
echo "size:" . $_FILES['imagen']['size'] . "<br>";
//Tipo del archivo
echo "type:" . $_FILES['imagen']['type'] . "<br>";
//Verifica que haya llegado al servidor con is_uploaded_file
if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
    //Con estas tres variables genero el nombre completo
    $nombreDirectorio = "img/";
    $nombreFichero = $_FILES['imagen']['name'];
    $nombreCompleto = $nombreDirectorio . $nombreFichero;

    //Verifico que imagen tenga un tamanio menor al indicado 
    // y que sea jpeg. Siempre es image/jpeg
    if ($_FILES['imagen']['size'] < 1000000000) {
        echo 'Tamanio valido <br>';

        //Si tiene tamanio inferior se copia en la carpeta
        if (is_dir($nombreDirectorio)) { // es un directorio existente
            
            //Conseguimos que el nombre sea unico siempre con time
            $idUnico = time();
            $nombreFichero = $idUnico . "-" . $nombreFichero;
            $nombreCompleto = $nombreDirectorio . $nombreFichero;

            move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreCompleto);
            echo "Fichero subido con el nombre: $nombreFichero<br>";
        } else
            echo "Directorio definitivo invalido";

        if ($_FILES['imagen']['type'] == 'image/jpeg') {
            echo 'Es una imagen <br>';
        } else {

            //Si no es una imagen compruebo si es un pdf
            //Para comprobar siempre tiene que ser application/pdf
            if ($_FILES['imagen']['type'] == 'application/pdf') {
                echo 'Es un pdf <br>';
            } else {
                echo 'No es una imagen ni un pdf <br>';

            }
        }
    } else {
        echo 'Tamanio invalido <br>';
    }



} else
    print ("No se ha podido subir el fichero\n");
?>
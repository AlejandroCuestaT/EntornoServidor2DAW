
<html><body><?php
function procesaFichero($nombre,$temporal){
   echo "name:".$nombre."<br>";
   echo "tmp_name:".$temporal."<br>";
   if (is_uploaded_file ($temporal)){
       $nombreDirectorio = "img/";
       $nombreFichero = $nombre;
       $nombreCompleto = $nombreDirectorio.$nombreFichero;
       if (is_dir($nombreDirectorio)){  // es un directorio existente
            $idUnico = time();
            $nombreFichero = $idUnico."-".$nombreFichero;
            $nombreCompleto = $nombreDirectorio.$nombreFichero;
            move_uploaded_file ($temporal,$nombreCompleto);
            echo "Fichero subido con el nombre: $nombreFichero<br>";
        }
        else echo 'Directorio definitivo inválido';
  }
else
        print ("No se ha podido subir el fichero<br>");
}
$tamanoMini=1000000;
$vacacionesMini=' ';
$vacacionesMiniTemporal=' ';
$tamanoMaxi=0;
$vacacionesMaxi=' ';
$vacacionesMaxiTemporal=' ';
foreach($_FILES as $fichero){
	echo $fichero['size'];
	if($fichero['size']<$tamanoMini){
			$tamanoMini=$fichero['size'];
			$vacacionesMini=$fichero['name'];;
			$vacacionesMiniTemporal=$fichero['tmp_name'];
	}elseif($fichero['size']>$tamanoMaxi){
			$tamanoMaxi=$fichero['size'];
			$vacacionesMaxi=$fichero['name'];;
			$vacacionesMaxiTemporal=$fichero['tmp_name'];
	}
echo '<br>';
}
procesaFichero($vacacionesMini,$vacacionesMiniTemporal);
procesaFichero($vacacionesMaxi,$vacacionesMaxiTemporal);
?></body></html>


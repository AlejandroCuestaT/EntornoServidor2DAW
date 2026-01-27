<?php 
$dir = '.'; //abre el directorio actual

//getcwd devuelve la ruta del directorio actual
echo getcwd().'<br>';

If ($descriptor = opendir($dir)){
//Mientras que haya un siguiente archivo sigue. 
//El !== es mientras que no devuelva un booleano falso
while(false !== ($fichero = readdir($descriptor))){
$ruta_completa = $dir . '/' . $fichero;
if(is_executable($ruta_completa)){
    echo "Es ejecutable  ";
}else{
    echo "No es ejecutable  ";
}
echo "$fichero  : " .filesize($ruta_completa).'bytes <br>';}
closedir($descriptor);}
?>
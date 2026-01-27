<?php 
//Valor del formulario texto
$texto = $_POST['texto'];
echo 'Texto: '.$texto;

echo '<br><br>';

//Valor del formulario radio
$radio = $_POST['sexo'];
echo 'Radio: '.$radio;

echo '<br><br>';

//Valor del forulario oculto
$oculto = $_POST['oculto'];
echo 'Valor oculto: '.$oculto;

echo '<br><br>';

//Valor del formulario password
$password = $_POST['password'];
echo 'Password: '.$password;

echo '<br><br>';

//Valor del formulario select
$select= $_POST['color'];
echo 'Opcion seleccionada: '.$select;

echo '<br><br>';

//Valor del formulario checkbox
$extra = $_POST['extra'];
echo "Valor del checkbox: \n";
echo $extra;


echo '<br><br>';

//Valor del formulario multicheckbox
echo "Valor del multi checkbox: <br><br> \n";
$extras = $_POST['extras'];
foreach ($extras as $extra)
echo "$extra<BR>\n";

echo'<br><br>';

//Valor del formulario multiselect
echo "Valor del multiselect: \n";
If ( ! empty($_POST['idiomas'])){
$idiomas = $_POST['idiomas'];
foreach ($idiomas as $idioma)
    echo "$idioma<BR>\n";
}

echo'<br>';
//Valor del formulario TextArea
echo "Valor del textArea: \n";
$comentario = $_POST['comentario'];
echo $comentario;
?>
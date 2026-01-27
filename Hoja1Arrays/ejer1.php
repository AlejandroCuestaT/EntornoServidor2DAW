<?php 
$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

foreach ($dias as $key => $value) {
    echo 'Clave: '.$key.' Valor: '.$value.' <br>';
}

echo '<br><br>';

for($i = 0; $i < count($dias); $i++){
    echo 'Dia: '.($i + 1).' Valor: '.$dias[$i].' <br>';
}
?>
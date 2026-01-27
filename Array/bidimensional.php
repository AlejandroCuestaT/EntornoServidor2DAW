<?php 
$col = array(
    'calidos' => array('rojo', 'naranja', 'amarillo'),
    'frios' => array('azul', 'gris','morado', 'verde'),
    'neutro' => array('beige', 'blanco','rosa')
);
$junto = array();

//junto todos los elementos en un unico array
foreach ($col as $clave => $valor) {
    foreach ($valor as $clave1 => $valor1) {
        $junto[] = $valor1;
    }
}

//ordeno los elementos ahora que ya estan todos juntos
sort($junto);

print_r($junto);
?>
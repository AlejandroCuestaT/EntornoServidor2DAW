<HTML>
<?php

//Comillas simples ['] solo si va a ser texto puro, a la hora de añadir \ o variable $ 
// hace falta comillas dobles ["]
print("Párrafo 1\n");
print('Párrafo 2');
$nombre = "Alex";
print("<br> Mi nombre es $nombre <br>");

//Este comando es para escribir en varias lineas de codigo el mismo texto
$cadenaCompuesta = <<< aa
    ---------------------- <br>
    cadena 1 <br>
    cadena 2 <br>
    ---------------------- <br>
aa;

echo $cadenaCompuesta;
print("<br>");

//print_r sirve para leer arrays
//print_r($_SERVER);

//print_r($_REQUEST);

$num1 = 1;
$cadena2 = "2 Alex";

//Aunque el 2 este en una cadena es de tipo numerico, lo detecta y se lo suma al 1
//print($num1+$cadena2);

//Concatena las dos variables, el punto sirve para concatenar texto
//print($cadena2.$num1);

//con && se puede recoger el nombre de la variable para hacer una variable con ella
/**
* $var = "_flor";
* $$var = "dos";
*
* print($var."<br>");
* print($_flor."<br>");
*/

//ejemplo practico &&
/**
 * $mensaje_es = "Hola";
 * $mensaje_en = "Hello";
 * 
 * $idioma = "en";
 * $mensaje = "mensaje_" . $idioma;
 * print($$mensaje);
 */


function PruebaSinGlobal(){

    $var++;
    echo "Prueba sin global. \$var: ".$var."<br>";
}

function PruebaConGlobal($var){
    //global $var;
    $var++;
    echo "Prueba con global. \$var: ".$var."<br>";
}

function PruebaConGlobals(){
    $GLOBALS["var"]++;
    echo "Prueba con globals. \$var: ".$GLOBALS["var"]."<br>";
}

function PruebaConReturn($var){
    $var++;
    echo "Prueba con return. \$var: ".$var."<br>";
    return $var;
}
    $var = 20;
    PruebaSinGlobal();
    echo "Prueba sin global fuera de funcion ".$var."<br><br>";

    PruebaConGlobal($var);
    echo "Prueba con global fuera de funcion ".$var."<br><br>";

    PruebaConGlobals();
    echo "Prueba con globals fuera de funcion ".$var."<br><br>";

    $var = PruebaConReturn($var);
    echo "Prueba con return ".$var."<br><br>";

    //Las constantes definidas van sin el $
    define("PI", 3.1416);
    print(PI);

    //operacion ternaria
    echo "<br>";
    $t1 = 3;
    $t2 = 1;
    echo (($t1 % $t2) == 0)? 'yess': 'nopp';
    echo "<br>";
    echo "<br>";

    //Poner & en cont hace que aunque se llame diferente, se refiere 
    //al valor que viene, lo cual cambia el valor de manera global
    function incrementaContador(&$cont){
        $cont++;
        echo "Valor cont: ".$cont."<br>";
    }

    $contador = 20;
    incrementaContador($contador);
    echo "valor contador: ".$contador."<br>";

    echo "<br>";
    $provincias = ["madrid", "valencia", "cordoba", "malaga"];
    foreach($provincias as $valor){
        echo $valor."<br>";
    }

    echo "<br>";
    $provincias2['Toledo'] = 500000;
    $provincias2['CR'] = 60000;
    $provincias2['Albacete'] = 60000;
    $provincias2['Cuenca'] = 60000;
    $provincias2['Guadalajara'] = 60000;
    foreach($provincias2 as $indice => $valor){
        echo $indice;
        echo $valor;
        echo "<br>";
    }
        
    print_r($provincias);

?>
</HTML>

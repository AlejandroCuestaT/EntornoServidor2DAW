<HTML>
    <BODY>
        <?php
        /**
         * Muestra la lista idiomas y al llegar al tercer elemento que el valor
         * es un array vuelve a imprimir ese array
         */

        //Array bidimensional solo en la posicion 3
        $idiomas = array(
                     'Alejandro'=>'Ingles',
                     'David R'=>'Frances', 
                     'David Romo'=>array('Ingles', 'Frances', 'Aleman'),
                     'Roy'=>'Aleman'
                    );
                    //print_r($idiomas);
                    echo '<br>';
        //Borro el idioma frances del array bidimensional David Romo
        unset($idiomas['David Romo'][1]);

        //Imprimo la primera dimension normal
        foreach($idiomas as $clave=>$valor){
            //Mira si el valor es un array mas, si lo es imprime otro array 
            if(is_array($valor)){
                echo 'El alumno '.$clave.' habla: ';
                echo '<ul>';
                foreach($valor as $clave1=>$valor1){
                   echo '<li>'.$valor1.'</li> ';
                };
                echo '</ul>';
                echo '<br>';
            //Si no es se imprime normal    
            }else{
                echo 'El alumno '.$clave.' habla '.$valor.'<br>';
            }
        }
        ?>
    </BODY>
</HTML>
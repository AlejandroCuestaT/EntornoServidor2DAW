<HTML>
    <BODY>
        <?php 
        //Al inicializar vacio siempre con parentsis
        $idiomas = array();
        //Esto funciona pero no es buena practica
        $malaPractica = ['a', 'b','c'];
        //Siempre inicializar con array
        $buenaPractica = array('a','b','c');
        foreach($malaPractica as $valor){
            echo $valor.' ';
        }

        echo '<br>';

        //Eliminacion de la variable
        unset($malaPractica[1]);

        foreach($malaPractica as $valor){
            echo $valor.' ';
        }


        $valor = 2;
        $idiomas2[] = $valor;

        ?>
    </BODY>
</HTML>
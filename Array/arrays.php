<HTML>
    <?php 
    $provincias = ["madrid", "valencia", "cordoba", "malaga"];
    foreach($provincias as $valor){
        echo $valor."<br>";
    }

    echo "<br>";
    $provincias2['Toledo'] = 500000;
    $provincias2['CR'] = 60000;
    $provincias2['Albacete'] = 20000;
    $provincias2['Cuenca'] = 70000;
    $provincias2['Guadalajara'] = 950000;
    foreach($provincias2 as $indice => $valor){
        echo $indice." ";
        echo $valor;
        echo "<br>";
    }
        
    print_r($provincias);
    
    ?>
</HTML>


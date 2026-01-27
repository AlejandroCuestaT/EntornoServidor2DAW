<HTML>
<HEAD>
<!-- 
CSS muy simple para dar un poco de color
-->
    <STYLE>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        
        
        th {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-weight: bold;
        }
        
        .pais-titulo {
            color: #2c3e50;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0 5px 0;
        }
    </STYLE>
</HEAD>

<BODY>
    <?php
    //Array Tridimensional con paises, ciudades+ y ext con hab
    $paises = array(
        'España' => array(
            'Toledo' => array(
                'Extension' => 100000,
                'Habitantes' => 70000
            ),
            'Madrid' => array(
                'Extension' => 150000,
                'Habitantes' => 800000
            )
        ),
        'Alemania' => array(
            'Berlin' => array(
                'Extension' => 5570,
                'Habitantes' => 7842
            ),
            'Duseldorf' => array(
                'Extension' => 5470,
                'Habitantes' => 7962
            )
        ),
        'Austria' => array(
            'Viena' => array(
                'Extension' => 8384,
                'Habitantes' => 7614
            )
        )
    );
    ?>

    <br> <br>

    <?php
    foreach ($paises as $pais => $ciudades) {
        echo '<div class="pais-titulo">' . $pais . ':</div>';
        echo "<TABLE>";
        echo "<TR>";
        echo '<TH>CIUDAD</TH>';
        echo '<TH>EXTENSION</TH>';
        echo '<TH>HABITANTES</TH>';
        echo "</TR>";
        foreach ($ciudades as $ciudad => $datos) {
            echo "<TR>";
            echo '<TD>' . $ciudad . '</TD>';
            echo '<TD>' . $datos['Extension'] . '</TD>';
            echo '<TD>' . $datos['Habitantes'] . '</TD>';
            echo "</TR>";
        }
        echo "</TABLE>";
    }
    ?>

    <br> <br>
</BODY>
</HTML>
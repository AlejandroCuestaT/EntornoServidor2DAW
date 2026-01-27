<html>

<head>
    <style>
        h1 {
            margin-top: 20px;
            color: blue;
            text-align: center;

        }

        .linea {
            margin-top: 20px;
            border-bottom: 10px solid blue;
        }

        h3 {
            color: blue;
            text-align: center;
            margin-top: 20px;
        }

        table {
            margin-top: 30px;
            margin-left: 10%;
            margin-right: 10%;
            width: 80%;
            color: blue;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>SISTEMA DE INSCRIPCION A OFERTAS DE TRABAJO</h1>
    <h1 class="linea"></h1>
    <h3>Ofertas activas</h3>

    <table>
        <tr>
            <th>EMPRESA</th>
            <th>Oferta</th>
            <th>Categoria</th>
            <th>Fecha Publicacion</th>
        </tr>

        
            <?php
            $fichero = fopen('../TXT/Ofertas.txt', 'r');

            if (!$fichero)
                //Te da error y termina el programa si no existe el fichero en esa ruta
                die("ERROR: no se ha podido abrir el fichero de datos");

                
            while (!feof($fichero)) {
                echo'<tr>';
                $linea = fgets($fichero);
                $palabras = explode('\t', $linea);
                foreach($palabras as $palabra){
                    echo '<th>'.$palabra . '</th>';
                }
                echo'</tr>';
                
                
            }

            fclose($fichero);

            ?>
        



    </table>
</body>

</html>
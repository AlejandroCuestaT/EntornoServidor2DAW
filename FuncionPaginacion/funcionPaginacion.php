<?php

    //Recoge la conexion y la query y decuelve un array con el limite puesto, el numero total de filas de la query,
    //la pagina actual y el numero de paginas que hay redondeado para arriba
    function paginacion($conn, $query){
        //Query para contar las lineas que hay con el filtro
        $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM ($query) as t"))['total'];
        $limit = 5;
        //Mira por get la pagina que ha clicado, si es la primera vez por defecto te pone 1
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; //Si hay pagina la recoge, si no se pone en 1

        $inicio = ($paginaActual - 1) * $limit;

        //Creacion de query con limit
        $queryLimit = $query . " LIMIT $inicio, $limit";

        //Query con limite
        $resultado = mysqli_query($conn, $queryLimit);

        //Devuelve Array con:
        //datos --> Resultado con el limite puesto
        //total --> El numero total de filas que tiene la query con los filtros
        //actual --> La pagina en la que se encuentra
        //paginas --> El numero de paginas que hay redondeado para arriba
        return[
            'datos' => $resultado,
            'total' => $total,
            'actual'  => $paginaActual,
            'paginas' => ceil($total / $limit) //Redondea para arriba las paginas que hay
        ];

    }

    //Pinta dinamicamente tanto la lista que necesitemos como la navegacion con los botones
function pintarListadoCompleto($listaPaginaActual) {
    
    // Verificamos quehaya algun registro
    if ($listaPaginaActual['total'] == 0) {
        echo "<p>No se encontraron registros.</p>";
        return;
    }

    echo "<table>";
    echo "<thead>";
    
    // Variable para los titulos de la cabecera
    $primeraFila = mysqli_fetch_assoc($listaPaginaActual['datos']);

    if ($primeraFila) {
        echo "<tr>";
        //Pintamos la primera fila de nombres de la tabla
        foreach (array_keys($primeraFila) as $columna) {
            echo "<th>" . $columna . "</th>";
        }
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        echo "<tr>";
        foreach ($primeraFila as $valor) {
            echo "<td>" . $valor . "</td>";
        }
        echo "</tr>";

        //Pintamos los valores del array devuelto de funcionPaginacion con el limite de filas
        while ($fila = mysqli_fetch_assoc($listaPaginaActual['datos'])) {
            echo "<tr>";
            foreach ($fila as $celda) {
                echo "<td>" . $celda . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
    }
    echo "</table>";


    
    //Pintamos la paginacion con botones debajo de la lista
    echo "<div class='paginacion' style='margin-top: 20px;'>";

    //Boton anterior para ir a la pagina anterior, si es la primera se desactiva para que no cliques
    if ($listaPaginaActual['actual'] > 1) {
        $prev = $listaPaginaActual['actual'] - 1;
        echo "<a href='?pagina=$prev'> << Anterior </a> ";
    } else {
        echo "<span style='color:gray'> << Anterior </span> ";
    }

    //Los botones entre anterior y siguiente, son 5 y el actual en el medio
    $maxBotones = 10; 
    $mitad = floor($maxBotones / 2);


    $inicioRango = $listaPaginaActual['actual'] - $mitad;
    $finRango = $listaPaginaActual['actual'] + $mitad;

    //Si estamos en las primeras paginas que no aparezca la activa en el medio
    if ($inicioRango < 1) {
        $inicioRango = 1;
        $finRango = min($maxBotones, $listaPaginaActual['paginas']);
    }

    //Igual pero al final
    if ($finRango > $listaPaginaActual['paginas']) {
        $finRango = $listaPaginaActual['paginas'];
        $inicioRango = max(1, $listaPaginaActual['paginas'] - $maxBotones + 1);
    }

    // Imprimimos solo los números calculados en el rango
    for ($i = $inicioRango; $i <= $finRango; $i++) {
        if ($i == $listaPaginaActual['actual']) {
            echo "<strong> $i </strong> "; 
        } else {
            echo "<a href='?pagina=$i'> $i </a> ";
        }
    }

        //Boton siguiente para ir a la pagina siguiente, si es la ultima se desactiva para que no cliques
        if ($listaPaginaActual['actual'] < $listaPaginaActual['paginas']) {
            $next = $listaPaginaActual['actual'] + 1;
            echo " <a href='?pagina=$next'> Siguiente >> </a>";
        } else {
            echo " <span style='color:gray'> Siguiente >> </span>";
        }

        echo "</div>";
    }
?>
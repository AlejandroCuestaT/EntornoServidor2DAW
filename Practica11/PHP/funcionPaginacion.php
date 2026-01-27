<?php

    /**
     * Recoge la conexion y la query y devuelve un array con:
     * el limite puesto, el numero total de filas de la query,
     * la pagina actual y el numero de paginas que hay redondeado para arriba.
     */
    function paginacion($conn, $query){
        // Query para contar las lineas que hay en total (con filtros aplicados si los hay)
        $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM ($query) as t"))['total'];
        
        // Establecemos el límite de registros por página
        $limit = 5;
        
        // Mira por GET la pagina que ha clicado, si es la primera vez por defecto pone 1
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; 

        // Calculamos el registro de inicio para la cláusula LIMIT de SQL
        $inicio = ($paginaActual - 1) * $limit;

        // Creacion de query final concatenando el LIMIT
        $queryLimit = $query . " LIMIT $inicio, $limit";

        // Ejecutamos la query con el limite de registros
        $resultado = mysqli_query($conn, $queryLimit);

        // Devuelve Array con los datos de control necesarios para la vista
        return [
            'datos'   => $resultado,             // Resultado de la DB con el limite puesto
            'total'   => $total,                 // Numero total de filas sin paginar
            'actual'  => $paginaActual,          // Pagina en la que se encuentra el usuario
            'paginas' => ceil($total / $limit)   // Numero de paginas totales redondeado para arriba
        ];
    }

    /**
     * Pinta dinamicamente tanto la lista que necesitemos como la navegacion con los botones.
     * Admite un parametro opcional para añadir una columna de "Borrar".
     */
    function pintarListadoCompleto($listaPaginaActual, $archivoBorrar = null) {
        
        // Verificamos que haya algun registro en la consulta
        if ($listaPaginaActual['total'] == 0) {
            echo "<p>No se encontraron registros.</p>";
            return;
        }

        echo "<table>";
        echo "<thead>";
        
        // Extraemos la primera fila para generar los titulos de la cabecera automaticamente
        $fila = mysqli_fetch_assoc($listaPaginaActual['datos']);

        if ($fila) {
            echo "<tr>";
            // Pintamos la primera fila de nombres de columna de la tabla basándonos en las keys del array
            foreach (array_keys($fila) as $columna) {
                echo "<th>" . ucfirst($columna) . "</th>";
            }
            
            // Si hemos pasado un nombre de archivo, pintamos la cabecera extra para la accion
            if ($archivoBorrar) echo "<th>Borrar</th>";
            
            echo "</tr>";
            echo "</thead>";

            echo "<tbody>";
            
            // Usamos do-while para no perder la primera fila que ya extrajimos para las cabeceras
            do {
                echo "<tr>";
                // Pintamos los valores de cada celda
                foreach ($fila as $celda) {
                    echo "<td>" . ($celda === null ? "(S/N)" : $celda) . "</td>";
                }

                // Si hay archivo de borrar, creamos dinamicamente el enlace usando la columna 'id'
                if ($archivoBorrar) {
                    echo "<td>";
                    echo "<a href='$archivoBorrar?id=" . $fila['id'] . "'>Borrar</a>";
                    echo "</td>";
                }
                echo "</tr>";
            } while ($fila = mysqli_fetch_assoc($listaPaginaActual['datos']));
            
            echo "</tbody>";
        }
        echo "</table>";

        

        //Pintamos la paginacion con botones debajo de la lista
        echo "<div class='paginacion' style='margin-top: 20px;'>";

        // Boton anterior: si es la primera pagina se desactiva visualmente
        if ($listaPaginaActual['actual'] > 1) {
            $prev = $listaPaginaActual['actual'] - 1;
            echo "<a href='?pagina=$prev'> << Anterior </a> ";
        } else {
            echo "<span style='color:gray'> << Anterior </span> ";
        }

        // Calculo del rango de botones numericos (maximo 10 botones visibles)
        $maxBotones = 10; 
        $mitad = floor($maxBotones / 2);

        $inicioRango = max(1, $listaPaginaActual['actual'] - $mitad);
        $finRango = min($listaPaginaActual['paginas'], $inicioRango + $maxBotones - 1);

        // Ajuste para que siempre se vean 10 botones si hay suficientes paginas
        if ($finRango - $inicioRango + 1 < $maxBotones) {
            $inicioRango = max(1, $finRango - $maxBotones + 1);
        }

        // Imprimimos los números calculados en el rango
        for ($i = $inicioRango; $i <= $finRango; $i++) {
            if ($i == $listaPaginaActual['actual']) {
                echo "<strong> $i </strong> "; // Pagina actual en negrita
            } else {
                echo "<a href='?pagina=$i'> $i </a> ";
            }
        }

        // Boton siguiente: si es la ultima pagina se desactiva
        if ($listaPaginaActual['actual'] < $listaPaginaActual['paginas']) {
            $next = $listaPaginaActual['actual'] + 1;
            echo " <a href='?pagina=$next'> Siguiente >> </a>";
        } else {
            echo " <span style='color:gray'> Siguiente >> </span>";
        }

        echo "</div>";
    }
?>
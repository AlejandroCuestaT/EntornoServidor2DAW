<?php

function paginacion($conn, $query) {
    // Contar total de registros
    $total = $conn->query("SELECT COUNT(*) as total FROM ($query) as t")->fetch(PDO::FETCH_ASSOC)['total'];
    $limit = 5;
    
    // Página actual
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $inicio = ($paginaActual - 1) * $limit;

    // Consulta con límite
    $queryLimit = $query . " LIMIT $inicio, $limit";
    $resultado = $conn->query($queryLimit);

    return [
        'datos' => $resultado,
        'total' => $total,
        'actual'  => $paginaActual,
        'paginas' => ceil($total / $limit)
    ];
}

function pintarListadoCompleto($listaPaginaActual) {
    
    if ($listaPaginaActual['total'] == 0) {
        echo "<p>No se encontraron registros.</p>";
        return;
    }

    echo "<table>";
    echo "<thead>";
    
    // Obtenemos la primera fila para los encabezados
    $primeraFila = $listaPaginaActual['datos']->fetch(PDO::FETCH_ASSOC);

    if ($primeraFila) {
        echo "<tr>";
        foreach (array_keys($primeraFila) as $columna) {
            echo "<th>" . htmlspecialchars($columna) . "</th>";
        }
        echo "<th>Acciones</th>"; 
        echo "</tr>";
        echo "</thead><tbody>";

        // Función para imprimir cada fila (incluye el formulario de borrado)
        function imprimirFila($fila) {
            echo "<tr>";
            foreach ($fila as $celda) {
                echo "<td>" . htmlspecialchars($celda) . "</td>";
            }
            
            $usuarioIdentificador = isset($fila['hora']) ? $fila['hora'] : '';

            echo "<td>
                    <form action='borrar.php' method='POST' onsubmit='return confirm(\"¿Seguro que quieres borrar al usuario " . htmlspecialchars($usuarioIdentificador) . "?\");' style='margin:0;'>
                        <input type='hidden' name='user_borrar' value='" . htmlspecialchars($usuarioIdentificador) . "'>
                        <button type='submit' style='background:#ff4d4d; color:white; border:none; padding:4px 7px; cursor:pointer; border-radius:3px; font-size:12px;'>Borrar</button>
                    </form>
                  </td>";
            echo "</tr>";
        }

        // Pintamos la primera fila
        imprimirFila($primeraFila);
        
        // Pintamos el resto de filas
        while ($fila = $listaPaginaActual['datos']->fetch(PDO::FETCH_ASSOC)) {
            imprimirFila($fila);
        }
        echo "</tbody>";
    }
    echo "</table>";

    echo "<div class='paginacion' style='margin-top: 20px;'>";

    // Botón Anterior
    if ($listaPaginaActual['actual'] > 1) {
        $prev = $listaPaginaActual['actual'] - 1;
        echo "<a href='?pagina=$prev'> << Anterior </a> ";
    } else {
        echo "<span style='color:gray'> << Anterior </span> ";
    }

    // Lógica para limitar a 10 botones
    $maxBotones = 10; 
    $mitad = floor($maxBotones / 2);

    $inicioRango = $listaPaginaActual['actual'] - $mitad;
    $finRango = $listaPaginaActual['actual'] + $mitad;

    if ($inicioRango < 1) {
        $inicioRango = 1;
        $finRango = min($maxBotones, $listaPaginaActual['paginas']);
    }

    if ($finRango > $listaPaginaActual['paginas']) {
        $finRango = $listaPaginaActual['paginas'];
        $inicioRango = max(1, $listaPaginaActual['paginas'] - $maxBotones + 1);
    }

    // Imprimir números de página según el rango calculado
    for ($i = $inicioRango; $i <= $finRango; $i++) {
        if ($i == $listaPaginaActual['actual']) {
            echo "<strong> $i </strong> "; 
        } else {
            echo "<a href='?pagina=$i'> $i </a> ";
        }
    }

    // Botón Siguiente
    if ($listaPaginaActual['actual'] < $listaPaginaActual['paginas']) {
        $next = $listaPaginaActual['actual'] + 1;
        echo " <a href='?pagina=$next'> Siguiente >> </a>";
    } else {
        echo " <span style='color:gray'> Siguiente >> </span>";
    }

    echo "</div>";
}
?>
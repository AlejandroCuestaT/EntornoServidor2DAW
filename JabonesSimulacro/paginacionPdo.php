<?php
// paginacionPdo.php

// Recoge la conexion y la query y devuelve un array con el limite puesto, el numero total de filas de la query,
// la pagina actual y el numero de paginas que hay redondeado para arriba
function paginacion($conn, $query){
    // Query para contar las lineas que hay con el filtro
    // En PDO usamos ->query() para ejecutar y ->fetch() para obtener el resultado
    $total = $conn->query("SELECT COUNT(*) as total FROM ($query) as t")->fetch(PDO::FETCH_ASSOC)['total'];
    
    // CAMBIO DE ENUNCIADO: La práctica de jabones exige de 2 en 2
    $limit = 2; 
    
    // Mira por get la pagina que ha clicado, si es la primera vez por defecto te pone 1
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; // Si hay pagina la recoge, si no se pone en 1

    $inicio = ($paginaActual - 1) * $limit;

    // Creacion de query con limit
    $queryLimit = $query . " LIMIT $inicio, $limit";

    // Query con limite
    $resultado = $conn->query($queryLimit);

    // Devuelve Array con todos tus datos estructurados
    return [
        'datos'   => $resultado,
        'total'   => $total,
        'actual'  => $paginaActual,
        'paginas' => ceil($total / $limit)
    ];
}
?>
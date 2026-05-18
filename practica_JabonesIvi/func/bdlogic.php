<?php

function conexionBBDD()
{
    $host = 'localhost';
    $db = 'tienda_online';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';
    $dns = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $pdo = new PDO($dns, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexion: " . $e->getMessage());
    }
}

// ============================================
// FUNCIONES DE PAGINACIÓN
// ============================================


function obtenerTotalRegistros($tabla, $condiciones = [])
{
    $pdo = conexionBBDD();

    $sql = "SELECT COUNT(*) as total FROM $tabla";
    $valores = [];

    // Si hay condiciones, las añadimos
    if (!empty($condiciones)) {
        $where = [];
        foreach ($condiciones as $columna => $valor) {
            $where[] = "$columna = ?";
            $valores[] = $valor;
        }
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($valores);
    $resultado = $stmt->fetch();

    return (int) $resultado['total'];
}

function obtenerDatosPaginados($tabla, $pagina = 1, $registrosPorPagina = 10, $condiciones = [], $columnas = "*", $ordenar = "")
{
    $pdo = conexionBBDD();

    // Validar que la página sea mayor a 0
    $pagina = max(1, (int) $pagina);

    // Calcular el OFFSET (desde qué registro empezamos)
    $offset = ($pagina - 1) * $registrosPorPagina;

    // Construir la consulta
    $sql = "SELECT $columnas FROM $tabla";
    $valores = [];

    // Añadir condiciones WHERE si existen
    if (!empty($condiciones)) {
        $where = [];
        foreach ($condiciones as $columna => $valor) {
            $where[] = "$columna = ?";
            $valores[] = $valor;
        }
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    // Añadir ORDER BY si se especifica
    if (!empty($ordenar)) {
        $sql .= " ORDER BY $ordenar";
    }

    // Añadir LIMIT y OFFSET
    $sql .= " LIMIT ? OFFSET ?";
    $valores[] = $registrosPorPagina;
    $valores[] = $offset;

    // Ejecutar consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute($valores);
    $datos = $stmt->fetchAll();

    // Obtener total de registros
    $totalRegistros = obtenerTotalRegistros($tabla, $condiciones);
    $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

    return [
        'datos' => $datos,
        'pagina_actual' => $pagina,
        'total_paginas' => $totalPaginas,
        'total_registros' => $totalRegistros,
        'registros_por_pagina' => $registrosPorPagina,
        'tiene_anterior' => $pagina > 1,
        'tiene_siguiente' => $pagina < $totalPaginas
    ];
}


function generarNumerosPaginas($paginacion, $rango = 2)
{
    $pagina_actual = $paginacion['pagina_actual'];
    $total_paginas = $paginacion['total_paginas'];

    $inicio = max(1, $pagina_actual - $rango);
    $fin = min($total_paginas, $pagina_actual + $rango);

    $numeros = [];
    for ($i = $inicio; $i <= $fin; $i++) {
        $numeros[] = $i;
    }

    return $numeros;
}

// ============================================
// FUNCIONES DE VISUALIZACIÓN
// ============================================

function mostrarTabla($datos, $mostrarAcciones = false)
{
    if (count($datos) == 0) {
        echo "<p style='text-align: center; color: #666;'>No hay productos disponibles</p>";
        return;
    }

    $titulos = array_keys($datos[0]);

    echo "<table class='styled-table'>";
    echo "<thead><tr>";

    // Mostrar encabezados
    foreach ($titulos as $titulo) {
        echo "<th>" . htmlspecialchars($titulo) . "</th>";
    }

    if ($mostrarAcciones) {
        echo "<th>Acciones</th>";
    }

    echo "</tr></thead><tbody>";

    // Mostrar datos
    foreach ($datos as $fila) {
        echo "<tr>";

        foreach ($fila as $valor) {
            // Escapar para evitar XSS
            echo "<td>" . htmlspecialchars($valor) . "</td>";
        }

        if ($mostrarAcciones) {
            echo "<td>";
            echo "<a href='#' class='btn-editar'>Editar</a> ";
            echo "<a href='#' class='btn-eliminar'>Eliminar</a>";
            echo "</td>";
        }

        echo "</tr>";
    }

    echo "</tbody></table>";
}


function mostrarPaginacion($paginacion, $urlBase = "?", $paramPagina = "pagina")
{
    $pagina_actual = $paginacion['pagina_actual'];
    $total_paginas = $paginacion['total_paginas'];

    echo "<div class='pagination'>";

    // Botón anterior
    if ($paginacion['tiene_anterior']) {
        $pag_anterior = $pagina_actual - 1;
        echo "<a href='{$urlBase}{$paramPagina}={$pag_anterior}' class='btn-paginacion'>← Anterior</a>";
    } else {
        echo "<span class='btn-paginacion disabled'>← Anterior</span>";
    }

    // Números de página
    echo "<div class='numeros-pagina'>";

    // Mostrar página 1 si no está en el rango
    $numeros = generarNumerosPaginas($paginacion);
    if ($numeros[0] > 1) {
        echo "<a href='{$urlBase}{$paramPagina}=1' class='btn-numero'>1</a>";
        if ($numeros[0] > 2) {
            echo "<span class='puntos'>...</span>";
        }
    }

    // Mostrar números en rango
    foreach ($numeros as $num) {
        if ($num == $pagina_actual) {
            echo "<span class='btn-numero activo'>$num</span>";
        } else {
            echo "<a href='{$urlBase}{$paramPagina}={$num}' class='btn-numero'>$num</a>";
        }
    }

    // Mostrar última página si no está en el rango
    if ($numeros[count($numeros) - 1] < $total_paginas) {
        if ($numeros[count($numeros) - 1] < $total_paginas - 1) {
            echo "<span class='puntos'>...</span>";
        }
        echo "<a href='{$urlBase}{$paramPagina}={$total_paginas}' class='btn-numero'>{$total_paginas}</a>";
    }

    echo "</div>";

    // Botón siguiente
    if ($paginacion['tiene_siguiente']) {
        $pag_siguiente = $pagina_actual + 1;
        echo "<a href='{$urlBase}{$paramPagina}={$pag_siguiente}' class='btn-paginacion'>Siguiente →</a>";
    } else {
        echo "<span class='btn-paginacion disabled'>Siguiente →</span>";
    }

    echo "</div>";

    // Información de página actual
    echo "<p style='text-align: center; color: #666; margin-top: 15px;'>";
    echo "Página {$pagina_actual} de {$total_paginas} | Total: {$paginacion['total_registros']} registros";
    echo "</p>";
}


function mostrarTablaOriginal($informacionBD)
{
    if (count($informacionBD) == 0) {
        return null;
    }
    $titulos = array_keys($informacionBD[0]);
    if (count($titulos) > 0) {
        echo ("<table class='styled-table'>");
        echo ("<thead><tr>");
        for ($i = 0; $i < count($titulos); $i++) {
            echo ("<td>" . $titulos[$i] . "</td>");
        }
        echo ("</tr></thead><tbody>");
        foreach ($informacionBD as $key => $value) {
            echo ("<tr>");
            if (is_array($value)) {
                foreach ($value as $key1 => $value1) {
                    echo ("<td>$value1</td>");
                }
            } else {
                echo ("<td>$value</td>");
            }
            echo ("</tr>");
        }
        echo ("<tbody></table>");
    }
}

function insertarDatos($tabla, $datos)
{
    $pdo = conexionBBDD();

    $columnas = implode(", ", array_keys($datos));
    $placeholders = implode(", ", array_fill(0, count($datos), "?"));

    $valoresEjecucion = [];
    foreach ($datos as $dato) {
        if (is_bool($dato)) {
            $valoresEjecucion[] = $dato ? 1 : 0;
        } else {
            $valoresEjecucion[] = $dato;
        }
    }

    try {
        $sql = "INSERT INTO $tabla ($columnas) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($valoresEjecucion);
        return true;
    } catch (PDOException $e) {
        throw new Exception("Error SQL: " . $e->getMessage());
    }
}

function obtenerDatos($tabla, $condiciones = [], $columnas = "*")
{
    $pdo = conexionBBDD();

    $sql = "SELECT $columnas FROM $tabla";

    $valores = [];

    if (!empty($condiciones)) {
        $where = [];
        foreach ($condiciones as $columna => $valor) {
            $where[] = "$columna = ?";
            $valores[] = $valor;
        }
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($valores);

    return $stmt;
}

function borrarDatos($tabla, $condiciones)
{
    $pdo = conexionBBDD();

    $where = [];
    $valores = [];

    foreach ($condiciones as $columna => $valor) {
        $where[] = "$columna = ?";
        $valores[] = $valor;
    }

    $sql = "DELETE FROM $tabla WHERE " . implode(" AND ", $where);

    $stmt = $pdo->prepare($sql);
    $stmt->execute($valores);

    return $stmt->rowCount();
}

function vista($tabla, $datos)
{
    try {
        $vista = obtenerDatos($tabla, [], $datos);
        mostrarTabla($vista->fetchAll());
    } catch (PDOException $pdoe) {
        echo $pdoe->getMessage();
    }
}

?>
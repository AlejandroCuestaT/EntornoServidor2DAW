<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Repaso Ficheros y Fechas</title>
    <style>
        body {
            font-family: monospace;
            line-height: 1.6;
            background: #f0f2f5;
            padding: 20px;
        }

        .bloque {
            background: white;
            padding: 15px;
            border-left: 5px solid #28a745;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .codigo {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 10px;
            border-radius: 5px;
            display: block;
            white-space: pre-wrap;
            margin: 10px 0;
        }

        .nota {
            color: #d63384;
            font-weight: bold;
            background: #fff0f6;
            padding: 2px 5px;
            border-radius: 4px;
        }

        .output {
            color: #004085;
            background-color: #cce5ff;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #b8daff;
        }
    </style>
</head>

<body>
    <h1>CHULETA: FICHEROS, HEADER Y DATETIME</h1>

    <?php

    /* ==========================================================================
       SECCIÓN 1: FICHEROS (LECTURA Y ESCRITURA)
       Basado en la lógica de 'infractores.php' y 'permiso.php'.
       ========================================================================== */

    echo "<div class='bloque'><h2>1. MANEJO DE FICHEROS</h2>";

    // 1.1 ESCRITURA (Guardar datos)
// --------------------------------------------------------------------------
    $ruta = "mi_examen_test.txt";
    $datosGuardar = "1234-ABC Juan Madrid\n"; // \n es vital para el salto de línea
    
    // Modo 'a' (Append): Añade al final. Si usas 'w', BORRAS lo anterior.
    $flujo = fopen($ruta, 'a');
    if ($flujo) {
        fputs($flujo, $datosGuardar);
        fputs($flujo, "5678-DEF Ana Barcelona\n");
        fclose($flujo); // ¡SIEMPRE CERRAR!
        echo "<p>✅ Datos escritos correctamente en <code>$ruta</code>.</p>";
    } else {
        echo "<p>❌ Error al abrir el fichero.</p>";
    }

    // 1.2 LECTURA CLÁSICA (Línea a línea) -> La más segura para exámenes
// --------------------------------------------------------------------------
    echo "<h3>Lectura con while (!feof) - El método clásico:</h3>";
    echo "<div class='output'>";

    if (file_exists($ruta)) { // Buena práctica: comprobar si existe
        $lector = fopen($ruta, 'r'); // Modo 'r' (Read)
    
        // feof devuelve true cuando llega al final (End Of File)
        while (!feof($lector)) {
            $linea = fgets($lector); // Lee una línea entera
    
            // IMPORTANTE: fgets lee el salto de línea, trim lo quita.
            // Si no haces trim, al comparar strings te fallará.
            $lineaLimpia = trim($linea);

            if (!empty($lineaLimpia)) { // Evita procesar líneas vacías finales
                echo "Leído: " . htmlspecialchars($lineaLimpia) . "<br>";

                // Aquí harías el explode como en tu práctica:
                // $datos = explode(" ", $lineaLimpia);
            }
        }
        fclose($lector);
    }
    echo "</div>";

    // 1.3 LECTURA RÁPIDA (Todo a un array)
// --------------------------------------------------------------------------
    echo "<h3>Lectura rápida con file():</h3>";
    // Esta función abre, lee todo, mete cada línea en un array y cierra.
// El flag FILE_IGNORE_NEW_LINES hace el trim automáticamente.
    $arrayRapido = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    echo "<div class='codigo'>\$arrayRapido = file('$ruta', FILE_IGNORE_NEW_LINES);</div>";
    echo "<p>Elementos leídos: <strong>" . count($arrayRapido) . "</strong></p>";
    echo "<span class='nota'>NOTA: Usa file() si el fichero es pequeño. Usa fopen/while si es gigante o el profesor pide control manual.</span>";

    echo "</div>";


    /* ==========================================================================
       SECCIÓN 2: CABECERAS (HEADER)
       Para redirecciones y descargas.
       ========================================================================== */

    echo "<div class='bloque'><h2>2. CABECERAS (HEADER)</h2>";
    echo "<p>Las cabeceras deben enviarse <strong>ANTES</strong> de cualquier HTML o echo.</p>";

    // Ejemplo de Redirección (Comentado para que no se ejecute ahora)
    ?>
    <div class='codigo'>
        // Redirigir a otra página (Ej: tras login correcto)
        header("Location: menu.html");
        exit(); // SIEMPRE pon exit después de un header location.

        // Forzar descarga de un archivo (Ej: PDF generado)
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename='permiso.pdf'");
    </div>
    <?php
    echo "<span class='nota'>IMPORTANTE: Si hay un espacio en blanco antes de &lt;?php, el header fallará.</span>";
    echo "</div>";


    /* ==========================================================================
       SECCIÓN 3: FECHAS (CLASE DATETIME)
       La forma moderna y orientada a objetos que usas en tus prácticas.
       ========================================================================== */

    echo "<div class='bloque'><h2>3. FECHAS (Objeto DateTime)</h2>";

    // 3.1 CREACIÓN Y FORMATO
// --------------------------------------------------------------------------
// Fecha actual
    $hoy = new DateTime();
    // Fecha específica (formato inglés Y-m-d o español d-m-Y suele funcionar, pero cuidado)
    $inicioPermiso = new DateTime("2023-10-22 10:30");

    echo "<p>Fecha formateada (d/m/Y H:i): <strong>" . $inicioPermiso->format('d/m/Y H:i') . "</strong></p>";


    // 3.2 COMPARACIÓN (Mayor/Menor)
// --------------------------------------------------------------------------
// En 'infractores.php' usas esto para ver si entra en horario de logística [cite: 5]
    $horaEntrada = new DateTime("09:00");
    $limiteInicio = new DateTime("06:00");
    $limiteFin = new DateTime("11:00");

    echo "<h3>Comparación de Horas:</h3>";
    echo "Entrada: 09:00. Horario permitido: 06:00 - 11:00.<br>";

    if ($horaEntrada >= $limiteInicio && $horaEntrada <= $limiteFin) {
        echo "<span style='color:green; font-weight:bold;'>✅ DENTRO DE HORARIO (Permitido)</span><br>";
    } else {
        echo "<span style='color:red; font-weight:bold;'>❌ FUERA DE HORARIO (Multa)</span><br>";
    }


    // 3.3 DIFERENCIAS (DateInterval)
// --------------------------------------------------------------------------
    // En 'permiso.php' usas esto para validar 1 año o 1 mes [cite: 5]
    $fechaInicio = new DateTime("2023-01-01");
    $fechaFin = new DateTime("2024-03-15");

    // diff devuelve un objeto DateInterval
    $intervalo = $fechaInicio->diff($fechaFin);

    echo "<h3>Cálculo de Intervalos (diff):</h3>";
    echo "<div class='output'>";
    echo "Diferencia entre " . $fechaInicio->format('Y-m-d') . " y " . $fechaFin->format('Y-m-d') . ":<br>";
    echo "<ul>";
    echo "<li>Años completos (\$intervalo->y): <strong>" . $intervalo->y . "</strong></li>";
    echo "<li>Meses sueltos (\$intervalo->m): <strong>" . $intervalo->m . "</strong></li>";
    echo "<li>Días sueltos (\$intervalo->d): <strong>" . $intervalo->d . "</strong></li>";
    echo "<li>Total de días (\$intervalo->days): <strong>" . $intervalo->days . "</strong></li>";
    echo "</ul>";
    echo "</div>";

    // Lógica de tu práctica explicada:
    echo "<div class='codigo'>
// Ejemplo validación residente (NO más de 1 año):
if (\$intervalo->y >= 1) {
    \$errores[] = 'Excede el límite de 1 año';
}
</div>";

    echo "</div>";

    // Limpieza del fichero de prueba
// unlink($ruta); 
    ?>

</body>

</html>
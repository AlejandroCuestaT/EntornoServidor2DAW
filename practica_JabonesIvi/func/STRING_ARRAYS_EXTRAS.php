<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen Maestro PHP</title>
    <style>
        body { font-family: monospace; line-height: 1.6; background: #f4f4f4; padding: 20px; }
        .bloque { background: white; padding: 15px; border-left: 5px solid #007bff; margin-bottom: 20px; }
        h2 { color: #333; border-bottom: 1px solid #ccc; }
        .nota { color: #d63384; font-weight: bold; } /* Color para apuntes clave */
        .output { color: green; font-style: italic; }
    </style>
</head>
<body>
    <h1>CHULETA DE FUNCIONES PHP (Strings y Arrays)</h1>
    <p>Este script resume las funciones vitales para el examen.</p>

<?php

/* ==========================================================================
   SECCIÓN 1: STRINGS (MANIPULACIÓN DE TEXTO)
   Fundamental para leer ficheros .txt y limpiar datos de formularios.
   ========================================================================== */

echo "<div class='bloque'><h2>1. STRINGS (Cadenas)</h2>";

// --- 1.1 EXPLODE (El más importante para ti) ---
// Convierte un String en un Array usando un separador.
// Lo usas en 'infractores.php' para separar matrícula, nombre, etc.
$lineaFichero = "1234-ABC Juan_Garcia C/Goya,123";
$datos = explode(" ", $lineaFichero); 

echo "<strong>explode():</strong> De texto a array.<br>";
echo "Original: $lineaFichero <br>";
echo "Resultado [0]: " . $datos[0] . " (Matrícula)<br>";
echo "<span class='nota'>NOTA: Vital para leer CSV o TXT delimitados.</span><br><br>";


// --- 1.2 TRIM ---
// Elimina espacios en blanco y saltos de línea (\n) del principio y final.
// IMPRESCINDIBLE al leer con fgets(), si no, el \n te romperá las comparaciones.
$inputUsuario = "   Maria_Perez   \n";
$limpio = trim($inputUsuario);

echo "<strong>trim():</strong> Limpieza de basura.<br>";
echo "Original (con espacios): '$inputUsuario'<br>";
echo "Limpio: '$limpio'<br>";
echo "<span class='nota'>NOTA: Úsalo siempre al recibir $_POST o leer fgets().</span><br><br>";


// --- 1.3 STRLEN y SUBSTR ---
// Longitud y cortar trozos.
$matricula = "1234-ABC";
$longitud = strlen($matricula); // 8
$numeros = substr($matricula, 0, 4); // Empieza en 0, coge 4 caracteres

echo "<strong>substr():</strong> Cortar texto.<br>";
echo "De '$matricula' extraigo los números: '$numeros'<br><br>";


// --- 1.4 STR_REPLACE ---
// Reemplazar contenido.
$direccion = "C/Goya,123";
$direccionSinComa = str_replace(",", " ", $direccion);

echo "<strong>str_replace():</strong> Sustituir.<br>";
echo "Cambiar comas por espacios: $direccionSinComa<br>";

echo "</div>";


/* ==========================================================================
   SECCIÓN 2: ARRAYS (LISTAS)
   Tu estructura de datos principal al no usar Base de Datos.
   ========================================================================== */

echo "<div class='bloque'><h2>2. ARRAYS (Listas)</h2>";

// Datos de ejemplo
$coches = ["1234-ABC", "5678-DEF", "9012-GHI"];
$usuario = [
    "nombre" => "Juan", 
    "rol" => "admin", 
    "saldo" => 50
];

// --- 2.1 COUNT ---
// Contar elementos
echo "<strong>count():</strong> Contar.<br>";
echo "Tengo " . count($coches) . " coches.<br><br>";


// --- 2.2 IN_ARRAY ---
// Buscar si existe un valor. Devuelve true/false.
// Usado para ver si una matrícula está en la lista de permitidos.
$busqueda = "5678-DEF";
if (in_array($busqueda, $coches)) {
    echo "<strong>in_array():</strong> Encontrado.<br>";
    echo "El coche $busqueda está en la lista.<br><br>";
}


// --- 2.3 IMPLODE ---
// Lo contrario a explode. Convierte Array a String.
// VITAL para escribir en ficheros (guardar datos).
$registroGuardar = implode(";", $usuario);

echo "<strong>implode():</strong> De array a texto.<br>";
echo "Listo para guardar en txt: '$registroGuardar'<br>";
echo "<span class='nota'>NOTA: Úsalo antes de fputs() o fwrite().</span><br><br>";


// --- 2.4 ARRAY_MERGE ---
// Unir dos o más arrays.
// Lo usaste en 'infractores.php' para unir residentes, taxis y EMT.
$nuevosCoches = ["3333-XYZ", "1111-AAA"];
$flotaTotal = array_merge($coches, $nuevosCoches);

echo "<strong>array_merge():</strong> Unir listas.<br>";
echo "Total vehículos ahora: " . count($flotaTotal) . "<br><br>";


// --- 2.5 UNSET y ARRAY_VALUES ---
// Borrar y Reorganizar. El combo clásico de examen.
echo "<strong>unset() + array_values():</strong><br>";

// Borramos el segundo elemento (índice 1)
unset($coches[1]); 
// AHORA EL ARRAY ESTÁ ROTO: Indices son 0 y 2. Falta el 1.

// Re-indexamos para arreglar los huecos
$coches = array_values($coches);

echo "He borrado uno y reordenado. Ahora el índice 1 es: " . $coches[1] . "<br>";
echo "<span class='nota'>NOTA: Si usas unset dentro de un bucle, usa array_values al salir del bucle.</span>";

echo "</div>";


/* ==========================================================================
   SECCIÓN 3: EXTRAS IMPORTANTES (VALIDACIONES)
   ========================================================================== */

echo "<div class='bloque'><h2>3. EXTRAS (Validaciones)</h2>";

// --- 3.1 EMPTY vs ISSET ---
$varVacia = "";
$varNull = null;

echo "<strong>empty():</strong> Detecta vacíos, 0, false o null.<br>";
if (empty($varVacia)) echo "- La variable string vacía da TRUE en empty<br>";

echo "<strong>isset():</strong> Detecta si está definida y no es null.<br>";
if (isset($varVacia)) echo "- La variable string vacía da TRUE en isset (porque existe)<br>";
if (!isset($varNull)) echo "- La variable null da FALSE en isset<br>";

echo "<span class='nota'>NOTA: Usa empty() para validar campos obligatorios de formularios.</span>";

echo "</div>";

?>
</body>
</html>
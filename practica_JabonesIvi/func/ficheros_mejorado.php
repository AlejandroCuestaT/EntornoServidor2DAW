<?php

/**
 * ============================================================================
 * LIBRERÍA AVANZADA DE MANEJO DE FICHEROS, IMÁGENES Y DOCUMENTOS
 * ============================================================================
 */

// ============================================================================
// SECCIÓN 1: MANEJO AVANZADO DE FICHEROS (CON FICHERO AUXILIAR)
// ============================================================================

/**
 * Reescribir una línea específica en un fichero usando fichero auxiliar
 * 
 * param string $rutaOriginal Ruta del fichero original
 * param int $numeroLinea Número de línea a reemplazar (comienza en 1)
 * param string $nuevoContenido Nuevo contenido para la línea
 * return bool True si tuvo éxito, False si hay error
 * 
 * EXPLICACIÓN:
 * 1. Leemos todo el fichero línea por línea
 * 2. Cuando llegamos a la línea deseada, la reemplazamos
 * 3. Escribimos todo en un fichero auxiliar (.tmp)
 * 4. Eliminamos el original y renombramos el auxiliar
 * 
 * 
 */
function reescribirLineaFichero($rutaOriginal, $numeroLinea, $nuevoContenido)
{
    // Validaciones iniciales
    if (!file_exists($rutaOriginal)) {
        throw new Exception("El fichero '$rutaOriginal' no existe.");
    }

    if ($numeroLinea < 1) {
        throw new Exception("El número de línea debe ser mayor a 0.");
    }

    $rutaAuxiliar = $rutaOriginal . ".tmp";
    $contadorLinea = 0;

    try {
        // Abrir fichero original para lectura
        $lectorOriginal = fopen($rutaOriginal, 'r');
        if (!$lectorOriginal) {
            throw new Exception("No se pudo abrir el fichero original para lectura.");
        }

        // Abrir fichero auxiliar para escritura
        $escritorAuxiliar = fopen($rutaAuxiliar, 'w');
        if (!$escritorAuxiliar) {
            fclose($lectorOriginal);
            throw new Exception("No se pudo crear el fichero auxiliar.");
        }

        // Procesar línea por línea
        while (!feof($lectorOriginal)) {
            $linea = fgets($lectorOriginal); // Incluye el \n

            if ($linea === false)
                break; // Error o fin del fichero

            $contadorLinea++;

            // Si es la línea a reemplazar
            if ($contadorLinea == $numeroLinea) {
                // Asegurar que el nuevo contenido termina con \n
                $nuevoContenido = rtrim($nuevoContenido, "\n") . "\n";
                fputs($escritorAuxiliar, $nuevoContenido);
            } else {
                // Copiar línea tal cual
                fputs($escritorAuxiliar, $linea);
            }
        }

        fclose($lectorOriginal);
        fclose($escritorAuxiliar);

        // Caso especial: si la línea solicitada no existe, el fichero quedó igual
        if ($contadorLinea < $numeroLinea) {
            unlink($rutaAuxiliar); // Borrar el auxiliar
            throw new Exception("El fichero solo tiene $contadorLinea líneas. No existe la línea $numeroLinea.");
        }

        // Reemplazar el original con el auxiliar
        // unlink eliminará el original, rename lo sustituye
        if (!unlink($rutaOriginal)) {
            unlink($rutaAuxiliar);
            throw new Exception("No se pudo eliminar el fichero original.");
        }

        if (!rename($rutaAuxiliar, $rutaOriginal)) {
            throw new Exception("No se pudo renombrar el fichero auxiliar.");
        }

        return true;

    } catch (Exception $e) {
        // Limpieza en caso de error
        if (file_exists($rutaAuxiliar)) {
            @unlink($rutaAuxiliar);
        }
        throw $e;
    }
}

/**
 * Reescribir una línea que cumple una condición (búsqueda por patrón)
 * 
 * param string $rutaFichero Ruta del fichero
 * param string $patronBusqueda Patrón a buscar (p.ej: "1234-ABC")
 * param string $nuevoContenido Nuevo contenido
 * param string $separador Carácter que separa campos (para búsqueda en ficheros CSV/TXT)
 * return bool True si encontró y reemplazó, False si no encontró
 * 
 * EJEMPLO DE USO:
 * reescribirLineaPorPatron("infracciones.txt", "1234-ABC", "1234-ABC Juan Pérez C/Nueva,45", " ");
 * Busca la línea que comience con "1234-ABC" y la reemplaza completamente.
 */
function reescribirLineaPorPatron($rutaFichero, $patronBusqueda, $nuevoContenido, $separador = " ")
{
    if (!file_exists($rutaFichero)) {
        throw new Exception("El fichero '$rutaFichero' no existe.");
    }

    $rutaAuxiliar = $rutaFichero . ".tmp";
    $encontrado = false;

    try {
        $lectorOriginal = fopen($rutaFichero, 'r');
        $escritorAuxiliar = fopen($rutaAuxiliar, 'w');

        if (!$lectorOriginal || !$escritorAuxiliar) {
            throw new Exception("Error al abrir ficheros.");
        }

        while (!feof($lectorOriginal)) {
            $linea = fgets($lectorOriginal);
            if ($linea === false)
                break;

            $lineaLimpia = trim($linea);

            // Dividir la línea en campos
            $campos = explode($separador, $lineaLimpia);

            // Si el primer campo coincide con el patrón, reemplazar
            if (!empty($campos[0]) && strpos($campos[0], $patronBusqueda) !== false) {
                $nuevoContenido = rtrim($nuevoContenido, "\n") . "\n";
                fputs($escritorAuxiliar, $nuevoContenido);
                $encontrado = true;
            } else {
                fputs($escritorAuxiliar, $linea);
            }
        }

        fclose($lectorOriginal);
        fclose($escritorAuxiliar);

        if ($encontrado) {
            unlink($rutaFichero);
            rename($rutaAuxiliar, $rutaFichero);
            return true;
        } else {
            unlink($rutaAuxiliar);
            return false;
        }

    } catch (Exception $e) {
        if (file_exists($rutaAuxiliar)) {
            @unlink($rutaAuxiliar);
        }
        throw $e;
    }
}

/**
 * Insertar una nueva línea en una posición específica
 * 
 * param string $rutaFichero Ruta del fichero
 * param int $numeroLinea Número de línea donde insertar (1 = antes de la primera)
 * param string $contenido Contenido a insertar
 * return bool True si tuvo éxito
 */
function insertarLineaFichero($rutaFichero, $numeroLinea, $contenido)
{
    if (!file_exists($rutaFichero)) {
        throw new Exception("El fichero '$rutaFichero' no existe.");
    }

    $rutaAuxiliar = $rutaFichero . ".tmp";
    $contadorLinea = 0;

    try {
        $lectorOriginal = fopen($rutaFichero, 'r');
        $escritorAuxiliar = fopen($rutaAuxiliar, 'w');

        if (!$lectorOriginal || !$escritorAuxiliar) {
            throw new Exception("Error al abrir ficheros.");
        }

        while (!feof($lectorOriginal)) {
            $linea = fgets($lectorOriginal);
            if ($linea === false)
                break;

            $contadorLinea++;

            // Si es la posición de inserción, escribir primero la nueva línea
            if ($contadorLinea == $numeroLinea) {
                $contenido = rtrim($contenido, "\n") . "\n";
                fputs($escritorAuxiliar, $contenido);
            }

            fputs($escritorAuxiliar, $linea);
        }

        // Si el número de línea es mayor al total, añadir al final
        if ($numeroLinea > $contadorLinea) {
            $contenido = rtrim($contenido, "\n") . "\n";
            fputs($escritorAuxiliar, $contenido);
        }

        fclose($lectorOriginal);
        fclose($escritorAuxiliar);

        unlink($rutaFichero);
        rename($rutaAuxiliar, $rutaFichero);

        return true;

    } catch (Exception $e) {
        if (file_exists($rutaAuxiliar)) {
            @unlink($rutaAuxiliar);
        }
        throw $e;
    }
}

/**
 * Eliminar una línea específica por número
 * 
 * @param string $rutaFichero Ruta del fichero
 * @param int $numeroLinea Número de línea a eliminar
 * @return bool True si tuvo éxito
 */
function eliminarLineaFichero($rutaFichero, $numeroLinea)
{
    if (!file_exists($rutaFichero)) {
        throw new Exception("El fichero '$rutaFichero' no existe.");
    }

    $rutaAuxiliar = $rutaFichero . ".tmp";
    $contadorLinea = 0;

    try {
        $lectorOriginal = fopen($rutaFichero, 'r');
        $escritorAuxiliar = fopen($rutaAuxiliar, 'w');

        if (!$lectorOriginal || !$escritorAuxiliar) {
            throw new Exception("Error al abrir ficheros.");
        }

        while (!feof($lectorOriginal)) {
            $linea = fgets($lectorOriginal);
            if ($linea === false)
                break;

            $contadorLinea++;

            // Si no es la línea a eliminar, copiar
            if ($contadorLinea != $numeroLinea) {
                fputs($escritorAuxiliar, $linea);
            }
        }

        fclose($lectorOriginal);
        fclose($escritorAuxiliar);

        unlink($rutaFichero);
        rename($rutaAuxiliar, $rutaFichero);

        return true;

    } catch (Exception $e) {
        if (file_exists($rutaAuxiliar)) {
            @unlink($rutaAuxiliar);
        }
        throw $e;
    }
}


// ============================================================================
// SECCIÓN 2: VALIDACIÓN Y MANEJO DE IMÁGENES
// ============================================================================

/**
 * Validar y procesar imagen subida
 * 
 * @param array $ficheroArray $_FILES['nombre_campo']
 * @param string $dirDestino Carpeta donde guardar la imagen
 * @param array $opcionesValidacion Array con: 'tamaño_max' (bytes), 'extensiones' (array)
 * @return array ['exito' => bool, 'mensaje' => string, 'fichero' => string]
 * 
 * EJEMPLO DE USO:
 * $resultado = validarYGuardarImagen($_FILES['foto'], 'uploads/fotos/', [
 *     'tamaño_max' => 2097152,  // 2MB
 *     'extensiones' => ['jpg', 'jpeg', 'png', 'gif']
 * ]);
 * 
 * if ($resultado['exito']) {
 *     echo "Imagen guardada: " . $resultado['fichero'];
 * } else {
 *     echo "Error: " . $resultado['mensaje'];
 * }
 */
function validarYGuardarImagen($ficheroArray, $dirDestino, $opcionesValidacion = [])
{
    // Opciones por defecto
    $tamañoMax = $opcionesValidacion['tamaño_max'] ?? 2097152; // 2MB por defecto
    $extensionesPermitidas = $opcionesValidacion['extensiones'] ?? ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ancho_min = $opcionesValidacion['ancho_min'] ?? 0;
    $alto_min = $opcionesValidacion['alto_min'] ?? 0;

    // Array de resultado
    $resultado = [
        'exito' => false,
        'mensaje' => '',
        'fichero' => null,
        'tamaño' => 0,
        'dimensiones' => ['ancho' => 0, 'alto' => 0]
    ];

    // 1. VALIDACIÓN: ¿Hay error en la subida?
    if (!isset($ficheroArray['error']) || $ficheroArray['error'] !== UPLOAD_ERR_OK) {
        $codigos_error = [
            UPLOAD_ERR_INI_SIZE => 'El archivo supera el tamaño máximo permitido por PHP.',
            UPLOAD_ERR_FORM_SIZE => 'El archivo supera el tamaño máximo del formulario.',
            UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente.',
            UPLOAD_ERR_NO_FILE => 'No se seleccionó ningún archivo.',
            UPLOAD_ERR_NO_TMP_DIR => 'No hay directorio temporal disponible.',
            UPLOAD_ERR_CANT_WRITE => 'No se puede escribir en el disco.',
        ];

        $codigo = $ficheroArray['error'] ?? -1;
        $resultado['mensaje'] = $codigos_error[$codigo] ?? 'Error desconocido en la subida.';
        return $resultado;
    }

    // 2. VALIDACIÓN: ¿Existe el fichero temporal?
    if (!isset($ficheroArray['tmp_name']) || !is_uploaded_file($ficheroArray['tmp_name'])) {
        $resultado['mensaje'] = 'El fichero no es una subida válida.';
        return $resultado;
    }

    // 3. VALIDACIÓN: ¿Tamaño correcto?
    $tamaño = filesize($ficheroArray['tmp_name']);
    if ($tamaño > $tamañoMax) {
        $tamañoMaxMB = round($tamañoMax / 1048576, 2);
        $resultado['mensaje'] = "El archivo pesa " . round($tamaño / 1024, 2) . "KB. Máximo permitido: {$tamañoMaxMB}MB";
        return $resultado;
    }

    // 4. VALIDACIÓN: ¿Extensión correcta?
    $nombreOriginal = $ficheroArray['name'];
    $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

    if (!in_array($extension, $extensionesPermitidas)) {
        $resultado['mensaje'] = "Extensión no permitida. Permitidas: " . implode(', ', $extensionesPermitidas);
        return $resultado;
    }

    // 5. VALIDACIÓN: ¿Es realmente una imagen? (MIME type)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $ficheroArray['tmp_name']);


    $mimePermitidos = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/x-icon'
    ];

    if (!in_array($mimeType, $mimePermitidos)) {
        $resultado['mensaje'] = "El archivo no es una imagen válida. MIME detectado: $mimeType";
        return $resultado;
    }

    // 6. VALIDACIÓN: Dimensiones mínimas (si se especifican)
    if ($ancho_min > 0 || $alto_min > 0) {
        $dimensiones = @getimagesize($ficheroArray['tmp_name']);
        if ($dimensiones === false) {
            $resultado['mensaje'] = "No se pudieron obtener las dimensiones de la imagen.";
            return $resultado;
        }

        $ancho = $dimensiones[0];
        $alto = $dimensiones[1];

        if ($ancho < $ancho_min || $alto < $alto_min) {
            $resultado['mensaje'] = "Imagen demasiado pequeña. Mínimo: {$ancho_min}x{$alto_min}px. Encontrada: {$ancho}x{$alto}px";
            return $resultado;
        }

        $resultado['dimensiones'] = ['ancho' => $ancho, 'alto' => $alto];
    }

    // 7. CREAR DIRECTORIO SI NO EXISTE
    if (!is_dir($dirDestino)) {
        if (!mkdir($dirDestino, 0755, true)) {
            $resultado['mensaje'] = "No se pudo crear el directorio de destino.";
            return $resultado;
        }
    }

    // 8. GENERAR NOMBRE SEGURO Y ÚNICO
    $nombreSeguro = md5(uniqid() . $nombreOriginal) . '.' . $extension;
    $rutaDestino = rtrim($dirDestino, '/') . '/' . $nombreSeguro;

    // 9. MOVER FICHERO
    if (!move_uploaded_file($ficheroArray['tmp_name'], $rutaDestino)) {
        $resultado['mensaje'] = "Error al guardar la imagen en el servidor.";
        return $resultado;
    }

    // 10. ÉXITO
    $resultado['exito'] = true;
    $resultado['mensaje'] = 'Imagen subida correctamente.';
    $resultado['fichero'] = $nombreSeguro;
    $resultado['tamaño'] = $tamaño;

    return $resultado;
}

/**
 * Validar imagen sin guardarla (solo comprobar)
 * 
 * @param array $ficheroArray $_FILES['campo']
 * @param array $validaciones Array con criterios
 * @return array ['valido' => bool, 'errores' => array]
 */
function validarImagenSinGuardar($ficheroArray, $validaciones = [])
{
    $tamañoMax = $validaciones['tamaño_max'] ?? 2097152;
    $extensionesPermitidas = $validaciones['extensiones'] ?? ['jpg', 'jpeg', 'png', 'gif'];

    $resultado = [
        'valido' => true,
        'errores' => []
    ];

    // Error en subida
    if (!isset($ficheroArray['error']) || $ficheroArray['error'] !== UPLOAD_ERR_OK) {
        $resultado['valido'] = false;
        $resultado['errores'][] = 'Error en la subida del fichero.';
        return $resultado;
    }

    // Tamaño
    $tamaño = filesize($ficheroArray['tmp_name']);
    if ($tamaño > $tamañoMax) {
        $resultado['valido'] = false;
        $resultado['errores'][] = 'Archivo demasiado grande.';
    }

    // Extensión
    $extension = strtolower(pathinfo($ficheroArray['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $extensionesPermitidas)) {
        $resultado['valido'] = false;
        $resultado['errores'][] = 'Extensión no permitida.';
    }

    return $resultado;
}


// ============================================================================
// SECCIÓN 3: VALIDACIÓN Y MANEJO DE DOCUMENTOS
// ============================================================================

/**
 * Obtener información detallada de un fichero
 * 
 * @param string $rutaFichero Ruta completa del fichero
 * @return array ['existe' => bool, 'tamaño' => int, 'tamaño_mb' => float, 'extension' => string, 'mime' => string, ...]
 */
function obtenerInfoFichero($rutaFichero)
{
    $info = [
        'existe' => file_exists($rutaFichero),
        'tamaño' => 0,
        'tamaño_mb' => 0,
        'tamaño_kb' => 0,
        'extension' => '',
        'mime' => '',
        'legible' => false,
        'escribible' => false,
        'fecha_modificacion' => null,
        'nombre' => basename($rutaFichero),
        'directorio' => dirname($rutaFichero)
    ];

    if (!$info['existe']) {
        return $info;
    }

    $info['tamaño'] = filesize($rutaFichero);
    $info['tamaño_kb'] = round($info['tamaño'] / 1024, 2);
    $info['tamaño_mb'] = round($info['tamaño'] / 1048576, 2);
    $info['extension'] = strtolower(pathinfo($rutaFichero, PATHINFO_EXTENSION));
    $info['legible'] = is_readable($rutaFichero);
    $info['escribible'] = is_writable($rutaFichero);
    $info['fecha_modificacion'] = filemtime($rutaFichero);

    // MIME type (más seguro con finfo)
    if (function_exists('finfo_file')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $info['mime'] = finfo_file($finfo, $rutaFichero);
        finfo_close($finfo);
    }

    return $info;
}

/**
 * Validar documento (PDF, Word, Excel, etc.)
 * 
 * @param array $ficheroArray $_FILES['documento']
 * @param string $dirDestino Carpeta destino
 * @param array $opciones Array con: 'tamaño_max', 'extensiones'
 * @return array ['exito' => bool, 'mensaje' => string, 'fichero' => string]
 * 
 * EJEMPLO:
 * $resultado = validarYGuardarDocumento($_FILES['cv'], 'uploads/documentos/', [
 *     'tamaño_max' => 5242880,  // 5MB
 *     'extensiones' => ['pdf', 'doc', 'docx']
 * ]);
 */
function validarYGuardarDocumento($ficheroArray, $dirDestino, $opciones = [])
{
    $tamañoMax = $opciones['tamaño_max'] ?? 5242880; // 5MB por defecto
    $extensionesPermitidas = $opciones['extensiones'] ?? ['pdf', 'doc', 'docx', 'xlsx', 'xls', 'txt'];

    $resultado = [
        'exito' => false,
        'mensaje' => '',
        'fichero' => null,
        'tamaño' => 0,
        'extension' => ''
    ];

    // Error en subida
    if (!isset($ficheroArray['error']) || $ficheroArray['error'] !== UPLOAD_ERR_OK) {
        $resultado['mensaje'] = 'Error al subir el documento.';
        return $resultado;
    }

    // Validar tamaño
    $tamaño = filesize($ficheroArray['tmp_name']);
    if ($tamaño > $tamañoMax) {
        $tamañoMaxMB = round($tamañoMax / 1048576, 2);
        $resultado['mensaje'] = "Documento demasiado grande. Máximo: {$tamañoMaxMB}MB";
        return $resultado;
    }

    // Validar extensión
    $extension = strtolower(pathinfo($ficheroArray['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $extensionesPermitidas)) {
        $resultado['mensaje'] = 'Tipo de documento no permitido.';
        return $resultado;
    }

    // Crear directorio si no existe
    if (!is_dir($dirDestino)) {
        if (!mkdir($dirDestino, 0755, true)) {
            $resultado['mensaje'] = 'Error al crear el directorio.';
            return $resultado;
        }
    }

    // Generar nombre seguro
    $nombreSeguro = md5(uniqid() . $ficheroArray['name']) . '.' . $extension;
    $rutaDestino = rtrim($dirDestino, '/') . '/' . $nombreSeguro;

    // Mover fichero
    if (!move_uploaded_file($ficheroArray['tmp_name'], $rutaDestino)) {
        $resultado['mensaje'] = 'Error al guardar el documento.';
        return $resultado;
    }

    $resultado['exito'] = true;
    $resultado['mensaje'] = 'Documento subido correctamente.';
    $resultado['fichero'] = $nombreSeguro;
    $resultado['tamaño'] = $tamaño;
    $resultado['extension'] = $extension;

    return $resultado;
}

/**
 * Comprobar si un fichero es seguro (anti-malware básico)
 * 
 * @param string $rutaFichero Ruta del fichero
 * @param array $extensionesProhibidas Extensiones que se consideren peligrosas
 * @return array ['seguro' => bool, 'razon' => string]
 */
function esSeguroFichero($rutaFichero, $extensionesProhibidas = ['exe', 'bat', 'cmd', 'scr', 'vbs', 'js'])
{
    $resultado = [
        'seguro' => true,
        'razon' => ''
    ];

    if (!file_exists($rutaFichero)) {
        $resultado['seguro'] = false;
        $resultado['razon'] = 'Fichero no existe.';
        return $resultado;
    }

    $extension = strtolower(pathinfo($rutaFichero, PATHINFO_EXTENSION));

    // Comprobar extensión prohibida
    if (in_array($extension, $extensionesProhibidas)) {
        $resultado['seguro'] = false;
        $resultado['razon'] = "Extensión peligrosa detectada: $extension";
        return $resultado;
    }

    // Comprobar MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $rutaFichero);


    $mimesProhibidos = ['application/x-executable', 'application/x-msdownload', 'application/x-dosexec'];
    if (in_array($mime, $mimesProhibidos)) {
        $resultado['seguro'] = false;
        $resultado['razon'] = "MIME peligroso detectado: $mime";
        return $resultado;
    }

    return $resultado;
}

/**
 * Convertir bytes a formato legible (KB, MB, GB)
 * 
 * @param int $bytes Cantidad de bytes
 * @param int $decimales Número de decimales a mostrar
 * @return string Tamaño formateado (ej: "2.5 MB")
 */
function formatearTamaño($bytes, $decimales = 2)
{
    $unidades = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($unidades) - 1);
    $bytes /= (1 << (10 * $pow));

    return round($bytes, $decimales) . ' ' . $unidades[$pow];
}

/**
 * Listar ficheros en un directorio con información
 * 
 * @param string $directorio Ruta del directorio
 * @param array $filtros Array con 'extensiones' => ['jpg', 'png'] (opcional)
 * @return array Array de ficheros con información
 */
function listarFicheros($directorio, $filtros = [])
{
    $ficheros = [];

    if (!is_dir($directorio)) {
        return $ficheros;
    }

    $archivos = scandir($directorio);

    foreach ($archivos as $archivo) {
        // Ignorar . y ..
        if ($archivo == '.' || $archivo == '..') {
            continue;
        }

        $rutaCompleta = $directorio . '/' . $archivo;

        // Ignorar directorios
        if (is_dir($rutaCompleta)) {
            continue;
        }

        // Aplicar filtros por extensión
        if (!empty($filtros['extensiones'])) {
            $ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
            if (!in_array($ext, $filtros['extensiones'])) {
                continue;
            }
        }

        $ficheros[] = [
            'nombre' => $archivo,
            'tamaño' => filesize($rutaCompleta),
            'tamaño_formateado' => formatearTamaño(filesize($rutaCompleta)),
            'extension' => strtolower(pathinfo($archivo, PATHINFO_EXTENSION)),
            'fecha_modificacion' => filemtime($rutaCompleta),
            'fecha_modificacion_legible' => date('d/m/Y H:i', filemtime($rutaCompleta))
        ];
    }

    // Ordenar por fecha (más recientes primero)
    usort($ficheros, function ($a, $b) {
        return $b['fecha_modificacion'] - $a['fecha_modificacion'];
    });

    return $ficheros;
}


// ============================================================================
// SECCIÓN 4: FUNCIONES DE UTILIDAD AVANZADA
// ============================================================================

/**
 * Copiar fichero de forma segura
 * 
 * @param string $origen Ruta del fichero original
 * @param string $destino Ruta del nuevo fichero
 * @return bool True si tuvo éxito
 */
function copiarFicheroSeguro($origen, $destino)
{
    if (!file_exists($origen)) {
        throw new Exception("El fichero origen no existe: $origen");
    }

    if (!is_readable($origen)) {
        throw new Exception("El fichero origen no es legible: $origen");
    }

    // Crear directorio destino si no existe
    $dirDestino = dirname($destino);
    if (!is_dir($dirDestino)) {
        mkdir($dirDestino, 0755, true);
    }

    if (!copy($origen, $destino)) {
        throw new Exception("Error al copiar el fichero.");
    }

    return true;
}

/**
 * Mover/Renombrar fichero de forma segura
 * 
 * @param string $origen Ruta original
 * @param string $destino Ruta destino
 * @return bool True si tuvo éxito
 */
function moverFicheroSeguro($origen, $destino)
{
    if (!file_exists($origen)) {
        throw new Exception("El fichero origen no existe: $origen");
    }

    $dirDestino = dirname($destino);
    if (!is_dir($dirDestino)) {
        mkdir($dirDestino, 0755, true);
    }

    if (!rename($origen, $destino)) {
        throw new Exception("Error al mover el fichero.");
    }

    return true;
}

/**
 * Limpiar nombre de fichero (eliminar caracteres peligrosos)
 * 
 * @param string $nombreFichero Nombre original
 * @return string Nombre sanitizado
 */
function sanitizarNombreFichero($nombreFichero)
{
    // Eliminar caracteres especiales peligrosos
    $nombreLimpio = preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFichero);

    // No permitir nombres de sistema
    $nombresProhibidos = ['con', 'prn', 'aux', 'nul', 'com1', 'lpt1'];
    if (in_array(strtolower($nombreLimpio), $nombresProhibidos)) {
        $nombreLimpio = 'fichero_' . $nombreLimpio;
    }

    return $nombreLimpio;
}

?>
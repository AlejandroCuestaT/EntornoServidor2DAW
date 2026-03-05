<?php
require_once 'conexion.php';
require_once 'Socio.php';
require_once 'UsuarioOcasional.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    try {
        if ($accion === 'nuevo_usuario') {
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $tipo = $_POST['tipo_usuario'];

            // Usamos las clases para obtener los límites de préstamos
            $obj = ($tipo === 'Socio') ? new Socio($dni, $nombre) : new UsuarioOcasional($dni, $nombre);

            $ins = $conn->prepare("INSERT INTO usuarios (dni, nombre, max_prestamos, limite_prestamos, tipo_usuario) VALUES (?, ?, ?, ?, ?)");
            $ins->execute([$obj->dni, $obj->nombre, $obj->maxPrestamos, $obj->limitePrestamos, $tipo]);
            
            header("Location: index.php?msg=Usuario_registrado");
        }

        if ($accion === 'nuevo_documento') {
            $cod = $_POST['codigo'];
            $tit = $_POST['titulo'];
            $tipo = $_POST['tipo_documento'];

            // Insertar en documentos
            $insDoc = $conn->prepare("INSERT INTO documentos (codigo, titulo, tipo_documento) VALUES (?, ?, ?)");
            $insDoc->execute([$cod, $tit, $tipo]);

            // Si es libro, insertar en la tabla libros
            if ($tipo === 'Libro') {
                $anio = $_POST['anio_publicacion'];
                $insLib = $conn->prepare("INSERT INTO libros (codigo_documento, anio_publicacion) VALUES (?, ?)");
                $insLib->execute([$cod, $anio]);
            }

            header("Location: index.php?msg=Documento_registrado");
        }
    } catch (Exception $e) {
        echo "Error en el proceso: " . $e->getMessage();
        echo "<br><a href='index.php'>Volver</a>";
    }
}
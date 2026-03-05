CREATE DATABASE biblioteca;
USE biblioteca;

-- 1. Tabla para Usuario
CREATE TABLE usuarios (
    dni VARCHAR(9) PRIMARY KEY,
    nombre VARCHAR(100),
    max_prestamos INT DEFAULT 0,
    limite_prestamos INT DEFAULT 1,
    num_prestamos INT DEFAULT 0,
    tipo_usuario ENUM('Socio', 'Ocasional') DEFAULT NULL 
);

-- 2. Tabla para Documento
CREATE TABLE documentos (
    codigo VARCHAR(50) PRIMARY KEY,
    titulo VARCHAR(150),
    dni_prestado_a VARCHAR(9) NULL,
    -- Quitamos el NOT NULL para permitir que sea null
    tipo_documento ENUM('Libro', 'Revista') DEFAULT NULL,
    FOREIGN KEY (dni_prestado_a) REFERENCES usuarios(dni)
);

-- 3. Tabla específica para Libro (Mantiene relación con documentos)
CREATE TABLE libros (
    codigo_documento VARCHAR(50) PRIMARY KEY,
    anio_publicacion INT,
    FOREIGN KEY (codigo_documento) REFERENCES documentos(codigo) ON DELETE CASCADE
);
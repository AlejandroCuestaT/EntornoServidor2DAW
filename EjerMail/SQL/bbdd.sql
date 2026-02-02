CREATE DATABASE ejercicio_mail;
USE ejercicio_mail;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellidos VARCHAR(50),
    email VARCHAR(100),
    direccion VARCHAR(100)
);

-- Insertamos un par de datos de prueba
INSERT INTO clientes (nombre, apellidos, email, direccion) VALUES 
('Juan', 'Pérez', 'juan@ejemplo.com', 'Calle Falsa 123'),
('Ana', 'García', 'ana@ejemplo.com', 'Avda. España 10');
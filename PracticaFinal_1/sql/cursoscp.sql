-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2026 a las 11:41:09
-- Versión del servidor: 8.0.37
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cursoscp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `usuario` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`usuario`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `codigo` smallint NOT NULL DEFAULT '0',
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `abierto` tinyint(1) NOT NULL DEFAULT '1',
  `numeroplazas` smallint NOT NULL DEFAULT '20',
  `plazoinscripcion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`codigo`, `nombre`, `abierto`, `numeroplazas`, `plazoinscripcion`) VALUES
(1, 'Instalacion y uso de Apache', 1, 20, '2015-05-20'),
(2, 'Administracion avanzada de Apache', 1, 30, '2015-05-20'),
(3, 'Elaboracion de recursos didacticos', 1, 20, '2015-05-20'),
(4, 'Uso didactico de Moodle en primaria', 1, 10, '2015-05-20'),
(5, 'Uso didactico de Moodle en secundaria', 0, 20, '2015-01-20'),
(6, 'Moodle y el aula de musica', 1, 20, '2015-05-25'),
(7, 'Tratamiento de imagenes', 0, 20, '2015-02-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitantes`
--

CREATE TABLE `solicitantes` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `apellidos` varchar(40) NOT NULL DEFAULT '',
  `nombre` varchar(20) NOT NULL DEFAULT '',
  `telefono` varchar(12) NOT NULL DEFAULT '',
  `correo` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `codcen` varchar(8) NOT NULL DEFAULT '',
  `coordinadortic` tinyint(1) NOT NULL DEFAULT '0',
  `grupotic` tinyint(1) NOT NULL DEFAULT '0',
  `nomgrupo` varchar(25) NOT NULL DEFAULT '',
  `pbilin` tinyint(1) NOT NULL DEFAULT '0',
  `cargo` tinyint(1) NOT NULL DEFAULT '0',
  `nombrecargo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `situacion` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fechaalt` date DEFAULT NULL,
  `especialidad` varchar(50) NOT NULL DEFAULT '',
  `puntos` tinyint UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `solicitantes`
--

INSERT INTO `solicitantes` (`dni`, `apellidos`, `nombre`, `telefono`, `correo`, `password`, `codcen`, `coordinadortic`, `grupotic`, `nomgrupo`, `pbilin`, `cargo`, `nombrecargo`, `situacion`, `fechaalt`, `especialidad`, `puntos`) VALUES
('50564590B', 'Alvarez', 'Roy', '658954123', 'roy@gmail.es', '1234', '12', 1, 1, 'asdsa', 0, 0, 'jefeDeEstudios', 'activo', '2015-12-05', 'aaaaa', 10),
('50564592F', 'Alvarez', 'Roy', '658954123', 'roy@gmail.es', '1234', '12', 1, 0, 'asdsa', 1, 0, 'jefeDeDepartamento', 'activo', '2000-01-01', 'aaaaa', 10),
('50564595A', 'Ruiz', 'David', '635256987', 'david@gmail.es', '1234', '12', 1, 0, 'asdsa', 0, 0, 'secretario', 'activo', '2015-12-05', 'aaaaa', 7),
('50564597V', 'Cuesta Trapote', 'Alejandro', '636840577', 'alex@gmail.com', '1234', '3', 1, 1, 'aa', 1, 1, 'director', 'activo', '2005-09-09', 'aa', 14),
('50564598H', 'Lopez', 'Laura', '654258785', 'laura@gmail.es', '1234', '12', 1, 0, 'asdsa', 0, 1, 'jefeDeEstudios', 'activo', '2009-12-05', 'abc', 8),
('sdf', 'dsfsdf', 'sdfdsf', '123456789', 'aaa@aa.es', '1234', '3', 1, 0, 'aa', 0, 1, 'secretario', 'activo', '2005-09-09', 'aa', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `dni` varchar(9) NOT NULL DEFAULT '',
  `codigocurso` smallint NOT NULL DEFAULT '0',
  `fechasolicitud` date NOT NULL,
  `admitido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`usuario`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `solicitantes`
--
ALTER TABLE `solicitantes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`dni`,`codigocurso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

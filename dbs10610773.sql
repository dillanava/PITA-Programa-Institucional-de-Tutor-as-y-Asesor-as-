-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2025 a las 04:28:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs10610773`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `nombre` varchar(50) NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `grupo` varchar(7) NOT NULL,
  `cuatrimestre` varchar(2) NOT NULL,
  `promedio` float NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `strikes` int(11) NOT NULL,
  `contraseña` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `active` int(11) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `imagen_de_perfil` longblob DEFAULT NULL,
  `turno` varchar(15) NOT NULL,
  `calificaciones_ingresadas` tinyint(1) DEFAULT 0,
  `generacion` int(11) NOT NULL,
  `encuesta_satisfaccion` tinyint(1) NOT NULL,
  `periodo_ultima_encuesta` tinyint(4) DEFAULT NULL,
  `periodo_inicio` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`nombre`, `matricula`, `grupo`, `cuatrimestre`, `promedio`, `id_carrera`, `strikes`, `contraseña`, `active`, `email`, `imagen_de_perfil`, `turno`, `calificaciones_ingresadas`, `generacion`, `encuesta_satisfaccion`, `periodo_ultima_encuesta`, `periodo_inicio`) VALUES
('Jonatan Arath Garcia Nieto', 13201305155, '8VSC0', '8', 9, 1, 0, 'K+OcmIuh2Yp/x/Y3UUhcNJ9KW5eNSR0M49XlHOoDJ8i8s/2xgrTOPo+vLOZ+LjuFWrs98Ppn2sZa2bw416Sosg==', 1, '13201305155@gmail.com', NULL, 'Matutino', 0, 2024, 0, NULL, 1),
('Juan Carlos', 13201305156, '2MSC1', '2', 10, 1, 0, 'NTN3toX00fQjB3p6Tm0VWGYUgNnmRM8hQfFINyr7IdPuTT0a+9hoX+FVHkAx8svo/jLWF9seupySpXWVBbE4nw==', 1, 'hatblckht@gmail.com', 0x696d6167656e65732f6131333230313330353135362e6a7067, 'Matutino', 1, 2025, 1, 2, 1),
('Bermeo Nava Dillan', 13201305189, '3MSC1', '3', 9, 1, 0, '+5rEhKeJVXYuE0rJqqpVV6YMNl9FrujaWJQWt+UoEcH6M8NyWDwMEZVAHtQf8I51+2bwxSN6LEEtUId63e8c/Q==', 1, '13201305189@gmail.com', 0x696d6167656e65732f6131333230313330353138392e6a7067, 'Matutino', 0, 2024, 0, 1, 1),
('José Luis Saucedo Fernández', 13211405309, '1VSC', '1', 0, 1, 0, 'EkPOsb2TNdy9BIWLxYVfm50S5Rgn066taN25lz5WEZLzV+bg7RZFwZn0/gDCmqe3IF7hhMZy97D4hrTMDsZZCQ==', 1, '132114053093@uptex.edu.mx', NULL, 'Vespertino', 0, 2023, 0, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_scores`
--

CREATE TABLE `alumno_scores` (
  `id` int(11) NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno_scores`
--

INSERT INTO `alumno_scores` (`id`, `matricula`, `score`) VALUES
(32, 13201305156, 180),
(33, 13201305189, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturasa`
--

CREATE TABLE `asignaturasa` (
  `id_asignaturasa` int(11) NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `id_materias` int(11) NOT NULL,
  `calificacion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaturasa`
--

INSERT INTO `asignaturasa` (`id_asignaturasa`, `matricula`, `id_materias`, `calificacion`) VALUES
(1603, 13211405309, 16, 0),
(1604, 13211405309, 17, 0),
(1605, 13211405309, 18, 0),
(1606, 13211405309, 19, 0),
(1607, 13211405309, 20, 0),
(1608, 13211405309, 21, 0),
(1609, 13211405309, 22, 0),
(1617, 13201305189, 37, 0),
(1618, 13201305189, 38, 0),
(1619, 13201305189, 39, 0),
(1620, 13201305189, 40, 0),
(1621, 13201305189, 41, 0),
(1622, 13201305189, 42, 0),
(1623, 13201305189, 43, 0),
(1624, 13201305156, 23, 0),
(1625, 13201305156, 24, 0),
(1626, 13201305156, 25, 0),
(1627, 13201305156, 26, 0),
(1628, 13201305156, 27, 0),
(1629, 13201305156, 28, 0),
(1630, 13201305156, 29, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturasp`
--

CREATE TABLE `asignaturasp` (
  `id_asignaturasp` int(11) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `id_materias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id_carrera` int(11) NOT NULL,
  `carreras` varchar(60) NOT NULL,
  `descripcion` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `carreras`, `descripcion`, `active`) VALUES
(1, 'Ingeniería en Sistemas Computacionales', 'computacion', 1),
(2, 'Ingeniería en Robótica ', 'Robótica ', 1),
(3, 'Ingeniería en Electrónica y Telecomunicaciones', 'electronica y telecomunicaciones', 1),
(4, 'Ingeniería en Logística y Transporte', 'logistica y transporte', 1),
(5, 'Jefe de carrera', 'No necesita seleccionar una carrera', 1),
(6, 'psicologo', 'No necesita seleccionar una carrera', 1),
(7, 'Licenciatura en Administración y Gestión Empresarial', 'Gestion y administracion', 1),
(8, 'Licenciatura en Comercio Internacional y Aduanas', 'Comercio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_citas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `tipo` int(11) NOT NULL,
  `id_citasN` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `hora` time NOT NULL,
  `tutor` bigint(20) NOT NULL,
  `periodo` tinyint(1) NOT NULL,
  `carrera` int(11) DEFAULT NULL,
  `materia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_citas`, `fecha`, `matricula`, `nempleado`, `tipo`, `id_citasN`, `status`, `hora`, `tutor`, `periodo`, `carrera`, `materia`) VALUES
(868, '2024-04-08', 13201305155, 85728, 21, 4, 2, '09:30:00', 35753, 1, 1, 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_eliminadas`
--

CREATE TABLE `citas_eliminadas` (
  `id_citas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `tipo` int(11) NOT NULL,
  `id_citasN` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `hora` time NOT NULL,
  `tutor` bigint(20) NOT NULL,
  `periodo` tinyint(1) NOT NULL,
  `carrera` int(11) DEFAULT NULL,
  `materia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas_eliminadas`
--

INSERT INTO `citas_eliminadas` (`id_citas`, `fecha`, `matricula`, `nempleado`, `tipo`, `id_citasN`, `status`, `hora`, `tutor`, `periodo`, `carrera`, `materia`) VALUES
(815, '2023-04-27', 13191205163, 563, 13, 2, 1, '12:30:00', 983, 1, NULL, NULL),
(822, '2023-04-26', 13191205163, 94638, 15, 2, 3, '09:30:00', 85728, 1, NULL, NULL),
(824, '2023-04-28', 13191205163, 642357, 11, 2, 0, '11:00:00', 35753, 1, NULL, NULL),
(825, '2023-04-27', 13191205163, 85728, 20, 4, 1, '10:30:00', 35753, 1, NULL, NULL),
(826, '2023-04-27', 13191205163, 94638, 15, 2, 1, '09:00:00', 85728, 1, NULL, NULL),
(836, '2023-04-27', 13191205163, 35753, 20, 4, 1, '10:00:00', 85728, 1, 1, 78),
(840, '2023-04-30', 13191205163, 94638, 13, 2, 2, '15:00:00', 85728, 1, 0, 0),
(841, '2023-04-28', 12345678, 94638, 14, 2, 3, '12:00:00', 35753, 1, NULL, NULL),
(842, '2023-04-28', 13191205163, 94638, 12, 2, 2, '01:45:00', 85728, 1, 0, 0),
(843, '2023-04-27', 13191205163, 85728, 18, 4, 2, '23:45:00', 85728, 1, 1, 77),
(845, '2023-05-16', 13191205009, 85728, 23, 4, 2, '09:30:00', 94638, 1, 1, 19),
(846, '2023-05-15', 13191205163, 35753, 18, 4, 2, '11:30:00', 85728, 1, 1, 79),
(848, '2023-05-10', 13191205009, 94638, 13, 2, 3, '08:30:00', 94638, 1, 0, 0),
(849, '2023-05-11', 13191205163, 94638, 12, 2, 2, '13:00:00', 85728, 1, 0, 0),
(850, '2023-05-12', 13191205163, 35753, 18, 4, 1, '14:00:00', 85728, 1, 1, 77),
(851, '2023-05-18', 13191205163, 94638, 16, 2, 2, '13:00:00', 85728, 1, 0, 0),
(852, '2023-05-12', 13191205163, 94638, 15, 2, 1, '15:00:00', 85728, 1, 0, 0),
(853, '2023-05-12', 13191205163, 35753, 20, 4, 2, '15:00:00', 85728, 1, 1, 77),
(855, '2023-05-18', 13191205163, 94638, 14, 2, 1, '13:00:00', 85728, 1, 0, 0),
(856, '2023-05-12', 13191205163, 94638, 11, 2, 1, '15:30:00', 85728, 1, 0, 0),
(857, '2024-02-27', 13201305155, 35753, 18, 4, 3, '12:00:00', 85728, 1, 1, 16),
(858, '2024-02-28', 13201305156, 35753, 18, 4, 2, '12:30:00', 35753, 1, 1, 19),
(859, '2024-02-28', 13191205035, 35753, 17, 4, 3, '13:30:00', 35753, 1, 1, 19),
(860, '2024-03-18', 13201305156, 85728, 17, 4, 2, '11:30:00', 35753, 1, 1, 17),
(861, '2024-03-18', 13201305156, 94638, 10, 2, 2, '10:30:00', 35753, 1, 0, 0),
(869, '2024-04-15', 13201305155, 85728, 20, 4, 2, '09:30:00', 35753, 1, 1, 82),
(870, '2024-03-25', 13201305189, 85728, 20, 4, 2, '10:30:00', 35753, 1, 1, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_procesar`
--

CREATE TABLE `citas_procesar` (
  `id_citas` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `tutor` bigint(20) NOT NULL,
  `id_citasN` int(11) NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas_procesar`
--

INSERT INTO `citas_procesar` (`id_citas`, `fecha`, `matricula`, `tutor`, `id_citasN`, `hora`) VALUES
(147, '2024-03-28', 13201305155, 35753, 1, '14:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `nombre` varchar(100) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `carrera` varchar(100) DEFAULT NULL,
  `grupo` varchar(20) DEFAULT NULL,
  `tutor` varchar(100) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `estado_civil` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `residencia_ciudad` varchar(100) DEFAULT NULL,
  `tiempo` varchar(50) DEFAULT NULL,
  `especifica` varchar(100) DEFAULT NULL,
  `vives` varchar(50) DEFAULT NULL,
  `trabajas` varchar(50) DEFAULT NULL,
  `tipo_empresa` varchar(100) DEFAULT NULL,
  `horas_semanales` int(11) DEFAULT NULL,
  `depende` varchar(100) DEFAULT NULL,
  `papa` varchar(100) DEFAULT NULL,
  `mama` varchar(100) DEFAULT NULL,
  `hermanos` int(11) DEFAULT NULL,
  `actividad` varchar(200) DEFAULT NULL,
  `casa` varchar(50) DEFAULT NULL,
  `beca_interna` varchar(200) DEFAULT NULL,
  `beca_externa` varchar(200) DEFAULT NULL,
  `cualidades` text DEFAULT NULL,
  `areas` text DEFAULT NULL,
  `valores` text DEFAULT NULL,
  `disgusta` text DEFAULT NULL,
  `tres` text DEFAULT NULL,
  `novio` varchar(50) DEFAULT NULL,
  `matrimonio` varchar(50) DEFAULT NULL,
  `futuro_personal` text DEFAULT NULL,
  `futuro_academico` text DEFAULT NULL,
  `futuro_profesional` text DEFAULT NULL,
  `tiempo_libre` text DEFAULT NULL,
  `medico` varchar(50) DEFAULT NULL,
  `procedencia` varchar(100) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `promedio` decimal(4,2) DEFAULT NULL,
  `admision` varchar(50) DEFAULT NULL,
  `razon_universidad` text DEFAULT NULL,
  `opcion_universidad` text DEFAULT NULL,
  `opcion_carrera` text DEFAULT NULL,
  `esperas` text DEFAULT NULL,
  `examena` varchar(50) DEFAULT NULL,
  `razon_examena` text DEFAULT NULL,
  `dificultad_materias` text DEFAULT NULL,
  `materiab` text DEFAULT NULL,
  `materiasa` text DEFAULT NULL,
  `tecnica` text DEFAULT NULL,
  `tecnicasa` text DEFAULT NULL,
  `libros` text DEFAULT NULL,
  `libros_detalle` text DEFAULT NULL,
  `computadora` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudio_se`
--

CREATE TABLE `estudio_se` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `matricula` varchar(255) DEFAULT NULL,
  `grupo` varchar(255) DEFAULT NULL,
  `cuatrimestre` int(11) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `estudio_se` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluaciones_activas`
--

CREATE TABLE `evaluaciones_activas` (
  `id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evaluaciones_activas`
--

INSERT INTO `evaluaciones_activas` (`id`, `estado`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_calificaciones`
--

CREATE TABLE `historial_calificaciones` (
  `id` int(11) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `calificacion` float NOT NULL,
  `cuatrimestre` int(11) DEFAULT NULL,
  `grupo` varchar(7) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `generacion` int(11) NOT NULL,
  `periodo_inicio` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_calificaciones`
--

INSERT INTO `historial_calificaciones` (`id`, `id_carrera`, `matricula`, `id_materia`, `calificacion`, `cuatrimestre`, `grupo`, `periodo`, `anio`, `generacion`, `periodo_inicio`) VALUES
(1, 1, 13191205163, 16, 9, 1, '1MSC1', 1, 2023, 2023, 1),
(2, 1, 13191205163, 17, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(3, 1, 13191205163, 18, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(4, 1, 13191205163, 19, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(5, 1, 13191205163, 20, 5, 1, '1MSC1', 1, 2023, 2023, 1),
(6, 1, 13191205163, 21, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(7, 1, 13191205163, 22, 9, 1, '1MSC1', 1, 2023, 2023, 1),
(8, 1, 13191205163, 23, 5, 2, '2MSC1', 1, 2023, 2023, 1),
(9, 1, 13191205163, 24, 5, 2, '2MSC1', 1, 2023, 2023, 1),
(10, 1, 13191205163, 25, 10, 2, '2MSC1', 1, 2023, 2023, 1),
(11, 1, 13191205163, 26, 10, 2, '2MSC1', 1, 2023, 2023, 1),
(12, 1, 13191205163, 27, 10, 2, '2MSC1', 1, 2023, 2023, 1),
(13, 1, 13191205163, 28, 10, 2, '2MSC1', 1, 2023, 2023, 1),
(14, 1, 13191205163, 29, 10, 2, '2MSC1', 1, 2023, 2023, 1),
(15, 1, 13191205163, 37, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(16, 1, 13191205163, 38, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(17, 1, 13191205163, 39, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(18, 1, 13191205163, 40, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(19, 1, 13191205163, 41, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(20, 1, 13191205163, 42, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(21, 1, 13191205163, 43, 8, 3, '3MSC1', 1, 2023, 2023, 1),
(22, 1, 13191205163, 44, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(23, 1, 13191205163, 45, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(24, 1, 13191205163, 46, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(25, 1, 13191205163, 47, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(26, 1, 13191205163, 48, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(27, 1, 13191205163, 49, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(28, 1, 13191205163, 50, 8, 4, '4MSC1', 2, 2023, 2023, 1),
(29, 1, 13191205163, 51, 8, 5, '5MSC1', 1, 2023, 2023, 1),
(30, 1, 13191205163, 52, 8, 5, '5MSC1', 1, 2023, 2023, 1),
(31, 1, 13191205163, 53, 8, 5, '5MSC1', 1, 2023, 2023, 1),
(32, 1, 13191205163, 54, 8, 5, '5MSC1', 1, 2023, 2023, 1),
(33, 1, 13191205163, 55, 8, 5, '5MSC1', 1, 2023, 2023, 1),
(34, 1, 13191205163, 56, 10, 5, '5MSC1', 1, 2023, 2023, 1),
(35, 1, 13191205163, 57, 5, 5, '5MSC1', 1, 2023, 2023, 1),
(36, 1, 12345678, 16, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(37, 1, 12345678, 17, 9, 1, '1MSC1', 1, 2023, 2023, 1),
(38, 1, 12345678, 18, 7, 1, '1MSC1', 1, 2023, 2023, 1),
(39, 1, 12345678, 19, 8, 1, '1MSC1', 1, 2023, 2023, 1),
(40, 1, 12345678, 20, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(41, 1, 12345678, 21, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(42, 1, 12345678, 22, 10, 1, '1MSC1', 1, 2023, 2023, 1),
(43, 1, 13191205163, 68, 10, 6, '1MSC1', 1, 2023, 2023, 1),
(44, 1, 13191205163, 69, 5, 6, '1MSC1', 1, 2023, 2023, 1),
(45, 1, 13191205163, 70, 8, 6, '1MSC1', 1, 2023, 2023, 1),
(46, 1, 13191205163, 71, 10, 6, '1MSC1', 1, 2023, 2023, 1),
(47, 1, 13191205163, 72, 7, 6, '1MSC1', 1, 2023, 2023, 1),
(48, 1, 13191205163, 73, 8, 6, '1MSC1', 1, 2023, 2023, 1),
(49, 1, 13191205163, 74, 10, 6, '1MSC1', 1, 2023, 2023, 1),
(50, 1, 13201305123, 16, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(51, 1, 13201305123, 17, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(52, 1, 13201305123, 18, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(53, 1, 13201305123, 19, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(54, 1, 13201305123, 20, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(55, 1, 13201305123, 21, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(56, 1, 13201305123, 22, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(57, 1, 13201305123, 23, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(58, 1, 13201305123, 24, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(59, 1, 13201305123, 25, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(60, 1, 13201305123, 26, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(61, 1, 13201305123, 27, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(62, 1, 13201305123, 28, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(63, 1, 13201305123, 29, 8, 2, '2MSC1', 1, 2024, 2024, 1),
(64, 1, 13201305123, 37, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(65, 1, 13201305123, 38, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(66, 1, 13201305123, 39, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(67, 1, 13201305123, 40, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(68, 1, 13201305123, 41, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(69, 1, 13201305123, 42, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(70, 1, 13201305123, 43, 9, 3, '3MSC1', 1, 2024, 2024, 1),
(71, 1, 13201305089, 16, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(72, 1, 13201305089, 17, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(73, 1, 13201305089, 18, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(74, 1, 13201305089, 19, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(75, 1, 13201305089, 20, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(76, 1, 13201305089, 21, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(77, 1, 13201305089, 22, 9, 1, '1MSC1', 1, 2024, 2024, 1),
(78, 3, 13201305999, 176, 9, 1, '1MET1', 1, 2024, 2024, 1),
(79, 3, 13201305999, 177, 8, 1, '1MET1', 1, 2024, 2024, 1),
(80, 3, 13201305999, 178, 8, 1, '1MET1', 1, 2024, 2024, 1),
(81, 3, 13201305999, 179, 8, 1, '1MET1', 1, 2024, 2024, 1),
(82, 3, 13201305999, 180, 8, 1, '1MET1', 1, 2024, 2024, 1),
(83, 3, 13201305999, 181, 8, 1, '1MET1', 1, 2024, 2024, 1),
(84, 3, 13201305999, 182, 8, 1, '1MET1', 1, 2024, 2024, 1),
(85, 4, 13201305777, 233, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(86, 4, 13201305777, 234, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(87, 4, 13201305777, 235, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(88, 4, 13201305777, 236, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(89, 4, 13201305777, 237, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(90, 4, 13201305777, 238, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(91, 4, 13201305777, 239, 9, 1, '1VLT0', 1, 2024, 2024, 1),
(92, 4, 13201305777, 240, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(93, 4, 13201305777, 241, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(94, 4, 13201305777, 242, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(95, 4, 13201305777, 243, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(96, 4, 13201305777, 244, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(97, 4, 13201305777, 245, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(98, 4, 13201305777, 246, 10, 2, '2VLT0', 1, 2024, 2024, 1),
(99, 4, 13201305777, 247, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(100, 4, 13201305777, 248, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(101, 4, 13201305777, 249, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(102, 4, 13201305777, 250, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(103, 4, 13201305777, 251, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(104, 4, 13201305777, 252, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(105, 4, 13201305777, 253, 9, 3, '3VLT0', 1, 2024, 2024, 1),
(106, 4, 13201305777, 254, 9, 4, '4VLT0', 1, 2024, 2024, 1),
(107, 4, 13201305777, 255, 9, 4, '4VLT0', 1, 2024, 2024, 1),
(108, 4, 13201305777, 256, 9, 4, '4VLT0', 1, 2024, 2024, 1),
(109, 4, 13201305777, 257, 9, 4, '4VLT0', 1, 2024, 2024, 1),
(110, 4, 13201305777, 258, 9, 4, '4VLT0', 1, 2024, 2024, 1),
(111, 4, 13201305777, 259, 10, 4, '4VLT0', 1, 2024, 2024, 1),
(112, 4, 13201305777, 260, 10, 4, '4VLT0', 1, 2024, 2024, 1),
(113, 1, 13201305155, 16, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(114, 1, 13201305155, 17, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(115, 1, 13201305155, 18, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(116, 1, 13201305155, 19, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(117, 1, 13201305155, 20, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(118, 1, 13201305155, 21, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(119, 1, 13201305155, 22, 9, 1, '1MSC0', 1, 2024, 2024, 1),
(120, 1, 13201305155, 23, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(121, 1, 13201305155, 24, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(122, 1, 13201305155, 25, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(123, 1, 13201305155, 26, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(124, 1, 13201305155, 27, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(125, 1, 13201305155, 28, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(126, 1, 13201305155, 29, 9, 2, '2MSC0', 1, 2024, 2024, 1),
(127, 1, 13201305155, 37, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(128, 1, 13201305155, 38, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(129, 1, 13201305155, 39, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(130, 1, 13201305155, 40, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(131, 1, 13201305155, 41, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(132, 1, 13201305155, 42, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(133, 1, 13201305155, 43, 9, 3, '3MSC0', 1, 2024, 2024, 1),
(134, 1, 13201305155, 44, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(135, 1, 13201305155, 45, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(136, 1, 13201305155, 46, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(137, 1, 13201305155, 47, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(138, 1, 13201305155, 48, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(139, 1, 13201305155, 49, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(140, 1, 13201305155, 50, 9, 4, '4MSC0', 1, 2024, 2024, 1),
(141, 1, 13201305155, 51, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(142, 1, 13201305155, 52, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(143, 1, 13201305155, 53, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(144, 1, 13201305155, 54, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(145, 1, 13201305155, 55, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(146, 1, 13201305155, 56, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(147, 1, 13201305155, 57, 9, 5, '5MSC0', 1, 2024, 2024, 1),
(148, 1, 13201305155, 68, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(149, 1, 13201305155, 69, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(150, 1, 13201305155, 70, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(151, 1, 13201305155, 71, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(152, 1, 13201305155, 72, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(153, 1, 13201305155, 73, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(154, 1, 13201305155, 74, 9, 6, '6MSC0', 1, 2024, 2024, 1),
(155, 1, 13201305155, 75, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(156, 1, 13201305155, 76, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(157, 1, 13201305155, 77, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(158, 1, 13201305155, 78, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(159, 1, 13201305155, 79, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(160, 1, 13201305155, 80, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(161, 1, 13201305155, 81, 9, 7, '7MSC0', 1, 2024, 2024, 1),
(162, 1, 13201305189, 16, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(163, 1, 13201305189, 17, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(164, 1, 13201305189, 18, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(165, 1, 13201305189, 19, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(166, 1, 13201305189, 20, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(167, 1, 13201305189, 21, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(168, 1, 13201305189, 22, 9, 1, '1MSC1', 2, 2024, 2024, 1),
(169, 1, 13211405309, 16, 10, 1, '1VSC1', 3, 2024, 2023, 2),
(170, 1, 13211405309, 17, 10, 1, '1VSC1', 3, 2024, 2023, 2),
(171, 1, 13211405309, 18, 9, 1, '1VSC1', 3, 2024, 2023, 2),
(172, 1, 13211405309, 19, 8, 1, '1VSC1', 3, 2024, 2023, 2),
(173, 1, 13211405309, 20, 7, 1, '1VSC1', 3, 2024, 2023, 2),
(174, 1, 13211405309, 21, 9, 1, '1VSC1', 3, 2024, 2023, 2),
(175, 1, 13211405309, 22, 10, 1, '1VSC1', 3, 2024, 2023, 2),
(176, 1, 13201305189, 23, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(177, 1, 13201305189, 24, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(178, 1, 13201305189, 25, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(179, 1, 13201305189, 26, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(180, 1, 13201305189, 27, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(181, 1, 13201305189, 28, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(182, 1, 13201305189, 29, 9, 2, '2MSC1', 3, 2025, 2024, 1),
(183, 1, 13201305156, 16, 10, 1, '1MSC1', 2, 2025, 2025, 1),
(184, 1, 13201305156, 17, 10, 1, '1MSC1', 2, 2025, 2025, 1),
(185, 1, 13201305156, 18, 10, 1, '1MSC1', 2, 2025, 2025, 1),
(186, 1, 13201305156, 19, 10, 1, '1MSC1', 2, 2025, 2025, 1),
(187, 1, 13201305156, 20, 10, 1, '1MSC1', 2, 2025, 2025, 1),
(188, 1, 13201305156, 21, 10, 1, '1MSC1', 2, 2025, 2025, 1),
(189, 1, 13201305156, 22, 10, 1, '1MSC1', 2, 2025, 2025, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_grupos`
--

CREATE TABLE `historial_grupos` (
  `id` int(11) NOT NULL,
  `matricula` bigint(20) NOT NULL,
  `grupo` varchar(7) NOT NULL,
  `cuatrimestre` varchar(2) NOT NULL,
  `generacion` int(11) NOT NULL,
  `promedio` float NOT NULL,
  `periodo` tinyint(1) NOT NULL,
  `periodo_inicio` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_grupos`
--

INSERT INTO `historial_grupos` (`id`, `matricula`, `grupo`, `cuatrimestre`, `generacion`, `promedio`, `periodo`, `periodo_inicio`) VALUES
(53, 13201305155, '1MSC0', '1', 2024, 9, 1, 1),
(54, 13201305155, '2MSC0', '2', 2024, 9, 1, 1),
(55, 13201305155, '3MSC0', '3', 2024, 9, 1, 1),
(56, 13201305155, '4MSC0', '4', 2024, 9, 1, 1),
(57, 13201305155, '5MSC0', '5', 2024, 9, 1, 1),
(58, 13201305155, '6MSC0', '6', 2024, 9, 1, 1),
(59, 13201305155, '7MSC0', '7', 2024, 9, 1, 1),
(60, 13201305189, '1MSC1', '1', 2024, 9, 2, 1),
(62, 13201305189, '2MSC1', '2', 2024, 9, 3, 1),
(63, 13201305156, '1MSC1', '1', 2025, 10, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materias` int(11) NOT NULL,
  `materia` varchar(60) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `cuatrimestre` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materias`, `materia`, `id_carrera`, `cuatrimestre`, `descripcion`, `active`) VALUES
(16, 'Inglés 1', 1, 1, 'Aprenderás las bases del inglés para comunicarte de manera básica', 1),
(17, 'Química básica', 1, 1, 'Introducción a los conceptos fundamentales de la química', 1),
(18, 'Álgebra lineal', 1, 1, 'Estudio de los espacios vectoriales y las transformaciones lineales', 1),
(19, 'Introducción a la programación', 1, 1, 'Aprenderás los fundamentos de la programación y el desarrollo de algoritmos', 1),
(20, 'Introducción a las tecnologías de información', 1, 1, 'Conocerás los conceptos básicos relacionados con las tecnologías de la información', 1),
(21, 'Herramientas ofimáticas', 1, 1, 'Aprenderás a utilizar herramientas ofimáticas para mejorar la productividad', 1),
(22, 'Expresión oral y escrita 1', 1, 1, 'Desarrollarás habilidades de comunicación oral y escrita', 1),
(23, 'Inglés 2', 1, 2, 'Continuarás mejorando tus habilidades de comunicación en inglés', 1),
(24, 'Desarrollo humano y valores', 1, 2, 'Explorarás conceptos de desarrollo humano y valores éticos', 1),
(25, 'Funciones matemáticas', 1, 2, 'Estudiarás funciones matemáticas y sus aplicaciones', 1),
(26, 'Física', 1, 2, 'Aprenderás los principios fundamentales de la física y sus aplicaciones', 1),
(27, 'Electricidad y magnetismo', 1, 2, 'Estudiarás los conceptos básicos de electricidad y magnetismo y sus aplicaciones en la tecnología', 1),
(28, 'Matemáticas básicas para computación', 1, 2, 'Aprenderás matemáticas aplicadas a la computación y la resolución de problemas', 1),
(29, 'Arquitectura de computadoras', 1, 2, 'Conocerás la estructura y funcionamiento de los sistemas de cómputo', 1),
(37, 'Inglés 3', 1, 3, 'Continuarás avanzando en tus habilidades de comunicación en inglés', 1),
(38, 'Inteligencia emocional y manejo de conflictos', 1, 3, 'Desarrollarás habilidades de inteligencia emocional y aprenderás a manejar conflictos', 1),
(39, 'Cálculo diferencial', 1, 3, 'Aprenderás los conceptos fundamentales del cálculo diferencial y sus aplicaciones', 1),
(40, 'Probabilidad y estadística', 1, 3, 'Estudiarás los conceptos básicos de probabilidad y estadística y sus aplicaciones en la ciencia de datos', 1),
(41, 'Programación', 1, 3, 'Profundizarás en los conceptos y técnicas de programación y desarrollo de software', 1),
(42, 'Introducción a redes', 1, 3, 'Conocerás los fundamentos de las redes de computadoras y su funcionamiento', 1),
(43, 'Mantenimiento a equipo de cómputo', 1, 3, 'Aprenderás técnicas y procedimientos para realizar mantenimiento a equipos de cómputo', 1),
(44, 'Inglés 4', 1, 4, 'Seguirás mejorando tus habilidades de comunicación en inglés a un nivel más avanzado', 1),
(45, 'Habilidades cognitivas y creatividad', 1, 4, 'Desarrollarás habilidades cognitivas y fomentarás la creatividad en la resolución de problemas', 1),
(46, 'Cálculo integral', 1, 4, 'Aprenderás los conceptos fundamentales del cálculo integral y sus aplicaciones', 1),
(47, 'Ingeniería de software', 1, 4, 'Estudiarás los principios y técnicas de la ingeniería de software y el desarrollo de sistemas', 1),
(48, 'Estructura de datos', 1, 4, 'Aprenderás sobre las diferentes estructuras de datos y su implementación en la programación', 1),
(49, 'Ruteo y comunicación', 1, 4, 'Conocerás los conceptos de ruteo y comunicación en redes de computadoras', 1),
(50, 'Estancia 1', 1, 4, 'Realizarás una estancia en una empresa o institución para aplicar tus conocimientos adquiridos', 1),
(51, 'Inglés 5', 1, 5, 'Continuarás perfeccionando tus habilidades de comunicación en inglés', 1),
(52, 'Ética profesional', 1, 5, 'Estudiarás los principios éticos y responsabilidades profesionales en la ingeniería', 1),
(53, 'Matemáticas para ingeniería 1', 1, 5, 'Aprenderás matemáticas aplicadas a problemas de ingeniería', 1),
(54, 'Física para ingeniería', 1, 5, 'Estudiarás física aplicada a problemas de ingeniería', 1),
(55, 'Fundamentos de programación orientada a objetos', 1, 5, 'Aprenderás los conceptos básicos de la programación orientada a objetos', 1),
(56, 'Escalamiento de redes', 1, 5, 'Estudiarás técnicas y conceptos para el escalamiento de redes de computadoras', 1),
(57, 'Base de datos', 1, 5, 'Conocerás los fundamentos de las bases de datos y su administración', 1),
(68, 'Inglés 6', 1, 6, 'Alcanzarás un alto nivel de competencia en la comunicación en inglés', 1),
(69, 'Habilidades gerenciales', 1, 6, 'Desarrollarás habilidades gerenciales y de liderazgo para la gestión de proyectos', 1),
(70, 'Matemáticas para ingeniería 2', 1, 6, 'Continuarás aprendiendo matemáticas aplicadas a problemas de ingeniería', 1),
(71, 'Sistemas operativos', 1, 6, 'Estudiarás los principios y arquitectura de los sistemas operativos', 1),
(72, 'Programación orientada a objetos', 1, 6, 'Profundizarás en la programación orientada a objetos y sus aplicaciones', 1),
(73, 'Interconexión de redes', 1, 6, 'Estudiarás técnicas y protocolos para la interconexión de redes de computadoras', 1),
(74, 'Administración de base de datos', 1, 6, 'Aprenderás técnicas y herramientas para la administración de bases de datos', 1),
(75, 'Inglés 7', 1, 7, 'Continuarás perfeccionando tus habilidades de comunicación en inglés a un nivel avanzado', 1),
(76, 'Liderazgo de equipos de alto desempeño', 1, 7, 'Aprenderás técnicas y habilidades para liderar equipos de alto rendimiento', 1),
(77, 'Formulación de proyectos de tecnologías de información', 1, 7, 'Estudiarás metodologías para la formulación y gestión de proyectos en el área de tecnologías de información', 1),
(78, 'Lenguajes y autómatas', 1, 7, 'Aprenderás sobre lenguajes formales, autómatas y gramáticas en la teoría de la computación', 1),
(79, 'Programación web', 1, 7, 'Conocerás tecnologías y técnicas para el desarrollo de aplicaciones web', 1),
(80, 'Ingeniería de requisitos', 1, 7, 'Estudiarás el proceso de identificación, análisis y especificación de requisitos en proyectos de software', 1),
(81, 'Estancia 2', 1, 7, 'Realizarás una segunda estancia en una empresa o institución para aplicar tus conocimientos adquiridos', 1),
(82, 'Inglés 8', 1, 8, 'Dominarás la comunicación en inglés a nivel profesional', 1),
(83, 'Tecnologías de virtualización', 1, 8, 'Estudiarás las tecnologías de virtualización y su aplicación en entornos empresariales', 1),
(84, 'Administración de proyectos de tecnologías de información', 1, 8, 'Aprenderás a administrar proyectos en el área de tecnologías de información', 1),
(85, 'Tecnologías y aplicaciones en internet', 1, 8, 'Conocerás las tecnologías y aplicaciones más recientes en el ámbito de internet', 1),
(86, 'Diseño de interfaces', 1, 8, 'Aprenderás sobre el diseño de interfaces de usuario y la experiencia del usuario', 1),
(87, 'Sistemas inteligentes', 1, 8, 'Estudiarás los fundamentos de los sistemas inteligentes y sus aplicaciones', 1),
(88, 'Gestión de desarrollo de software', 1, 8, 'Aprenderás técnicas y herramientas para la gestión del desarrollo de software', 1),
(89, 'Inglés 9', 1, 9, 'Perfeccionarás tus habilidades de comunicación en inglés a nivel experto', 1),
(90, 'Inteligencia de negocios', 1, 9, 'Estudiarás técnicas y herramientas para el análisis y toma de decisiones en base a datos', 1),
(92, 'Desarrollo de negocios para tecnologías de información', 1, 9, 'Estudiarás cómo aplicar técnicas de desarrollo de negocios en el campo de las tecnologías de información', 1),
(93, 'Sistemas embebidos', 1, 9, 'Aprenderás sobre el diseño y desarrollo de sistemas embebidos y su aplicación en diferentes campos', 1),
(94, 'Programación móvil', 1, 9, 'Estudiarás el desarrollo de aplicaciones para dispositivos móviles y plataformas específicas', 1),
(95, 'Seguridad informática', 1, 9, 'Aprenderás sobre la protección de sistemas informáticos y redes de comunicaciones', 1),
(96, 'Expresión oral y escrita 2', 1, 9, 'Continuarás desarrollando tus habilidades de comunicación oral y escrita en español', 1),
(97, 'Estadía profesional', 1, 10, 'Aplicarás tus conocimientos y habilidades en un entorno profesional real', 1),
(112, 'Inglés 1', 2, 1, 'Inglés 1: materia introductoria al idioma inglés. Aprende vocabulario, gramática y habilidades básicas de lectura y escritura.', 1),
(113, 'Desarrollo Humano y Valores', 2, 1, 'Desarrolla habilidades socioemocionales y éticas para formar profesionales íntegros y comprometidos con su entorno.', 1),
(114, 'Álgebra Lineal', 2, 1, 'El álgebra lineal estudia los sistemas de ecuaciones lineales y sus propiedades. Fundamental en ciencia e ingeniería.', 1),
(115, 'Química Básica', 2, 1, 'La química básica es una materia introductoria a los conceptos fundamentales de la química. Fundamental en ciencia e ingeniería.', 1),
(116, 'Funciones Matemáticas', 2, 1, 'Herramientas fundamentales para el análisis de problemas en áreas como la física, la economía y la ingeniería. Estudio de funciones y propiedades bási', 1),
(117, 'Metrología', 2, 1, 'La metrología es la ciencia de la medición, fundamental para la calidad en la industria y la ciencia. Estudio de técnicas de medición y calibración.', 1),
(118, 'Expresión Oral y Escrita', 2, 1, 'Desarrolla habilidades de comunicación oral y escrita efectivas en el ámbito profesional. Aprende técnicas de presentación, escritura y argumentación.', 1),
(119, 'Inglés 2', 2, 2, 'Aprende gramática, vocabulario y habilidades de comunicación en inglés. Intermedio.', 1),
(120, 'Inteligencia Emocional y Manejo de Conflictos', 2, 2, 'Desarrolla habilidades de inteligencia emocional y manejo de conflictos. Personal y profesional.', 1),
(121, 'Cálculo Diferencial', 2, 2, 'Aprende cálculo diferencial y sus aplicaciones en la ciencia y la ingeniería.', 1),
(122, 'Física', 2, 2, 'Estudia los fundamentos de la física y su aplicación en la comprensión del mundo natural.', 1),
(123, 'Electricidad y Magnetismo', 2, 2, 'Estudia los fenómenos eléctricos y magnéticos y sus aplicaciones en ingeniería.', 1),
(124, 'Mantenimiento y Seguridad Industrial', 2, 2, 'Aprende procesos de mantenimiento y seguridad industrial para garantizar calidad y seguridad.', 1),
(125, 'Dibujo para Ingeniería', 2, 2, 'Aprende técnicas y herramientas de dibujo para la representación gráfica en ingeniería.', 1),
(126, 'Inglés 3', 2, 3, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(127, 'Habilidades Cognitivas y Creatividad', 2, 3, 'Desarrollo de habilidades cognitivas y creatividad para la resolución de problemas.', 1),
(128, 'Cálculo Integral', 2, 3, 'Estudio del cálculo integral y sus aplicaciones en la ciencia y la ingeniería.', 1),
(129, 'Probabilidad y Estadística', 2, 3, 'Estudio de la probabilidad y estadística y sus aplicaciones en la toma de decisiones.', 1),
(130, 'Mecánica de Cuerpo Rígido', 2, 3, 'Estudio de la mecánica de cuerpo rígido y sus aplicaciones en la ingeniería.', 1),
(131, 'Administración de Mantenimiento', 2, 3, 'Estudio de la administración de mantenimiento y sus aplicaciones en la industria.', 1),
(132, 'Circuitos Eléctricos y Electrónicos', 2, 3, 'Estudio de los circuitos eléctricos y electrónicos y sus aplicaciones en la ingeniería.', 1),
(133, 'Inglés 4', 2, 4, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(134, 'Ética Profesional', 2, 4, 'Estudio de la ética profesional y su aplicación en la toma de decisiones y la responsabilidad social.', 1),
(135, 'Estructura y Propiedades de los Materiales', 2, 4, 'Estudio de la estructura y propiedades de los materiales y su aplicación en la ingeniería.', 1),
(136, 'Programación de Periféricos', 2, 4, 'Aprende a programar periféricos y su aplicación en la automatización de procesos.', 1),
(137, 'Sistemas Electrónicos de Interfaz', 2, 4, 'Estudio de los sistemas electrónicos de interfaz y su aplicación en la ingeniería.', 1),
(138, 'Controladores Lógicos Programables', 2, 4, 'Estudio de los controladores lógicos programables y su aplicación en la automatización de procesos.', 1),
(139, 'Estancia 1', 2, 4, 'Estancia profesional en la que se aplica lo aprendido en un ambiente real.', 1),
(140, 'Inglés 5', 2, 5, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(141, 'Habilidades Gerenciales', 2, 5, 'Desarrollo de habilidades gerenciales para la dirección de equipos y proyectos.', 1),
(142, 'Matemáticas para Ingeniería 1', 2, 5, 'Estudio de las matemáticas para la ingeniería y su aplicación en la resolución de problemas.', 1),
(143, 'Física para Ingeniería', 2, 5, 'Estudio de la física y su aplicación en la ingeniería.', 1),
(144, 'Procesos de Manufactura', 2, 5, 'Estudio de los procesos de manufactura y su aplicación en la producción de bienes.', 1),
(145, 'Sistemas Digitales', 2, 5, 'Estudio de los sistemas digitales y su aplicación en la ingeniería.', 1),
(146, 'Sistemas Neumáticos e Hidráulicos', 2, 5, 'Estudio de los sistemas neumáticos e hidráulicos y su aplicación en la ingeniería.', 1),
(147, 'Inglés 6', 2, 6, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(148, 'Liderazgo de Equipos de Alto Desempeño', 2, 6, 'Desarrollo de habilidades de liderazgo para la dirección de equipos de trabajo.', 1),
(149, 'Matemáticas para la Ingeniería', 2, 6, 'Estudio de las matemáticas para la ingeniería y su aplicación en la resolución de problemas.', 1),
(150, 'Resistencia de Materiales', 2, 6, 'Estudio de la resistencia de materiales y su aplicación en la ingeniería.', 1),
(151, 'Cinemática de Mecanismos', 2, 6, 'Estudio de la cinemática de mecanismos y su aplicación en la ingeniería.', 1),
(152, 'Automatización Industrial', 2, 6, 'Estudio de la automatización industrial y su aplicación en la producción de bienes.', 1),
(153, 'Control de Motores Eléctricos', 2, 6, 'Estudio del control de motores eléctricos y su aplicación en la ingeniería.', 1),
(154, 'Inglés 7', 2, 7, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(155, 'Programación de Sistemas Embebidos', 2, 7, 'Estudio de la programación de sistemas embebidos y su aplicación en la ingeniería.', 1),
(156, 'Modelado y Simulación de Sistemas', 2, 7, 'Estudio del modelado y simulación de sistemas y su aplicación en la ingeniería.', 1),
(157, 'Diseño y Selección de Elementos Mecánicos', 2, 7, 'Estudio del diseño y selección de elementos mecánicos y su aplicación en la ingeniería.', 1),
(158, 'Cinemática de Robots', 2, 7, 'Estudio de la cinemática de robots y su aplicación en la ingeniería.', 1),
(159, 'Programación de Robots Industriales', 2, 7, 'Estudio de la programación de robots industriales y su aplicación en la producción de bienes.', 1),
(160, 'Estancia 2', 2, 7, 'Estancia profesional en la que se aplica lo aprendido en un ambiente real.', 1),
(161, 'Inglés 8', 2, 8, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(162, 'Diseño de Sistemas Mecatrónicos', 2, 8, 'Estudio del diseño de sistemas mecatrónicos y su aplicación en la ingeniería.', 1),
(163, 'Ingeniería de Control', 2, 8, 'Estudio de la ingeniería de control y su aplicación en la automatización de procesos.', 1),
(164, 'Ingeniería Asistida por Computadora', 2, 8, 'Estudio de la ingeniería asistida por computadora y su aplicación en la simulación y diseño de sistemas.', 1),
(165, 'Dinámica de Robots', 2, 8, 'Estudio de la dinámica de robots y su aplicación en la ingeniería.', 1),
(166, 'Sistemas de Visión Artificial', 2, 8, 'Estudio de los sistemas de visión artificial y su aplicación en la automatización de procesos.', 1),
(167, 'Adquisición y Procesamiento Digital de Señales', 2, 8, 'Estudio de la adquisición y procesamiento digital de señales y su aplicación en la ingeniería.', 1),
(168, 'Inglés 9', 2, 9, 'Curso avanzado de inglés para la comunicación en entornos académicos y profesionales.', 1),
(169, 'Integración de Sistemas Mecatrónicos y Robóticos', 2, 9, 'Estudio de la integración de sistemas mecatrónicos y robóticos y su aplicación en la ingeniería.', 1),
(170, 'Control Avanzado', 2, 9, 'Estudio del control avanzado y su aplicación en la automatización de procesos.', 1),
(171, 'Sistemas Avanzados de Manufactura', 2, 9, 'Estudio de los sistemas avanzados de manufactura y su aplicación en la producción de bienes.', 1),
(172, 'Control de Robots', 2, 9, 'Estudio del control de robots y su aplicación en la producción de bienes.', 1),
(173, 'Termodinámica', 2, 9, 'Estudio de la termodinámica y su aplicación en la ingeniería.', 1),
(175, 'Expresión Oral y Escrita 2', 2, 9, 'Desarrollo de habilidades de comunicación oral y escrita efectivas en el ámbito profesional.', 1),
(176, 'Inglés 1', 3, 1, 'Materia de inglés para comunicación básica en el ámbito laboral', 1),
(177, 'Valores del Ser', 3, 1, 'Materia que promueve el desarrollo humano y ético en el ámbito profesional', 1),
(178, 'Tópicos de Ingeniería en Electrónica y Telecomunicaciones', 3, 1, 'Materia que introduce los conceptos fundamentales de electrónica y telecomunicaciones', 1),
(179, 'Fundamentos de Química', 3, 1, 'Materia que introduce los conceptos básicos de la química', 1),
(180, 'Fundamentos de Física', 3, 1, 'Materia que introduce los conceptos básicos de la física', 1),
(181, 'Cálculo Diferencial e Integral', 3, 1, 'Materia que introduce los conceptos fundamentales del cálculo diferencial e integral', 1),
(182, 'Lógica de Programación', 3, 1, 'Materia que introduce los conceptos fundamentales de la programación', 1),
(183, 'Inglés 2', 3, 2, 'Materia de inglés para comunicación avanzada en el ámbito laboral', 1),
(184, 'Inteligencia Emocional', 3, 2, 'Materia que desarrolla habilidades para el manejo de emociones y relaciones interpersonales', 1),
(185, 'Mantenimiento Electrónico', 3, 2, 'Materia que introduce los conceptos fundamentales del mantenimiento de equipos electrónicos', 1),
(186, 'Cálculo Vectorial', 3, 2, 'Materia que introduce los conceptos fundamentales del cálculo vectorial', 1),
(187, 'Electricidad y Magnetismo', 3, 2, 'Materia que introduce los conceptos fundamentales de la electricidad y el magnetismo', 1),
(188, 'Álgebra Lineal', 3, 2, 'Materia que introduce los conceptos fundamentales del álgebra lineal', 1),
(189, 'Programación Estructurada', 3, 2, 'Materia que introduce los conceptos fundamentales de la programación estructurada', 1),
(190, 'Inglés 3', 3, 3, 'Materia de inglés avanzado para comunicación empresarial', 1),
(191, 'Desarrollo Interpersonal', 3, 3, 'Materia que busca el desarrollo personal y profesional de los estudiantes', 1),
(192, 'Circuitos en Corriente Directa', 3, 3, 'Materia que introduce los conceptos fundamentales de los circuitos eléctricos en corriente directa', 1),
(193, 'Ecuaciones Diferenciales', 3, 3, 'Materia que introduce los conceptos fundamentales de las ecuaciones diferenciales', 1),
(194, 'Circuitos Lógicos', 3, 3, 'Materia que introduce los conceptos fundamentales de los circuitos lógicos', 1),
(195, 'Probabilidad y Estadística', 3, 3, 'Materia que introduce los conceptos fundamentales de la probabilidad y la estadística', 1),
(196, 'Programación de Periféricos', 3, 3, 'Materia que introduce los conceptos fundamentales de la programación de periféricos', 1),
(197, 'Inglés 4', 3, 4, 'Materia de inglés avanzado para la comunicación en contextos empresariales y tecnológicos', 1),
(198, 'Habilidades del Pensamiento', 3, 4, 'Materia que busca el desarrollo de habilidades para el pensamiento crítico y la resolución de problemas', 1),
(199, 'Circuitos en Corriente Alterna', 3, 4, 'Materia que introduce los conceptos fundamentales de los circuitos eléctricos en corriente alterna', 1),
(200, 'Análisis de Dispositivos Electrónicos', 3, 4, 'Materia que introduce los conceptos fundamentales del análisis de dispositivos electrónicos', 1),
(201, 'Sistemas Digitales', 3, 4, 'Materia que introduce los conceptos fundamentales de los sistemas digitales', 1),
(202, 'Procesos Estocásticos', 3, 4, 'Materia que introduce los conceptos fundamentales de los procesos estocásticos', 1),
(203, 'Estancia 1', 3, 4, 'Materia que busca integrar los conocimientos adquiridos en proyectos de aplicación práctica en el sector tecnológico', 1),
(204, 'Inglés 5', 3, 5, 'Materia de inglés avanzado para la comunicación en contextos empresariales y tecnológicos', 1),
(205, 'Habilidades Organizacionales', 3, 5, 'Materia que busca desarrollar habilidades para la organización y gestión de proyectos', 1),
(206, 'Teoría Electromagnética', 3, 5, 'Materia que introduce los conceptos fundamentales de la teoría electromagnética', 1),
(207, 'Sistemas de Amplificación', 3, 5, 'Materia que introduce los conceptos fundamentales de los sistemas de amplificación', 1),
(208, 'Diseño Digital', 3, 5, 'Materia que introduce los conceptos fundamentales del diseño digital', 1),
(209, 'Métodos Numéricos', 3, 5, 'Materia que introduce los métodos numéricos para la solución de problemas en la ingeniería', 1),
(210, 'Métodos Matemáticos', 3, 5, 'Materia que introduce los métodos matemáticos para la solución de problemas en la ingeniería', 1),
(211, 'Inglés 6', 3, 6, 'Materia de inglés avanzado para la comunicación en contextos empresariales y tecnológicos', 1),
(212, 'Ética Profesional', 3, 6, 'Materia que introduce los conceptos fundamentales de la ética profesional', 1),
(213, 'Microcontroladores', 3, 6, 'Materia que introduce los conceptos fundamentales de los microcontroladores y su programación', 1),
(214, 'Ingeniería de Control', 3, 6, 'Materia que introduce los conceptos fundamentales de la ingeniería de control', 1),
(215, 'Modulaciones Analógicas', 3, 6, 'Materia que introduce los conceptos fundamentales de las modulaciones analógicas', 1),
(216, 'Filtros Analógicos', 3, 6, 'Materia que introduce los conceptos fundamentales de los filtros analógicos', 1),
(217, 'Redes de Comunicaciones', 3, 6, 'Materia que introduce los conceptos fundamentales de las redes de comunicaciones', 1),
(218, 'Inglés 7', 3, 7, 'Materia de inglés avanzado para la comunicación en contextos empresariales y tecnológicos', 1),
(219, 'Instrumentación Electrónica', 3, 7, 'Materia que introduce los conceptos fundamentales de la instrumentación electrónica', 1),
(220, 'Control Industrial', 3, 7, 'Materia que introduce los conceptos fundamentales del control industrial', 1),
(221, 'Estancia 2', 3, 7, 'Materia de prácticas profesionales supervisadas', 1),
(222, 'Inglés 8', 3, 8, 'Materia de inglés avanzado para la comunicación en contextos empresariales y tecnológicos', 1),
(223, 'Procesamiento Digital de Señales', 3, 8, 'Materia que introduce los conceptos fundamentales del procesamiento digital de señales', 1),
(224, 'Control Digital', 3, 8, 'Materia que introduce los conceptos fundamentales del control digital', 1),
(225, 'Gestión Administrativa', 3, 8, 'Materia que introduce los conceptos fundamentales de la gestión administrativa en empresas tecnológicas', 1),
(226, 'PLC\'s', 3, 8, 'Materia que introduce los conceptos fundamentales de los controladores lógicos programables', 1),
(227, 'Inglés IX', 3, 9, 'Materia de inglés avanzado para la comunicación en contextos académicos y profesionales', 1),
(228, 'Control', 3, 9, 'Materia que profundiza en los conceptos fundamentales del control de sistemas', 1),
(229, 'Control de Calidad', 3, 9, 'Materia que introduce los conceptos fundamentales del control de calidad en empresas tecnológicas', 1),
(230, 'Seminario de Proyectos', 3, 9, 'Materia que prepara al estudiante para la elaboración y presentación de proyectos tecnológicos', 1),
(231, 'Sistemas Optoelectrónicos', 3, 9, 'Materia que introduce los conceptos fundamentales de los sistemas optoelectrónicos', 1),
(232, 'Estadía Profesional', 3, 10, 'Materia en la que el estudiante aplica los conocimientos adquiridos en la carrera en un entorno laboral real', 1),
(233, 'Inglés 1', 4, 1, 'Materia enfocada en el desarrollo de habilidades comunicativas en inglés', 1),
(234, 'Valores del Ser', 4, 1, 'Materia enfocada en el desarrollo de valores y habilidades personales', 1),
(235, 'Fundamentos de la Cadena de Suministro', 4, 1, 'Materia enfocada en los principios fundamentales de la gestión de la cadena de suministro', 1),
(236, 'Administración y Principios de Economía', 4, 1, 'Materia enfocada en los principios fundamentales de la administración y la economía', 1),
(237, 'Álgebra Lineal', 4, 1, 'Materia enfocada en los conceptos fundamentales del álgebra lineal', 1),
(238, 'Calidad en la Cadena de Suministro', 4, 1, 'Materia enfocada en la gestión de la calidad en la cadena de suministro', 1),
(239, 'Probabilidad y Estadística', 4, 1, 'Materia enfocada en los conceptos fundamentales de la probabilidad y la estadística', 1),
(240, 'ingles 2', 4, 2, 'Inglés básico para el ámbito profesional', 1),
(241, 'inteligencia emocional', 4, 2, 'Desarrollo de habilidades emocionales y sociales para mejorar la calidad de vida', 1),
(242, 'logistica del abastecimiento', 4, 2, 'Análisis y diseño de sistemas de abastecimiento en la cadena de suministro', 1),
(243, 'calculo diferencial e integral', 4, 2, 'Estudio de las funciones y sus derivadas, aplicando técnicas de cálculo integral', 1),
(244, 'quimica energitica y ambiental', 4, 2, 'Estudio de la química y su relación con la energía y el medio ambiente', 1),
(245, 'control estadistico de la calidad', 4, 2, 'Métodos y técnicas estadísticas para el control de la calidad en la cadena de suministro', 1),
(246, 'logica de programación', 4, 2, 'Introducción a la programación estructurada', 1),
(247, 'ingles 3', 4, 3, 'Materia enfocada en el desarrollo del idioma inglés', 1),
(248, 'desarrollo interpersonal', 4, 3, 'Materia enfocada en el desarrollo de habilidades sociales', 1),
(249, 'TI aplicadas a los pronosticos en la cadena de suministro', 4, 3, 'Materia enfocada en la aplicación de tecnología de información en pronósticos de la cadena de suministro', 1),
(250, 'ti aplicadas a la planeación y control de inventarios', 4, 3, 'Materia enfocada en la aplicación de tecnología de información en la planeación y control de inventarios', 1),
(251, 'temas selectos de fisica', 4, 3, 'Materia enfocada en temas específicos de física', 1),
(252, 'introducción a la operacion del transporte', 4, 3, 'Materia enfocada en la introducción a la operación del transporte', 1),
(253, 'simulación de procesos logisticos', 4, 3, 'Materia enfocada en la simulación de procesos logísticos', 1),
(254, 'ingles 4', 4, 4, 'Curso de inglés avanzado', 1),
(255, 'habilidades del pensamiento', 4, 4, 'Desarrollo de habilidades de pensamiento crítico', 1),
(256, 'logistica de la producción', 4, 4, 'Optimización de la cadena de suministro en la producción', 1),
(257, 'metodos cuantitativos para optimización', 4, 4, 'Métodos matemáticos para la optimización de procesos', 1),
(258, 'sistemas de transportación ferroviario y carretero', 4, 4, 'Diseño y operación de sistemas de transporte terrestre', 1),
(259, 'TI aplicadas al transporte', 4, 4, 'Uso de tecnología de la información en el transporte', 1),
(260, 'estancia 1', 4, 4, 'Prácticas profesionales en empresas del sector logístico', 1),
(261, 'ingles 5', 4, 5, 'Clases de inglés para nivel avanzado.', 1),
(262, 'habilidades organizacionales', 4, 5, 'Curso para desarrollar habilidades organizacionales y de liderazgo en el ámbito laboral.', 1),
(263, 'centros de distribución y almacenes', 4, 5, 'Estudio de los procesos logísticos en los centros de distribución y almacenes.', 1),
(264, 'investigación de operaciones logisticas', 4, 5, 'Aplicación de la investigación de operaciones en la optimización de la cadena de suministro.', 1),
(265, 'sistemas de transportación aereo y martitimo', 4, 5, 'Estudio de los sistemas de transporte aéreo y marítimo para la logística.', 1),
(266, 'tecnicas de seleccion y renovación vehicular', 4, 5, 'Aplicación de técnicas para seleccionar y renovar vehículos de transporte en la cadena de suministro.', 1),
(267, 'mercadotecnica', 4, 5, 'Introducción a la mercadotecnia y su aplicación en la logística.', 1),
(268, 'Ingles 6', 4, 6, 'Curso de inglés para el desarrollo de habilidades lingüísticas en el ámbito profesional', 1),
(269, 'Etica profesional', 4, 6, 'Introducción a la ética y responsabilidad social en el ámbito laboral y profesional', 1),
(270, 'Planeación estratégica', 4, 6, 'Fundamentos y herramientas para la planeación estratégica en la gestión de la cadena de suministro', 1),
(271, 'Economía del transporte', 4, 6, 'Aspectos económicos y financieros del transporte y la logística', 1),
(272, 'Administración del mantenimiento', 4, 6, 'Introducción a la administración del mantenimiento de equipo y vehículos', 1),
(273, 'Transporte y sistemas de distribución', 4, 6, 'Conceptos y herramientas para el diseño y la gestión de sistemas de transporte y distribución', 1),
(274, 'Administración de personal', 4, 6, 'Fundamentos y herramientas para la administración de recursos humanos en la cadena de suministro', 1),
(275, 'ingles 7', 4, 7, 'Materia de inglés correspondiente al cuatrimestre 7 de la carrera de Logística y Transporte.', 1),
(276, 'comercio internacional', 4, 7, 'Materia sobre comercio internacional y su relación con la logística y el transporte.', 1),
(277, 'sistemas de costeo en operaciones logisticas', 4, 7, 'Materia que aborda los sistemas de costeo y su aplicación en las operaciones logísticas.', 1),
(278, 'ingenieria de transito', 4, 7, 'Materia que estudia la ingeniería de tránsito y su relación con la logística y el transporte.', 1),
(279, 'logistica y transporte sustentables', 4, 7, 'Materia que aborda la importancia de la sustentabilidad en la logística y el transporte.', 1),
(280, 'metodologia de la investigacion', 4, 7, 'Materia que aborda las metodologías de investigación aplicadas a la logística y el transporte.', 1),
(281, 'estancia 2', 4, 7, 'Estancia profesional correspondiente al cuatrimestre 7 de la carrera de Logística y Transporte.', 1),
(282, 'ingles 8', 4, 8, 'Clase de inglés para el octavo cuatrimestre de la carrera de Logística', 1),
(283, 'logistica, trafico y aduanas', 4, 8, 'Curso sobre logística, tráfico y aduanas en el octavo cuatrimestre de la carrera de Logística', 1),
(284, 'operaciones de flotas y terminales', 4, 8, 'Curso sobre operaciones de flotas y terminales en el octavo cuatrimestre de la carrera de Logística', 1),
(285, 'ingenieria economica', 4, 8, 'Curso de ingeniería económica en el octavo cuatrimestre de la carrera de Logística', 1),
(286, 'legislación y derecho del transporte', 4, 8, 'Curso sobre legislación y derecho del transporte en el octavo cuatrimestre de la carrera de Logística', 1),
(287, 'estudios de ingenieria del transporte', 4, 8, 'Curso sobre estudios de ingeniería del transporte en el octavo cuatrimestre de la carrera de Logística', 1),
(288, 'operacion de almacenes de refacciones', 4, 8, 'Curso sobre operación de almacenes de refacciones en el octavo cuatrimestre de la carrera de Logística', 1),
(289, 'Ingles 9', 4, 9, 'Inglés técnico y profesional para el comercio internacional', 1),
(290, 'Distribución física internacional', 4, 9, 'Análisis de los procesos y sistemas de distribución física internacional', 1),
(291, 'Gestión y dirección de empresas', 4, 9, 'Principales técnicas y herramientas para la gestión empresarial', 1),
(292, 'Formulación y evaluación de proyectos', 4, 9, 'Metodologías para la elaboración y evaluación de proyectos de transporte y logística', 1),
(293, 'Modelos de transporte y logística', 4, 9, 'Modelos matemáticos para la optimización de los procesos logísticos y de transporte', 1),
(294, 'Transporte urbano', 4, 9, 'Estudio de los sistemas de transporte urbano y su impacto en la ciudad', 1),
(295, 'Seminario de análisis de casos y decisiones', 4, 9, 'Análisis de casos reales de transporte y logística para la toma de decisiones estratégicas', 1),
(296, 'Estadía Profesional', 4, 10, 'Materia en la que el estudiante aplica los conocimientos adquiridos en la carrera en un entorno laboral real', 1),
(297, 'Inglés l', 7, 1, 'Conocimiento en otras lenguas', 1),
(298, 'Desarrollo Humano y valores', 7, 1, 'Materias humanitarias', 1),
(299, 'Introducción a las matemáticas', 7, 1, 'Logica', 1),
(300, 'Introducción a la contabilidad', 7, 1, 'Estadistica y contabilidad', 1),
(301, 'Marco legal de las organizaciónes', 7, 1, 'Leyes y jurisdiccion', 1),
(302, 'Introducción a la administración', 7, 1, 'administracion de ingresos', 1),
(303, 'Expresión oral y escrita l', 7, 1, 'Escritura y desarrollo de proyectos', 1),
(304, 'Inglés ll', 7, 2, 'aprendizaje de otras lenguas', 1),
(305, 'Inteligencia emocional y manejo de conflictos', 7, 2, 'Manejo de las emociones', 1),
(306, 'Matemáticas aplicadas a la administración', 7, 2, 'Logica y desarrollo', 1),
(307, 'Proceso Adminstrativo', 7, 2, 'Administracion', 1),
(308, 'Contabilidad', 7, 2, 'Contabilidad', 1),
(309, 'Derecho Mercantil', 7, 2, 'Leyes', 1),
(310, 'Sistemas de información en organizaciones', 7, 2, 'Computo', 1),
(311, 'Inglés lll', 7, 3, 'Aprendizaje de lenguas extranjeras', 1),
(312, 'Habilidades cognitivas y creatividad', 7, 3, 'Habilidades para la comunicación', 1),
(313, 'Probabilidad y estadística', 7, 3, 'Probabilidad en economia', 0),
(314, 'Planeación estratégica en las organizaciones', 7, 3, 'Planeacion de estrategias dentro de organizaciónes', 1),
(315, 'Contabilidad administrativa', 7, 3, 'sistema de control y registro de los gastos e ingresos y demás operaciones económicas', 1),
(316, 'Metodología de la Investigación', 7, 3, 'métodos que se siguen en una investigación científica, un estudio o una exposición doctrinal.', 1),
(317, 'Economía de la empresa', 7, 3, 'recursos disponibles que suelen ser escasos, para satisfacer las diferentes necesidades y así tener un mayor bienestar.', 1),
(318, 'Inglés lV', 7, 4, 'Aprendizaje de otras lenguas extranjeras', 1),
(319, 'Ética Profesional', 7, 4, 'disciplina que estudia la conducta humana.', 1),
(320, 'Administración y gestión del talento humano', 7, 4, 'ciencia social, cuyo interés se centra en las organizaciones humanas.', 1),
(321, 'Contabilidad de costos y productos', 7, 4, 'La contabilidad es una ciencia que se basa en la coordinación y estructuración en libros y registros de la composición cualitativa .', 1),
(322, 'Fundamentos de mercadotecnia', 7, 4, 'dinámica que requiere de audacia, visión y competitividad, ya que es la que identifica y selecciona los mercados, las necesidades. ', 1),
(323, 'Agregados económicos', 7, 4, 'dinámica que requiere de audacia, visión y competitividad, ya que es la que identifica y selecciona los mercados, las necesidades ', 0),
(324, 'Estancia l', 7, 4, 'Desarrollo de las habilidades aprendidas', 0),
(325, 'Inglés V', 7, 5, 'Aprendizaje de lenguas extranjeras', 1),
(326, 'Habilidades gerenciales', 7, 5, 'Habilidades en gestion de empresas', 1),
(327, 'Matemáticas financieras', 7, 5, 'Logica y matematicas', 1),
(328, 'Comportamiento y desarrollo empresarial', 7, 5, 'Desarrollo en las organizaciones', 1),
(329, 'Contabilidad de costos-serviciós', 7, 5, 'Desarrollo de contabilidad', 1),
(330, 'Investigación de mercados', 7, 5, ' el proceso mediante el cual las empresas buscan hacer una recolección de datos de manera sistemática para poder tomar mejores decisiones.', 1),
(331, 'Legislación laboral', 7, 5, 'Leyes y jurisdiccion', 1),
(332, 'Inglés Vl', 6, 6, 'Aprendizaje de lenguas extranjeras', 1),
(333, 'Liderazgo de alto desempeño', 7, 6, 'Liderazgo en equipos', 1),
(334, 'Econometría', 7, 6, 'La econometría es la rama de la economía que hace un uso extensivo de modelos matemáticos y estadísticos', 1),
(335, 'Administración Financiera', 7, 6, 'Finanzas', 1),
(336, 'Administración de sueldos y salarios', 7, 6, 'Sueldos y salarios', 1),
(337, 'Mercadotecnia estratégica', 7, 6, 'Mercadotecnia en negocios', 1),
(338, 'Administración de la calidad', 7, 6, 'Calidad de productos', 1),
(339, 'Inglés Vll', 7, 7, 'Apendizaje de la lengua extranjera', 1),
(340, 'Comercio internacional', 7, 7, 'negociacion extranjera', 1),
(341, 'Sustentabilidad', 7, 7, 'Apoyo y solvencia', 1),
(342, 'Contribuciónes fiscales', 7, 7, 'Fisco', 1),
(343, 'Administración de la producción', 7, 7, 'Visualizacion de la produccion', 1),
(344, 'Tecnologías de  la información', 7, 7, 'Computacion y analisis', 1),
(345, 'Estancia ll', 7, 7, 'Desarrollo del aprendizaje obtenido', 1),
(346, 'Inglés Vll', 7, 8, 'Apendizaje de la lengua extranjera', 1),
(347, 'Negociación y toma de decisiones empresariales', 7, 8, 'Decisiones empresariales', 1),
(348, 'Emprendimiento', 7, 8, 'Iniciativa en proyectos', 1),
(349, 'Auditoria administrativa', 7, 8, 'Auditoria en las empresas', 1),
(350, 'Formulación de proyectos', 7, 8, 'Administracion de proyectos', 1),
(351, 'Logística administrativa', 7, 8, ' actividades estratégicas para optimizar el manejo de los recursos de una empresa, haciendo que su gestión sea más eficiente y eficaz.', 1),
(352, 'Resposabilidad social empresarial', 7, 8, 'Emprendimiento social', 1),
(353, 'Inglés lX', 7, 9, 'Aprendizaje de la lengua extrajenra', 1),
(354, 'Administración de redes empresariales', 7, 9, 'Red empresarial en desarrollo', 1),
(355, 'Consultoría', 7, 9, 'consultar', 1),
(356, 'Gestión de marca', 7, 9, 'Administarcion de marcas', 1),
(357, 'Gestion y evaluación de proyectos', 7, 9, 'Desarrollo de proyectos', 1),
(358, 'Expresión oral y escrita ll', 7, 9, 'Escritura', 1),
(359, 'Comercialización internacional', 7, 9, 'Comercializacion de la industria internacional', 1),
(360, 'Estadias', 7, 10, 'Desarrollo de proyectos y marcas', 1),
(361, 'Inglés l', 8, 1, 'Aprendizaje de lengua extranjera', 1),
(362, 'Valores Del Ser', 8, 1, 'Valores a implementar', 1),
(363, 'Introducción A La Mecadotecnia', 8, 1, 'Es el momento en el que se implementa el Plan de Mercadotecnia; por tanto, es la etapa en la que la planeación, organización y dirección se someten a ', 1),
(364, 'Fundamentos De Administración', 8, 1, 'eglas que permiten establecer un plan de desarrollo empresarial, ponerlo en marcha y determinar si los resultados obtenidos fueron o no los esperados.', 1),
(365, 'Introducción A la Economía', 8, 1, ' ciencia social que estudia la producción, distribución, circulación y consumo de bienes y servicios producidos por una sociedad, para satisfacer sus ', 1),
(366, 'Metodología De La Investigación', 8, 1, ' la selección, exposición y análisis de la o las teorías, métodos, procedimientos y conocimientos que sirven para fundamentar el tema, para explicar l', 1),
(367, 'Matemáticas Para La Comercialización', 8, 1, 'base fundamental de los negocios, sin estas no habría información real sobre la situación financiera de tu negocio o empresa.', 1),
(368, 'Inglés II', 8, 2, 'Aprendizaje de la lengua extranjera', 1),
(369, 'Inteligencia Emocional', 8, 2, 'la capacidad de reconocer sentimientos propios y ajenos, de motivarnos y de manejar adecuadamente las relaciones.', 1),
(370, 'Mezcla De Mercadotecnia', 8, 2, 'La mezcla de mercadotecnia, también llamadas las 4p\'s del marketing o Marketing Mix, representan los cuatro pilares básicos de cualquier estrategia de', 1),
(371, 'Base De Datos', 8, 2, 'Administracion y distribucion de la informacion', 1),
(372, 'Estadística', 8, 2, ' Estadística es la ciencia y el arte de dar sentido a los datos, proporcionando la teoría y los métodos para extraer información de estos y poder reso', 1),
(373, 'Introducción Al Comercio Internacional', 7, 2, 'El comercio exterior es un intercambio de un bien o servicio realizado entre al menos dos países diferentes. Los intercambios pueden ser importaciones', 1),
(374, 'Administración De La Calidad', 8, 2, 'establece meta de calidad a largo plazo y define el enfoque para cumplir esta meta, ya que es la alta administración quien desarrolla, implanta y diri', 1),
(375, 'Inglés III', 8, 3, 'Aprendizaje de la lengua extranjera', 1),
(376, 'Desarrollo Interpersonal', 7, 3, 'El desarrollo interpersonal permite que las personas tengan más recursos y elementos, como la capacidad de dialogar y negociar soluciones benéficas de', 1),
(377, 'Comercio Electrónico', 8, 3, ' modelo de negocio basado en la compra, venta y comercialización de productos y servicios a través de medios digitales', 1),
(378, 'Derecho Mercantil', 8, 3, 'conjunto de normas jurídicas que regulan a las personas, las relaciones, los actos y las cosas que tienen que ver con el comercio.', 1),
(379, 'Introducción A La Contabilidad', 8, 3, 'disciplina que se ocupa de estudiar y realizar mediciones sobre las finanzas y patrimonios de los individuos o las empresas para conocer el estado de ', 1),
(380, 'Investigación De Mercados', 7, 3, 'La investigación de mercados es el proceso mediante el cual las empresas buscan hacer una recolección de datos de manera sistemática para poder tomar ', 1),
(381, 'Comercialización Estrategica', 7, 3, 'onjunto de acciones bien estructuradas y planeadas con las cuales se logran objetivos, según las exigencias de los consumidores o el público interesad', 1),
(382, 'Inglés IV', 7, 4, 'Aprendizaje de la lengua extranjera', 1),
(383, 'Habilidades Del Pensamiento', 8, 4, 'eorizar, predecir, evaluar, recordar y organizar el pensamiento.', 1),
(384, 'Contabilidad De Costos', 8, 4, 'Dicha contabilidad de costos es un sistema de información para registrar, determinar, distribuir, acumular, analizar, interpretar, controlar e informa', 1),
(385, 'Legislación y Derecho Fiscal', 8, 4, 'El Derecho Fiscal lo definimos como la rama del Derecho Público que comprende el conjunto de normas jurídicas que regulan las relaciones jurídicas ent', 1),
(386, 'Matemáticas Financieras', 7, 4, ' las Matemáticas Financieras como una rama de la Matemática Aplicada que estudia el valor del dinero en el tiempo', 1),
(387, 'Planeación Estratégica', 8, 4, 'consiste en estudiar, definir y ejecutar el camino que debe seguir una empresa para llegar a sus objetivos estratégicos.', 1),
(388, 'Estancia I', 8, 4, 'Desarrollo de las habilidades', 1),
(389, 'Inglés V', 8, 5, 'Aprendizaje de la lengua extranjera', 1),
(390, 'Habilidades Organizacionales', 8, 5, 'Las habilidades organizacionales son aquellas habilidades que ayudan a tus empleados a hacer su trabajo de manera eficiente.', 1),
(391, 'Contabilidad Financiera', 8, 5, 'constituye la práctica de contabilizar el dinero que entra y sale de una organización.', 1),
(392, 'Economía Internacional', 8, 5, 'La economía internacional, como parte de la teoría económica, plantea el estudio de los problemas que surgen en las transacciones económicas mundiales', 1),
(393, 'Geografía Económica', 8, 5, 'rama de la geografía humana que se dedica al estudio de los diversos tipos de actividades económicas y su relación con la explotación de los recursos ', 1),
(394, 'Mercadotecnía Internacional', 8, 5, 'disciplina que se encarga de desarrollar estrategias para la comercialización de productos y servicios en un mercado diferente al propio', 1),
(395, 'Sistema Financiero Nacional E Internacional', 8, 5, 'El sistema financiero internacional está compuesto por un conjunto de instituciones públicas y privadas, y un conjunto de normas y regulaciones nacion', 1),
(396, 'Inglés VI', 7, 6, 'Aprendizaje de la lengua extranjera', 1),
(397, 'Ética Profesional', 8, 6, 'La ética profesional se puede se puede entender como un campo enfocado en códigos y otras normas de conducta y que se aplica a todas las profesiones.', 1),
(398, 'Política Monetaria', 8, 6, 'Las herramientas de política monetaria son las tasas de interés o la base monetaria y el ancla nominal puede ser la inflación, el tipo de cambio, tasa', 1),
(399, 'Financiamiento y Formas De Pago Internacional', 8, 6, ' forma de acceder al capital de trabajo necesario para que las empresas puedan financiar sus exportaciones y seguir ofreciendo esquemas de pagos a sus', 1),
(400, 'Control Presupuestal', 8, 6, 'conjunto de herramientas, mecanismos y acciones que facilitan el seguimiento del presupuesto con el que cuenta una organización.', 1),
(401, 'Derecho Internacional', 8, 6, 'El derecho internacional define las responsabilidades legales de los Estados en sus relaciones entre ellos, y el trato a los individuos dentro de las ', 1),
(402, 'Introducción A La Logística', 8, 6, 'La logística es la función que permite entregar el producto correcto, en la calidad correcta, en buenas condiciones, en el lugar correcto, en el momen', 1),
(403, ' Inglés VII', 7, 7, 'Aprendizaje de la lengua extranjera', 1),
(404, 'Introducción Al Derecho Aduanero', 8, 7, ' conjunto de disposiciones jurídicas que regulan la entrada y salida de mercancías de territorio nacional, regula por medio de contribuciones y regula', 1),
(405, 'Regulación Y Clasificación Arancelaria', 8, 6, ' proceso que consiste en asignar un código numérico creado por la Organización Mundial de Aduanas (WCO por sus siglas en Inglés) a las mercancías. ', 1),
(406, 'Logística Internacional', 8, 7, 'la logística internacional es el conjunto de operaciones destinadas a transportar materias primas o productos finalizados desde el país de origen', 1),
(407, 'Legislación De Comercio Exterior', 8, 7, 'regula las facultades del ejecutivo en materia de aranceles, importaciones y exportaciones, manejo de negociaciones comerciales internacionales y facu', 1),
(408, 'Organismos De Control Y Apoyo Al Comercio Internacional', 8, 7, 'En pocas palabras: el comercio exterior mexicano se regula principalmente por la SE, en coordinación con las demás Secretarías de Estado y dependencia', 1),
(409, 'Estancia II', 7, 7, 'Desarrollo de las habilidades', 1),
(410, ' Inglés VIII', 8, 8, 'Aprendizaje de la lengua extranjera', 1),
(411, ' Derecho Aduanero', 8, 8, 'Conjunto de normas jurídicas que regulan, las actividades y funciones del Estado con relación a su comercio exterior, incluyendo entre otras, al ingre', 1),
(412, 'Evaluación Y Administración Del Riesgo', 8, 8, 'La evaluación del riesgo es un proceso en la gestión de riesgos empresariales que implica determinar a cuánto riesgo se enfrenta una empresa.', 1),
(413, 'Investigación De Operaciones Trafico Internacional', 8, 8, 'a Evaluación de los Tipos y Características de los diferentes equipos de Transporte (tipos y tamaños de contenedores, equipo automotriz de transporte,', 1),
(414, ' Envase Y Embalaje', 6, 8, 'el envase alberga directamente el producto y lo protege en todo momento, mientras que el embalaje se utiliza para proteger el producto hasta que llega', 1),
(415, 'Modelos Globales De Negocios', 7, 8, 'El modelo de negocio es una herramienta que permite tener una visión global de un proyecto empresarial, tanto a nivel interno como externo, a la organ', 1),
(416, 'Tratados Y Acuerdos Comerciales Internacionales', 8, 8, 'acuerdo que establecen dos o más países bajo el amparo del derecho internacional y con el objetivo de mejorar sus relaciones en términos económicos y ', 1),
(417, 'Inglés IX', 8, 9, 'Aprendizaje dela lengua extranjera', 1),
(418, 'Comercio Sustentable', 8, 9, 'El comercio sustentable se define como un comercio que genera valor económico, reduce la pobreza y inequidad, y regenera los recursos ambientale', 1),
(419, 'Procedimientos Y Tramites Aduanales', 8, 9, 'procedimientos aduaneros significa el trato aplicado por la administración aduanera de cada Parte a las mercancías y medios de transporte que están su', 1),
(420, 'Comercio Con Asia,África Y Oceanía', 6, 9, 'Los mercados de exportación más grandes de Oceanía incluyen Japón, China, Estados Unidos y Corea del Sur. ', 1),
(421, 'Comercio Con Europa', 8, 9, 'La UE es uno de los actores principales en el comercio mundial, siendo el segundo mayor exportador e importador de bienes del mundo, con solo China po', 1),
(422, 'Comercio Con América', 8, 9, 'El comercio intrarregional en América Latina y el Caribe se mantiene en niveles bajos: solo una quinta parte (19,2%) de las exportaciones tiene como d', 1),
(423, 'Elaboración De Plan De Negocios De Exportación', 8, 9, 'Un plan de negocios de exportación es una herramienta útil que le permite al empresario conocer cómo está parado frente a los mercados externos.', 1),
(424, 'Estadias', 8, 10, 'Desarrollo de las habilidades', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medallas`
--

CREATE TABLE `medallas` (
  `id_medalla` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `icono` varchar(255) NOT NULL,
  `citas_resueltas` int(11) DEFAULT NULL,
  `nombre_nivel` varchar(255) DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#343A40'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medallas`
--

INSERT INTO `medallas` (`id_medalla`, `nombre`, `descripcion`, `icono`, `citas_resueltas`, `nombre_nivel`, `color`) VALUES
(1, 'Maestro en instrucción', 'Resuelve 10 citas', 'bi bi-award', 10, NULL, '#C98840'),
(2, 'Especialista en aprendizaje', 'Resuelve 50 citas', 'fa-solid fa-crown', 50, NULL, '#FFDB58'),
(3, 'Yoda sabio', 'Resuelve 100 citas', 'fa-solid fa-jedi', 100, NULL, '#b0e0e6'),
(4, 'Embajador de PITA', '¡Bienvenido a PITA, nos espera un largo viaje de ayudar a la comunidad!', 'fa-solid fa-face-smile', NULL, NULL, '#fdfd96'),
(5, 'Como Adventure', 'Eres un profesor explorador, me agradas', 'fa-solid fa-egg', NULL, NULL, '#ffb6c1'),
(6, 'El arquitecto', 'Medalla para jefes de carrera', 'fa-solid fa-hammer', NULL, 'Jefe de Carrera', '#f5f5dc'),
(7, 'Super tutor', 'Medalla para encargados de grupo', 'bi bi-star-half', NULL, 'Tutor', '#AFEeee'),
(8, 'Psico-Héroe', 'Medalla para psicólogos', 'fa-solid fa-brain', NULL, 'Psicólogo', '#ffa07a'),
(9, 'Experto en la enseñanza', 'Medalla para profesores', 'fa-solid fa-glasses', NULL, 'Profesor', '#98fb98'),
(10, 'El poder del infinito', 'Resuelve 200 citas', 'fa-solid fa-user-astronaut', 200, NULL, '#A6A2F8'),
(11, 'Explorador intergaláctico', 'Resuelve 300 citas', 'bi bi-tropical-storm', 300, NULL, '#715AFF'),
(12, 'Guía novato', 'Resuelve 1 cita', 'bi bi-spellcheck', 1, NULL, '#E6E6FA'),
(13, 'Feliz día', '¡Feliz Día del Profesor!', 'fa-solid fa-chalkboard-user', NULL, NULL, '#8CC7B5'),
(14, 'Maestro Pokémon', 'Medalla otorgada por completar citas de nivel 2 y 4', 'fa-solid fa-medal', NULL, NULL, '#B22222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medallas_profesor`
--

CREATE TABLE `medallas_profesor` (
  `id` int(11) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `id_medalla` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medallas_profesor`
--

INSERT INTO `medallas_profesor` (`id`, `nempleado`, `id_medalla`) VALUES
(35, 85728, 12),
(36, 85728, 7),
(37, 85728, 9),
(38, 53423, 6),
(39, 94638, 12),
(40, 94638, 7),
(41, 94638, 8),
(42, 35753, 12),
(43, 35753, 7),
(44, 35753, 9),
(45, 85728, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `remitente` bigint(20) NOT NULL,
  `receptor` bigint(20) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id_mensaje`, `remitente`, `receptor`, `mensaje`, `leido`) VALUES
(952, 85728, 94638, 'M+BDVkve/sgbS6N+2TAVcsWIH+v7K2F44buoNk3k/AuFspUZQbDgH2m31KPCTHPFMxG8RtnM3gODTcr3MWUdt9rB31FuzUdVJfTiJXLi6HM=', 1),
(953, 1, 53423, 'tdlgYpAmlzlagZOeZLDob3o++FY06p2Rr9kewoVhIKeUyb+ZkpZ2oXCX8vJ+V6uwTbK7A1qTKFQ7Yz6p5MC0Rw==', 0),
(954, 94638, 85728, 'aJJROZa09LZTQnx4G5vwbAWVRe9fOJsj223d80VE7TgZZPMbhN9+piQ0t23SV7Pnj5+Oi1gIg6ZvXE1AhCCPCQ==', 1),
(955, 94638, 85728, 'dCPTS7bOpLVKWUL3+qBAaXyoz2MUS2NKKEAUiD8UhbRk8WK9ORSXrs18R9yQk4Mxv10XgIyVkywJj1CWrtc85A==', 1),
(956, 94638, 85728, 'Yz+RCFO3+EBUS+gZqXJ63/JEnB96ihc8SC6Vej2s7CmU8xZ+1Y6pB8i+cdY6grM1hKbreTFvGEj+VvgGPE1n0A==', 1),
(957, 94638, 85728, 'ELPyWSrwQxq1kzGn5/TqOr6I7OG6ZP/aczmY4eEASGURndAcToR6zxob1gp7rFHU2E9bq9kH4xxtlCpKGIAeYw==', 1),
(958, 85728, 315, 'ea0anYqYCYbZB4pRnmSRb+yo2CAfxSapgsue/k3sw+npLNE2GfqXtfRH+0RAhw2aaCs29LxmRhVRxOH1tCO9tw==', 0),
(960, 94638, 35753, 'q+JRhhbTZvK3DnzE2Hzz/ZS2v5jVjQYq5UbU/Ob1ewKYJt7P22prHMD9BQqpfRZDfzhEnp0iPhhaekJ2yrX+Zg==', 1),
(961, 35753, 94638, 'M/lySrxX6+s5babyHzRmyvryCI9FNEY4Bx857iPvsR3XbNE1UqhN8yNHKO++4oqC3IZf+xawipUxbAd/rCXrhg==', 1),
(962, 35753, 85728, 'NXZwtHCAXWNJlaSZ50DHexLaVs+LSAn7iqcsmNSDCv7Eylta1srwgLVsQ4m9hZQ2s9NH2+VmiuAS3BcF1BgAhA==', 0),
(963, 1, 94638, '6z/0gfw4/kmJyUJI8x+1qWINh8D3MBtmfa/vS8JGiphd/KSb00+qYVSjQGxPBxx+ekp1czk/t2obgCzQPHwtgg==', 1),
(964, 1, 85728, 'QlIVhMMoGmwJN8zn/5mQ230VoBTzB9NFV9WYwh6StZaK7lfHtfNK9Q/h8qksYJYTvR1KVLBjN9ITFDV91hS9sQ==', 0),
(965, 94638, 85728, '7GauZbrIeTix6ZO9Vkc1GVMLzVM4HigaSW6wu+db4/jmAvzkxB730GY4PkMiWBBa78YJCCkTi/IuCIUAq+mR7w==', 1),
(968, 1, 94638, 'mhGWeB1qEXeIV2xYE9tIEpgHN7W433idInwMYjAHvfeZaYPP7fWdazL/nVA9PDGkZ3L901yNzAPa+vm/z9zAXA==', 0),
(969, 1, 987, '+etIG69Ndvi+f10wrGabvxjP3n2e+BjwY94RaeS8KGcGCX1D8s+Hzx94oyBp5nHr2z93gZBa6hN2oKmC9jGyiA==', 0),
(970, 1, 53423, 'GsmRCKmWLma796yQs7MPBHAHl2pkxRChJiQcpHbhl4AEpLHGDlixHcYY5eqX/cWnQfvF0BB0uqk9xptBETXX8A==', 1),
(971, 1, 35753, 'gdXlmQVL/+z2GgMeyHDPHcVj6LY+nNtooM4ib4YyRg1nM656FORFWGEH/MsLTZKFVOaJp94Esp6lC5llmU1Jww==', 0),
(972, 1, 85728, 'J4fVxd175TuCvL+yYm1vBHVX3pGdTi9o+9IFaxlUdyp7QS/Jc7knBKGiNEhtO0GTxnJqffiQKwvVb5cIxtJ2vQ==', 0),
(981, 94638, 35753, 'mn3CCF1yR5zDj7dk7i+ruAqDYbSAuAyDJw10CMlPv2cd9yzdqs33OmvdmMOCfbBpM2mc2XNn0uGpMpXQUvHnPkInu2E8Z36m7qEotkeFDb0=', 0),
(982, 85728, 94638, 'xFpXxY6G22+aWHwmbHAY8hqB9jRC4FlRoVP4/8vMMm5VsNIU5G/SRmS0m4KHixL0zzyf7fYbVOU+4/U0gt81SnkZpXjYjoTLH3dg4J/zeKI=', 0),
(983, 85728, 35753, 'R1DnFo4CvYwclAhVoGgyFkObAl63Yqp2F/E8MR5POe/Gz26KDvOHDUsCSuvZKVBPfvD9rfjovnM6I60bUabwQwutaSAZySvxST2jY+0bpSQ=', 0),
(986, 53423, 94638, '7HFnRGcLqHD5cMRZXUAkmErWVe6h+ZgeQNZfntZtk025/2BdaXcWAvaofO+IGDiGlVhsIW7pyjp8jfy7JFDffsX57pYwgnf1harP5DusYms=', 0),
(987, 53423, 35753, 'zx3oN8jWVCOUfCIo/NNFIIPcnhZVfwsMHCVBtLZbxH1IlOVo+y9HofEwP7lOsDz03l66kYxcy/r1jktixREQi8m88YewGWxfqg9a7FsyIF0=', 0),
(988, 1, 85728, 'c3WZZVzIsJ1diZn8KH8VOzlitYmyh/Oz5Ay+bvJ51DdIRWvL3ecDRNmDqO5etJevBcXGRRYLYBoqepbLCwHQUjNi3KEfK81jt3Hk20zM/hg=', 1),
(989, 1, 94638, 'pjplTuCtNTrIYmerJb2R0brDSn5V6zPBkXngZtFUBVtaRmgZZsY2Q1z8BLv2W9xEskd9qJeKS0vW8NbMsW603w==', 0),
(991, 1, 53423, '36YtQNg45bszT5I9R3ELhiRqvjwMxF8VW3Jq0daHtD/T/DNAyDIJmQxnp+ZY/TzN4CPZsVXOkbepdMrdKeCIDw==', 1),
(992, 1, 53423, '21K/H5eE4yCywizJzURzDrU91o1Op4DzBAW0jqeYFPSjxUZdHqFVoxp/gZ43VZDSY2Tjm8LeCqd2PIzpVWLTGQ==', 1),
(993, 1, 94638, 'n2IeGoO7UrQrzVqAIilJ/djqxu6/ETexyTlCmOeIcBVo2gC+Y+SBAAlLrs9mtybZAQ6iEP3Fpf1Yf7L5Hd+YCw==', 0),
(995, 85728, 35753, 'mz3QT08weSpPgy1B5FOA5v6fGxLwDAppP291489J58ppqBY7MmpUEZ/8+KzhTgoH/NnFBFuJp7/JFcQRHYjCa1Xqdq/vpdMhgZ007H/FYPg=', 1),
(996, 35753, 85728, '6iaq+WSD3nvytaSvgN6WwaC0jVwBWyabXVsFRTsQ0IHIcNhMsLYO3+JJbXONXQp6LeOAMDt/Ptm3oGWIoAnf1Q==', 0),
(997, 35753, 94638, 'Mx6KxlcLgMTd06Vz4eyZrZMl9MFlbDxqLjKr8R2gqLBp1HoTGoROwkr+7i5sBohX2koNQ/kHNemG6RBDir55jg==', 1),
(998, 94638, 35753, 'h/el9pvojHnUwPNP38oCcMD3XS/eNqJGfpFJWg+l6DtUZdmCCpVOgO7PdPpEQn6c87xYoT8eqGJfGL4HMD6EhsiKf25RSlP/lyW0rdsknFE=', 1),
(999, 94638, 35753, 'fXhjAX/nSnAVLhLb4w6PExgrsmRFeMjfNWJeDtHkHEr1C1N4FCWmv5C7bVzq5aY6DqgHOCXYykeEnA8iPDbplMhxn/U5lxZ3dgpVw14d1to=', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `id_nivel` int(11) NOT NULL,
  `nivel` varchar(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id_nivel`, `nivel`, `descripcion`) VALUES
(1, 'Jefe de Carrera', 'jefe de carrera'),
(2, 'Tutor', 'encargados de grupo'),
(3, 'Psicólogo', 'psicólogos'),
(4, 'Profesor', 'profesores'),
(5, 'rector', 'rector de la universidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivelcitas`
--

CREATE TABLE `nivelcitas` (
  `id_citasN` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivelcitas`
--

INSERT INTO `nivelcitas` (`id_citasN`, `nombre`, `descripcion`) VALUES
(1, 'Tutoría', 'asesoria de tutor'),
(2, 'Psicológica', 'asesoria psicologica'),
(4, 'Académica', 'asesoria con profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `titulo` text NOT NULL,
  `nota` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_nota`, `nempleado`, `titulo`, `nota`) VALUES
(39, 35753, 'AwoArA3sHKYqvF+xtCd7xdQfJzSHi2QQNUXkbh82di9HuozoZC/TciGmac3iqGQJLnQGhdOOTDeJGiKxD3Y8SA==', 'm0ER1SK2swugOhA0n4ngYxRkWFCRAZNSdnYWBSufj6hVLCnXOnXacJnC4y6PakDEayUgDnV9+a9DYKT3ZC+yDQ=='),
(41, 53423, 'ielPEtPZbuhqaeLjOn/wNaYRSgBrg4ip428yMX0mXcm/trMjnJ7tuPXfldkMIMAV2+aUirgQ7DG3SQU7XF/yqg==', 'JXpfcDaCh3AQKePZcaAWpkKeNstcJOL0Lb7KwTTBG6uiNpvV6ik8EBQbJekfFmsj1U9fG2ymujar4q3nKgtk5g=='),
(45, 85728, '8gfWQgwxwZyKym7POpGqp3J80MxhD1YN7maml4TyxTTcrnaLCnjtNeQxKdpqWz9SvQrGBPP3GO7TqvC9Ppq1Eg==', 'T9xDfAzzFZqdsMS6rPSlWq9dyf7t47ubtM9AnECUats1cBkfX5WqcagAwUqEhS/rN0Y7ya0PgQjZiN082zfIFw=='),
(46, 94638, 'HgJgOZ+kr20FsDGSe6WYD4h/yqk0rWxwsRRwWoRSQHenu5T4MlMvNE7SnpF7ZKPkPVKIlbObtdNb8Z0irmnt0g==', 'mVzSFQJn4eZasGvaMYMJYCY4Gej6NuS0dPOoj5FshAPDeXyzolJLNCzCdoKuTmNpbaoRuFl8O9s8DoQBkI890oFlXIPNRtIiRT+0hgg6bEA='),
(47, 94638, 'zwEJ7tapwLRIsG/9Nfmf5nK4a0EBkzv14/MYbTsCnFPtcuIivaEyL6I3EGlMCoQHJr8V+sYXuJGyj7/m0zmbvg==', 'OjMnRiVD8p2hK/kEHQZ+ka1tiT0PxePg5jo1EEuvAe1+n/+8BiRxDPJX/6Ft8ITrnj8VUYBSuEtptGhWl/Yan064cwrZCMd2V4P9rBhodkM='),
(49, 1, 'tP1wNw2wFtaFmnUfX9wl6hr2LXRnscs7fadcj20Ai9a/ChC2e1LRck5euWR1QoWO+VP0q7/N2PK6cq2VRhz+vGArxv5AO3gzuMykFs9fuyM=', 'IhrI/mHyFTvtDPG17KB15MdzrLni5ZjeP36FzhnNHCh4+pLnMk6PJ/xO+xHUG0LR2yCEBzmJo2dMPqtJGafk8w==');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `periodo` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `nombre_periodo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`periodo`, `activo`, `nombre_periodo`) VALUES
(1, 0, 'Enero - Abril'),
(2, 1, 'Mayo - Agosto'),
(3, 0, 'Septiembre - Diciembre'),
(1, 0, 'Enero - Abril'),
(2, 1, 'Mayo - Agosto'),
(3, 0, 'Septiembre - Diciembre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `nombre` varchar(30) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `imagen_de_perfil` longblob DEFAULT NULL,
  `recien_creado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`nombre`, `nempleado`, `id_nivel`, `active`, `contraseña`, `email`, `imagen_de_perfil`, `recien_creado`) VALUES
('Héctor Manuel Gómez Martínez', 1, 5, 1, 'E2jNahV2kvB4d8Jops/f1Eo7LLGYWwN98Eopa5RakPj9kgev9RKe6WMERJpSRDWWHZrNqATPsQWEsDV6OgJvxg==', 'rector@uptex.edu.mx', 0x696d6167656e65732f70312e6a7067, 0),
('Julio Cesar Tenorio', 315, 4, 1, 'bXGulcIRQNrdN2bMPmHnZINlJb+kMNLN9rQ5gkuecK2aTszK3PwlEwBq2bZHrF6FhJwnzPDCMa6sfcWKB+TOGg==', 'juliocesar.tenorio@uptex.edu.mx', NULL, 1),
('Julian Garcia', 987, 2, 1, '8cOnKXgk2wCm/t3N821SsXn9P44DwZ2Mlcgkd0T4ddQyZ9tggiP4XCJc94ZRpe6O3ysDM+yFN7tQ8sf5ZrpaSg==', 'julian@gmail.com', NULL, 1),
('Nancy Hernandez Rivera', 6549, 1, 1, 'helado!', 'nallely.hernandez@uptex.edu.mx', NULL, 0),
('Carbajalio Silvario Lozano', 10101, 2, 1, 'gA8re5cPminPftofBJNSFFZ81q2dNG17UmVblAKoEjw9VYNUVKypiKuR0Hfk+xni7kXcRIBllN8UdI+Fqfm6ow==', 'carbajaliosilvario1@gmail.com', NULL, 1),
('Jesús Román Fuentes Ruíz', 35753, 4, 1, 'jYwMNs4eK+woXTlljqVjItuHd4HsrCsF/1nEJ7z9fjEskBGlHRU8SM29PXEEQNpwY4jhbAD+1itrWS+GomuEnA==', 'roman.fuentes@uptex.edu.mx', 0x696d6167656e65732f7033353735332e6a7067, 0),
('Ángel David Barrera García', 53423, 1, 1, 'nh84tbRDhREDl8Ny9R55S9BTHT9pN+TGdnLNqARoayXuInAMRLZ8z5Xyof7CNK/sgjCU5SoN+s6H0EuYd5/XGQ==', 'angel@hotmail.com', 0x696d6167656e65732f7035333432332e6a7067, 0),
('Jonatan Arath Nieto Nieto', 77777, 2, 1, 'MOWjTXcCRTaRPk6w6q4LZhhwoeCf7ymUP9P/C6KHRfYtLG9fJg6D32RhwFJWWeFapaApuP+wplEAPehxdXGKlw==', '77777@gmailcom', NULL, 1),
('Celso Márquez Sánchez', 85728, 2, 1, 'CT6qwVNMKSd4zijhHP+0zQjbhujFTFNbgvx15dVycbGPW4k/kDsOXe3X2RzumcQI4AYDl0fyrUewYReG+y+CFg==', 'celso.marquez@uptex.edu.mx', NULL, 0),
('Osiriz Marlen Trujillo López', 94638, 3, 1, 'SMyBaEO7xgCKS6kSErslSOJ+L7dFfno2HoUmGQYNaDpi3fl6IWTC1H3vhEHxz8mawLwLW6a6oC1dfjQsDP7aMA==', 'osiriz.trujillo@uptex.edu.mx', 0x696d6167656e65732f7039343633382e6a7067, 0),
('Mireya Alvarez Benitez', 642357, 4, 1, 'R9/JEmzmwb0aAfOd2Rj0w4fWswGR5n76vi94uFBn2Kzjwhc5E2plZ+5rX+S0GpXMZ/spi5fHRq63Gu4h+6M4iWFlrOQfSiymQVJFfM94M3k=', 'ma.benitez@uptex.edu.mx', NULL, 1),
('Jacquelinne Arellano Montiel', 4826489, 4, 1, 'T+ynkkjzyXbW26g1GKD7+ot08VclW5HJa6x8s2J0lbXgOXzfN4ShmHa+LMEkHYW5lnpP3G8FFYM46yW8yeenFPHtz27S32keihG45M2n6K8=', 'jaqueline.arellanomo@uptex.edu.mx', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_carrera`
--

CREATE TABLE `profesor_carrera` (
  `nempleado` bigint(20) NOT NULL,
  `id_carrera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor_carrera`
--

INSERT INTO `profesor_carrera` (`nempleado`, `id_carrera`) VALUES
(315, 1),
(315, 3),
(6549, 7),
(6549, 8),
(10101, 1),
(35753, 1),
(35753, 2),
(35753, 3),
(53423, 1),
(53423, 2),
(53423, 3),
(77777, 2),
(85728, 1),
(85728, 3),
(94638, 1),
(94638, 2),
(642357, 1),
(642357, 2),
(642357, 4),
(4826489, 1),
(4826489, 2),
(4826489, 3),
(4826489, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_horario`
--

CREATE TABLE `profesor_horario` (
  `nempleado` bigint(20) NOT NULL,
  `dia_semana` tinyint(1) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tipo_hora` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor_horario`
--

INSERT INTO `profesor_horario` (`nempleado`, `dia_semana`, `hora_inicio`, `hora_fin`, `tipo_hora`) VALUES
(1, 1, '07:00:00', '14:00:00', 2),
(1, 1, '15:00:00', '17:00:00', 2),
(1, 2, '07:00:00', '12:00:00', 2),
(1, 2, '13:00:00', '18:00:00', 2),
(1, 3, '07:00:00', '12:00:00', 2),
(1, 3, '13:00:00', '17:00:00', 1),
(1, 4, '07:00:00', '11:00:00', 2),
(1, 4, '12:00:00', '18:00:00', 1),
(1, 5, '07:00:00', '10:00:00', 2),
(1, 5, '12:00:00', '19:00:00', 4),
(315, 1, '07:00:00', '14:00:00', 1),
(315, 2, '07:00:00', '10:00:00', 1),
(315, 3, '07:00:00', '14:00:00', 2),
(315, 4, '07:00:00', '11:00:00', 2),
(10101, 1, '07:00:00', '20:00:00', 1),
(10101, 2, '11:00:00', '15:00:00', 2),
(10101, 3, '16:00:00', '18:00:00', 4),
(35753, 1, '09:00:00', '12:00:00', 4),
(35753, 1, '13:00:00', '15:00:00', 1),
(35753, 2, '09:00:00', '11:00:00', 1),
(35753, 2, '12:00:00', '14:00:00', 4),
(35753, 3, '08:00:00', '14:00:00', 4),
(35753, 3, '15:00:00', '17:00:00', 1),
(35753, 4, '10:00:00', '13:00:00', 4),
(35753, 4, '14:00:00', '16:00:00', 1),
(35753, 5, '09:00:00', '12:00:00', 1),
(35753, 5, '13:00:00', '16:00:00', 4),
(85728, 1, '07:00:00', '13:00:00', 4),
(85728, 1, '13:00:00', '17:00:00', 2),
(85728, 1, '17:00:00', '19:00:00', 1),
(94638, 1, '09:00:00', '12:00:00', 1),
(94638, 1, '13:00:00', '14:00:00', 2),
(94638, 1, '15:00:00', '17:00:00', 4),
(94638, 2, '07:00:00', '12:00:00', 4),
(94638, 2, '14:00:00', '19:00:00', 2),
(94638, 3, '07:00:00', '12:00:00', 4),
(94638, 3, '13:00:00', '17:00:00', 2),
(94638, 4, '07:00:00', '11:00:00', 4),
(94638, 4, '12:00:00', '16:00:00', 2),
(94638, 5, '07:00:00', '14:00:00', 4),
(94638, 5, '15:00:00', '20:00:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_nivel`
--

CREATE TABLE `profesor_nivel` (
  `nempleado` bigint(20) NOT NULL,
  `id_nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesor_nivel`
--

INSERT INTO `profesor_nivel` (`nempleado`, `id_nivel`) VALUES
(315, 4),
(987, 2),
(987, 4),
(6549, 1),
(10101, 2),
(35753, 2),
(35753, 4),
(53423, 1),
(77777, 2),
(85728, 2),
(85728, 4),
(94638, 2),
(94638, 3),
(642357, 3),
(642357, 4),
(4826489, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperacion_contrasenia`
--

CREATE TABLE `recuperacion_contrasenia` (
  `email` varchar(50) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recuperacion_contrasenia`
--

INSERT INTO `recuperacion_contrasenia` (`email`, `codigo`) VALUES
('alexistexo@gmail.com', 0),
('alexistexo@gmail.com', 0),
('alexistexo@gmail.com', 0),
('alexistexo@hotmail.com', 0),
('esmeraldaseam@gmail.com', 0),
('13191205163@uptex.edu.mx', 0),
('sombrererolocoalicia16@gmail.com', 0),
('miguel.sanchez.2001@gmail.com', 0),
('hdhd@gmail.com', 0),
('jonyboy@gmail.com', 0),
('13191205163@uptex.edu.mx', 0),
('esmeraldaseam@gmail.com', 0),
('13191205163@uptex.edu.mx', 0),
('alexistexo@hotmail.com', 0),
('13191205163@uptex.edu.mx', 0),
('alexistexo@hotmail.com', 0),
('alexistexo@hotmail.com', 0),
('alexistexo@hotmail.com', 0),
('nayeli_celix@hotmail.com', 0),
('sombrererolocoalicia16@gmail.com', 0),
('13191205009@uptex.edu.mx', 0),
('cesar285d@gmail.com', 0),
('paquitos.2001@gmail.com', 0),
('esthervivar4@gmail.com', 0),
('jis@gmqil.c', 0),
('alexistexo@hotmail.com', 0),
('miguel.masg.2001@gmail.com', 0),
('q@gmai.com', 0),
('alexistexo@hotmail.com', 871502),
('alexistexo@hotmail.com', 875205),
('soberanesquiroz@gmail.com', 0),
('juanito28112001@gmail.com', 0),
('alexistexo@protonmail.com', 0),
('nayeli_celix@hotmail.com', 0),
('lallisdiana13@gmail.com', 0),
('esthervivar4@gmail.com', 0),
('13191205055@uptex.edu.mx', 0),
('13191205174@uptex.edu.mx', 0),
('13201305204@uptex.edu.mx', 0),
('13191205001@uptex.edu.mx', 0),
('13191205027@uptex.edu.mx', 0),
('alexistexo@hotmail.com', 255578),
('alexistexo@hotmail.com', 842382),
('alexistexo@hotmail.com', 572904),
('alexistexo@hotmail.com', 584268),
('x@x.com', 0),
('vbw05257@nezid.com', 0),
('alexistexo@proton.me', 0),
('esmeraldaseam@gmail.com', 0),
('sombrererolocoalicia16@gmail.com', 0),
('alexistexo@1.com', 0),
('alexistexo@x.com', 0),
('alexistexo@x1.com', 0),
('alexistexo@b.com', 0),
('alexistexo@n.com', 0),
('alexistexo@ba.com', 0),
('alexistexo@baa.com', 0),
('alexistexo@baaa.com', 0),
('alexistexo@baaaa.com', 0),
('alexistexo@bbaa.com', 0),
('alexistexo@a.com', 0),
('alexistexo@aa.com', 0),
('juanito28112001@gmail.com', 286429);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_encuesta`
--

CREATE TABLE `resultados_encuesta` (
  `id` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `periodo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `pregunta1` int(11) NOT NULL,
  `pregunta2` int(11) NOT NULL,
  `pregunta3` int(11) NOT NULL,
  `pregunta4` int(11) NOT NULL,
  `pregunta5` int(11) NOT NULL,
  `pregunta6` int(11) NOT NULL,
  `pregunta7` int(11) NOT NULL,
  `pregunta8` int(11) NOT NULL,
  `pregunta9` int(11) NOT NULL,
  `pregunta10` int(11) NOT NULL,
  `pregunta11` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resultados_encuesta`
--

INSERT INTO `resultados_encuesta` (`id`, `anio`, `periodo`, `fecha`, `pregunta1`, `pregunta2`, `pregunta3`, `pregunta4`, `pregunta5`, `pregunta6`, `pregunta7`, `pregunta8`, `pregunta9`, `pregunta10`, `pregunta11`) VALUES
(31, 2023, 1, '2023-04-18', 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 1),
(32, 2023, 2, '2023-04-18', 0, 1, 1, 1, 0, 0, 1, 1, 1, 0, 1),
(33, 2023, 3, '2023-04-18', 1, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0),
(34, 2023, 1, '2023-04-18', 1, 0, 1, 1, 0, 1, 0, 0, 0, 0, 1),
(35, 2023, 1, '2023-04-18', 1, 1, 1, 1, 0, 1, 1, 0, 0, 1, 1),
(36, 2023, 2, '2023-04-18', 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1),
(37, 2023, 1, '2023-04-18', 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1),
(38, 2023, 1, '2023-04-18', 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0),
(39, 2023, 1, '2023-04-18', 1, 1, 0, 1, 0, 0, 1, 0, 1, 0, 1),
(40, 2023, 1, '2023-04-18', 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 1),
(41, 2023, 2, '2023-04-18', 0, 1, 0, 1, 1, 0, 0, 0, 1, 1, 1),
(42, 2023, 1, '2023-04-18', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(43, 2023, 1, '2023-04-19', 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0),
(44, 2023, 1, '2023-04-19', 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0),
(45, 2023, 2, '2023-04-20', 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1),
(46, 2023, 2, '2023-04-20', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(47, 2023, 2, '2023-04-20', 0, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1),
(48, 2023, 1, '2023-04-20', 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1),
(49, 2023, 1, '2023-04-29', 0, 0, 0, 1, 1, 1, 0, 0, 1, 0, 1),
(50, 2023, 1, '2023-04-29', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1),
(51, 2023, 1, '2023-04-30', 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0),
(52, 2023, 1, '2023-04-30', 1, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1),
(53, 2023, 1, '2023-05-03', 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1),
(54, 2023, 1, '2023-05-08', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(55, 2023, 1, '2023-05-09', 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1),
(56, 2024, 2, '2024-03-21', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(57, 2025, 3, '2025-02-17', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(58, 2025, 1, '2025-02-17', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(59, 2025, 1, '2025-02-17', 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1),
(60, 2025, 2, '2025-02-19', 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_problema`
--

CREATE TABLE `tipo_problema` (
  `id_tipo_problema` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `tipo_problema` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_problema`
--

INSERT INTO `tipo_problema` (`id_tipo_problema`, `id_nivel`, `tipo_problema`) VALUES
(10, 2, 'Problemas personales\r\n'),
(11, 2, 'Problemas familiares\r\n'),
(12, 2, 'Problemas emocionales\r\n'),
(13, 2, 'Problemas de autoestima\r\n'),
(14, 2, 'Problemas de disciplina\r\n'),
(15, 2, 'Dificultades en el manejo del estrés\r\n'),
(16, 2, 'Falta de orientación vocacional'),
(17, 4, 'Dificultades en el aprendizaje de una segunda lengua\r\n'),
(18, 4, 'Problemas de lectura y escritura\r\n'),
(19, 2, 'Falta de motivación'),
(20, 4, 'Falta de recursos didácticos\r\n'),
(21, 4, 'Bajo rendimiento académico\r\n'),
(22, 2, 'Problemas de atención\r\n'),
(23, 4, 'Dificultades de comprensión\r\n'),
(24, 2, 'Falta de confianza en las propias habilidades'),
(25, 2, 'Falta de habilidades sociales\r\n'),
(26, 2, 'Problemas de ansiedad\r\n'),
(27, 2, 'Dificultades en la memorización\r\n'),
(28, 2, 'Problemas de conducta\r\n'),
(29, 2, 'Problemas de autocontrol\r\n'),
(30, 4, 'Falta de habilidades en el uso de herramientas tecnológicas\r\n'),
(31, 2, 'Problemas de integración social\r\n'),
(32, 2, 'Dificultades en la concentración\r\n'),
(33, 2, 'Otro...'),
(34, 4, 'Otro...');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor_grupos`
--

CREATE TABLE `tutor_grupos` (
  `id_tutor_grupo` int(11) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `grupo` varchar(7) NOT NULL,
  `generacion` int(11) NOT NULL,
  `periodo_inicio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tutor_grupos`
--

INSERT INTO `tutor_grupos` (`id_tutor_grupo`, `nempleado`, `nombre`, `grupo`, `generacion`, `periodo_inicio`) VALUES
(67, 35753, 'Jesús Román Fuentes Ruíz', '8MSC0', 2024, 1),
(68, 35753, 'Jesús Román Fuentes Ruíz', '8VSC0', 2024, 1),
(69, 35753, 'Jesús Román Fuentes Ruíz', '1MSC1', 2024, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor_grupos_historial`
--

CREATE TABLE `tutor_grupos_historial` (
  `id_tutor_grupo` int(11) NOT NULL,
  `nempleado` bigint(20) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `grupo` varchar(7) NOT NULL,
  `generacion` int(11) NOT NULL,
  `periodo_inicio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tutor_grupos_historial`
--

INSERT INTO `tutor_grupos_historial` (`id_tutor_grupo`, `nempleado`, `nombre`, `grupo`, `generacion`, `periodo_inicio`) VALUES
(13, 542, 'Celso Marquez', '1MSC1', 2023, 1),
(14, 542, 'Celso Marquez', '1MSC1', 2025, 1),
(16, 85728, 'Celso Márquez Sánchez', '1MSC1', 2023, 1),
(19, 4569, 'Julian Garcia', '1MSC1', 2023, 1),
(20, 4569, 'Julian Garcia', '1MSC1', 2023, 1),
(18, 85728, 'Celso Márquez Sánchez', '1MSC1', 2023, 1),
(22, 4569, '', '1MSC1', 2023, 1),
(28, 4569, '', '1MSC1', 2023, 1),
(29, 35753, '', '1MSC1', 2023, 1),
(30, 35753, 'Jesús Román Fuentes Ruíz', '1', 2023, 1),
(31, 4569, 'Julian Garcia', '1', 2023, 1),
(33, 35753, 'Jesús Román Fuentes Ruíz', '1', 2023, 1),
(34, 35753, 'Jesús Román Fuentes Ruíz', '1', 2023, 1),
(35, 35753, 'Jesús Román Fuentes Ruíz', '1msc1', 2023, 1),
(36, 35753, 'Jesús Román Fuentes Ruíz', '1msc1', 2023, 1),
(32, 85728, 'Celso Márquez Sánchez', '1MSC1', 2023, 1),
(37, 35753, 'Jesús Román Fuentes Ruíz', '1MSC1', 2023, 1),
(38, 4569, 'Julian Garcia', '1MSC1', 2023, 1),
(39, 85728, 'Celso Márquez Sánchez', '1MSC1', 2023, 1),
(42, 35753, 'Jesús Román Fuentes Ruíz', '3453', 2024, 1),
(43, 4569, 'Julian Garcia', '2MSC1', 2025, 1),
(44, 35753, 'Jesús Román Fuentes Ruíz', '2MSC1', 2023, 1),
(45, 85728, 'Celso Márquez Sánchez', '7MSC1', 2023, 1),
(47, 85728, 'Celso Márquez Sánchez', '1MSC1', 2023, 1),
(48, 94638, 'Osiriz Marlen Trujillo López', '1MSC1', 2023, 2),
(50, 35753, 'Jesús Román Fuentes Ruíz', '1VSC1', 2023, 3),
(52, 94638, 'Osiriz Marlen Trujillo López', '1VSC1', 2023, 1),
(54, 35753, 'Jesús Román Fuentes Ruíz', '1MSC0', 2024, 1),
(55, 85728, 'Celso Márquez Sánchez', '2MSC1', 2024, 1),
(56, 35753, 'Jesús Román Fuentes Ruíz', '4MSC1', 2024, 1),
(58, 85728, 'Celso Márquez Sánchez', '1MSC1', 2024, 1),
(59, 10101, 'Carbajalio Silvario Lozano', '1MSC1', 2024, 1),
(60, 35753, 'Jesús Román Fuentes Ruíz', '1VSC1', 2023, 1),
(61, 35753, 'Jesús Román Fuentes Ruíz', '1MSC1', 2024, 1),
(62, 35753, 'Jesús Román Fuentes Ruíz', '1VSC1', 2024, 1),
(63, 85728, 'Celso Márquez Sánchez', '2MET1', 2024, 1),
(64, 35753, 'Jesús Román Fuentes Ruíz', '2VET1', 2024, 1),
(65, 35753, 'Jesús Román Fuentes Ruíz', '5VLT0', 2024, 1),
(66, 35753, 'Jesús Román Fuentes Ruíz', '1MSC0', 2024, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `nivel_acceso` tinyint(4) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `matricula` bigint(20) DEFAULT NULL,
  `nempleado` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `contraseña`, `nivel_acceso`, `email`, `created_at`, `matricula`, `nempleado`) VALUES
('Jesús Román Fuentes Ruíz', 'jYwMNs4eK+woXTlljqVjItuHd4HsrCsF/1nEJ7z9fjEskBGlHRU8SM29PXEEQNpwY4jhbAD+1itrWS+GomuEnA==', 1, 'roman.fuentes@uptex.edu.mx', '2023-04-21 08:02:26', NULL, 35753),
('Osiriz Marlen Trujillo López', 'SMyBaEO7xgCKS6kSErslSOJ+L7dFfno2HoUmGQYNaDpi3fl6IWTC1H3vhEHxz8mawLwLW6a6oC1dfjQsDP7aMA==', 1, 'osiriz.trujillo@uptex.edu.mx', '2023-04-21 08:04:27', NULL, 94638),
('Mireya Alvarez Benitez', 'R9/JEmzmwb0aAfOd2Rj0w4fWswGR5n76vi94uFBn2Kzjwhc5E2plZ+5rX+S0GpXMZ/spi5fHRq63Gu4h+6M4iWFlrOQfSiymQVJFfM94M3k=', 1, 'ma.benitez@uptex.edu.mx', '2023-04-21 08:08:51', NULL, 642357),
('Celso Márquez Sánchez', 'CT6qwVNMKSd4zijhHP+0zQjbhujFTFNbgvx15dVycbGPW4k/kDsOXe3X2RzumcQI4AYDl0fyrUewYReG+y+CFg==', 1, 'celso.marquez@uptex.edu.mx', '2023-04-21 08:21:24', NULL, 85728),
('Jacquelinne Arellano Montiel', 'T+ynkkjzyXbW26g1GKD7+ot08VclW5HJa6x8s2J0lbXgOXzfN4ShmHa+LMEkHYW5lnpP3G8FFYM46yW8yeenFPHtz27S32keihG45M2n6K8=', 1, 'jaqueline.arellanomo@uptex.edu.mx', '2023-04-21 08:57:03', NULL, 4826489),
('Héctor Manuel Gómez Martínez\r\n', 'E2jNahV2kvB4d8Jops/f1Eo7LLGYWwN98Eopa5RakPj9kgev9RKe6WMERJpSRDWWHZrNqATPsQWEsDV6OgJvxg==', 1, 'rector@uptex.edu.mx', '2023-04-21 12:09:11', NULL, 1),
('Ángel David Barrera García', 'nh84tbRDhREDl8Ny9R55S9BTHT9pN+TGdnLNqARoayXuInAMRLZ8z5Xyof7CNK/sgjCU5SoN+s6H0EuYd5/XGQ==', 1, 'angel@hotmail.com', '2023-04-21 21:47:06', NULL, 53423),
('Julian Garcia', '8cOnKXgk2wCm/t3N821SsXn9P44DwZ2Mlcgkd0T4ddQyZ9tggiP4XCJc94ZRpe6O3ysDM+yFN7tQ8sf5ZrpaSg==', 1, 'julian@gmail.com', '2023-04-25 16:47:25', NULL, 987),
('Julio Cesar Tenorio', 'bXGulcIRQNrdN2bMPmHnZINlJb+kMNLN9rQ5gkuecK2aTszK3PwlEwBq2bZHrF6FhJwnzPDCMa6sfcWKB+TOGg==', 1, 'juliocesar.tenorio@uptex.edu.mx', '2023-05-03 17:33:31', NULL, 315),
('Nancy Hernandez Rivera', 'hDjkPjTK0K5kG8S4g6PfrlQJdSKNHX7Q3VZWwnxV0L+RQCtxs1cora3vUDZiArD/vZ4gZkJjsAOp0h9ttDa3Cw==', 1, 'nallely.hernandez@uptex.edu.mx', '2023-05-07 00:17:30', NULL, 6549),
('Carbajalio Silvario Lozano', 'gA8re5cPminPftofBJNSFFZ81q2dNG17UmVblAKoEjw9VYNUVKypiKuR0Hfk+xni7kXcRIBllN8UdI+Fqfm6ow==', 1, 'carbajaliosilvario1@gmail.com', '2024-03-06 17:47:20', NULL, 10101),
('Jonatan Arath Nieto Nieto', 'MOWjTXcCRTaRPk6w6q4LZhhwoeCf7ymUP9P/C6KHRfYtLG9fJg6D32RhwFJWWeFapaApuP+wplEAPehxdXGKlw==', 1, '77777@gmailcom', '2024-03-06 18:29:47', NULL, 77777),
('Jonatan Arath Garcia Nieto', 'K+OcmIuh2Yp/x/Y3UUhcNJ9KW5eNSR0M49XlHOoDJ8i8s/2xgrTOPo+vLOZ+LjuFWrs98Ppn2sZa2bw416Sosg==', 0, '13201305155@gmail.com', '2024-03-20 21:00:02', 13201305155, NULL),
('Bermeo Nava Dillan', '+5rEhKeJVXYuE0rJqqpVV6YMNl9FrujaWJQWt+UoEcH6M8NyWDwMEZVAHtQf8I51+2bwxSN6LEEtUId63e8c/Q==', 0, '13201305189@gmail.com', '2024-03-21 20:15:35', 13201305189, NULL),
('José Luis Saucedo Fernández', 'EkPOsb2TNdy9BIWLxYVfm50S5Rgn066taN25lz5WEZLzV+bg7RZFwZn0/gDCmqe3IF7hhMZy97D4hrTMDsZZCQ==', 0, '132114053093@uptex.edu.mx', '2024-06-24 17:28:59', 13211405309, NULL),
('Juan Carlos', 'NTN3toX00fQjB3p6Tm0VWGYUgNnmRM8hQfFINyr7IdPuTT0a+9hoX+FVHkAx8svo/jLWF9seupySpXWVBbE4nw==', 0, 'hatblckht@gmail.com', '2025-02-17 20:58:38', 13201305156, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`matricula`),
  ADD KEY `alumnos_ibfk_1` (`id_carrera`);

--
-- Indices de la tabla `alumno_scores`
--
ALTER TABLE `alumno_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumno_scores_ibfk_1` (`matricula`);

--
-- Indices de la tabla `asignaturasa`
--
ALTER TABLE `asignaturasa`
  ADD PRIMARY KEY (`id_asignaturasa`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `id_materias` (`id_materias`);

--
-- Indices de la tabla `asignaturasp`
--
ALTER TABLE `asignaturasp`
  ADD PRIMARY KEY (`id_asignaturasp`),
  ADD KEY `nempleado` (`nempleado`),
  ADD KEY `id_materias` (`id_materias`),
  ADD KEY `nempleado_2` (`nempleado`,`id_materias`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_citas`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `nempleado` (`nempleado`),
  ADD KEY `id_citasN` (`id_citasN`),
  ADD KEY `matricula_2` (`matricula`,`nempleado`,`id_citasN`),
  ADD KEY `tutor` (`tutor`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `citas_eliminadas`
--
ALTER TABLE `citas_eliminadas`
  ADD PRIMARY KEY (`id_citas`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `nempleado` (`nempleado`),
  ADD KEY `id_citasN` (`id_citasN`),
  ADD KEY `matricula_2` (`matricula`,`nempleado`,`id_citasN`),
  ADD KEY `tutor` (`tutor`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `citas_procesar`
--
ALTER TABLE `citas_procesar`
  ADD PRIMARY KEY (`id_citas`),
  ADD KEY `matricula` (`matricula`),
  ADD KEY `nempleado` (`tutor`),
  ADD KEY `id_citasN` (`id_citasN`),
  ADD KEY `matricula_2` (`matricula`,`tutor`,`id_citasN`);

--
-- Indices de la tabla `estudio_se`
--
ALTER TABLE `estudio_se`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indices de la tabla `evaluaciones_activas`
--
ALTER TABLE `evaluaciones_activas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_calificaciones`
--
ALTER TABLE `historial_calificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_grupos`
--
ALTER TABLE `historial_grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula` (`matricula`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materias`),
  ADD KEY `id_carrera` (`id_carrera`);

--
-- Indices de la tabla `medallas`
--
ALTER TABLE `medallas`
  ADD PRIMARY KEY (`id_medalla`);

--
-- Indices de la tabla `medallas_profesor`
--
ALTER TABLE `medallas_profesor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medallas_profesor_ibfk_1` (`nempleado`),
  ADD KEY `medallas_profesor_ibfk_2` (`id_medalla`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `sender_id` (`remitente`),
  ADD KEY `receiver_id` (`receptor`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `nivelcitas`
--
ALTER TABLE `nivelcitas`
  ADD PRIMARY KEY (`id_citasN`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `nempleado_notas` (`nempleado`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`nempleado`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Indices de la tabla `profesor_carrera`
--
ALTER TABLE `profesor_carrera`
  ADD PRIMARY KEY (`nempleado`,`id_carrera`),
  ADD KEY `id_carrera` (`id_carrera`),
  ADD KEY `nempleado` (`nempleado`);

--
-- Indices de la tabla `profesor_horario`
--
ALTER TABLE `profesor_horario`
  ADD PRIMARY KEY (`nempleado`,`dia_semana`,`hora_inicio`);

--
-- Indices de la tabla `profesor_nivel`
--
ALTER TABLE `profesor_nivel`
  ADD PRIMARY KEY (`nempleado`,`id_nivel`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Indices de la tabla `resultados_encuesta`
--
ALTER TABLE `resultados_encuesta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_problema`
--
ALTER TABLE `tipo_problema`
  ADD PRIMARY KEY (`id_tipo_problema`),
  ADD KEY `fk_1` (`id_nivel`);

--
-- Indices de la tabla `tutor_grupos`
--
ALTER TABLE `tutor_grupos`
  ADD PRIMARY KEY (`id_tutor_grupo`),
  ADD KEY `nempleado` (`nempleado`);

--
-- Indices de la tabla `tutor_grupos_historial`
--
ALTER TABLE `tutor_grupos_historial`
  ADD KEY `nempleado` (`nempleado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `usuarios_ibfk_1` (`matricula`),
  ADD KEY `usuarios_ibfk_2` (`nempleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumno_scores`
--
ALTER TABLE `alumno_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `asignaturasa`
--
ALTER TABLE `asignaturasa`
  MODIFY `id_asignaturasa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1631;

--
-- AUTO_INCREMENT de la tabla `asignaturasp`
--
ALTER TABLE `asignaturasp`
  MODIFY `id_asignaturasp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_citas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=871;

--
-- AUTO_INCREMENT de la tabla `citas_eliminadas`
--
ALTER TABLE `citas_eliminadas`
  MODIFY `id_citas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=871;

--
-- AUTO_INCREMENT de la tabla `citas_procesar`
--
ALTER TABLE `citas_procesar`
  MODIFY `id_citas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT de la tabla `estudio_se`
--
ALTER TABLE `estudio_se`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evaluaciones_activas`
--
ALTER TABLE `evaluaciones_activas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historial_calificaciones`
--
ALTER TABLE `historial_calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT de la tabla `historial_grupos`
--
ALTER TABLE `historial_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT de la tabla `medallas`
--
ALTER TABLE `medallas`
  MODIFY `id_medalla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `medallas_profesor`
--
ALTER TABLE `medallas_profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `nivelcitas`
--
ALTER TABLE `nivelcitas`
  MODIFY `id_citasN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `resultados_encuesta`
--
ALTER TABLE `resultados_encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `tipo_problema`
--
ALTER TABLE `tipo_problema`
  MODIFY `id_tipo_problema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tutor_grupos`
--
ALTER TABLE `tutor_grupos`
  MODIFY `id_tutor_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alumno_scores`
--
ALTER TABLE `alumno_scores`
  ADD CONSTRAINT `alumno_scores_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignaturasa`
--
ALTER TABLE `asignaturasa`
  ADD CONSTRAINT `asignaturasa_ibfk_2` FOREIGN KEY (`id_materias`) REFERENCES `materias` (`id_materias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignaturasa_ibfk_3` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asignaturasp`
--
ALTER TABLE `asignaturasp`
  ADD CONSTRAINT `asignaturasp_ibfk_2` FOREIGN KEY (`id_materias`) REFERENCES `materias` (`id_materias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asignaturasp_ibfk_3` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`id_citasN`) REFERENCES `nivelcitas` (`id_citasN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_4` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_5` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_6` FOREIGN KEY (`tutor`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_7` FOREIGN KEY (`tipo`) REFERENCES `tipo_problema` (`id_tipo_problema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `citas_procesar`
--
ALTER TABLE `citas_procesar`
  ADD CONSTRAINT `fkidnivel_1` FOREIGN KEY (`id_citasN`) REFERENCES `nivelcitas` (`id_citasN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmatricuka_1` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fknempleado` FOREIGN KEY (`tutor`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudio_se`
--
ALTER TABLE `estudio_se`
  ADD CONSTRAINT `estudio_se_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `alumnos` (`id_carrera`);

--
-- Filtros para la tabla `historial_grupos`
--
ALTER TABLE `historial_grupos`
  ADD CONSTRAINT `historial_grupos_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medallas_profesor`
--
ALTER TABLE `medallas_profesor`
  ADD CONSTRAINT `medallas_profesor_ibfk_1` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medallas_profesor_ibfk_2` FOREIGN KEY (`id_medalla`) REFERENCES `medallas` (`id_medalla`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`remitente`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`receptor`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `nempleado_notasfk1` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor_carrera`
--
ALTER TABLE `profesor_carrera`
  ADD CONSTRAINT `profesor_carrera_ibfk_1` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profesor_carrera_ibfk_2` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor_horario`
--
ALTER TABLE `profesor_horario`
  ADD CONSTRAINT `profesor_horario_ibfk_1` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesor_nivel`
--
ALTER TABLE `profesor_nivel`
  ADD CONSTRAINT `profesor_nivel_ibfk_1` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profesor_nivel_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipo_problema`
--
ALTER TABLE `tipo_problema`
  ADD CONSTRAINT `fk_1` FOREIGN KEY (`id_nivel`) REFERENCES `nivelcitas` (`id_citasN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tutor_grupos`
--
ALTER TABLE `tutor_grupos`
  ADD CONSTRAINT `tutor_grupo-fk1` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`matricula`) REFERENCES `alumnos` (`matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`nempleado`) REFERENCES `profesores` (`nempleado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2020 a las 18:06:40
-- Versión del servidor: 10.1.40-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `example`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`id`, `nombre`, `fecha_registro`, `fecha_modificacion`) VALUES
(1, 'Operaciones', '2020-04-09 16:06:02', NULL),
(2, 'Operaciones', '2020-04-09 16:06:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE latin1_spanish_ci NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`id`, `nombre`, `id_modulo`, `fecha_registro`, `fecha_modificacion`) VALUES
(1, 'Crear operacion', 1, '2020-04-09 16:05:42', NULL),
(2, 'Eliminar operacion', 1, '2020-04-09 16:05:42', NULL),
(3, 'Detalles de operacion', 1, '2020-04-09 16:05:42', NULL),
(4, 'Modificar operacion', 1, '2020-04-09 16:05:42', NULL),
(5, 'Listar operaciones', 1, '2020-04-09 16:05:42', NULL),
(6, 'Crear rol', 1, '2020-04-09 16:05:42', NULL),
(7, 'Eliminar rol', 1, '2020-04-09 16:05:42', NULL),
(8, 'Detalles de rol', 1, '2020-04-09 16:05:42', NULL),
(9, 'Modificar rol', 1, '2020-04-09 16:05:42', NULL),
(10, 'Listar roles', 1, '2020-04-09 16:05:42', NULL),
(11, 'Crear permiso', 1, '2020-04-09 16:05:42', NULL),
(12, 'Eliminar permiso', 1, '2020-04-09 16:05:42', NULL),
(13, 'Detalles de permiso', 1, '2020-04-09 16:05:42', NULL),
(14, 'Modificar permiso', 1, '2020-04-09 16:05:42', NULL),
(15, 'Listar permisos', 1, '2020-04-09 16:05:42', NULL),
(16, 'Crear usuario', 1, '2020-04-09 16:05:42', NULL),
(17, 'Eliminar usuario', 1, '2020-04-09 16:05:42', NULL),
(18, 'Detalles de usuario', 1, '2020-04-09 16:05:42', NULL),
(19, 'Modificar usuario', 1, '2020-04-09 16:05:42', NULL),
(20, 'Listar usuarios', 1, '2020-04-09 16:05:42', NULL),
(21, 'Crear operacion', 1, '2020-04-09 16:05:42', NULL),
(22, 'Eliminar operacion', 1, '2020-04-09 16:05:42', NULL),
(23, 'Detalles de operacion', 1, '2020-04-09 16:05:42', NULL),
(24, 'Modificar operacion', 1, '2020-04-09 16:05:42', NULL),
(25, 'Listar operaciones', 1, '2020-04-09 16:05:42', NULL),
(26, 'Crear rol', 1, '2020-04-09 16:05:42', NULL),
(27, 'Eliminar rol', 1, '2020-04-09 16:05:42', NULL),
(28, 'Detalles de rol', 1, '2020-04-09 16:05:42', NULL),
(29, 'Modificar rol', 1, '2020-04-09 16:05:42', NULL),
(30, 'Listar roles', 1, '2020-04-09 16:05:42', NULL),
(31, 'Crear permiso', 1, '2020-04-09 16:05:42', NULL),
(32, 'Eliminar permiso', 1, '2020-04-09 16:05:42', NULL),
(33, 'Detalles de permiso', 1, '2020-04-09 16:05:42', NULL),
(34, 'Modificar permiso', 1, '2020-04-09 16:05:42', NULL),
(35, 'Listar permisos', 1, '2020-04-09 16:05:42', NULL),
(36, 'Crear usuario', 1, '2020-04-09 16:05:42', NULL),
(37, 'Eliminar usuario', 1, '2020-04-09 16:05:42', NULL),
(38, 'Detalles de usuario', 1, '2020-04-09 16:05:42', NULL),
(39, 'Modificar usuario', 1, '2020-04-09 16:05:42', NULL),
(40, 'Listar usuarios', 1, '2020-04-09 16:05:42', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_operacion` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `id_rol`, `id_operacion`, `fecha_registro`, `fecha_modificacion`) VALUES
(1, 1, 1, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(2, 1, 2, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(3, 1, 3, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(4, 1, 4, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(5, 1, 5, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(6, 1, 6, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(7, 1, 7, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(8, 1, 8, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(9, 1, 9, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(10, 1, 10, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(11, 1, 11, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(12, 1, 12, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(13, 1, 13, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(14, 1, 14, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(15, 1, 15, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(16, 1, 16, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(17, 1, 17, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(18, 1, 18, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(19, 1, 19, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(20, 1, 20, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(26, 2, 3, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(27, 1, 1, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(28, 1, 2, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(29, 1, 3, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(30, 1, 4, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(31, 1, 5, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(32, 1, 6, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(33, 1, 7, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(34, 1, 8, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(35, 1, 9, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(36, 1, 10, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(37, 1, 11, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(38, 1, 12, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(39, 1, 13, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(40, 1, 14, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(41, 1, 15, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(42, 1, 16, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(43, 1, 17, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(44, 1, 18, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(45, 1, 19, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(46, 1, 20, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(47, 1, 21, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(48, 1, 22, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(49, 1, 23, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(50, 1, 24, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(51, 1, 25, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(52, 2, 3, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(53, 2, 5, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(54, 2, 8, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(55, 2, 10, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(56, 2, 13, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(57, 2, 15, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(58, 2, 18, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(59, 2, 20, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(60, 2, 21, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(61, 2, 22, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(62, 2, 23, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(63, 2, 24, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(64, 2, 25, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(65, 3, 3, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(66, 3, 5, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(67, 3, 8, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(68, 3, 10, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(69, 3, 13, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(70, 3, 15, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(71, 3, 18, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(72, 3, 20, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(73, 3, 23, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(74, 3, 25, '2020-04-09 16:05:20', '0000-00-00 00:00:00'),
(75, 4, 25, '2020-04-09 16:05:20', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `fecha_registro`, `fecha_modificacion`) VALUES
(1, 'Developer', '2020-04-09 16:05:02', NULL),
(2, 'Administrador', '2020-04-09 16:05:02', NULL),
(3, 'Supervisor', '2020-04-09 16:05:02', NULL),
(4, 'Cliente', '2020-04-09 16:05:02', NULL),
(5, 'Developer', '2020-04-09 16:05:02', NULL),
(6, 'Administrador', '2020-04-09 16:05:02', NULL),
(7, 'Supervisor', '2020-04-09 16:05:02', NULL),
(8, 'Cliente', '2020-04-09 16:05:02', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `clave` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `id_rol` int(11) NOT NULL DEFAULT '2',
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `clave`, `nombre`, `id_rol`, `fecha_registro`, `fecha_modificacion`) VALUES
(1, 'fercalmet@gmail.com', '12345678', 'Fernando Calmet', 1, '2020-04-09 16:04:32', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_modulo` (`id_modulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_operacion` (`id_operacion`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD CONSTRAINT `operaciones_ibfk_1` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_operacion`) REFERENCES `operaciones` (`id`),
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

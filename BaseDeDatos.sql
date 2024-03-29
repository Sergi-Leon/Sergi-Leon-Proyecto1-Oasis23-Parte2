-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2024 a las 22:44:04
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_oasis23`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_camareros`
--

CREATE TABLE `tbl_camareros` (
  `id_camarero` int(11) NOT NULL,
  `username_camarero` varchar(20) NOT NULL,
  `nombre_camarero` varchar(45) NOT NULL,
  `apellidos_camarero` varchar(60) NOT NULL,
  `correo_camarero` varchar(80) NOT NULL,
  `telefono_camarero` char(9) NOT NULL,
  `pwd_camarero` varchar(80) NOT NULL,
  `imagen_camarero` varchar(120) DEFAULT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_camareros`
--

INSERT INTO `tbl_camareros` (`id_camarero`, `username_camarero`, `nombre_camarero`, `apellidos_camarero`, `correo_camarero`, `telefono_camarero`, `pwd_camarero`, `imagen_camarero`, `id_cargo`) VALUES
(1, 'ivanmoreno', 'Ivan', 'Moreno', 'imoreno@oasis.com', '111111111', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/ivan.jpg', 3),
(2, 'adricamarero', 'Adrian', 'Herraez', 'aherraez@oasis.com', '222222222', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/adri.jpg', 2),
(3, 'sergioleon', 'Sergio', 'Leon', 'sleon@oasis.com', '333333333', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/sergio.jpg', 1),
(4, 'messicamarero', 'Leo', 'Messi', 'lmessi@oasis.com', '444444444', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/messi.jpg', 2),
(5, 'ianromero', 'Ian', 'Romero', 'iromero@oasis.com', '555555555', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/ian.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cargo`
--

CREATE TABLE `tbl_cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cargo`
--

INSERT INTO `tbl_cargo` (`id_cargo`, `nombre_cargo`) VALUES
(1, 'Administrador'),
(2, 'Camarero'),
(3, 'Mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mesas`
--

CREATE TABLE `tbl_mesas` (
  `id_mesa` int(11) NOT NULL,
  `nombre_mesa` varchar(4) NOT NULL,
  `estado_mesa` enum('Libre','Ocupada','Mantenimiento') NOT NULL,
  `sillas_mesa` int(11) NOT NULL,
  `id_sala_mesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mesas`
--

INSERT INTO `tbl_mesas` (`id_mesa`, `nombre_mesa`, `estado_mesa`, `sillas_mesa`, `id_sala_mesa`) VALUES
(1, 'T1M1', 'Libre', 10, 1),
(2, 'T1M2', 'Libre', 1, 1),
(3, 'T1M3', 'Libre', 2, 1),
(4, 'T1M4', 'Libre', 3, 1),
(5, 'T2M1', 'Libre', 2, 2),
(6, 'T2M2', 'Libre', 2, 2),
(7, 'T2M3', 'Libre', 2, 2),
(8, 'T3M1', 'Ocupada', 3, 3),
(9, 'T3M2', 'Libre', 3, 3),
(10, 'T3M3', 'Libre', 1, 3),
(11, 'C1M1', 'Ocupada', 1, 4),
(12, 'C1M2', 'Libre', 1, 4),
(13, 'C1M3', 'Libre', 2, 4),
(14, 'C2M1', 'Libre', 2, 5),
(15, 'C2M2', 'Libre', 3, 5),
(16, 'C2M3', 'Libre', 3, 5),
(17, 'P1M1', 'Ocupada', 5, 6),
(18, 'P2M1', 'Libre', 3, 7),
(19, 'P3M1', 'Libre', 3, 8),
(20, 'P4M1', 'Ocupada', 4, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reservas`
--

CREATE TABLE `tbl_reservas` (
  `id_reserva` int(11) NOT NULL,
  `hora_inicio_reserva` datetime NOT NULL,
  `hora_final_reserva` datetime DEFAULT NULL,
  `id_camarero_reserva` int(11) NOT NULL,
  `id_mesa_reserva` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_reservas`
--

INSERT INTO `tbl_reservas` (`id_reserva`, `hora_inicio_reserva`, `hora_final_reserva`, `id_camarero_reserva`, `id_mesa_reserva`) VALUES
(1, '2024-01-16 17:11:59', '2024-01-24 16:27:13', 4, 1),
(2, '2024-01-16 17:12:08', '2024-01-16 17:15:58', 4, 9),
(3, '2024-01-16 17:12:15', '2024-01-16 17:16:05', 4, 12),
(4, '2024-01-16 17:12:19', '2024-01-16 17:16:08', 4, 16),
(5, '2024-01-16 17:12:28', '2024-01-23 12:20:15', 4, 17),
(6, '2024-01-16 17:12:31', '2024-01-23 12:20:19', 4, 20),
(7, '2024-01-16 17:18:05', '2024-01-24 16:27:13', 4, 1),
(8, '2024-01-16 17:49:50', '2024-01-24 16:27:13', 4, 1),
(9, '2024-01-16 17:53:15', '2024-01-24 16:27:13', 4, 1),
(10, '2024-01-16 17:57:15', '2024-01-23 12:20:13', 4, 11),
(11, '2024-01-16 20:09:26', '2024-01-24 16:27:13', 4, 1),
(12, '2024-01-16 20:09:31', '2024-01-24 16:27:13', 4, 1),
(13, '2024-01-16 20:12:11', '2024-01-24 16:27:13', 4, 1),
(14, '2024-01-16 20:27:32', '2024-01-24 16:27:13', 4, 1),
(15, '2024-01-16 20:49:07', '2024-01-24 16:27:13', 4, 1),
(16, '2024-01-17 17:11:06', '2024-01-24 16:27:13', 2, 1),
(17, '2024-01-17 17:12:12', '2024-01-24 16:27:13', 2, 1),
(18, '2024-01-17 17:12:18', '2024-01-24 16:27:13', 2, 1),
(30, '2024-01-19 12:10:24', '2024-01-24 16:27:13', 4, 1),
(31, '2024-01-19 12:11:46', '2024-01-24 16:27:13', 4, 1),
(32, '2024-01-19 12:21:13', '2024-01-24 16:27:13', 4, 1),
(33, '2024-01-19 12:25:12', '2024-01-24 16:27:13', 4, 1),
(34, '2024-01-19 12:25:16', '2024-01-22 19:43:17', 4, 8),
(35, '2024-01-19 12:25:29', '2024-01-23 12:20:15', 4, 17),
(36, '2024-01-19 12:25:39', '2024-01-23 12:20:13', 4, 11),
(37, '2024-01-19 15:09:56', '2024-01-24 16:27:13', 2, 1),
(38, '2024-01-19 16:07:34', '2024-01-23 12:20:19', 2, 20),
(39, '2024-01-19 16:18:54', '2024-01-24 16:27:13', 2, 1),
(40, '2024-01-22 19:43:18', '2024-01-24 16:27:13', 3, 1),
(41, '2024-01-22 20:15:26', '2024-01-24 10:59:41', 3, 2),
(42, '2024-01-22 20:15:44', '2024-01-23 11:28:38', 3, 19),
(43, '2024-01-22 20:17:49', '2024-01-23 11:28:38', 3, 19),
(44, '2024-01-22 20:18:31', '2024-01-24 10:59:41', 3, 2),
(45, '2024-01-22 20:41:50', '2024-01-24 16:27:13', 3, 1),
(46, '2024-01-22 20:41:54', '2024-01-24 10:59:41', 3, 2),
(47, '2024-01-22 20:42:41', '2024-01-24 10:59:41', 3, 2),
(48, '2024-01-22 20:43:48', '2024-01-24 10:59:41', 3, 2),
(49, '2024-01-22 20:49:34', '2024-01-24 10:59:41', 3, 2),
(50, '2024-01-23 09:10:29', '2024-01-24 10:59:41', 3, 2),
(51, '2024-01-23 09:41:08', '2024-01-23 11:28:38', 3, 19),
(52, '2024-01-23 09:41:49', '2024-01-23 12:20:10', 3, 3),
(53, '2024-01-23 09:44:53', '2024-01-23 11:28:38', 3, 19),
(54, '2024-01-23 10:09:15', '2024-01-24 10:59:41', 3, 2),
(55, '2024-01-23 10:23:02', '2024-01-24 10:59:41', 3, 2),
(56, '2024-01-23 10:23:06', '2024-01-24 10:59:41', 3, 2),
(57, '2024-01-23 10:36:37', '2024-01-24 10:59:41', 3, 2),
(58, '2024-01-23 10:57:39', '2024-01-24 10:59:41', 3, 2),
(59, '2024-01-23 10:57:42', '2024-01-23 10:58:04', 3, 4),
(60, '2024-01-23 10:57:57', '2024-01-23 10:58:04', 3, 4),
(61, '2024-01-23 10:58:00', '2024-01-24 10:59:41', 3, 2),
(62, '2024-01-23 11:15:51', '2024-01-24 10:59:41', 4, 2),
(63, '2024-01-23 11:15:57', '2024-01-24 16:27:13', 4, 1),
(64, '2024-01-23 11:20:32', '2024-01-24 16:27:13', 1, 1),
(65, '2024-01-23 11:20:37', '2024-01-24 16:27:13', 1, 1),
(66, '2024-01-23 11:22:30', '2024-01-23 12:20:15', 1, 17),
(67, '2024-01-23 11:23:10', '2024-01-24 16:27:13', 4, 1),
(68, '2024-01-23 11:23:27', '2024-01-23 11:23:30', 4, 18),
(69, '2024-01-23 11:28:28', '2024-01-23 11:28:38', 5, 19),
(70, '2024-01-23 11:28:42', '2024-01-23 12:20:15', 5, 17),
(71, '2024-01-24 10:59:24', '2024-01-24 16:27:13', 5, 1),
(72, '2024-01-24 10:59:29', '2024-01-24 10:59:41', 5, 2),
(73, '2024-01-24 10:59:38', '2024-01-24 10:59:41', 5, 2),
(74, '2024-01-24 12:38:42', '2024-01-24 16:27:13', 5, 1),
(75, '2024-01-24 12:38:50', '2024-01-24 12:38:53', 5, 14),
(76, '2024-01-24 12:48:13', '2024-01-24 16:27:13', 5, 1),
(77, '2024-01-24 14:12:05', '2024-01-24 16:27:13', 5, 1),
(78, '2024-01-24 14:22:20', '2024-01-24 16:27:13', 5, 1),
(79, '2024-01-24 14:48:58', '2024-01-24 16:27:13', 5, 1),
(80, '2024-01-24 14:49:16', '2024-01-24 16:27:13', 5, 1),
(81, '2024-01-24 15:37:26', '2024-01-24 16:27:13', 5, 1),
(82, '2024-01-24 16:03:48', '2024-01-24 16:27:13', 5, 1),
(83, '2024-01-24 16:03:55', '2024-01-24 16:27:13', 5, 1),
(84, '2024-01-24 16:11:33', '2024-01-24 16:27:13', 5, 1),
(85, '2024-01-24 16:20:46', '2024-01-24 16:27:13', 5, 1),
(86, '2024-01-24 16:22:34', '2024-01-24 16:27:13', 5, 1),
(87, '2024-01-24 16:22:50', '2024-01-24 16:27:13', 5, 1),
(88, '2024-01-24 16:27:01', '2024-01-24 16:27:13', 2, 1),
(89, '2024-01-24 16:27:12', '2024-01-24 16:27:13', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reservas2`
--

CREATE TABLE `tbl_reservas2` (
  `id_reserva2` int(11) NOT NULL,
  `nombre_reserva2` varchar(20) NOT NULL,
  `num_personas_reserva2` int(11) NOT NULL,
  `fecha_reserva2` date NOT NULL,
  `hora_reserva2` time NOT NULL,
  `id_mesa_reserva2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_reservas2`
--

INSERT INTO `tbl_reservas2` (`id_reserva2`, `nombre_reserva2`, `num_personas_reserva2`, `fecha_reserva2`, `hora_reserva2`, `id_mesa_reserva2`) VALUES
(22, 'oejrpç', 5, '2024-01-27', '19:15:00', 14),
(26, 'alberto', 6, '2024-01-25', '20:00:00', 16),
(27, 'agnes', 44, '2024-01-25', '20:00:00', 16),
(28, 'feop', 4, '2024-01-24', '18:36:00', 13),
(29, 'prueba5', 5, '2024-01-26', '20:00:00', 16),
(30, 'prueba8', 8, '2024-01-23', '20:00:00', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_salas`
--

CREATE TABLE `tbl_salas` (
  `id_sala` int(11) NOT NULL,
  `nombre_sala` varchar(15) NOT NULL,
  `tipo_sala` enum('Terraza','Comedor','Sala Privada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_salas`
--

INSERT INTO `tbl_salas` (`id_sala`, `nombre_sala`, `tipo_sala`) VALUES
(1, 'Terraza1', 'Terraza'),
(2, 'Terraza2', 'Terraza'),
(3, 'Terraza3', 'Terraza'),
(4, 'Comedor1', 'Comedor'),
(5, 'Comedor2', 'Comedor'),
(6, 'SalaPrivada1', 'Sala Privada'),
(7, 'SalaPrivada2', 'Sala Privada'),
(8, 'SalaPrivada3', 'Sala Privada'),
(9, 'SalaPrivada4', 'Sala Privada');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  ADD PRIMARY KEY (`id_camarero`),
  ADD KEY `id_cargo_fk` (`id_cargo`);

--
-- Indices de la tabla `tbl_cargo`
--
ALTER TABLE `tbl_cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `mesas_salas_fk` (`id_sala_mesa`);

--
-- Indices de la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `reservas_camareros_fk` (`id_camarero_reserva`),
  ADD KEY `reservas_mesas_fk` (`id_mesa_reserva`);

--
-- Indices de la tabla `tbl_reservas2`
--
ALTER TABLE `tbl_reservas2`
  ADD PRIMARY KEY (`id_reserva2`),
  ADD KEY `reservas_mesas_fk2` (`id_mesa_reserva2`);

--
-- Indices de la tabla `tbl_salas`
--
ALTER TABLE `tbl_salas`
  ADD PRIMARY KEY (`id_sala`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  MODIFY `id_camarero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_cargo`
--
ALTER TABLE `tbl_cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `tbl_reservas2`
--
ALTER TABLE `tbl_reservas2`
  MODIFY `id_reserva2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `tbl_salas`
--
ALTER TABLE `tbl_salas`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  ADD CONSTRAINT `id_cargo_fk` FOREIGN KEY (`id_cargo`) REFERENCES `tbl_cargo` (`id_cargo`);

--
-- Filtros para la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  ADD CONSTRAINT `mesas_salas_fk` FOREIGN KEY (`id_sala_mesa`) REFERENCES `tbl_salas` (`id_sala`);

--
-- Filtros para la tabla `tbl_reservas`
--
ALTER TABLE `tbl_reservas`
  ADD CONSTRAINT `reservas_camareros_fk` FOREIGN KEY (`id_camarero_reserva`) REFERENCES `tbl_camareros` (`id_camarero`),
  ADD CONSTRAINT `reservas_mesas_fk` FOREIGN KEY (`id_mesa_reserva`) REFERENCES `tbl_mesas` (`id_mesa`);

--
-- Filtros para la tabla `tbl_reservas2`
--
ALTER TABLE `tbl_reservas2`
  ADD CONSTRAINT `reservas_mesas_fk2` FOREIGN KEY (`id_mesa_reserva2`) REFERENCES `tbl_mesas` (`id_mesa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

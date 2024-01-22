CREATE DATABASE db_Oasis23 DEFAULT CHARACTER SET utf8mb4;
USE db_Oasis23;

CREATE TABLE `tbl_cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(25) NOT NULL,
  PRIMARY KEY (`id_cargo`)
);

CREATE TABLE `tbl_camareros` (
  `id_camarero` int(11) NOT NULL AUTO_INCREMENT,
  `username_camarero` varchar(20) NOT NULL,
  `nombre_camarero` varchar(45) NOT NULL,
  `apellidos_camarero` varchar(60) NOT NULL,
  `correo_camarero` varchar(80) NOT NULL,
  `telefono_camarero` char(9) NOT NULL,
  `pwd_camarero` varchar(80) NOT NULL,
  `imagen_camarero` varchar(120) DEFAULT NULL,
  `id_cargo` int(11) NOT NULL,
  PRIMARY KEY (`id_camarero`)
);

CREATE TABLE `tbl_salas` (
  `id_sala` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_sala` varchar(15) NOT NULL,
  `tipo_sala` enum('Terraza','Comedor','Sala Privada') NOT NULL,
  PRIMARY KEY (`id_sala`)
);

CREATE TABLE `tbl_mesas` (
  `id_mesa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_mesa` varchar(4) NOT NULL,
  `estado_mesa` enum('Libre','Ocupada') NOT NULL,
  `sillas_mesa` enum('2','4','6','8','12') NOT NULL,
  `id_sala_mesa` int(11) NOT NULL,
  PRIMARY KEY (`id_mesa`)
);

CREATE TABLE `tbl_reservas` (
  `id_reserva` int(11) NOT NULL AUTO_INCREMENT,
  `hora_inicio_reserva` datetime NOT NULL,
  `hora_final_reserva` datetime DEFAULT NULL,
  `id_camarero_reserva` int(11) NOT NULL,
  `id_mesa_reserva` int(11) NOT NULL,
  PRIMARY KEY (`id_reserva`)
);

ALTER TABLE `tbl_camareros` ADD CONSTRAINT `id_cargo_fk`
FOREIGN KEY (`id_cargo`)
REFERENCES `tbl_cargo` (`id_cargo`);

ALTER TABLE `tbl_mesas` ADD CONSTRAINT `mesas_salas_fk`
FOREIGN KEY (`id_sala_mesa`)
REFERENCES `tbl_salas` (`id_sala`);

ALTER TABLE `tbl_reservas` ADD CONSTRAINT `reservas_camareros_fk`
FOREIGN KEY (`id_camarero_reserva`)
REFERENCES `tbl_camareros` (`id_camarero`);

ALTER TABLE `tbl_reservas` ADD CONSTRAINT `reservas_mesas_fk`
FOREIGN KEY (`id_mesa_reserva`)
REFERENCES `tbl_mesas` (`id_mesa`);

INSERT INTO `tbl_cargo` (`id_cargo`, `nombre_cargo`) VALUES
(1, 'Administrador'),
(2, 'Camarero'),
(3, 'Mantenimiento');

INSERT INTO `tbl_camareros` (`id_camarero`, `username_camarero`, `nombre_camarero`, `apellidos_camarero`, `correo_camarero`, `telefono_camarero`, `pwd_camarero`, `imagen_camarero`, `id_cargo`) VALUES
(1, 'ivanmoreno', 'Ivan', 'Moreno', 'imoreno@oasis.com', '111111111', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/ivan.jpg', 3),
(2, 'adricamarero', 'Adrian', 'Herraez', 'aherraez@oasis.com', '222222222', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/adri.jpg', 2),
(3, 'sergioleon', 'Sergio', 'Leon', 'sleon@oasis.com', '333333333', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/sergio.jpg', 1),
(4, 'messicamarero', 'Leo', 'Messi', 'lmessi@oasis.com', '444444444', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/messi.jpg', 2),
(5, 'ianromero', 'Ian', 'Romero', 'iromero@oasis.com', '555555555', '$2y$10$wigWyJ26umFhiMWROr/DK.NqNltLAI4M2dRT5l4MyPPkoy4YN5rW6', './img/ian.jpg', 1);

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

INSERT INTO `tbl_mesas` (`id_mesa`, `nombre_mesa`, `estado_mesa`, `sillas_mesa`, `id_sala_mesa`) VALUES
(1, 'T1M1', 'Libre', '2', 1),
(2, 'T1M2', 'Libre', '2', 1),
(3, 'T1M3', 'Libre', '4', 1),
(4, 'T1M4', 'Libre', '6', 1),
(5, 'T2M1', 'Libre', '4', 2),
(6, 'T2M2', 'Libre', '4', 2),
(7, 'T2M3', 'Libre', '4', 2),
(8, 'T3M1', 'Ocupada', '6', 3),
(9, 'T3M2', 'Libre', '6', 3),
(10, 'T3M3', 'Libre', '2', 3),
(11, 'C1M1', 'Ocupada', '2', 4),
(12, 'C1M2', 'Libre', '2', 4),
(13, 'C1M3', 'Libre', '4', 4),
(14, 'C2M1', 'Libre', '4', 5),
(15, 'C2M2', 'Libre', '6', 5),
(16, 'C2M3', 'Libre', '6', 5),
(17, 'P1M1', 'Ocupada', '12', 6),
(18, 'P2M1', 'Libre', '6', 7),
(19, 'P3M1', 'Libre', '6', 8),
(20, 'P4M1', 'Ocupada', '8', 9);



INSERT INTO `tbl_reservas` (`id_reserva`, `hora_inicio_reserva`, `hora_final_reserva`, `id_camarero_reserva`, `id_mesa_reserva`) VALUES
(1, '2024-01-16 17:11:59', '2024-01-19 16:18:56', 4, 1),
(2, '2024-01-16 17:12:08', '2024-01-16 17:15:58', 4, 9),
(3, '2024-01-16 17:12:15', '2024-01-16 17:16:05', 4, 12),
(4, '2024-01-16 17:12:19', '2024-01-16 17:16:08', 4, 16),
(5, '2024-01-16 17:12:28', '2024-01-16 17:16:14', 4, 17),
(6, '2024-01-16 17:12:31', '2024-01-16 17:16:18', 4, 20),
(7, '2024-01-16 17:18:05', '2024-01-19 16:18:56', 4, 1),
(8, '2024-01-16 17:49:50', '2024-01-19 16:18:56', 4, 1),
(9, '2024-01-16 17:53:15', '2024-01-19 16:18:56', 4, 1),
(10, '2024-01-16 17:57:15', '2024-01-16 17:57:17', 4, 11),
(11, '2024-01-16 20:09:26', '2024-01-19 16:18:56', 4, 1),
(12, '2024-01-16 20:09:31', '2024-01-19 16:18:56', 4, 1),
(13, '2024-01-16 20:12:11', '2024-01-19 16:18:56', 4, 1),
(14, '2024-01-16 20:27:32', '2024-01-19 16:18:56', 4, 1),
(15, '2024-01-16 20:49:07', '2024-01-19 16:18:56', 4, 1),
(16, '2024-01-17 17:11:06', '2024-01-19 16:18:56', 2, 1),
(17, '2024-01-17 17:12:12', '2024-01-19 16:18:56', 2, 1),
(18, '2024-01-17 17:12:18', '2024-01-19 16:18:56', 2, 1),
(30, '2024-01-19 12:10:24', '2024-01-19 16:18:56', 4, 1),
(31, '2024-01-19 12:11:46', '2024-01-19 16:18:56', 4, 1),
(32, '2024-01-19 12:21:13', '2024-01-19 16:18:56', 4, 1),
(33, '2024-01-19 12:25:12', '2024-01-19 16:18:56', 4, 1),
(34, '2024-01-19 12:25:16', NULL, 4, 8),
(35, '2024-01-19 12:25:29', NULL, 4, 17),
(36, '2024-01-19 12:25:39', NULL, 4, 11),
(37, '2024-01-19 15:09:56', '2024-01-19 16:18:56', 2, 1),
(38, '2024-01-19 16:07:34', NULL, 2, 20),
(39, '2024-01-19 16:18:54', '2024-01-19 16:18:56', 2, 1);

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2023 a las 05:51:58
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prestigetravels`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `Usuario` int(10) NOT NULL,
  `codigo_hotel` int(20) DEFAULT NULL,
  `cod_paquete` int(20) DEFAULT NULL,
  `cantidad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`Usuario`, `codigo_hotel`, `cod_paquete`, `cantidad`) VALUES
(210812872, 7, NULL, 1),
(210812872, 4, NULL, 1),
(210812872, NULL, 6, 1),
(104567892, 15, NULL, 1),
(543452341, 2, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

CREATE TABLE `hotel` (
  `codigo_hotel` int(20) NOT NULL,
  `nombre_hotel` varchar(40) NOT NULL,
  `#Estrellas` int(5) NOT NULL,
  `precio` int(15) NOT NULL,
  `Ciudad` varchar(20) NOT NULL,
  `HabitacionesTotales` int(5) NOT NULL,
  `disponibles` int(5) NOT NULL,
  `Estacionamiento` tinyint(1) NOT NULL,
  `Piscina` tinyint(1) NOT NULL,
  `ServicioLavanderia` tinyint(1) NOT NULL,
  `PetFriendly` tinyint(1) NOT NULL,
  `ServicioDesayuno` tinyint(1) NOT NULL,
  `imagen` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hotel`
--

INSERT INTO `hotel` (`codigo_hotel`, `nombre_hotel`, `#Estrellas`, `precio`, `Ciudad`, `HabitacionesTotales`, `disponibles`, `Estacionamiento`, `Piscina`, `ServicioLavanderia`, `PetFriendly`, `ServicioDesayuno`, `imagen`) VALUES
(1, 'Hotel USM', 5, 100000, 'santiago', 15, 6, 1, 0, 0, 1, 0, 'hotel1.jpg'),
(2, 'Hotel Estrella', 3, 50000, 'Santiago', 40, 7, 1, 1, 1, 0, 1, 'hotel2.jpg'),
(3, 'Gran Hotel', 4, 150000, 'Valparaíso', 50, 0, 1, 1, 0, 1, 1, 'hotel3.jpg'),
(4, 'Hotel del Sol', 5, 300000, 'Viña del Mar', 20, 1, 1, 1, 1, 1, 1, 'hotel4.jpg'),
(5, 'Hotel Montaña', 2, 500000, 'Puerto Varas', 40, 7, 0, 0, 1, 1, 0, 'hotel5.jpg'),
(6, 'Hotel Oasis', 3, 120000, 'La Serena', 60, 1, 1, 0, 0, 0, 1, 'hotel6.jpg'),
(7, 'Hotel Marítimo', 4, 180000, 'Valdivia', 45, 5, 1, 1, 0, 1, 0, 'hotel7.jpg'),
(8, 'Hotel Elegante', 2, 40000, 'Antofagasta', 45, 30, 1, 0, 1, 0, 0, 'hotel8.jpg'),
(10, 'Hotel Serenity', 4, 70000, 'San Fernando', 20, 14, 1, 0, 0, 0, 1, 'hotel9.jpg'),
(11, 'The Grand Vista Hotel', 4, 120000, 'Viña del Mar', 30, 15, 1, 1, 1, 0, 1, 'hotel10.jpg'),
(12, 'Oasis Resort & Spa', 5, 200000, 'Valdivia', 40, 9, 1, 1, 1, 1, 1, 'hotel11.jpg'),
(13, 'Sunset Beach Hotel', 3, 60000, 'Valparaiso', 20, 18, 1, 0, 0, 1, 0, 'hotel12.jpg'),
(14, 'Mountain View Lodge', 4, 120000, 'Santiago', 25, 7, 1, 0, 0, 0, 1, 'hotel13.jpg'),
(15, 'Royal Palace Hotel', 5, 300000, 'Santiago', 40, 29, 1, 1, 1, 1, 1, 'hotel14.jpg'),
(16, 'Harborview Inn', 3, 70000, 'Iquique', 20, 13, 1, 0, 1, 0, 1, 'hotel15.jpg'),
(17, 'The Tranquil Retreat', 2, 30000, 'Santiago', 30, 12, 0, 0, 0, 0, 0, 'hotel16.jpg'),
(18, 'Hotel Certero', 4, 150000, 'Talca', 35, 23, 1, 1, 0, 1, 0, 'hotel17.jpg'),
(19, 'The Regal Tower Hotel', 5, 400000, 'Villarrica', 20, 3, 1, 1, 1, 1, 1, 'hotel18.jpg'),
(20, 'The Boutique Inn', 3, 120000, 'Antofagasta', 20, 7, 1, 0, 1, 0, 1, 'hotel19.jpg'),
(21, 'Hotel Shile', 3, 60000, 'Santiago', 30, 16, 1, 0, 0, 1, 0, 'hotel20.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

CREATE TABLE `paquete` (
  `cod_paquete` int(20) NOT NULL,
  `nombre_paquete` varchar(40) NOT NULL,
  `aerolinea_ida` varchar(20) NOT NULL,
  `hospedaje1` int(3) DEFAULT NULL,
  `hospedaje2` int(3) DEFAULT NULL,
  `hospedaje3` int(3) DEFAULT NULL,
  `aerolinea_vuelta` varchar(20) NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_llegada` date NOT NULL,
  `noches_totales` int(5) NOT NULL,
  `precio` int(15) NOT NULL,
  `disponibles` int(5) NOT NULL,
  `max_pers_x_paq` int(10) NOT NULL,
  `imagen` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`cod_paquete`, `nombre_paquete`, `aerolinea_ida`, `hospedaje1`, `hospedaje2`, `hospedaje3`, `aerolinea_vuelta`, `fecha_salida`, `fecha_llegada`, `noches_totales`, `precio`, `disponibles`, `max_pers_x_paq`, `imagen`) VALUES
(1, 'Paquete B', 'JetSmart', 1, 2, NULL, 'Latam', '2023-07-05', '2023-07-12', 7, 489990, 3, 4, 'paquete1.jpg'),
(2, 'Paquete C', 'American', 4, 2, NULL, 'Latam', '2023-08-15', '2023-08-22', 7, 399990, 8, 3, 'paquete2.jpg'),
(3, 'Paquete D', 'Latam', 7, 20, 16, 'Latam', '2023-09-01', '2023-09-08', 7, 800000, 0, 2, 'paquete3.jpg'),
(4, 'Paquete E', 'SKY', 15, 19, NULL, 'Latam', '2023-10-20', '2023-10-27', 7, 1100000, 0, 3, 'paquete4.jpg'),
(5, 'Paquete F', 'LOW', 4, 5, 18, 'SKY', '2023-11-12', '2023-11-19', 7, 600000, 12, 4, 'paquete5.jpg'),
(6, 'Paquete G', 'Latam', 19, 6, 16, 'Latam', '2023-12-03', '2023-12-10', 7, 900000, 2, 2, 'paquete6.jpg'),
(7, 'Paquete H', 'SKY', 14, 12, NULL, 'SKY', '2024-01-18', '2024-01-25', 7, 1000000, 9, 3, 'paquete7.jpg'),
(8, 'Paquete I', 'American', 19, NULL, NULL, 'Latam', '2024-02-29', '2024-03-07', 7, 899990, 3, 4, 'paquete8.jpg'),
(9, 'Paquete J', 'Latam', 10, 13, NULL, 'LOW', '2024-04-14', '2024-04-21', 7, 999990, 3, 2, 'paquete9.jpg'),
(10, 'Paquete K', 'Latam', 5, 21, NULL, 'Latam', '2023-06-14', '2023-06-22', 7, 400000, 15, 3, 'paquete10.jpg'),
(11, 'Paquete L', 'Latam', 4, 1, 13, 'SKY', '2023-06-08', '2023-06-27', 18, 1000000, 2, 2, 'paquete11.jpg'),
(12, 'Paquete M', 'SKY', 16, 11, NULL, 'LOW', '2023-06-09', '2023-06-26', 16, 600000, 70, 4, 'paquete12.jpg'),
(13, 'Paquete N', 'LOW', 18, 1, 1, 'SKY', '2023-06-12', '2023-06-22', 9, 500000, 30, 5, 'paquete13.jpg'),
(14, 'Paquete O', 'JetSmart', 7, 13, NULL, 'JetSmart', '2023-06-15', '2023-06-26', 10, 599990, 6, 3, 'paquete14.jpg'),
(15, 'Paquete Premium', 'Latam', 12, 19, 15, 'Latam', '2023-06-08', '2023-06-30', 21, 2099990, 4, 2, 'paquete15.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseña`
--

CREATE TABLE `reseña` (
  `Usuario` int(11) NOT NULL,
  `codigo_hotel` int(11) DEFAULT NULL,
  `cod_paquete` int(4) DEFAULT NULL,
  `calificacion1` int(4) NOT NULL,
  `calificacion2` int(4) NOT NULL,
  `calificacion3` int(4) NOT NULL,
  `calificacion4` int(4) NOT NULL,
  `textoReseña` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseña`
--

INSERT INTO `reseña` (`Usuario`, `codigo_hotel`, `cod_paquete`, `calificacion1`, `calificacion2`, `calificacion3`, `calificacion4`, `textoReseña`) VALUES
(123456788, 1, NULL, 4, 5, 3, 4, 'ta weno'),
(123456788, NULL, 1, 4, 3, 3, 3, 'meh'),
(123456788, 4, NULL, 4, 2, 1, 3, 'una mierda'),
(210812872, NULL, 6, 2, 5, 3, 5, 'La experiencia fue ma o meno noma'),
(210812873, 4, NULL, 4, 4, 4, 4, 'Bastante bueno con sus pequeños detalles'),
(123456788, NULL, 15, 5, 5, 5, 5, 'Lo mejor, maravilloso'),
(123456789, 19, NULL, 5, 5, 5, 5, 'Weno weno, muy caro pero el precio esta justificado'),
(210812873, NULL, 6, 3, 3, 3, 3, 'Weno pero esperaba mas'),
(101234565, NULL, 12, 4, 4, 4, 4, 'Ta weno'),
(210812873, 18, NULL, 5, 5, 5, 5, 'like'),
(210812872, 16, 6, 5, 5, 5, 5, 'super'),
(210812872, 12, NULL, 4, 5, 3, 5, 'weno'),
(123456788, 12, NULL, 5, 4, 4, 5, 'bueno'),
(123456788, 20, NULL, 3, 4, 5, 3, ''),
(101234565, NULL, 9, 5, 5, 5, 5, ''),
(210812873, NULL, 13, 5, 5, 4, 4, ''),
(123456789, 3, NULL, 4, 4, 4, 4, ''),
(210812873, 2, NULL, 4, 5, 3, 3, ''),
(123456781, 11, NULL, 4, 5, 3, 4, ''),
(210812872, 21, NULL, 3, 3, 4, 3, ''),
(123456788, 6, NULL, 4, 3, 4, 3, ''),
(123456781, 8, NULL, 5, 5, 5, 5, ''),
(101234565, NULL, 7, 5, 5, 5, 5, ''),
(123456788, NULL, 14, 5, 4, 4, 4, ''),
(123456788, NULL, 3, 4, 5, 4, 5, ''),
(123456788, NULL, 11, 4, 5, 2, 3, ''),
(210812873, NULL, 12, 5, 5, 5, 5, ''),
(210812873, NULL, 4, 5, 4, 4, 3, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `rut` int(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `Hoteles_comprados` varchar(255) DEFAULT NULL,
  `Paquetes_comprados` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`rut`, `nombre`, `contrasena`, `fecha_nacimiento`, `email`, `Hoteles_comprados`, `Paquetes_comprados`) VALUES
(5435234, 'pruebajaja', '$2y$10$DmuP0HOsF308qEQm/UeVYOi/qBhincFrlAYFqTkxRF6EKjKTehMJ2', '1999-10-20', 'pruebasdjasjkls@gmail.com', NULL, NULL),
(101234565, 'Francisco Dominguez', '', '2002-04-18', 'test@gmail.com', NULL, NULL),
(103654581, 'ayudante', '$2y$10$opUBaZ45/El7fJ/eklV.IuRANNbG4xaSEECgTN7vQ6GjQ5JxeSuNO', '1998-10-01', 'ayudante@gmail.com', NULL, NULL),
(104567892, 'panchodm123', '$2y$10$YlyG6ovAWjmkcac2p9AAe.4HB9oFyjTE7Mh7LTFYQtj0KkTWJE10W', '1010-10-10', 'testpoqweasd@gmail.com', NULL, NULL),
(105438610, 'pancho8', '$2y$10$Py8LtBVrR9I6X/944jP5jeL1ZK3u1XerTaLqG9LMxO66clePCHMDa', '2022-02-02', 'pancho8@gmail.com', NULL, NULL),
(123456781, 'prueba', '$2y$10$eTC50P/LLVeGfqL8uAeyK.Hsj.hRM6rMJ726Ff/JQz1FODXsRV2au', '2002-10-11', 'test1@gmail.com', NULL, NULL),
(123456788, 'alu', '$2y$10$BcHWj9dw.Wbnk1fHlDF82.UgKiI/j4DEAHo//TE3egJUEK33FFc9y', '2000-02-02', 'gg@gmail.con', NULL, NULL),
(123456789, 'AJASJDASJ', '$2y$10$5KO5M6QTyFB18uEVo63LSOIhrt90aomJTSR5Tb0ImPx.YTkGofgAW', '2001-10-25', 'tes@gmail.com', NULL, NULL),
(126531235, 'vicente', '$2y$10$3oQIcVpCt0WEE3v58MFaGOXkYrOZRun/3NytGNfnYm/wl8bhW1uzG', '2003-10-10', 'pan1234cho@gmail.com', NULL, NULL),
(210812872, 'holA', '$2y$10$s/DwKKEDGlrkW0iN9SQLQO1vypyltn/n2dYqw/iZielSvYKJXlV7q', '2002-05-05', 'testtt@gmail.com', NULL, NULL),
(210812873, 'pancho', '', '2002-10-11', 'panchodm03@gmail.com', NULL, NULL),
(543452341, 'jose', '$2y$10$KybfuL/T33gp9/bCkXLuPe.FctrTnJV7439DqVNNIsPha/RwdCM1m', '1999-02-05', 'asdasdasd@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `Usuario` int(11) NOT NULL,
  `Paquetes` int(11) DEFAULT NULL,
  `Hotel` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `wishlist`
--

INSERT INTO `wishlist` (`Usuario`, `Paquetes`, `Hotel`) VALUES
(103654581, 6, NULL),
(103654581, NULL, 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD UNIQUE KEY `Usuario` (`Usuario`,`codigo_hotel`,`cod_paquete`),
  ADD KEY `codigo_hotel` (`codigo_hotel`),
  ADD KEY `cod_paquete` (`cod_paquete`);

--
-- Indices de la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`codigo_hotel`);

--
-- Indices de la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD PRIMARY KEY (`cod_paquete`),
  ADD KEY `hospedaje2` (`hospedaje2`),
  ADD KEY `hospedaje3` (`hospedaje3`),
  ADD KEY `hospedaje1` (`hospedaje1`);

--
-- Indices de la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD KEY `cod_paquete` (`cod_paquete`),
  ADD KEY `Usuario` (`Usuario`) USING BTREE,
  ADD KEY `codigo_hotel` (`codigo_hotel`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`rut`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD KEY `Paquetes` (`Paquetes`),
  ADD KEY `Hotel` (`Hotel`),
  ADD KEY `Usuario` (`Usuario`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hotel`
--
ALTER TABLE `hotel`
  MODIFY `codigo_hotel` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `paquete`
--
ALTER TABLE `paquete`
  MODIFY `cod_paquete` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`codigo_hotel`) REFERENCES `hotel` (`codigo_hotel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_3` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_4` FOREIGN KEY (`cod_paquete`) REFERENCES `paquete` (`cod_paquete`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD CONSTRAINT `paquete_ibfk_1` FOREIGN KEY (`hospedaje2`) REFERENCES `hotel` (`codigo_hotel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paquete_ibfk_2` FOREIGN KEY (`hospedaje3`) REFERENCES `hotel` (`codigo_hotel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paquete_ibfk_3` FOREIGN KEY (`hospedaje1`) REFERENCES `hotel` (`codigo_hotel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD CONSTRAINT `reseña_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reseña_ibfk_2` FOREIGN KEY (`codigo_hotel`) REFERENCES `hotel` (`codigo_hotel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reseña_ibfk_3` FOREIGN KEY (`cod_paquete`) REFERENCES `paquete` (`cod_paquete`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`Paquetes`) REFERENCES `paquete` (`cod_paquete`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_3` FOREIGN KEY (`Hotel`) REFERENCES `hotel` (`codigo_hotel`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

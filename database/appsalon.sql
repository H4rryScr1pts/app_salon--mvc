-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-02-2024 a las 17:42:39
-- Versión del servidor: 8.1.0
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appsalon_mvc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citasservicios`
--

CREATE TABLE `citasservicios` (
  `id` int NOT NULL,
  `citaId` int DEFAULT NULL,
  `servicioId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `citasservicios`
--

INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(26, NULL, 2),
(27, NULL, 2),
(28, NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(2, 'Corte de Cabello Hombre', 80.00),
(3, 'Corte de Barba', 60.00),
(4, 'Peinado Mujer', 80.00),
(5, 'Peinado Hombre', 60.00),
(6, 'Tinte', 300.00),
(7, 'Uñas', 400.00),
(8, 'Lavado de Cabello', 50.00),
(9, 'Tratamiento Capilar', 150.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `admin`, `confirmado`, `token`) VALUES
(19, 'Harry', 'Wilson', 'harrywilsonth01@gmail.com', '$2y$10$LsXp4qxl70bWgmGHfzGC3.sxMBzybh6pZGzFOTXtLhzvBgsFRaehy', '2462207373', 1, 1, ''),
(20, ' Leo', 'Torres', 'harry@gmail.com', '$2y$10$XjHUOQSS8RtqgWrfSgLbbuEKy3zJIwmQhU6t3U361D3ZZKbITShnC', '2462297373', 0, 1, ''),
(22, ' Nico', 'Fraga', '3522110150@uth.edu.mx', '$2y$10$83Gxtl9DvzfrV8Lff5Az/uFgPUkCcYfIRc3MwwF11MhJuMaSAvMYm', '2581644165', 0, 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cita` (`citaId`),
  ADD KEY `servicioId` (`servicioId`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD CONSTRAINT `citasservicios_ibfk_3` FOREIGN KEY (`citaId`) REFERENCES `citas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `citasservicios_ibfk_4` FOREIGN KEY (`servicioId`) REFERENCES `servicios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

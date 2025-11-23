-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2025 a las 02:18:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `antojitosmarbe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_detalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad_detalle`) VALUES
(8, 6, 1, 2),
(9, 6, 2, 1),
(10, 6, 3, 1),
(15, 9, 3, 2),
(18, 11, 1, 1),
(19, 12, 2, 1),
(20, 13, 2, 2),
(21, 13, 3, 1),
(22, 14, 15, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id_opinion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `comentario_opinion` text NOT NULL,
  `calificacion_opinion` int(11) NOT NULL,
  `fecha_opinion` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`id_opinion`, `id_usuario`, `id_pedido`, `comentario_opinion`, `calificacion_opinion`, `fecha_opinion`) VALUES
(17, 19, 7, 'Estuvo muy bien, pero la atención del no fue la mejor...', 4, '2025-09-15'),
(20, 3, 6, 'Estuvo muy delicioso todo y me gustó mucho el combo 1 ya que estaba muy completo :)', 5, '2025-09-15'),
(21, 3, 8, 'Me gustó mucho todo, pero falto más salsa.', 4, '2025-09-15'),
(22, 19, 9, 'No me gustaron las gorditas :(', 2, '2025-09-15'),
(27, 3, 12, 'Estuvo muy delicioso. ', 5, '2025-10-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_pedido` decimal(10,0) NOT NULL,
  `estado_pedido` varchar(20) NOT NULL,
  `extra_pedido` text NOT NULL,
  `entrega_pedido` varchar(30) NOT NULL,
  `disponible_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `total_pedido`, `estado_pedido`, `extra_pedido`, `entrega_pedido`, `disponible_pedido`) VALUES
(6, 3, '2025-09-11 18:51:43', 640, 'Entregando', 'Más cebolla, Tortillas extra ($10), Cargo por envío ($30)', 'Domicilio', 1),
(9, 19, '2025-09-15 21:34:44', 540, 'Recibido', 'Tortillas extra ($10), Cargo por envío ($30)', 'Domicilio', 1),
(11, 3, '2025-10-11 23:19:27', 110, 'Recibido', 'Queso extra ($10)', 'Recoger en Mitras Poniente', 1),
(12, 3, '2025-10-11 23:25:02', 150, 'Recibido', 'No hay extras.', 'Recoger en Real de Cumbres', 1),
(13, 19, '2025-10-11 23:30:37', 560, 'Recibido', 'Más cebolla, Aguacate ($10)', 'Recoger en Mitras Poniente', 1),
(14, 19, '2025-10-11 23:33:30', 200, 'Terminado', 'No hay extras.', 'Recoger en Real de Cumbres', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `foto_producto` varchar(20) NOT NULL,
  `nom_producto` varchar(50) NOT NULL,
  `desc_producto` text NOT NULL,
  `precio_producto` float(10,0) NOT NULL,
  `disponible_producto` int(11) NOT NULL,
  `fecha_producto` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `foto_producto`, `nom_producto`, `desc_producto`, `precio_producto`, `disponible_producto`, `fecha_producto`) VALUES
(1, 'archivos/1.jpg', 'Tacos', 'Tacos con papa y zanahoria', 100, 1, '2025-08-31'),
(2, 'archivos/2.jpg', 'Gorditas', 'Gorditas con papa y zanahoria', 150, 1, '2025-08-31'),
(3, 'archivos/3.jpg', 'Combo #1', 'En este combo se incluyen unas gorditas muy ricas con algunas flautas, también tiene chiles enteros, zanahorias, etc.', 250, 1, '2025-08-31'),
(13, 'archivos/13.jpg', 'Combo #2', 'En este combo se incluyen unas gorditas muy ricas con algunas flautas, también tiene chiles enteros, zanahorias, etc. Y más cosas que el combo #1.', 300, 1, '2025-09-06'),
(14, 'archivos/14.jpg', 'Flautas', 'Flautas con tomate y cebolla.', 100, 1, '2025-09-06'),
(15, 'archivos/15.jpg', 'Gorditas con frijoles', 'Gorditas pero se agregan frijoles recién hechos.', 200, 1, '2025-09-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nom_usuario` varchar(50) NOT NULL,
  `nomcompleto_usuario` varchar(50) NOT NULL,
  `correo_usuario` varchar(50) NOT NULL,
  `pass_usuario` varchar(25) NOT NULL,
  `tel_usuario` varchar(11) NOT NULL,
  `direccion_usuario` text NOT NULL,
  `rol_usuario` varchar(15) NOT NULL,
  `activo_usuario` int(11) NOT NULL,
  `fecha_usuario` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nom_usuario`, `nomcompleto_usuario`, `correo_usuario`, `pass_usuario`, `tel_usuario`, `direccion_usuario`, `rol_usuario`, `activo_usuario`, `fecha_usuario`) VALUES
(2, 'empleado', 'Empleado Yahir Nicolas Blanco Elizondo', 'empleado@gmail.com', '123', '0123456789', 'Calle #123, Colonia Imaginaria, entre Calle 1 y Calle 2, N.L ', 'Empleado', 1, '2025-08-21'),
(3, 'cliente', 'Cliente Yahir Nicolas Blanco Elizondo', 'cliente@gmail.com', '123', '0123456789', 'Calle #123, Colonia Imaginaria, entre Calle 1 y Calle 2, N.L ', 'Cliente', 1, '2025-08-21'),
(19, 'clienteEjemplo', 'Prueba', 'prueba@gmail.com', '123', '0123456789', 'calle 999, colonia Random entre 1 y 2', 'Cliente', 0, '2025-09-11'),
(21, 'admin', 'Admin Yahir Nicolas Blanco Elizondo', 'admin@gmail.com', '123', '0123456789', 'Calle #123, Colonia Imaginaria, entre Calle 1 y Calle 2, N.L ', 'Administrador', 1, '2025-09-15'),
(27, 'clYahir', 'Yahir Nicolas Blanco Elizondo', 'yahir.nicolasblanco12@gmail.com', '123', '8126946143', 'ejemplo de prueba de dirección de prueba', 'Cliente', 1, '2025-11-15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id_opinion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id_opinion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD CONSTRAINT `opiniones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

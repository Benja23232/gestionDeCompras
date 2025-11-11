-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2025 a las 13:16:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `comprador_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `fecha`, `comprador_id`, `nombre`, `user_id`) VALUES
(21, '2025-10-25 00:00:00', 1, 'Verduleria', NULL),
(22, '2025-10-25 00:00:00', 1, 'Coto', NULL),
(23, '2025-10-25 00:00:00', 1, 'pago?', NULL),
(24, '2025-10-25 00:00:00', 1, 'pago?', NULL),
(25, '2025-10-25 00:00:00', 1, 'pago?', NULL),
(26, '2025-10-25 00:00:00', 1, 'pagoo', NULL),
(27, '2025-10-18 00:00:00', 2, 'Verduleria', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250612190157', '2025-06-12 21:01:59', 44);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `monto` double NOT NULL,
  `fecha` datetime NOT NULL,
  `pagador_id` int(11) DEFAULT NULL,
  `receptor_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `monto`, `fecha`, `pagador_id`, `receptor_id`, `user_id`) VALUES
(24, 400, '2025-10-25 17:08:07', 2, 1, NULL),
(25, 200, '2025-10-25 17:25:14', 2, 1, NULL),
(26, 300, '2025-10-25 17:25:54', 2, 1, NULL),
(27, 100, '2025-10-04 00:00:00', 1, 2, NULL),
(28, 100, '2025-10-23 00:00:00', 2, 1, NULL),
(29, 300, '2025-10-25 17:31:38', 2, 1, NULL),
(30, 1000, '2025-10-25 17:35:50', 2, 1, NULL),
(31, 3200, '2025-10-25 17:56:12', 2, 1, NULL),
(32, 3100, '2025-10-25 17:57:15', 2, 1, NULL),
(33, 200, '2025-10-25 00:00:00', 2, 1, NULL),
(34, 300, '2025-10-26 00:00:00', 1, 2, NULL),
(35, 300, '2025-10-26 00:00:00', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` double NOT NULL,
  `descuento` double DEFAULT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `tiene_descuento` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`, `descuento`, `compra_id`, `tiene_descuento`) VALUES
(44, 'papa', 400, NULL, 21, 0),
(45, 'Fideos', 1000, NULL, 22, 0),
(46, 'oagoi>', 3200, NULL, 23, 0),
(47, 'oagoi>', 3200, NULL, 24, 0),
(48, 'oagoi>', 3200, NULL, 25, 0),
(49, 'pruevaaaaaaaa', 200, NULL, 26, 0),
(50, 'Agua', 150, NULL, 26, 0),
(51, 'papa', 600, NULL, 27, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_user`
--

CREATE TABLE `producto_user` (
  `producto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_user`
--

INSERT INTO `producto_user` (`producto_id`, `user_id`) VALUES
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 1),
(49, 2),
(50, 2),
(51, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `saldo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nombre`, `saldo`) VALUES
(1, 'benjaarncivia@gmail.com', '[]', '$2y$13$Kof21i4mtFF/3qEnpZy1m.9SSBbPrze..NoOML9xKC/Axg97QoHZm', NULL, NULL),
(2, 'prueba@gmai.com', '[]', '$2y$13$YpV1LQJS5CJ/7/eFJHwwLuQGh62jMN562TZbVeRIptxnhpoDCSL2W', NULL, NULL),
(3, 'jua@gmail.com', '[]', '$2y$13$L/pkWVlpVijcjDbOWnO2z.QS4y3X0jxkGQecHfFt.OC7CX6SIVyze', 'jua', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_producto`
--

CREATE TABLE `user_producto` (
  `user_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `saldo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9EC131FF200A5E25` (`comprador_id`),
  ADD KEY `IDX_9EC131FFA76ED395` (`user_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4DF5F3E79054F1F` (`pagador_id`),
  ADD KEY `IDX_F4DF5F3E386D8D01` (`receptor_id`),
  ADD KEY `IDX_F4DF5F3EA76ED395` (`user_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A7BB0615F2E704D7` (`compra_id`);

--
-- Indices de la tabla `producto_user`
--
ALTER TABLE `producto_user`
  ADD PRIMARY KEY (`producto_id`,`user_id`),
  ADD KEY `IDX_7590DAA37645698E` (`producto_id`),
  ADD KEY `IDX_7590DAA3A76ED395` (`user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Indices de la tabla `user_producto`
--
ALTER TABLE `user_producto`
  ADD PRIMARY KEY (`user_id`,`producto_id`),
  ADD KEY `IDX_4736E215A76ED395` (`user_id`),
  ADD KEY `IDX_4736E2157645698E` (`producto_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `FK_9EC131FF200A5E25` FOREIGN KEY (`comprador_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9EC131FFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `FK_F4DF5F3E386D8D01` FOREIGN KEY (`receptor_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F4DF5F3E79054F1F` FOREIGN KEY (`pagador_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_F4DF5F3EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_A7BB0615F2E704D7` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`);

--
-- Filtros para la tabla `producto_user`
--
ALTER TABLE `producto_user`
  ADD CONSTRAINT `FK_7590DAA37645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7590DAA3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_producto`
--
ALTER TABLE `user_producto`
  ADD CONSTRAINT `FK_4736E2157645698E` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4736E215A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

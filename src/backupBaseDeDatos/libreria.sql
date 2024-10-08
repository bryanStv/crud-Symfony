-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-10-2024 a las 10:11:35
-- Versión del servidor: 8.0.39-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `libreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240926073846', '2024-09-26 09:39:06', 231),
('DoctrineMigrations\\Version20240930070223', '2024-09-30 09:02:48', 1491),
('DoctrineMigrations\\Version20240930071718', '2024-09-30 09:17:29', 205),
('DoctrineMigrations\\Version20241003080645', '2024-10-03 10:07:00', 455);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editorial`
--

CREATE TABLE `editorial` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `editorial`
--

INSERT INTO `editorial` (`id`, `name`) VALUES
(1, 'Anaya'),
(2, 'Planeta'),
(3, 'Planeta deagostini');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `autor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` int NOT NULL,
  `editorial_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id`, `titulo`, `autor`, `precio`, `editorial_id`) VALUES
(1, 'Pepe el Explorador', 'El Pepe', 14, 1),
(2, 'Hola Mundo', 'Jaimito El Escritor', 5, 1),
(3, 'Mundo Inmenso', 'Ana', 10, 2),
(6, 'Excalibur', 'Arturo', 18, 1),
(7, 'El metro', 'Anonimo', 15, 2),
(9, 'El infinito', 'Pepe El Escritor', 5, 1),
(15, 'Hola Mundo 2', 'Paco', 5, 2),
(16, 'Hello World', 'El Autor Desconocido', 15, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'b@a.com', '[]', '$2y$13$LS/6KVYqWKEi.cOI7zXNxeAjPTizGwC/j8z1BKtpljdIsKd/kJwHG'),
(2, 'bryan@gmail.com', '[]', '$2y$13$i/p5NbUvK0wmnSceTUEoY.e7fH.x1C1ETy/TdDJB3qJcmzhea0t8q'),
(3, 'u1', '[]', '$2y$13$3aWxRExhvE87DDFeyNclQ.g3wiZUhQ6Gb0VHJPqKxBJZoIVmHiSEq'),
(4, 'u2', '[]', '$2y$13$CCPgXEVxbKKcBW7crPEfoeYN91orz5PVpc5R1GQrKRt1v78TFkQPG'),
(5, 'u3', '[]', '$2y$13$K5OLu3lw9GsPrlNEP1ecF.VZTH7TUaqTkG0sUL1Uev2Z2XwHHKbIW'),
(6, 'adrian@gmail.com', '[]', '$2y$13$kSSFiI8N1.TswzB5jeSv3e4QEVflXOaJCDB.c5zWrsvs.ItlvGl/i');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `editorial`
--
ALTER TABLE `editorial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5799AD2BBAF1A24D` (`editorial_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `editorial`
--
ALTER TABLE `editorial`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `FK_5799AD2BBAF1A24D` FOREIGN KEY (`editorial_id`) REFERENCES `editorial` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

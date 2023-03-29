-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2020 a las 22:26:04
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `software_smadia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `filters`
--

CREATE TABLE `filters` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `filters`
--

INSERT INTO `filters` (`id`, `name`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Soltero', 'estado', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(2, 'Casado', 'estado', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(3, 'Divorciado', 'estado', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(4, 'Viudo', 'estado', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(5, 'Unión libre', 'estado', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(6, 'Separado', 'estado', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(7, 'Salud Total EPS', 'eps', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(8, 'Sura EPS', 'eps', 'activo', '2019-02-09 17:53:14', '2019-02-09 17:53:14'),
(9, 'Nueva EPS', 'eps', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(10, 'Caja copi', 'eps', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(11, 'SURA ', 'arl', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(12, 'COLPATRIA', 'arl', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(13, 'PORVENIR', 'pension', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(14, 'COLFONDOS', 'pension', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(15, 'SEGUROS DE VIDA ALFA', 'arl', 'activo', '2020-09-10 13:17:07', '2020-09-10 13:18:36'),
(16, 'LIBERTY SEGUROS', 'arl', 'activo', '2020-09-10 13:17:09', '2020-09-10 13:18:36'),
(17, 'POSITIVA', 'arl', 'activo', '2020-09-10 13:17:10', '2020-09-10 13:18:36'),
(18, 'COLMENA SA', 'arl', 'activo', '2020-09-10 13:17:12', '2020-09-10 13:18:36'),
(19, 'LA EQUIDAD SEGUROS', 'arl', 'activo', '2020-09-10 13:17:13', '2020-09-10 13:18:36'),
(20, 'MAPFRE COLOMBIA', 'arl', 'activo', '2020-09-10 13:17:23', '2020-09-10 13:18:36'),
(21, 'SEGUROS BOLÍVAR SA', 'arl', 'activo', '2020-09-10 13:18:26', '2020-09-10 13:18:36'),
(22, 'SEGUROS DE VIDA AURORA', 'arl', 'activo', '2020-09-10 13:18:28', '2020-09-10 13:18:36'),
(23, 'COLPENSIONES', 'pension', 'activo', '2020-09-10 13:19:39', '2020-09-10 13:22:05'),
(24, 'PROTECCIÓN', 'pension', 'activo', '2020-09-10 13:19:40', '2020-09-10 13:22:05'),
(25, 'OLD MUTUAL ', 'pension', 'activo', '2020-09-10 13:19:42', '2020-09-10 13:22:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

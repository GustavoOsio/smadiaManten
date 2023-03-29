-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2019 a las 18:01:34
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `smadia-soft`
--

--
-- Volcado de datos para la tabla `systems`
--

INSERT INTO `systems` (`id`, `name`, `name_observation`, `created_at`, `updated_at`) VALUES
(1, 'Cabeza, Cara y Cuello', 'system_head_face_neck', '2019-08-23 18:47:05', NULL),
(2, 'Cardio Respiratorio', 'system_respiratory_cardio', '2019-08-23 18:47:07', NULL),
(3, 'Sistema Digestivo', 'system_digestive', '2019-08-23 18:47:09', NULL),
(4, 'Sistema Genito Urinario', 'system_genito_urinary', '2019-08-23 18:47:10', NULL),
(5, 'Sistema Locomotor', 'system_locomotor', '2019-08-23 18:47:11', NULL),
(6, 'Sistema Nervioso', 'system_nervous', '2019-08-23 18:47:12', NULL),
(7, 'Sistema Tegumentario', 'system_integumentary', '2019-08-23 18:47:13', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

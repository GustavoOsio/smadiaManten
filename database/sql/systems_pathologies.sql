-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2019 a las 18:02:30
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
-- Volcado de datos para la tabla `systems_pathologies`
--

INSERT INTO `systems_pathologies` (`id`, `systems_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cefalea', '2019-08-23 19:03:26', NULL),
(2, 1, 'trastornos de la visión', '2019-08-23 19:03:27', NULL),
(3, 1, 'Disfagia', '2019-08-23 19:03:28', NULL),
(4, 1, 'Disfonía', '2019-08-23 19:03:29', NULL),
(5, 1, 'Amigdalitis', '2019-08-23 19:03:30', NULL),
(6, 1, 'Agrandamiento de la tiroides.', '2019-08-23 19:03:31', NULL),
(7, 2, 'Tos', '2019-08-23 19:03:32', NULL),
(8, 2, 'Expectoración', '2019-08-23 19:03:33', NULL),
(9, 2, 'Hemoptisis', '2019-08-23 19:03:34', NULL),
(10, 2, 'Dolor torácico', '2019-08-23 19:03:35', NULL),
(11, 2, 'Disnea', '2019-08-23 19:03:36', NULL),
(12, 2, 'Ortopnea', '2019-08-23 19:03:36', NULL),
(13, 2, 'Disnea paroxística nocturna', '2019-08-23 19:03:39', NULL),
(14, 2, 'Palpitaciones', '2019-08-23 19:03:40', NULL),
(15, 2, 'Edemas', '2019-08-23 19:03:41', NULL),
(16, 2, 'Dolor retroesternal', '2019-08-23 19:03:42', NULL),
(17, 3, 'Apetito', '2019-08-23 19:03:43', NULL),
(18, 3, 'Náuseas', '2019-08-23 19:03:44', NULL),
(19, 3, 'Vómito', '2019-08-23 19:03:46', NULL),
(20, 3, 'Pirosis', '2019-08-23 19:03:47', NULL),
(21, 3, 'Eructos frecuentes', '2019-08-23 19:03:47', NULL),
(22, 3, 'Disfagia', '2019-08-23 19:03:48', NULL),
(23, 3, 'Diarrea', '2019-08-23 19:03:50', NULL),
(24, 3, 'Estreñimiento', '2019-08-23 19:03:53', NULL),
(25, 3, 'Hematemesis', '2019-08-23 19:03:53', NULL),
(26, 3, 'Melenas', '2019-08-23 19:03:54', NULL),
(27, 3, 'Proctorragia', '2019-08-23 19:03:55', NULL),
(28, 3, 'Dolor abdominal', '2019-08-23 19:03:56', NULL),
(29, 3, 'Flatulencia', '2019-08-23 19:03:57', NULL),
(30, 3, 'Prurito rectal', '2019-08-23 19:03:58', NULL),
(31, 3, 'Ulcera péptica', '2019-08-23 19:03:59', NULL),
(32, 4, 'Dolor lumbar', '2019-08-23 19:04:00', NULL),
(33, 4, 'Poliuria', '2019-08-23 19:04:01', NULL),
(34, 4, 'Disuria', '2019-08-23 19:04:01', NULL),
(35, 4, 'Hematuria', '2019-08-23 19:04:02', NULL),
(36, 4, 'Orinas turbias', '2019-08-23 19:04:03', NULL),
(37, 4, 'Retención urinaria', '2019-08-23 19:04:04', NULL),
(38, 4, 'Incontinencia urinaria', '2019-08-23 19:04:05', NULL),
(39, 4, 'Tenesmo', '2019-08-23 19:04:06', NULL),
(40, 5, 'Leucorrea', '2019-08-23 19:04:07', NULL),
(41, 5, 'Amenorrea', '2019-08-23 19:04:07', NULL),
(42, 5, 'Metrorragia', '2019-08-23 19:04:08', NULL),
(43, 5, 'Dismenorrea', '2019-08-23 19:04:09', NULL),
(44, 6, 'Cefalea', '2019-08-23 19:04:10', NULL),
(45, 6, 'insomnio', '2019-08-23 19:04:11', NULL),
(46, 6, 'vértigo', '2019-08-23 19:04:12', NULL),
(47, 6, 'Síncopes', '2019-08-23 19:04:12', NULL),
(48, 6, 'Amnesia', '2019-08-23 19:04:13', NULL),
(49, 6, 'Afasia', '2019-08-23 19:04:14', NULL),
(50, 6, 'Desorientación', '2019-08-23 19:04:14', NULL),
(51, 6, 'Paresias', '2019-08-23 19:04:15', NULL),
(52, 6, 'Parestesias', '2019-08-23 19:04:16', NULL),
(53, 6, 'Convulsiones', '2019-08-23 19:04:16', NULL),
(54, 6, 'Perdida del conocimiento', '2019-08-23 19:03:24', NULL),
(55, 6, 'Alteraciones de la marcha', '2019-08-23 19:03:23', NULL),
(56, 6, 'Trastornos de la sensibilidad', '2019-08-23 19:03:23', NULL),
(57, 7, 'Equimosis', '2019-08-23 19:03:22', NULL),
(58, 7, 'Petequias', '2019-08-23 19:03:21', NULL),
(59, 7, 'Erupciones', '2019-08-23 19:03:20', NULL),
(60, 7, 'Prurito', '2019-08-23 19:03:19', NULL),
(61, 7, 'Caida del cabello', '2019-08-23 19:03:19', NULL),
(62, 7, 'Sudoración excesiva', '2019-08-23 19:03:17', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

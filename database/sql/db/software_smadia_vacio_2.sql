-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2020 a las 00:31:01
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
-- Estructura de tabla para la tabla `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `account` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('ahorros','corriente') COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anamnesis`
--

CREATE TABLE `anamnesis` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `reason_consultation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_illness` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_patologico` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_surgical` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_allergic` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_traumatic` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_medicines` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_gynecological` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_fum` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ant_habits` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_familiar` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ant_nutritional` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audits`
--

CREATE TABLE `audits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_values` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `audits`
--

INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'App\\User', 1, 'deleted', 'App\\Models\\Role', 11, '{\"id\":11,\"name\":\"Auxiliar de enfermeria\",\"superadmin\":0,\"status\":\"activo\",\"created_at\":\"2020-02-11 15:55:19\",\"updated_at\":\"2020-02-11 15:55:19\"}', '[]', 'http://127.0.0.1:8000/roles/11?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-26 19:22:42', '2020-08-26 19:22:42'),
(2, 'App\\User', 1, 'deleted', 'App\\Models\\Role', 10, '{\"id\":10,\"name\":\"Instrumentador\",\"superadmin\":0,\"status\":\"activo\",\"created_at\":\"2019-05-15 17:57:42\",\"updated_at\":\"2019-05-15 17:57:42\"}', '[]', 'http://127.0.0.1:8000/roles/10?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-26 19:22:47', '2020-08-26 19:22:47'),
(3, 'App\\User', 1, 'deleted', 'App\\Models\\Role', 6, '{\"id\":6,\"name\":\"Aux Call Center\",\"superadmin\":0,\"status\":\"activo\",\"created_at\":\"2018-11-20 20:26:11\",\"updated_at\":\"2018-11-20 20:26:11\"}', '[]', 'http://127.0.0.1:8000/roles/6?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-08-26 19:24:41', '2020-08-26 19:24:41'),
(4, 'App\\User', 1, 'created', 'App\\Models\\Diagnostic', 1, '[]', '{\"name\":\"Prueba\",\"type\":\"principal\",\"status\":\"activo\",\"updated_at\":\"2020-09-07 16:10:52\",\"created_at\":\"2020-09-07 16:10:52\",\"id\":1}', 'http://127.0.0.1:8000/diagnostics?', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', NULL, '2020-09-07 21:10:52', '2020-09-07 21:10:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `balance_box`
--

CREATE TABLE `balance_box` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `con_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('Ingreso','Ingreso Anulado','Venta','Venta Anulada','Egreso','Egreso Anulado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Ingreso',
  `monto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biological_medicine_plan`
--

CREATE TABLE `biological_medicine_plan` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `array_biological_medicine` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `array_observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cicle` int(11) NOT NULL,
  `sesion` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloods`
--

CREATE TABLE `bloods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bloods`
--

INSERT INTO `bloods` (`id`, `name`) VALUES
(1, 'O+'),
(2, 'O-'),
(3, 'A+'),
(4, 'A-'),
(5, 'B+'),
(6, 'B-'),
(7, 'AB+'),
(8, 'AB-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `budgetdashboard`
--

CREATE TABLE `budgetdashboard` (
  `id` int(10) UNSIGNED NOT NULL,
  `mouth` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `patients` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `budgets`
--

CREATE TABLE `budgets` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_expiration` date DEFAULT NULL,
  `status` enum('activo','anulado','contrato') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campaign`
--

CREATE TABLE `campaign` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cellars`
--

CREATE TABLE `cellars` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactivo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `center_costs`
--

CREATE TABLE `center_costs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('egreso','ingreso') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

CREATE TABLE `cities` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status` int(1) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id`, `name`, `status`, `state_id`) VALUES
(1, 'Abriaquí', 1, 5),
(2, 'Acacías', 1, 50),
(3, 'Acandí', 1, 27),
(4, 'Acevedo', 1, 41),
(5, 'Achí', 1, 13),
(6, 'Agrado', 1, 41),
(7, 'Agua de Dios', 1, 25),
(8, 'Aguachica', 1, 20),
(9, 'Aguada', 1, 68),
(10, 'Aguadas', 1, 17),
(11, 'Aguazul', 1, 85),
(12, 'Agustín Codazzi', 1, 20),
(13, 'Aipe', 1, 41),
(14, 'Albania', 1, 18),
(15, 'Albania', 1, 44),
(16, 'Albania', 1, 68),
(17, 'Albán', 1, 25),
(18, 'Albán (San José)', 1, 52),
(19, 'Alcalá', 1, 76),
(20, 'Alejandria', 1, 5),
(21, 'Algarrobo', 1, 47),
(22, 'Algeciras', 1, 41),
(23, 'Almaguer', 1, 19),
(24, 'Almeida', 1, 15),
(25, 'Alpujarra', 1, 73),
(26, 'Altamira', 1, 41),
(27, 'Alto Baudó (Pie de Pato)', 1, 27),
(28, 'Altos del Rosario', 1, 13),
(29, 'Alvarado', 1, 73),
(30, 'Amagá', 1, 5),
(31, 'Amalfi', 1, 5),
(32, 'Ambalema', 1, 73),
(33, 'Anapoima', 1, 25),
(34, 'Ancuya', 1, 52),
(35, 'Andalucía', 1, 76),
(36, 'Andes', 1, 5),
(37, 'Angelópolis', 1, 5),
(38, 'Angostura', 1, 5),
(39, 'Anolaima', 1, 25),
(40, 'Anorí', 1, 5),
(41, 'Anserma', 1, 17),
(42, 'Ansermanuevo', 1, 76),
(43, 'Anzoátegui', 1, 73),
(44, 'Anzá', 1, 5),
(45, 'Apartadó', 1, 5),
(46, 'Apulo', 1, 25),
(47, 'Apía', 1, 66),
(48, 'Aquitania', 1, 15),
(49, 'Aracataca', 1, 47),
(50, 'Aranzazu', 1, 17),
(51, 'Aratoca', 1, 68),
(52, 'Arauca', 1, 81),
(53, 'Arauquita', 1, 81),
(54, 'Arbeláez', 1, 25),
(55, 'Arboleda (Berruecos)', 1, 52),
(56, 'Arboledas', 1, 54),
(57, 'Arboletes', 1, 5),
(58, 'Arcabuco', 1, 15),
(59, 'Arenal', 1, 13),
(60, 'Argelia', 1, 5),
(61, 'Argelia', 1, 19),
(62, 'Argelia', 1, 76),
(63, 'Ariguaní (El Difícil)', 1, 47),
(64, 'Arjona', 1, 13),
(65, 'Armenia', 1, 5),
(66, 'Armenia', 1, 63),
(67, 'Armero (Guayabal)', 1, 73),
(68, 'Arroyohondo', 1, 13),
(69, 'Astrea', 1, 20),
(70, 'Ataco', 1, 73),
(71, 'Atrato (Yuto)', 1, 27),
(72, 'Ayapel', 1, 23),
(73, 'Bagadó', 1, 27),
(74, 'Bahía Solano (Mútis)', 1, 27),
(75, 'Bajo Baudó (Pizarro)', 1, 27),
(76, 'Balboa', 1, 19),
(77, 'Balboa', 1, 66),
(78, 'Baranoa', 1, 8),
(79, 'Baraya', 1, 41),
(80, 'Barbacoas', 1, 52),
(81, 'Barbosa', 1, 5),
(82, 'Barbosa', 1, 68),
(83, 'Barichara', 1, 68),
(84, 'Barranca de Upía', 1, 50),
(85, 'Barrancabermeja', 1, 68),
(86, 'Barrancas', 1, 44),
(87, 'Barranco de Loba', 1, 13),
(88, 'Barranquilla', 1, 8),
(89, 'Becerríl', 1, 20),
(90, 'Belalcázar', 1, 17),
(91, 'Bello', 1, 5),
(92, 'Belmira', 1, 5),
(93, 'Beltrán', 1, 25),
(94, 'Belén', 1, 15),
(95, 'Belén', 1, 52),
(96, 'Belén de Bajirá', 1, 27),
(97, 'Belén de Umbría', 1, 66),
(98, 'Belén de los Andaquíes', 1, 18),
(99, 'Berbeo', 1, 15),
(100, 'Betania', 1, 5),
(101, 'Beteitiva', 1, 15),
(102, 'Betulia', 1, 5),
(103, 'Betulia', 1, 68),
(104, 'Bituima', 1, 25),
(105, 'Boavita', 1, 15),
(106, 'Bochalema', 1, 54),
(107, 'Bogotá D.C.', 1, 11),
(108, 'Bojacá', 1, 25),
(109, 'Bojayá (Bellavista)', 1, 27),
(110, 'Bolívar', 1, 5),
(111, 'Bolívar', 1, 19),
(112, 'Bolívar', 1, 68),
(113, 'Bolívar', 1, 76),
(114, 'Bosconia', 1, 20),
(115, 'Boyacá', 1, 15),
(116, 'Briceño', 1, 5),
(117, 'Briceño', 1, 15),
(118, 'Bucaramanga', 1, 68),
(119, 'Bucarasica', 1, 54),
(120, 'Buenaventura', 1, 76),
(121, 'Buenavista', 1, 15),
(122, 'Buenavista', 1, 23),
(123, 'Buenavista', 1, 63),
(124, 'Buenavista', 1, 70),
(125, 'Buenos Aires', 1, 19),
(126, 'Buesaco', 1, 52),
(127, 'Buga', 1, 76),
(128, 'Bugalagrande', 1, 76),
(129, 'Burítica', 1, 5),
(130, 'Busbanza', 1, 15),
(131, 'Cabrera', 1, 25),
(132, 'Cabrera', 1, 68),
(133, 'Cabuyaro', 1, 50),
(134, 'Cachipay', 1, 25),
(135, 'Caicedo', 1, 5),
(136, 'Caicedonia', 1, 76),
(137, 'Caimito', 1, 70),
(138, 'Cajamarca', 1, 73),
(139, 'Cajibío', 1, 19),
(140, 'Cajicá', 1, 25),
(141, 'Calamar', 1, 13),
(142, 'Calamar', 1, 95),
(143, 'Calarcá', 1, 63),
(144, 'Caldas', 1, 5),
(145, 'Caldas', 1, 15),
(146, 'Caldono', 1, 19),
(147, 'California', 1, 68),
(148, 'Calima (Darién)', 1, 76),
(149, 'Caloto', 1, 19),
(150, 'Calí', 1, 76),
(151, 'Campamento', 1, 5),
(152, 'Campo de la Cruz', 1, 8),
(153, 'Campoalegre', 1, 41),
(154, 'Campohermoso', 1, 15),
(155, 'Canalete', 1, 23),
(156, 'Candelaria', 1, 8),
(157, 'Candelaria', 1, 76),
(158, 'Cantagallo', 1, 13),
(159, 'Cantón de San Pablo', 1, 27),
(160, 'Caparrapí', 1, 25),
(161, 'Capitanejo', 1, 68),
(162, 'Caracolí', 1, 5),
(163, 'Caramanta', 1, 5),
(164, 'Carcasí', 1, 68),
(165, 'Carepa', 1, 5),
(166, 'Carmen de Apicalá', 1, 73),
(167, 'Carmen de Carupa', 1, 25),
(168, 'Carmen de Viboral', 1, 5),
(169, 'Carmen del Darién (CURBARADÓ)', 1, 27),
(170, 'Carolina', 1, 5),
(171, 'Cartagena', 1, 13),
(172, 'Cartagena del Chairá', 1, 18),
(173, 'Cartago', 1, 76),
(174, 'Carurú', 1, 97),
(175, 'Casabianca', 1, 73),
(176, 'Castilla la Nueva', 1, 50),
(177, 'Caucasia', 1, 5),
(178, 'Cañasgordas', 1, 5),
(179, 'Cepita', 1, 68),
(180, 'Cereté', 1, 23),
(181, 'Cerinza', 1, 15),
(182, 'Cerrito', 1, 68),
(183, 'Cerro San Antonio', 1, 47),
(184, 'Chachaguí', 1, 52),
(185, 'Chaguaní', 1, 25),
(186, 'Chalán', 1, 70),
(187, 'Chaparral', 1, 73),
(188, 'Charalá', 1, 68),
(189, 'Charta', 1, 68),
(190, 'Chigorodó', 1, 5),
(191, 'Chima', 1, 68),
(192, 'Chimichagua', 1, 20),
(193, 'Chimá', 1, 23),
(194, 'Chinavita', 1, 15),
(195, 'Chinchiná', 1, 17),
(196, 'Chinácota', 1, 54),
(197, 'Chinú', 1, 23),
(198, 'Chipaque', 1, 25),
(199, 'Chipatá', 1, 68),
(200, 'Chiquinquirá', 1, 15),
(201, 'Chiriguaná', 1, 20),
(202, 'Chiscas', 1, 15),
(203, 'Chita', 1, 15),
(204, 'Chitagá', 1, 54),
(205, 'Chitaraque', 1, 15),
(206, 'Chivatá', 1, 15),
(207, 'Chivolo', 1, 47),
(208, 'Choachí', 1, 25),
(209, 'Chocontá', 1, 25),
(210, 'Chámeza', 1, 85),
(211, 'Chía', 1, 25),
(212, 'Chíquiza', 1, 15),
(213, 'Chívor', 1, 15),
(214, 'Cicuco', 1, 13),
(215, 'Cimitarra', 1, 68),
(216, 'Circasia', 1, 63),
(217, 'Cisneros', 1, 5),
(218, 'Ciénaga', 1, 15),
(219, 'Ciénaga', 1, 47),
(220, 'Ciénaga de Oro', 1, 23),
(221, 'Clemencia', 1, 13),
(222, 'Cocorná', 1, 5),
(223, 'Coello', 1, 73),
(224, 'Cogua', 1, 25),
(225, 'Colombia', 1, 41),
(226, 'Colosó (Ricaurte)', 1, 70),
(227, 'Colón', 1, 86),
(228, 'Colón (Génova)', 1, 52),
(229, 'Concepción', 1, 5),
(230, 'Concepción', 1, 68),
(231, 'Concordia', 1, 5),
(232, 'Concordia', 1, 47),
(233, 'Condoto', 1, 27),
(234, 'Confines', 1, 68),
(235, 'Consaca', 1, 52),
(236, 'Contadero', 1, 52),
(237, 'Contratación', 1, 68),
(238, 'Convención', 1, 54),
(239, 'Copacabana', 1, 5),
(240, 'Coper', 1, 15),
(241, 'Cordobá', 1, 63),
(242, 'Corinto', 1, 19),
(243, 'Coromoro', 1, 68),
(244, 'Corozal', 1, 70),
(245, 'Corrales', 1, 15),
(246, 'Cota', 1, 25),
(247, 'Cotorra', 1, 23),
(248, 'Covarachía', 1, 15),
(249, 'Coveñas', 1, 70),
(250, 'Coyaima', 1, 73),
(251, 'Cravo Norte', 1, 81),
(252, 'Cuaspud (Carlosama)', 1, 52),
(253, 'Cubarral', 1, 50),
(254, 'Cubará', 1, 15),
(255, 'Cucaita', 1, 15),
(256, 'Cucunubá', 1, 25),
(257, 'Cucutilla', 1, 54),
(258, 'Cuitiva', 1, 15),
(259, 'Cumaral', 1, 50),
(260, 'Cumaribo', 1, 99),
(261, 'Cumbal', 1, 52),
(262, 'Cumbitara', 1, 52),
(263, 'Cunday', 1, 73),
(264, 'Curillo', 1, 18),
(265, 'Curití', 1, 68),
(266, 'Curumaní', 1, 20),
(267, 'Cáceres', 1, 5),
(268, 'Cáchira', 1, 54),
(269, 'Cácota', 1, 54),
(270, 'Cáqueza', 1, 25),
(271, 'Cértegui', 1, 27),
(272, 'Cómbita', 1, 15),
(273, 'Córdoba', 1, 13),
(274, 'Córdoba', 1, 52),
(275, 'Cúcuta', 1, 54),
(276, 'Dabeiba', 1, 5),
(277, 'Dagua', 1, 76),
(278, 'Dibulla', 1, 44),
(279, 'Distracción', 1, 44),
(280, 'Dolores', 1, 73),
(281, 'Don Matías', 1, 5),
(282, 'Dos Quebradas', 1, 66),
(283, 'Duitama', 1, 15),
(284, 'Durania', 1, 54),
(285, 'Ebéjico', 1, 5),
(286, 'El Bagre', 1, 5),
(287, 'El Banco', 1, 47),
(288, 'El Cairo', 1, 76),
(289, 'El Calvario', 1, 50),
(290, 'El Carmen', 1, 54),
(291, 'El Carmen', 1, 68),
(292, 'El Carmen de Atrato', 1, 27),
(293, 'El Carmen de Bolívar', 1, 13),
(294, 'El Castillo', 1, 50),
(295, 'El Cerrito', 1, 76),
(296, 'El Charco', 1, 52),
(297, 'El Cocuy', 1, 15),
(298, 'El Colegio', 1, 25),
(299, 'El Copey', 1, 20),
(300, 'El Doncello', 1, 18),
(301, 'El Dorado', 1, 50),
(302, 'El Dovio', 1, 76),
(303, 'El Espino', 1, 15),
(304, 'El Guacamayo', 1, 68),
(305, 'El Guamo', 1, 13),
(306, 'El Molino', 1, 44),
(307, 'El Paso', 1, 20),
(308, 'El Paujil', 1, 18),
(309, 'El Peñol', 1, 52),
(310, 'El Peñon', 1, 13),
(311, 'El Peñon', 1, 68),
(312, 'El Peñón', 1, 25),
(313, 'El Piñon', 1, 47),
(314, 'El Playón', 1, 68),
(315, 'El Retorno', 1, 95),
(316, 'El Retén', 1, 47),
(317, 'El Roble', 1, 70),
(318, 'El Rosal', 1, 25),
(319, 'El Rosario', 1, 52),
(320, 'El Tablón de Gómez', 1, 52),
(321, 'El Tambo', 1, 19),
(322, 'El Tambo', 1, 52),
(323, 'El Tarra', 1, 54),
(324, 'El Zulia', 1, 54),
(325, 'El Águila', 1, 76),
(326, 'Elías', 1, 41),
(327, 'Encino', 1, 68),
(328, 'Enciso', 1, 68),
(329, 'Entrerríos', 1, 5),
(330, 'Envigado', 1, 5),
(331, 'Espinal', 1, 73),
(332, 'Facatativá', 1, 25),
(333, 'Falan', 1, 73),
(334, 'Filadelfia', 1, 17),
(335, 'Filandia', 1, 63),
(336, 'Firavitoba', 1, 15),
(337, 'Flandes', 1, 73),
(338, 'Florencia', 1, 18),
(339, 'Florencia', 1, 19),
(340, 'Floresta', 1, 15),
(341, 'Florida', 1, 76),
(342, 'Floridablanca', 1, 68),
(343, 'Florián', 1, 68),
(344, 'Fonseca', 1, 44),
(345, 'Fortúl', 1, 81),
(346, 'Fosca', 1, 25),
(347, 'Francisco Pizarro', 1, 52),
(348, 'Fredonia', 1, 5),
(349, 'Fresno', 1, 73),
(350, 'Frontino', 1, 5),
(351, 'Fuente de Oro', 1, 50),
(352, 'Fundación', 1, 47),
(353, 'Funes', 1, 52),
(354, 'Funza', 1, 25),
(355, 'Fusagasugá', 1, 25),
(356, 'Fómeque', 1, 25),
(357, 'Fúquene', 1, 25),
(358, 'Gachalá', 1, 25),
(359, 'Gachancipá', 1, 25),
(360, 'Gachantivá', 1, 15),
(361, 'Gachetá', 1, 25),
(362, 'Galapa', 1, 8),
(363, 'Galeras (Nueva Granada)', 1, 70),
(364, 'Galán', 1, 68),
(365, 'Gama', 1, 25),
(366, 'Gamarra', 1, 20),
(367, 'Garagoa', 1, 15),
(368, 'Garzón', 1, 41),
(369, 'Gigante', 1, 41),
(370, 'Ginebra', 1, 76),
(371, 'Giraldo', 1, 5),
(372, 'Girardot', 1, 25),
(373, 'Girardota', 1, 5),
(374, 'Girón', 1, 68),
(375, 'Gonzalez', 1, 20),
(376, 'Gramalote', 1, 54),
(377, 'Granada', 1, 5),
(378, 'Granada', 1, 25),
(379, 'Granada', 1, 50),
(380, 'Guaca', 1, 68),
(381, 'Guacamayas', 1, 15),
(382, 'Guacarí', 1, 76),
(383, 'Guachavés', 1, 52),
(384, 'Guachené', 1, 19),
(385, 'Guachetá', 1, 25),
(386, 'Guachucal', 1, 52),
(387, 'Guadalupe', 1, 5),
(388, 'Guadalupe', 1, 41),
(389, 'Guadalupe', 1, 68),
(390, 'Guaduas', 1, 25),
(391, 'Guaitarilla', 1, 52),
(392, 'Gualmatán', 1, 52),
(393, 'Guamal', 1, 47),
(394, 'Guamal', 1, 50),
(395, 'Guamo', 1, 73),
(396, 'Guapota', 1, 68),
(397, 'Guapí', 1, 19),
(398, 'Guaranda', 1, 70),
(399, 'Guarne', 1, 5),
(400, 'Guasca', 1, 25),
(401, 'Guatapé', 1, 5),
(402, 'Guataquí', 1, 25),
(403, 'Guatavita', 1, 25),
(404, 'Guateque', 1, 15),
(405, 'Guavatá', 1, 68),
(406, 'Guayabal de Siquima', 1, 25),
(407, 'Guayabetal', 1, 25),
(408, 'Guayatá', 1, 15),
(409, 'Guepsa', 1, 68),
(410, 'Guicán', 1, 15),
(411, 'Gutiérrez', 1, 25),
(412, 'Guática', 1, 66),
(413, 'Gámbita', 1, 68),
(414, 'Gámeza', 1, 15),
(415, 'Génova', 1, 63),
(416, 'Gómez Plata', 1, 5),
(417, 'Hacarí', 1, 54),
(418, 'Hatillo de Loba', 1, 13),
(419, 'Hato', 1, 68),
(420, 'Hato Corozal', 1, 85),
(421, 'Hatonuevo', 1, 44),
(422, 'Heliconia', 1, 5),
(423, 'Herrán', 1, 54),
(424, 'Herveo', 1, 73),
(425, 'Hispania', 1, 5),
(426, 'Hobo', 1, 41),
(427, 'Honda', 1, 73),
(428, 'Ibagué', 1, 73),
(429, 'Icononzo', 1, 73),
(430, 'Iles', 1, 52),
(431, 'Imúes', 1, 52),
(432, 'Inzá', 1, 19),
(433, 'Inírida', 1, 94),
(434, 'Ipiales', 1, 52),
(435, 'Isnos', 1, 41),
(436, 'Istmina', 1, 27),
(437, 'Itagüí', 1, 5),
(438, 'Ituango', 1, 5),
(439, 'Izá', 1, 15),
(440, 'Jambaló', 1, 19),
(441, 'Jamundí', 1, 76),
(442, 'Jardín', 1, 5),
(443, 'Jenesano', 1, 15),
(444, 'Jericó', 1, 5),
(445, 'Jericó', 1, 15),
(446, 'Jerusalén', 1, 25),
(447, 'Jesús María', 1, 68),
(448, 'Jordán', 1, 68),
(449, 'Juan de Acosta', 1, 8),
(450, 'Junín', 1, 25),
(451, 'Juradó', 1, 27),
(452, 'La Apartada y La Frontera', 1, 23),
(453, 'La Argentina', 1, 41),
(454, 'La Belleza', 1, 68),
(455, 'La Calera', 1, 25),
(456, 'La Capilla', 1, 15),
(457, 'La Ceja', 1, 5),
(458, 'La Celia', 1, 66),
(459, 'La Cruz', 1, 52),
(460, 'La Cumbre', 1, 76),
(461, 'La Dorada', 1, 17),
(462, 'La Esperanza', 1, 54),
(463, 'La Estrella', 1, 5),
(464, 'La Florida', 1, 52),
(465, 'La Gloria', 1, 20),
(466, 'La Jagua de Ibirico', 1, 20),
(467, 'La Jagua del Pilar', 1, 44),
(468, 'La Llanada', 1, 52),
(469, 'La Macarena', 1, 50),
(470, 'La Merced', 1, 17),
(471, 'La Mesa', 1, 25),
(472, 'La Montañita', 1, 18),
(473, 'La Palma', 1, 25),
(474, 'La Paz', 1, 68),
(475, 'La Paz (Robles)', 1, 20),
(476, 'La Peña', 1, 25),
(477, 'La Pintada', 1, 5),
(478, 'La Plata', 1, 41),
(479, 'La Playa', 1, 54),
(480, 'La Primavera', 1, 99),
(481, 'La Salina', 1, 85),
(482, 'La Sierra', 1, 19),
(483, 'La Tebaida', 1, 63),
(484, 'La Tola', 1, 52),
(485, 'La Unión', 1, 5),
(486, 'La Unión', 1, 52),
(487, 'La Unión', 1, 70),
(488, 'La Unión', 1, 76),
(489, 'La Uvita', 1, 15),
(490, 'La Vega', 1, 19),
(491, 'La Vega', 1, 25),
(492, 'La Victoria', 1, 15),
(493, 'La Victoria', 1, 17),
(494, 'La Victoria', 1, 76),
(495, 'La Virginia', 1, 66),
(496, 'Labateca', 1, 54),
(497, 'Labranzagrande', 1, 15),
(498, 'Landázuri', 1, 68),
(499, 'Lebrija', 1, 68),
(500, 'Leiva', 1, 52),
(501, 'Lejanías', 1, 50),
(502, 'Lenguazaque', 1, 25),
(503, 'Leticia', 1, 91),
(504, 'Liborina', 1, 5),
(505, 'Linares', 1, 52),
(506, 'Lloró', 1, 27),
(507, 'Lorica', 1, 23),
(508, 'Los Córdobas', 1, 23),
(509, 'Los Palmitos', 1, 70),
(510, 'Los Patios', 1, 54),
(511, 'Los Santos', 1, 68),
(512, 'Lourdes', 1, 54),
(513, 'Luruaco', 1, 8),
(514, 'Lérida', 1, 73),
(515, 'Líbano', 1, 73),
(516, 'López (Micay)', 1, 19),
(517, 'Macanal', 1, 15),
(518, 'Macaravita', 1, 68),
(519, 'Maceo', 1, 5),
(520, 'Machetá', 1, 25),
(521, 'Madrid', 1, 25),
(522, 'Magangué', 1, 13),
(523, 'Magüi (Payán)', 1, 52),
(524, 'Mahates', 1, 13),
(525, 'Maicao', 1, 44),
(526, 'Majagual', 1, 70),
(527, 'Malambo', 1, 8),
(528, 'Mallama (Piedrancha)', 1, 52),
(529, 'Manatí', 1, 8),
(530, 'Manaure', 1, 44),
(531, 'Manaure Balcón del Cesar', 1, 20),
(532, 'Manizales', 1, 17),
(533, 'Manta', 1, 25),
(534, 'Manzanares', 1, 17),
(535, 'Maní', 1, 85),
(536, 'Mapiripan', 1, 50),
(537, 'Margarita', 1, 13),
(538, 'Marinilla', 1, 5),
(539, 'Maripí', 1, 15),
(540, 'Mariquita', 1, 73),
(541, 'Marmato', 1, 17),
(542, 'Marquetalia', 1, 17),
(543, 'Marsella', 1, 66),
(544, 'Marulanda', 1, 17),
(545, 'María la Baja', 1, 13),
(546, 'Matanza', 1, 68),
(547, 'Medellín', 1, 5),
(548, 'Medina', 1, 25),
(549, 'Medio Atrato', 1, 27),
(550, 'Medio Baudó', 1, 27),
(551, 'Medio San Juan (ANDAGOYA)', 1, 27),
(552, 'Melgar', 1, 73),
(553, 'Mercaderes', 1, 19),
(554, 'Mesetas', 1, 50),
(555, 'Milán', 1, 18),
(556, 'Miraflores', 1, 15),
(557, 'Miraflores', 1, 95),
(558, 'Miranda', 1, 19),
(559, 'Mistrató', 1, 66),
(560, 'Mitú', 1, 97),
(561, 'Mocoa', 1, 86),
(562, 'Mogotes', 1, 68),
(563, 'Molagavita', 1, 68),
(564, 'Momil', 1, 23),
(565, 'Mompós', 1, 13),
(566, 'Mongua', 1, 15),
(567, 'Monguí', 1, 15),
(568, 'Moniquirá', 1, 15),
(569, 'Montebello', 1, 5),
(570, 'Montecristo', 1, 13),
(571, 'Montelíbano', 1, 23),
(572, 'Montenegro', 1, 63),
(573, 'Monteria', 1, 23),
(574, 'Monterrey', 1, 85),
(575, 'Morales', 1, 13),
(576, 'Morales', 1, 19),
(577, 'Morelia', 1, 18),
(578, 'Morroa', 1, 70),
(579, 'Mosquera', 1, 25),
(580, 'Mosquera', 1, 52),
(581, 'Motavita', 1, 15),
(582, 'Moñitos', 1, 23),
(583, 'Murillo', 1, 73),
(584, 'Murindó', 1, 5),
(585, 'Mutatá', 1, 5),
(586, 'Mutiscua', 1, 54),
(587, 'Muzo', 1, 15),
(588, 'Málaga', 1, 68),
(589, 'Nariño', 1, 5),
(590, 'Nariño', 1, 25),
(591, 'Nariño', 1, 52),
(592, 'Natagaima', 1, 73),
(593, 'Nechí', 1, 5),
(594, 'Necoclí', 1, 5),
(595, 'Neira', 1, 17),
(596, 'Neiva', 1, 41),
(597, 'Nemocón', 1, 25),
(598, 'Nilo', 1, 25),
(599, 'Nimaima', 1, 25),
(600, 'Nobsa', 1, 15),
(601, 'Nocaima', 1, 25),
(602, 'Norcasia', 1, 17),
(603, 'Norosí', 1, 13),
(604, 'Novita', 1, 27),
(605, 'Nueva Granada', 1, 47),
(606, 'Nuevo Colón', 1, 15),
(607, 'Nunchía', 1, 85),
(608, 'Nuquí', 1, 27),
(609, 'Nátaga', 1, 41),
(610, 'Obando', 1, 76),
(611, 'Ocamonte', 1, 68),
(612, 'Ocaña', 1, 54),
(613, 'Oiba', 1, 68),
(614, 'Oicatá', 1, 15),
(615, 'Olaya', 1, 5),
(616, 'Olaya Herrera', 1, 52),
(617, 'Onzaga', 1, 68),
(618, 'Oporapa', 1, 41),
(619, 'Orito', 1, 86),
(620, 'Orocué', 1, 85),
(621, 'Ortega', 1, 73),
(622, 'Ospina', 1, 52),
(623, 'Otanche', 1, 15),
(624, 'Ovejas', 1, 70),
(625, 'Pachavita', 1, 15),
(626, 'Pacho', 1, 25),
(627, 'Padilla', 1, 19),
(628, 'Paicol', 1, 41),
(629, 'Pailitas', 1, 20),
(630, 'Paime', 1, 25),
(631, 'Paipa', 1, 15),
(632, 'Pajarito', 1, 15),
(633, 'Palermo', 1, 41),
(634, 'Palestina', 1, 17),
(635, 'Palestina', 1, 41),
(636, 'Palmar', 1, 68),
(637, 'Palmar de Varela', 1, 8),
(638, 'Palmas del Socorro', 1, 68),
(639, 'Palmira', 1, 76),
(640, 'Palmito', 1, 70),
(641, 'Palocabildo', 1, 73),
(642, 'Pamplona', 1, 54),
(643, 'Pamplonita', 1, 54),
(644, 'Pandi', 1, 25),
(645, 'Panqueba', 1, 15),
(646, 'Paratebueno', 1, 25),
(647, 'Pasca', 1, 25),
(648, 'Patía (El Bordo)', 1, 19),
(649, 'Pauna', 1, 15),
(650, 'Paya', 1, 15),
(651, 'Paz de Ariporo', 1, 85),
(652, 'Paz de Río', 1, 15),
(653, 'Pedraza', 1, 47),
(654, 'Pelaya', 1, 20),
(655, 'Pensilvania', 1, 17),
(656, 'Peque', 1, 5),
(657, 'Pereira', 1, 66),
(658, 'Pesca', 1, 15),
(659, 'Peñol', 1, 5),
(660, 'Piamonte', 1, 19),
(661, 'Pie de Cuesta', 1, 68),
(662, 'Piedras', 1, 73),
(663, 'Piendamó', 1, 19),
(664, 'Pijao', 1, 63),
(665, 'Pijiño', 1, 47),
(666, 'Pinchote', 1, 68),
(667, 'Pinillos', 1, 13),
(668, 'Piojo', 1, 8),
(669, 'Pisva', 1, 15),
(670, 'Pital', 1, 41),
(671, 'Pitalito', 1, 41),
(672, 'Pivijay', 1, 47),
(673, 'Planadas', 1, 73),
(674, 'Planeta Rica', 1, 23),
(675, 'Plato', 1, 47),
(676, 'Policarpa', 1, 52),
(677, 'Polonuevo', 1, 8),
(678, 'Ponedera', 1, 8),
(679, 'Popayán', 1, 19),
(680, 'Pore', 1, 85),
(681, 'Potosí', 1, 52),
(682, 'Pradera', 1, 76),
(683, 'Prado', 1, 73),
(684, 'Providencia', 1, 52),
(685, 'Providencia', 1, 88),
(686, 'Pueblo Bello', 1, 20),
(687, 'Pueblo Nuevo', 1, 23),
(688, 'Pueblo Rico', 1, 66),
(689, 'Pueblorrico', 1, 5),
(690, 'Puebloviejo', 1, 47),
(691, 'Puente Nacional', 1, 68),
(692, 'Puerres', 1, 52),
(693, 'Puerto Asís', 1, 86),
(694, 'Puerto Berrío', 1, 5),
(695, 'Puerto Boyacá', 1, 15),
(696, 'Puerto Caicedo', 1, 86),
(697, 'Puerto Carreño', 1, 99),
(698, 'Puerto Colombia', 1, 8),
(699, 'Puerto Concordia', 1, 50),
(700, 'Puerto Escondido', 1, 23),
(701, 'Puerto Gaitán', 1, 50),
(702, 'Puerto Guzmán', 1, 86),
(703, 'Puerto Leguízamo', 1, 86),
(704, 'Puerto Libertador', 1, 23),
(705, 'Puerto Lleras', 1, 50),
(706, 'Puerto López', 1, 50),
(707, 'Puerto Nare', 1, 5),
(708, 'Puerto Nariño', 1, 91),
(709, 'Puerto Parra', 1, 68),
(710, 'Puerto Rico', 1, 18),
(711, 'Puerto Rico', 1, 50),
(712, 'Puerto Rondón', 1, 81),
(713, 'Puerto Salgar', 1, 25),
(714, 'Puerto Santander', 1, 54),
(715, 'Puerto Tejada', 1, 19),
(716, 'Puerto Triunfo', 1, 5),
(717, 'Puerto Wilches', 1, 68),
(718, 'Pulí', 1, 25),
(719, 'Pupiales', 1, 52),
(720, 'Puracé (Coconuco)', 1, 19),
(721, 'Purificación', 1, 73),
(722, 'Purísima', 1, 23),
(723, 'Pácora', 1, 17),
(724, 'Páez', 1, 15),
(725, 'Páez (Belalcazar)', 1, 19),
(726, 'Páramo', 1, 68),
(727, 'Quebradanegra', 1, 25),
(728, 'Quetame', 1, 25),
(729, 'Quibdó', 1, 27),
(730, 'Quimbaya', 1, 63),
(731, 'Quinchía', 1, 66),
(732, 'Quipama', 1, 15),
(733, 'Quipile', 1, 25),
(734, 'Ragonvalia', 1, 54),
(735, 'Ramiriquí', 1, 15),
(736, 'Recetor', 1, 85),
(737, 'Regidor', 1, 13),
(738, 'Remedios', 1, 5),
(739, 'Remolino', 1, 47),
(740, 'Repelón', 1, 8),
(741, 'Restrepo', 1, 50),
(742, 'Restrepo', 1, 76),
(743, 'Retiro', 1, 5),
(744, 'Ricaurte', 1, 25),
(745, 'Ricaurte', 1, 52),
(746, 'Rio Negro', 1, 68),
(747, 'Rioblanco', 1, 73),
(748, 'Riofrío', 1, 76),
(749, 'Riohacha', 1, 44),
(750, 'Risaralda', 1, 17),
(751, 'Rivera', 1, 41),
(752, 'Roberto Payán (San José)', 1, 52),
(753, 'Roldanillo', 1, 76),
(754, 'Roncesvalles', 1, 73),
(755, 'Rondón', 1, 15),
(756, 'Rosas', 1, 19),
(757, 'Rovira', 1, 73),
(758, 'Ráquira', 1, 15),
(759, 'Río Iró', 1, 27),
(760, 'Río Quito', 1, 27),
(761, 'Río Sucio', 1, 17),
(762, 'Río Viejo', 1, 13),
(763, 'Río de oro', 1, 20),
(764, 'Ríonegro', 1, 5),
(765, 'Ríosucio', 1, 27),
(766, 'Sabana de Torres', 1, 68),
(767, 'Sabanagrande', 1, 8),
(768, 'Sabanalarga', 1, 5),
(769, 'Sabanalarga', 1, 8),
(770, 'Sabanalarga', 1, 85),
(771, 'Sabanas de San Angel (SAN ANGEL)', 1, 47),
(772, 'Sabaneta', 1, 5),
(773, 'Saboyá', 1, 15),
(774, 'Sahagún', 1, 23),
(775, 'Saladoblanco', 1, 41),
(776, 'Salamina', 1, 17),
(777, 'Salamina', 1, 47),
(778, 'Salazar', 1, 54),
(779, 'Saldaña', 1, 73),
(780, 'Salento', 1, 63),
(781, 'Salgar', 1, 5),
(782, 'Samacá', 1, 15),
(783, 'Samaniego', 1, 52),
(784, 'Samaná', 1, 17),
(785, 'Sampués', 1, 70),
(786, 'San Agustín', 1, 41),
(787, 'San Alberto', 1, 20),
(788, 'San Andrés', 1, 68),
(789, 'San Andrés Sotavento', 1, 23),
(790, 'San Andrés de Cuerquía', 1, 5),
(791, 'San Antero', 1, 23),
(792, 'San Antonio', 1, 73),
(793, 'San Antonio de Tequendama', 1, 25),
(794, 'San Benito', 1, 68),
(795, 'San Benito Abad', 1, 70),
(796, 'San Bernardo', 1, 25),
(797, 'San Bernardo', 1, 52),
(798, 'San Bernardo del Viento', 1, 23),
(799, 'San Calixto', 1, 54),
(800, 'San Carlos', 1, 5),
(801, 'San Carlos', 1, 23),
(802, 'San Carlos de Guaroa', 1, 50),
(803, 'San Cayetano', 1, 25),
(804, 'San Cayetano', 1, 54),
(805, 'San Cristobal', 1, 13),
(806, 'San Diego', 1, 20),
(807, 'San Eduardo', 1, 15),
(808, 'San Estanislao', 1, 13),
(809, 'San Fernando', 1, 13),
(810, 'San Francisco', 1, 5),
(811, 'San Francisco', 1, 25),
(812, 'San Francisco', 1, 86),
(813, 'San Gíl', 1, 68),
(814, 'San Jacinto', 1, 13),
(815, 'San Jacinto del Cauca', 1, 13),
(816, 'San Jerónimo', 1, 5),
(817, 'San Joaquín', 1, 68),
(818, 'San José', 1, 17),
(819, 'San José de Miranda', 1, 68),
(820, 'San José de Montaña', 1, 5),
(821, 'San José de Pare', 1, 15),
(822, 'San José de Uré', 1, 23),
(823, 'San José del Fragua', 1, 18),
(824, 'San José del Guaviare', 1, 95),
(825, 'San José del Palmar', 1, 27),
(826, 'San Juan de Arama', 1, 50),
(827, 'San Juan de Betulia', 1, 70),
(828, 'San Juan de Nepomuceno', 1, 13),
(829, 'San Juan de Pasto', 1, 52),
(830, 'San Juan de Río Seco', 1, 25),
(831, 'San Juan de Urabá', 1, 5),
(832, 'San Juan del Cesar', 1, 44),
(833, 'San Juanito', 1, 50),
(834, 'San Lorenzo', 1, 52),
(835, 'San Luis', 1, 73),
(836, 'San Luís', 1, 5),
(837, 'San Luís de Gaceno', 1, 15),
(838, 'San Luís de Palenque', 1, 85),
(839, 'San Marcos', 1, 70),
(840, 'San Martín', 1, 20),
(841, 'San Martín', 1, 50),
(842, 'San Martín de Loba', 1, 13),
(843, 'San Mateo', 1, 15),
(844, 'San Miguel', 1, 68),
(845, 'San Miguel', 1, 86),
(846, 'San Miguel de Sema', 1, 15),
(847, 'San Onofre', 1, 70),
(848, 'San Pablo', 1, 13),
(849, 'San Pablo', 1, 52),
(850, 'San Pablo de Borbur', 1, 15),
(851, 'San Pedro', 1, 5),
(852, 'San Pedro', 1, 70),
(853, 'San Pedro', 1, 76),
(854, 'San Pedro de Cartago', 1, 52),
(855, 'San Pedro de Urabá', 1, 5),
(856, 'San Pelayo', 1, 23),
(857, 'San Rafael', 1, 5),
(858, 'San Roque', 1, 5),
(859, 'San Sebastián', 1, 19),
(860, 'San Sebastián de Buenavista', 1, 47),
(861, 'San Vicente', 1, 5),
(862, 'San Vicente del Caguán', 1, 18),
(863, 'San Vicente del Chucurí', 1, 68),
(864, 'San Zenón', 1, 47),
(865, 'Sandoná', 1, 52),
(866, 'Santa Ana', 1, 47),
(867, 'Santa Bárbara', 1, 5),
(868, 'Santa Bárbara', 1, 68),
(869, 'Santa Bárbara (Iscuandé)', 1, 52),
(870, 'Santa Bárbara de Pinto', 1, 47),
(871, 'Santa Catalina', 1, 13),
(872, 'Santa Fé de Antioquia', 1, 5),
(873, 'Santa Genoveva de Docorodó', 1, 27),
(874, 'Santa Helena del Opón', 1, 68),
(875, 'Santa Isabel', 1, 73),
(876, 'Santa Lucía', 1, 8),
(877, 'Santa Marta', 1, 47),
(878, 'Santa María', 1, 15),
(879, 'Santa María', 1, 41),
(880, 'Santa Rosa', 1, 13),
(881, 'Santa Rosa', 1, 19),
(882, 'Santa Rosa de Cabal', 1, 66),
(883, 'Santa Rosa de Osos', 1, 5),
(884, 'Santa Rosa de Viterbo', 1, 15),
(885, 'Santa Rosa del Sur', 1, 13),
(886, 'Santa Rosalía', 1, 99),
(887, 'Santa Sofía', 1, 15),
(888, 'Santana', 1, 15),
(889, 'Santander de Quilichao', 1, 19),
(890, 'Santiago', 1, 54),
(891, 'Santiago', 1, 86),
(892, 'Santo Domingo', 1, 5),
(893, 'Santo Tomás', 1, 8),
(894, 'Santuario', 1, 5),
(895, 'Santuario', 1, 66),
(896, 'Sapuyes', 1, 52),
(897, 'Saravena', 1, 81),
(898, 'Sardinata', 1, 54),
(899, 'Sasaima', 1, 25),
(900, 'Sativanorte', 1, 15),
(901, 'Sativasur', 1, 15),
(902, 'Segovia', 1, 5),
(903, 'Sesquilé', 1, 25),
(904, 'Sevilla', 1, 76),
(905, 'Siachoque', 1, 15),
(906, 'Sibaté', 1, 25),
(907, 'Sibundoy', 1, 86),
(908, 'Silos', 1, 54),
(909, 'Silvania', 1, 25),
(910, 'Silvia', 1, 19),
(911, 'Simacota', 1, 68),
(912, 'Simijaca', 1, 25),
(913, 'Simití', 1, 13),
(914, 'Sincelejo', 1, 70),
(915, 'Sincé', 1, 70),
(916, 'Sipí', 1, 27),
(917, 'Sitionuevo', 1, 47),
(918, 'Soacha', 1, 25),
(919, 'Soatá', 1, 15),
(920, 'Socha', 1, 15),
(921, 'Socorro', 1, 68),
(922, 'Socotá', 1, 15),
(923, 'Sogamoso', 1, 15),
(924, 'Solano', 1, 18),
(925, 'Soledad', 1, 8),
(926, 'Solita', 1, 18),
(927, 'Somondoco', 1, 15),
(928, 'Sonsón', 1, 5),
(929, 'Sopetrán', 1, 5),
(930, 'Soplaviento', 1, 13),
(931, 'Sopó', 1, 25),
(932, 'Sora', 1, 15),
(933, 'Soracá', 1, 15),
(934, 'Sotaquirá', 1, 15),
(935, 'Sotara (Paispamba)', 1, 19),
(936, 'Sotomayor (Los Andes)', 1, 52),
(937, 'Suaita', 1, 68),
(938, 'Suan', 1, 8),
(939, 'Suaza', 1, 41),
(940, 'Subachoque', 1, 25),
(941, 'Sucre', 1, 19),
(942, 'Sucre', 1, 68),
(943, 'Sucre', 1, 70),
(944, 'Suesca', 1, 25),
(945, 'Supatá', 1, 25),
(946, 'Supía', 1, 17),
(947, 'Suratá', 1, 68),
(948, 'Susa', 1, 25),
(949, 'Susacón', 1, 15),
(950, 'Sutamarchán', 1, 15),
(951, 'Sutatausa', 1, 25),
(952, 'Sutatenza', 1, 15),
(953, 'Suárez', 1, 19),
(954, 'Suárez', 1, 73),
(955, 'Sácama', 1, 85),
(956, 'Sáchica', 1, 15),
(957, 'Tabio', 1, 25),
(958, 'Tadó', 1, 27),
(959, 'Talaigua Nuevo', 1, 13),
(960, 'Tamalameque', 1, 20),
(961, 'Tame', 1, 81),
(962, 'Taminango', 1, 52),
(963, 'Tangua', 1, 52),
(964, 'Taraira', 1, 97),
(965, 'Tarazá', 1, 5),
(966, 'Tarqui', 1, 41),
(967, 'Tarso', 1, 5),
(968, 'Tasco', 1, 15),
(969, 'Tauramena', 1, 85),
(970, 'Tausa', 1, 25),
(971, 'Tello', 1, 41),
(972, 'Tena', 1, 25),
(973, 'Tenerife', 1, 47),
(974, 'Tenjo', 1, 25),
(975, 'Tenza', 1, 15),
(976, 'Teorama', 1, 54),
(977, 'Teruel', 1, 41),
(978, 'Tesalia', 1, 41),
(979, 'Tibacuy', 1, 25),
(980, 'Tibaná', 1, 15),
(981, 'Tibasosa', 1, 15),
(982, 'Tibirita', 1, 25),
(983, 'Tibú', 1, 54),
(984, 'Tierralta', 1, 23),
(985, 'Timaná', 1, 41),
(986, 'Timbiquí', 1, 19),
(987, 'Timbío', 1, 19),
(988, 'Tinjacá', 1, 15),
(989, 'Tipacoque', 1, 15),
(990, 'Tiquisio (Puerto Rico)', 1, 13),
(991, 'Titiribí', 1, 5),
(992, 'Toca', 1, 15),
(993, 'Tocaima', 1, 25),
(994, 'Tocancipá', 1, 25),
(995, 'Toguí', 1, 15),
(996, 'Toledo', 1, 5),
(997, 'Toledo', 1, 54),
(998, 'Tolú', 1, 70),
(999, 'Tolú Viejo', 1, 70),
(1000, 'Tona', 1, 68),
(1001, 'Topagá', 1, 15),
(1002, 'Topaipí', 1, 25),
(1003, 'Toribío', 1, 19),
(1004, 'Toro', 1, 76),
(1005, 'Tota', 1, 15),
(1006, 'Totoró', 1, 19),
(1007, 'Trinidad', 1, 85),
(1008, 'Trujillo', 1, 76),
(1009, 'Tubará', 1, 8),
(1010, 'Tuchín', 1, 23),
(1011, 'Tulúa', 1, 76),
(1012, 'Tumaco', 1, 52),
(1013, 'Tunja', 1, 15),
(1014, 'Tunungua', 1, 15),
(1015, 'Turbaco', 1, 13),
(1016, 'Turbaná', 1, 13),
(1017, 'Turbo', 1, 5),
(1018, 'Turmequé', 1, 15),
(1019, 'Tuta', 1, 15),
(1020, 'Tutasá', 1, 15),
(1021, 'Támara', 1, 85),
(1022, 'Támesis', 1, 5),
(1023, 'Túquerres', 1, 52),
(1024, 'Ubalá', 1, 25),
(1025, 'Ubaque', 1, 25),
(1026, 'Ubaté', 1, 25),
(1027, 'Ulloa', 1, 76),
(1028, 'Une', 1, 25),
(1029, 'Unguía', 1, 27),
(1030, 'Unión Panamericana (ÁNIMAS)', 1, 27),
(1031, 'Uramita', 1, 5),
(1032, 'Uribe', 1, 50),
(1033, 'Uribia', 1, 44),
(1034, 'Urrao', 1, 5),
(1035, 'Urumita', 1, 44),
(1036, 'Usiacuri', 1, 8),
(1037, 'Valdivia', 1, 5),
(1038, 'Valencia', 1, 23),
(1039, 'Valle de San José', 1, 68),
(1040, 'Valle de San Juan', 1, 73),
(1041, 'Valle del Guamuez', 1, 86),
(1042, 'Valledupar', 1, 20),
(1043, 'Valparaiso', 1, 5),
(1044, 'Valparaiso', 1, 18),
(1045, 'Vegachí', 1, 5),
(1046, 'Venadillo', 1, 73),
(1047, 'Venecia', 1, 5),
(1048, 'Venecia (Ospina Pérez)', 1, 25),
(1049, 'Ventaquemada', 1, 15),
(1050, 'Vergara', 1, 25),
(1051, 'Versalles', 1, 76),
(1052, 'Vetas', 1, 68),
(1053, 'Viani', 1, 25),
(1054, 'Vigía del Fuerte', 1, 5),
(1055, 'Vijes', 1, 76),
(1056, 'Villa Caro', 1, 54),
(1057, 'Villa Rica', 1, 19),
(1058, 'Villa de Leiva', 1, 15),
(1059, 'Villa del Rosario', 1, 54),
(1060, 'Villagarzón', 1, 86),
(1061, 'Villagómez', 1, 25),
(1062, 'Villahermosa', 1, 73),
(1063, 'Villamaría', 1, 17),
(1064, 'Villanueva', 1, 13),
(1065, 'Villanueva', 1, 44),
(1066, 'Villanueva', 1, 68),
(1067, 'Villanueva', 1, 85),
(1068, 'Villapinzón', 1, 25),
(1069, 'Villarrica', 1, 73),
(1070, 'Villavicencio', 1, 50),
(1071, 'Villavieja', 1, 41),
(1072, 'Villeta', 1, 25),
(1073, 'Viotá', 1, 25),
(1074, 'Viracachá', 1, 15),
(1075, 'Vista Hermosa', 1, 50),
(1076, 'Viterbo', 1, 17),
(1077, 'Vélez', 1, 68),
(1078, 'Yacopí', 1, 25),
(1079, 'Yacuanquer', 1, 52),
(1080, 'Yaguará', 1, 41),
(1081, 'Yalí', 1, 5),
(1082, 'Yarumal', 1, 5),
(1083, 'Yolombó', 1, 5),
(1084, 'Yondó (Casabe)', 1, 5),
(1085, 'Yopal', 1, 85),
(1086, 'Yotoco', 1, 76),
(1087, 'Yumbo', 1, 76),
(1088, 'Zambrano', 1, 13),
(1089, 'Zapatoca', 1, 68),
(1090, 'Zapayán (PUNTA DE PIEDRAS)', 1, 47),
(1091, 'Zaragoza', 1, 5),
(1092, 'Zarzal', 1, 76),
(1093, 'Zetaquirá', 1, 15),
(1094, 'Zipacón', 1, 25),
(1095, 'Zipaquirá', 1, 25),
(1096, 'Zona Bananera (PRADO - SEVILLA)', 1, 47),
(1097, 'Ábrego', 1, 54),
(1098, 'Íquira', 1, 41),
(1099, 'Úmbita', 1, 15),
(1100, 'Útica', 1, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clinical_diagnostics`
--

CREATE TABLE `clinical_diagnostics` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumed`
--

CREATE TABLE `consumed` (
  `id` int(10) UNSIGNED NOT NULL,
  `schedule_id` int(10) UNSIGNED NOT NULL,
  `contract_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `amount` decimal(15,2) NOT NULL,
  `sessions` int(11) NOT NULL,
  `session` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_sources`
--

CREATE TABLE `contact_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contact_sources`
--

INSERT INTO `contact_sources` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'activo', '2018-11-14 04:41:30', '2018-11-14 04:41:30'),
(2, 'Instagram', 'activo', '2018-11-21 01:04:39', '2018-11-21 01:04:39'),
(3, 'Valla', 'activo', '2018-11-21 01:04:47', '2018-11-21 01:04:47'),
(4, 'Referido', 'activo', '2018-11-21 01:05:01', '2018-11-21 01:05:01'),
(5, 'Revista', 'activo', '2018-11-21 01:05:14', '2018-11-21 01:05:14'),
(6, 'Whatsapp', 'activo', '2020-08-14 20:44:32', '2020-08-14 20:44:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contracts`
--

CREATE TABLE `contracts` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('sin confirmar','activo','anulado','liquidado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sin confirmar',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cosmetological_evolution`
--

CREATE TABLE `cosmetological_evolution` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `evolution` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostics`
--

CREATE TABLE `diagnostics` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('relacionado','principal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `diagnostics`
--

INSERT INTO `diagnostics` (`id`, `name`, `type`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Prueba', 'principal', '', 'activo', '2020-09-07 21:10:52', '2020-09-07 21:10:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostic_aids`
--

CREATE TABLE `diagnostic_aids` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `diagnostic_aids`
--

INSERT INTO `diagnostic_aids` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Laboratorio', 'activo', '2019-08-22 14:43:53', '2019-08-22 14:43:53'),
(4, 'Ayudas Diagnosticas', 'activo', '2019-08-29 19:22:07', '2019-08-29 19:22:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `electronic_equipments`
--

CREATE TABLE `electronic_equipments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voltage` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `email_confirmation`
--

CREATE TABLE `email_confirmation` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `firm` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `email_confirmation`
--

INSERT INTO `email_confirmation` (`id`, `text`, `address`, `firm`, `created_at`, `updated_at`) VALUES
(1, '<p><span style=\"color: rgb(128, 128, 128); font-family: roboto, &quot;helvetica neue&quot;, helvetica, arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Su cita de [service_name], ha sido agendada, es muy importante que llegue con 10 Minutos de antelación, de no ser así, se corre el riesgo de que no podamos atenderlo (a), ya que nuestro personal maneja agenda con horas asignadas para las citas.</span>&nbsp;</p><p><span style=\"color: rgb(128, 128, 128); font-family: roboto, &quot;helvetica neue&quot;, helvetica, arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Cabe anotar que existen momentos en que la agenda de los médicos se retrasa por causas inherentes al mismo servicio, si esto ocurre le pedimos nos lo haga saber y entiendas nuestras razones.</span>&nbsp;</p><p><span style=\"color: rgb(128, 128, 128); font-family: roboto, &quot;helvetica neue&quot;, helvetica, arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">En caso de solicitud de cambio o modificación de su cita de Procedimiento Estético; Mad Laser o Lipoval debe llamar con 96 horas de anticipación (4 días hábiles).</span>&nbsp;</p><p><span style=\"color: rgb(128, 128, 128); font-family: roboto, &quot;helvetica neue&quot;, helvetica, arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">En caso de solicitud de cambio o modificación de su cita de valoración inicial, control médico o tratamiento estético, debe llamar con 48 horas de anticipación (2 días hábiles).</span>&nbsp;</p><p><span style=\"color: rgb(128, 128, 128); font-family: roboto, &quot;helvetica neue&quot;, helvetica, arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Agradecemos llamar o contactarnos vía whatsaap al número 3009108531 y reprogramar para asignarle una nueva cita en el menor tiempo posible y sin que se generen gastos administrativos.</span>&nbsp;</p><p><span style=\"color: rgb(128, 128, 128); font-family: roboto, &quot;helvetica neue&quot;, helvetica, arial, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Recuerde que su cita para el día [date] a la hora [start_time] ha sido confirmada con este Email automático, por favor no responder por este medio. Si desea escribirnos o tiene alguna inquietud puede contactarnos a info@smadiaclinic.com o al número 3009108531 y con mucho gusto lo atenderemos.</span></p>', '<p>Barranquilla: Cll 87 # 47- 47, Sede Smadia Clinic.</p><p>Montería: <span style=\"color: rgb(65, 65, 65); font-family: sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Cll 60 9-07</span>, Sede Smadia Clinic</p>', '<p>Cordialmente, Anileth Pineda P. / Coordinadora Call Center</p><p>Desde Celular: <span style=\"color: rgb(65, 65, 65); font-family: sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">3109122813</span> / WhatsApp: <span style=\"color: rgb(65, 65, 65); font-family: sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">310 9122813</span></p><p>Barranquilla - Colombia / Calle 87 No. 47-47</p>', NULL, '2020-08-14 19:59:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `provider_id` int(10) UNSIGNED DEFAULT NULL,
  `date` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_orders_id` int(10) UNSIGNED DEFAULT NULL,
  `form_pay` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `center_costs_id` int(10) UNSIGNED DEFAULT NULL,
  `retention_id` int(10) UNSIGNED DEFAULT NULL,
  `total_expense` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `porcent_iva` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apli_fact` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_pront_pay` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc_total` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_aplica` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_base` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_porcent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_iva` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_iva_porcent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_iva_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_ica` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_ica_porcent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_ica_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_cree` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_cree_porcent` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rte_cree_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses_sheet`
--

CREATE TABLE `expenses_sheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(11, 'Sura', 'arl', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(12, 'Colpatria', 'arl', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(13, 'Porvenir', 'pension', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(14, 'Colfondos', 'pension', 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulation_appointment`
--

CREATE TABLE `formulation_appointment` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genders`
--

CREATE TABLE `genders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `genders`
--

INSERT INTO `genders` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Hombre', 'activo', '2019-02-09 17:53:11', '2019-02-09 17:53:11'),
(2, 'Mujer', 'activo', '2019-02-09 17:53:11', '2019-02-09 17:53:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidents`
--

CREATE TABLE `incidents` (
  `id` int(10) UNSIGNED NOT NULL,
  `monitoring_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `responsable_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incomes`
--

CREATE TABLE `incomes` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `contract_id` int(10) UNSIGNED DEFAULT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  `responsable_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `center_cost_id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `account_2_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(19,2) NOT NULL,
  `amount_one` decimal(19,2) DEFAULT NULL,
  `amount_two` decimal(19,2) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_of_pay` enum('efectivo','tarjeta','consignacion','tarjeta recargable','software','online') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `type` enum('unico','compartido','bolsa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `campaign` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','anulado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `type_of_card` enum('debito','mastercard','visa','american express','dinners club') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_of_card` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_entity` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_bank` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_account` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ref_epayco` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_epayco` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_of_pay_2` enum('efectivo','tarjeta','consignacion','tarjeta recargable','software','online') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_card_2` enum('debito','mastercard','visa','american express','dinners club') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_of_card_2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_entity_2` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_bank_2` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_account_2` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_epayco_2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_epayco_2` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infirmary_evolution`
--

CREATE TABLE `infirmary_evolution` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `evolution` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `array_evolutions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infirmary_notes`
--

CREATE TABLE `infirmary_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `issues`
--

CREATE TABLE `issues` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `issues`
--

INSERT INTO `issues` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LLamada', 'activo', '2018-11-21 01:15:59', '2018-11-21 01:15:59'),
(2, 'Correo', 'activo', '2018-11-21 01:16:21', '2018-11-21 01:16:21'),
(3, 'Mensaje de Watsapp', 'activo', '2018-11-21 01:16:36', '2018-11-21 01:16:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `contract_id` int(10) UNSIGNED DEFAULT NULL,
  `budget_id` int(10) UNSIGNED DEFAULT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `percent` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratories`
--

CREATE TABLE `laboratories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratory_exams`
--

CREATE TABLE `laboratory_exams` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `comments` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lab_results`
--

CREATE TABLE `lab_results` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `array_files` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquid_control`
--

CREATE TABLE `liquid_control` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `parental_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parental_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parental_3` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parental_4` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parental_5` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_adm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_del` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote_products`
--

CREATE TABLE `lote_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `lote` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `measurements`
--

CREATE TABLE `measurements` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `imc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bust` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contour` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waistline` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `umbilical` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abd_lower` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abd_higher` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legs` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `right_thigh` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `left_thigh` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `right_arm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `left_arm` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_evolutions`
--

CREATE TABLE `medical_evolutions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_history`
--

CREATE TABLE `medical_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `id_type` int(10) UNSIGNED DEFAULT NULL,
  `id_relation` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `date` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medication_control`
--

CREATE TABLE `medication_control` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `service` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicines`
--

CREATE TABLE `medicines` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `type`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Usuarios', 'users', 'config', NULL, 'activo', '2019-02-09 17:53:11', '2019-02-09 17:53:11'),
(2, 'Roles', 'roles', 'config', NULL, 'activo', '2019-02-09 17:53:11', '2019-02-09 17:53:11'),
(3, 'Cuentas de banco', 'accounts', 'config', NULL, 'activo', '2019-02-09 17:53:11', '2019-02-09 17:53:11'),
(4, 'Bancos', 'banks', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(5, 'Centros de costo', 'center-costs', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(6, 'Fuentes de contacto', 'contact-sources', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(7, 'Diagnosticos', 'diagnostics', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(8, 'Temas de seguimiento', 'issues', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(9, 'Laboratorios', 'laboratories', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(10, 'Medicamentos biológicos', 'medicines', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(11, 'Proveedores', 'providers', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(12, 'Líneas de servicio', 'services', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(13, 'Centros de compra', 'shopping-centers', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(14, 'Tipos de servicio', 'type-services', 'config', '', 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(15, 'Pacientes', 'patients', 'dashboard', 'icon-icon-03', 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(16, 'Agenda', 'schedules', 'dashboard', 'icon-icon-04', 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(17, 'Ingresos', 'incomes', 'box', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(18, 'Contratos', 'contracts', 'box', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(19, 'Presupuestos', 'budgets', 'box', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(20, 'Seguimientos', 'monitorings', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(21, 'Categorias de productos', 'types', 'config', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(22, 'Productos', 'products', 'inventory', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(23, 'Ordenes de compra', 'purchase-orders', 'inventory', NULL, 'activo', '2019-02-09 17:53:12', '2019-02-09 17:53:12'),
(24, 'Compras', 'purchases', 'inventory', NULL, 'activo', '2019-02-09 17:53:13', '2019-02-09 17:53:13'),
(25, 'Anamnesis', 'anamnesis', '', NULL, 'activo', '2019-02-09 17:53:13', '2019-02-09 17:53:13'),
(26, 'Ventas', 'sales', 'box', NULL, 'activo', '2019-03-08 02:33:37', '2019-03-08 02:33:37'),
(27, 'Bodegas', 'cellars', 'inventory', NULL, 'activo', '2019-03-21 02:32:24', '2019-03-21 02:32:24'),
(28, 'Presupuesto', 'budget', 'config', NULL, 'activo', '2019-04-09 01:28:33', '2019-04-09 01:28:33'),
(29, 'Ordenes de pedido', 'order-purchases', 'inventory', NULL, 'activo', '2019-04-09 01:28:33', '2019-04-09 01:28:33'),
(30, 'Productos por vencer', 'products-expired', 'report', NULL, 'activo', '2019-04-13 00:59:17', '2019-04-13 00:59:17'),
(31, 'Cuentas por cobrar', 'accounts-receivable', 'box', NULL, 'activo', '2019-05-25 07:45:39', '2019-05-25 07:45:39'),
(32, 'Cuentas por pagar', 'debts-to-pay', 'box', NULL, 'activo', '2019-05-25 07:46:13', '2019-05-25 07:46:13'),
(33, 'Egresos', 'expenses', 'box', NULL, 'activo', '2019-05-25 07:47:12', '2019-05-25 07:47:12'),
(34, 'Control de medicamentos', 'medication_control', '', NULL, 'activo', '2019-07-31 20:54:22', '2019-07-31 20:54:22'),
(35, 'Control de liquidos', 'liquid_control', '', NULL, 'activo', '2019-07-31 20:54:22', '2019-07-31 20:54:22'),
(36, 'Ayudas Diagnostica', 'diagnostic_aids', 'config', NULL, 'activo', '2019-08-28 22:13:26', '2019-08-28 22:13:26'),
(37, 'Revisión por Sistema', 'system-review', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(38, 'Exámen físico', 'physical-exams', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(39, 'Tabla de medidas', 'measurements', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(40, 'Diagnostico clínico', 'clinical-diagnostics', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(41, 'Plan de Tratamiento', 'treatment-plan', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(42, 'Plan de Medicina Biologica', 'biological-medicine-plan', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(43, 'Ayudas Diagnosticas', 'laboratory-exams', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(44, 'Evolución médica', 'medical-evolutions', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(45, 'Evolución Cosmetológica', 'cosmetological-evolution', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(46, 'Evolución de Enfermería', 'infirmary-evolution', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(47, 'Formulación', 'formulation-appointment', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(48, 'Hoja de Gastos', 'expenses-sheet', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(49, 'Hoja de Gastos de Cirugía', 'surgery-expenses-sheet', '', NULL, 'activo', '2019-09-24 20:18:35', '2019-09-24 20:18:35'),
(50, 'Notas de Enfermería', 'infirmary-notes', '', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(51, 'Descripción Quirúrgica', 'surgical-description', '', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(52, 'Fotografias', 'patient-photographs', '', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(53, 'Resultados de Laboratorio', 'lab-results', '', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(54, 'Lote de productos', 'lote-products', 'inventory', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(55, 'Reserva de citas', 'reservation-date', '', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(56, 'Relacion de productos', 'relation-products', 'box', NULL, 'activo', '2019-09-24 20:18:36', '2019-09-24 20:18:36'),
(57, 'Requisiciones', 'requisitions', 'inventory', NULL, 'activo', '2019-11-06 19:21:45', '2019-11-06 19:21:45'),
(58, 'Categorías de requisiciones', 'requisitions-category', '', NULL, 'activo', '2019-11-06 19:21:45', '2019-11-06 19:21:45'),
(59, 'Producto de requisiciones', 'requisitions-product-category', '', NULL, 'activo', '2019-11-06 19:21:45', '2019-11-06 19:21:45'),
(60, 'Pago a asistenciales', 'payment-assistance', 'pay', NULL, 'activo', '2019-11-06 19:21:45', '2019-11-06 19:21:45'),
(61, 'Saldo de caja', 'balance-box', 'box', NULL, 'activo', '2020-02-04 21:57:05', '2020-02-04 21:57:05'),
(62, 'Correo Confirmacion de cita', 'email-confirmation', 'config', NULL, 'activo', '2020-02-05 21:35:13', '2020-02-05 21:35:13'),
(63, 'Campañas y Promociones', 'campaign', 'config', NULL, 'activo', '2020-08-26 14:04:27', '2020-08-26 14:04:27'),
(64, 'Tareas', 'tasks', '', NULL, 'activo', '2020-08-28 14:01:43', '2020-08-28 14:01:57'),
(65, 'Equipos', 'electronic-equipment', 'config', NULL, 'activo', '2020-08-28 14:03:09', '2020-08-28 14:03:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_role`
--

CREATE TABLE `menu_role` (
  `visible` tinyint(1) DEFAULT 1,
  `create` tinyint(1) DEFAULT 1,
  `update` tinyint(1) DEFAULT 1,
  `delete` tinyint(1) DEFAULT 1,
  `role_id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `menu_role`
--

INSERT INTO `menu_role` (`visible`, `create`, `update`, `delete`, `role_id`, `menu_id`) VALUES
(1, 1, 1, 1, 1, 1),
(1, 1, 1, 1, 1, 2),
(1, 1, 1, 1, 1, 3),
(1, 1, 1, 1, 1, 4),
(1, 1, 1, 1, 1, 5),
(1, 1, 1, 1, 1, 6),
(1, 1, 1, 1, 1, 7),
(1, 1, 1, 1, 1, 8),
(1, 1, 1, 1, 1, 9),
(1, 1, 1, 1, 1, 10),
(1, 1, 1, 1, 1, 11),
(1, 1, 1, 1, 1, 12),
(1, 1, 1, 1, 1, 13),
(1, 1, 1, 1, 1, 14),
(1, 1, 1, 1, 1, 15),
(1, 1, 1, 1, 1, 16),
(1, 1, 1, 1, 1, 17),
(1, 1, 1, 1, 1, 18),
(1, 1, 1, 1, 1, 19),
(1, 1, 1, 1, 1, 20),
(1, 1, 1, 1, 1, 25),
(1, 1, 1, NULL, 2, 7),
(1, 1, 1, NULL, 2, 8),
(1, 1, 1, NULL, 2, 9),
(1, NULL, 1, NULL, 2, 10),
(1, 1, 1, NULL, 2, 15),
(1, 1, 1, NULL, 2, 16),
(1, 1, 1, NULL, 2, 18),
(1, 1, 1, NULL, 2, 19),
(1, 1, 1, NULL, 2, 20),
(1, 1, 1, 1, 3, 1),
(1, 1, 1, 1, 3, 2),
(1, 1, 1, 1, 3, 3),
(1, 1, 1, 1, 3, 4),
(1, 1, 1, 1, 3, 5),
(1, 1, 1, 1, 3, 6),
(1, 1, 1, 1, 3, 7),
(1, 1, 1, 1, 3, 8),
(1, 1, 1, 1, 3, 9),
(1, 1, 1, 1, 3, 10),
(1, 1, 1, 1, 3, 11),
(1, 1, 1, 1, 3, 12),
(1, 1, 1, 1, 3, 13),
(1, 1, 1, 1, 3, 14),
(1, 1, 1, 1, 3, 15),
(1, 1, 1, 1, 3, 16),
(1, 1, 1, 1, 3, 17),
(1, 1, 1, 1, 3, 18),
(1, 1, 1, 1, 3, 19),
(1, 1, 1, 1, 3, 20),
(1, 1, 1, 1, 4, 8),
(1, 1, 1, 1, 4, 18),
(1, 1, 1, 1, 4, 19),
(1, 1, 1, 1, 4, 20),
(1, 1, 1, 1, 5, 7),
(1, 1, 1, 1, 5, 8),
(1, 1, 1, 1, 5, 9),
(1, 1, 1, 1, 5, 10),
(1, 1, 1, 1, 5, 15),
(1, 1, 1, 1, 5, 16),
(1, 1, 1, 1, 5, 17),
(1, 1, 1, 1, 5, 18),
(1, 1, 1, 1, 5, 19),
(1, 1, 1, 1, 5, 20),
(1, 1, 1, 1, 6, 1),
(1, 1, 1, 1, 6, 2),
(1, 1, 1, 1, 6, 3),
(1, 1, 1, 1, 6, 4),
(1, 1, 1, 1, 6, 5),
(1, 1, 1, 1, 6, 6),
(1, 1, 1, 1, 6, 7),
(1, 1, 1, 1, 6, 8),
(1, 1, 1, 1, 6, 9),
(1, 1, 1, 1, 6, 10),
(1, 1, 1, 1, 6, 14),
(1, 1, 1, 1, 6, 15),
(1, 1, 1, 1, 6, 16),
(1, 1, 1, 1, 6, 18),
(1, 1, 1, 1, 6, 19),
(1, 1, 1, 1, 6, 20),
(1, 1, 1, 1, 3, 21),
(1, 1, 1, 1, 3, 22),
(1, 1, 1, 1, 3, 26),
(1, 1, 1, 1, 1, 26),
(1, 1, 1, 1, 1, 27),
(1, 1, 1, 1, 1, 21),
(1, 1, 1, 1, 1, 22),
(1, 1, 1, 1, 1, 23),
(1, 1, 1, 1, 1, 24),
(1, 1, 1, 1, 1, 28),
(1, 1, 1, 1, 1, 29),
(1, 1, 1, 1, 1, 30),
(1, 1, 1, 1, 1, 31),
(1, 1, 1, 1, 1, 32),
(1, 1, 1, 1, 1, 33),
(1, 1, 1, 1, 1, 34),
(1, 1, 1, 1, 1, 35),
(1, 1, 1, 1, 1, 36),
(1, 1, 1, 1, 1, 37),
(1, 1, 1, 1, 1, 38),
(1, 1, 1, 1, 1, 39),
(1, 1, 1, 1, 1, 40),
(1, 1, 1, 1, 1, 41),
(1, 1, 1, 1, 1, 42),
(1, 1, 1, 1, 1, 43),
(1, 1, 1, 1, 1, 44),
(1, 1, 1, 1, 1, 45),
(1, 1, 1, 1, 1, 46),
(1, 1, 1, 1, 1, 47),
(1, 1, 1, 1, 1, 48),
(1, 1, 1, 1, 1, 49),
(1, 1, 1, 1, 1, 50),
(1, 1, 1, 1, 1, 51),
(1, 1, 1, 1, 1, 52),
(1, 1, 1, 1, 1, 53),
(1, 1, 1, 1, 1, 54),
(1, 1, 1, 1, 1, 55),
(1, 1, 1, 1, 1, 56),
(1, 1, 1, 1, 1, 57),
(1, 1, 1, 1, 1, 58),
(1, 1, 1, 1, 1, 59),
(1, 1, 1, 1, 1, 60),
(1, 1, 1, 1, 1, 61),
(1, 1, 1, 1, 1, 62),
(1, 1, 1, 1, 11, 7),
(1, 1, 1, 1, 11, 15),
(1, 1, 1, 1, 11, 16),
(1, 1, 1, 1, 11, 20),
(1, 1, 1, 1, 11, 25),
(1, 1, 1, 1, 11, 34),
(1, 1, 1, 1, 11, 35),
(1, 1, 1, 1, 11, 39),
(1, 1, 1, 1, 11, 42),
(1, 1, 1, 1, 11, 46),
(1, 1, 1, 1, 11, 48),
(1, 1, 1, 1, 11, 49),
(1, 1, 1, 1, 11, 50),
(1, 1, 1, 1, 11, 51),
(1, 1, 1, 1, 7, 15),
(1, 1, 1, 1, 7, 16),
(1, 1, 1, 1, 7, 25),
(1, 1, 1, 1, 7, 34),
(1, 1, 1, 1, 7, 35),
(1, 1, 1, 1, 7, 36),
(1, 1, 1, 1, 7, 37),
(1, 1, 1, 1, 7, 38),
(1, 1, 1, 1, 7, 39),
(1, 1, 1, 1, 7, 40),
(1, 1, 1, 1, 7, 41),
(1, 1, 1, 1, 7, 42),
(1, 1, 1, 1, 7, 43),
(1, 1, 1, 1, 7, 44),
(1, 1, 1, 1, 7, 51),
(1, 1, 1, 1, 2, 34),
(1, 1, 1, 1, 2, 35),
(1, 1, 1, 1, 2, 36),
(1, 1, 1, 1, 2, 37),
(1, 1, 1, 1, 2, 38),
(1, 1, 1, 1, 2, 39),
(1, 1, 1, 1, 2, 40),
(1, 1, 1, 1, 2, 41),
(1, 1, 1, 1, 2, 42),
(1, 1, 1, 1, 2, 43),
(1, 1, 1, 1, 2, 44),
(1, 1, 1, 1, 2, 47),
(1, 1, 1, 1, 2, 48),
(1, 1, 1, 1, 2, 49),
(1, 1, 1, 1, 2, 50),
(1, 1, 1, 1, 2, 51),
(1, 1, 1, 1, 2, 52),
(1, 1, 1, 1, 2, 53),
(1, 1, 1, 1, 2, 57),
(1, 1, 1, 1, 5, 34),
(1, 1, 1, 1, 5, 35),
(1, 1, 1, 1, 5, 42),
(1, 1, 1, 1, 5, 46),
(1, 1, 1, 1, 5, 50),
(1, 1, 1, 1, 5, 52),
(1, 1, 1, 1, 4, 45),
(1, 1, 1, 1, 4, 48),
(1, 1, 1, 1, 4, 52),
(1, 1, 1, 1, 5, 39),
(1, 1, 1, 1, 5, 48),
(1, 1, 1, 1, 4, 15),
(1, 1, 1, 1, 4, 16),
(1, 1, 1, 1, 1, 63),
(1, 1, 1, 1, 1, 64),
(1, 1, 1, 1, 1, 65);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2018_08_30_114100_create_states_table', 1),
(3, '2018_08_30_114109_create_cities_table', 1),
(4, '2018_09_01_033120_create_genders_table', 1),
(5, '2018_09_01_040311_create_filters_table', 1),
(6, '2018_09_01_043507_create_bloods_table', 1),
(7, '2018_09_02_162014_create_roles_table', 1),
(8, '2018_09_02_163420_create_menus_table', 1),
(9, '2018_09_02_163421_create_menu_role_table', 1),
(10, '2018_09_02_181800_create_users_table', 1),
(11, '2018_09_08_124108_create_services_table', 1),
(12, '2018_09_08_125001_create_types_services_table', 1),
(13, '2018_09_11_030358_create_contact_sources_table', 1),
(14, '2018_09_11_031034_create_centers_costs_table', 1),
(15, '2018_09_11_033528_create_banks_table', 1),
(16, '2018_09_11_034032_create_accounts_table', 1),
(17, '2018_09_11_035951_create_issues_table', 1),
(18, '2018_09_12_014925_create_laboratories_table', 1),
(19, '2018_09_12_015529_create_diagnostics_table', 1),
(20, '2018_09_12_020918_create_medicines_table', 1),
(21, '2018_09_12_021727_create_shopping_centers_table', 1),
(22, '2018_09_12_023801_create_providers_table', 1),
(23, '2018_09_20_002257_create_patiens_table', 1),
(24, '2018_09_20_003742_create_budgets_table', 1),
(25, '2018_09_25_025054_create_contracts_table', 1),
(26, '2018_09_27_024404_create_schedule_table', 1),
(27, '2018_09_30_174749_create_text_table', 1),
(28, '2018_10_09_011915_create_items_table', 1),
(29, '2018_10_09_015356_create_monitorings_table', 1),
(30, '2018_10_10_222204_create_service_user_table', 1),
(31, '2018_10_14_161238_create_incomes_table', 1),
(32, '2018_10_14_202328_create_sessions_table', 1),
(33, '2018_11_06_211716_create_consumed_table', 1),
(34, '2018_11_07_214908_add_session_to_consumed', 1),
(35, '2018_11_11_164507_add_address_to_patients', 1),
(36, '2018_11_22_205443_create_types_table', 1),
(37, '2018_11_22_220749_create_products_table', 1),
(38, '2018_11_23_195737_add_fields_to_inccomes', 1),
(39, '2018_11_27_193725_add_confirm_comment_to_schedules', 1),
(40, '2018_12_01_081543_add_additional_to_budgets', 1),
(41, '2018_12_13_205421_add_fields_to_incomes', 1),
(42, '2018_12_18_192041_create_purchase_orders_table', 1),
(43, '2018_12_18_193500_create_order_products_table', 1),
(44, '2018_12_20_214812_create_purchases_table', 1),
(45, '2018_12_22_062958_create_purchase_products_table', 1),
(46, '2019_01_14_150032_create_anamnesis_table', 1),
(47, '2019_01_14_150125_create_system_review_table', 1),
(48, '2019_01_14_161447_create_physical_exams_table', 1),
(49, '2019_01_14_161452_create_measurements_table', 1),
(50, '2019_01_14_161459_create_clinical_diagnostics_table', 1),
(51, '2019_01_14_161460_create_relation_clinical_diagnostics_table', 1),
(52, '2019_01_14_161506_create_treatment_plan_table', 1),
(53, '2019_01_14_161507_create_relation_treatment_plan_table', 1),
(54, '2019_01_14_161514_create_biological_medicine_plan_table', 1),
(55, '2019_01_14_161522_create_laboratory_exams_table', 1),
(56, '2019_01_14_161523_create_relation_laboratory_exams_table', 1),
(57, '2019_01_14_161529_create_medical_evolutions_table', 1),
(58, '2019_01_14_161535_create_cosmetological_evolution_table', 1),
(59, '2019_01_14_161542_create_infirmary_evolution_table', 1),
(60, '2019_01_14_161627_create_formulation_appointment_table', 1),
(61, '2019_01_14_161628_create_relation_formulation_appointment_table', 1),
(62, '2019_01_14_161634_create_expenses_sheet_table', 1),
(63, '2019_01_14_161635_create_relation_expenses_sheet_table', 1),
(64, '2019_01_14_161639_create_surgery_expenses_sheet_table', 1),
(65, '2019_01_14_161640_create_relation_surgery_expenses_sheet_table', 1),
(66, '2019_01_14_161644_create_infirmary_notes_table', 1),
(67, '2019_01_14_161651_create_surgical_description_table', 1),
(68, '2019_01_14_161657_create_patient_photographs_table', 1),
(69, '2019_01_14_161703_create_lab_results_table', 1),
(70, '2019_02_09_100654_create_audits_table', 1),
(71, '2019_02_16_071602_create_incidents_table', 1),
(72, '2019_02_20_194559_create_tasks_table', 1),
(73, '2019_02_20_195357_create_task_user_table', 1),
(74, '2019_02_21_210202_add_status_to_incomes', 1),
(75, '2019_03_07_200653_create_sales_table', 1),
(76, '2019_03_07_204635_create_sales_products_table', 1),
(77, '2019_03_11_193717_add_title_to_tasks', 1),
(78, '2019_03_11_202307_create_notifications_table', 1),
(79, '2019_03_13_202444_add_fields_to_monitorings', 1),
(80, '2019_03_18_193307_add_fields_to_purchase_orders', 1),
(81, '2019_03_19_202306_add_cost_to_products', 1),
(82, '2019_03_19_212539_create_cellars_table', 1),
(83, '2019_03_19_222620_add_user_id_to_purchases', 1),
(84, '2019_03_19_224110_add_purchase_id_to_purchases', 1),
(85, '2019_03_23_105008_create_payments_table', 1),
(86, '2019_03_25_122424_add_balance_to_purchases', 1),
(87, '2019_03_25_154401_add_status_to_purchases', 2),
(88, '2019_03_28_210509_add_purchase_product_id_to_sales_products', 3),
(90, '2019_04_08_202149_add_fields_to_purchase_orders', 4),
(91, '2019_04_09_213140_add_fields_to_sales', 5),
(92, '2019_04_08_151100_create_type_medical_history_table', 6),
(93, '2019_04_08_151101_create_medical_history_table', 6),
(94, '2019_04_11_124026_create_budgetdashboard_table', 6),
(95, '2019_05_03_112332_create_retention_table', 7),
(96, '2019_05_03_112333_create_expenses_table', 7),
(99, '2019_05_15_214308_create_electronic_equipments_table', 8),
(100, '2019_05_16_222700_add_electronic_equipment_id_to_services', 8),
(101, '2019_05_27_223334_add_fields_to_sales', 9),
(102, '2019_06_27_221538_add_form_to_products', 9),
(103, '2019_07_30_102427_add_evolutions_to_infirmary_evolution_table', 10),
(104, '2019_07_30_143703_create_medication_control_table', 10),
(105, '2019_07_30_143925_create_relation_medication_control_table', 10),
(106, '2019_07_30_173422_create_liquid_control_table', 10),
(107, '2019_07_30_173908_create_relation_liquid_control_table', 10),
(108, '2019_08_22_082010_create_diagnostic_aids_table', 11),
(109, '2019_08_22_141215_add_type_to_laboratories_table', 12),
(110, '2019_08_22_153110_add_diagnosis_to_relation_laboratory_exams_table', 12),
(111, '2019_08_23_083716_create_systems_table', 12),
(112, '2019_08_23_084320_create_systems_pathologies_table', 12),
(113, '2019_08_23_091123_create_systems_review_relation_table', 12),
(114, '2019_09_05_092108_add_code_to_diagnostics_table', 13),
(115, '2019_09_11_140949_add_more_to_biological_medicine_plan_table', 13),
(116, '2019_09_17_095837_create_lote_products_table', 13),
(117, '2019_09_17_171234_create_sucesses_table', 13),
(118, '2019_09_18_105746_create_reservation_dates_table', 13),
(119, '2019_09_20_142244_add_more_to_sales_table', 13),
(120, '2019_10_18_160457_alter_status_to_purchases', 14),
(121, '2019_10_18_162039_add_status_to_purchase_products', 15),
(122, '2019_10_21_145059_create_requisitions_table', 16),
(123, '2019_10_21_145305_create_requisitions_categories_table', 16),
(124, '2019_10_21_145307_create_requisitions_products_table', 16),
(125, '2019_10_21_151137_create_products_requisitions_table', 16),
(126, '2019_10_24_100342_add_price_vent_to_products_table', 16),
(127, '2019_11_01_161831_create_payment_assistance_table', 16),
(128, '2019_11_02_094108_add_service_id_to_consumed_table', 16),
(129, '2020_02_04_084939_create_balance_box_table', 17),
(130, '2020_02_05_114030_create_email_confirmation_table', 18),
(131, '2020_08_21_094954_create_campaign_table', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monitorings`
--

CREATE TABLE `monitorings` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `responsable_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `issue_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `date_close` date DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_close` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','cerrado','fallido','aplazado','vencido') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `notified_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_id` int(10) UNSIGNED DEFAULT NULL,
  `text` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `notified_id`, `type`, `type_id`, `text`, `read`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'task', 4, 'El usuario Super le ha asignado la tarea Esto es una prueba para el día 13/03/2019', 0, '2019-03-12 02:10:28', '2019-03-12 02:10:28'),
(2, 1, 1, 'task', 4, 'El usuario Super le ha asignado la tarea Esto es una prueba para el día 13/03/2019', 0, '2019-03-12 02:10:28', '2019-03-12 02:10:28'),
(3, 1, 2, 'task', 5, 'El usuario Super le ha asignado la tarea prueba dic 2019 para el día 04/12/2019', 0, '2019-12-04 13:39:36', '2019-12-04 13:39:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_products`
--

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` decimal(5,2) NOT NULL,
  `type` enum('P/O','A/C','PRO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identy` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `state_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `gender_id` int(10) UNSIGNED DEFAULT NULL,
  `service_id` int(10) UNSIGNED DEFAULT NULL,
  `contact_source_id` int(10) UNSIGNED DEFAULT NULL,
  `eps_id` int(10) UNSIGNED DEFAULT NULL,
  `civil_status_id` int(10) UNSIGNED DEFAULT NULL,
  `ocupation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkage` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cellphone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_relationship` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patient_photographs`
--

CREATE TABLE `patient_photographs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `array_photos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_assistance`
--

CREATE TABLE `payment_assistance` (
  `id` int(10) UNSIGNED NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `patient` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asyst` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serv` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sesion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `desc` int(11) NOT NULL,
  `comision` int(11) NOT NULL,
  `seller` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stable_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int(11) NOT NULL,
  `balance_favor` int(11) NOT NULL,
  `pay` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `physical_exams`
--

CREATE TABLE `physical_exams` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_neck` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cardiopulmonary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `abdomen` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `extremities` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nervous_system` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `skin_fanera` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `others` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax` decimal(4,2) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `cost` decimal(19,2) DEFAULT NULL,
  `stock` decimal(10,2) NOT NULL,
  `presentation_id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `inventory_id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED DEFAULT NULL,
  `form` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `price_vent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_requisition`
--

CREATE TABLE `products_requisition` (
  `id` int(10) UNSIGNED NOT NULL,
  `requisition_id` int(10) UNSIGNED NOT NULL,
  `category` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `providers`
--

CREATE TABLE `providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `nit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cellphone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `cellar_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bill` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(20,2) NOT NULL,
  `balance` decimal(19,2) DEFAULT NULL,
  `discount` decimal(15,2) NOT NULL,
  `payment_method` enum('efectivo','credito','consignacion') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `days` int(11) DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `account_id` int(10) UNSIGNED DEFAULT NULL,
  `bank` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_cost_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','anulado','incompleta') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `receive_id` int(10) UNSIGNED NOT NULL,
  `status` enum('enviado','inventariado','pedido') COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `provider_id` int(10) UNSIGNED DEFAULT NULL,
  `delivery` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_of_payment` enum('efectivo','tarjeta','transferencia','cheque','online','consignacion') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efectivo',
  `id_order` int(11) DEFAULT NULL,
  `id_purchase` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_products`
--

CREATE TABLE `purchase_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `cellar_id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` decimal(5,2) NOT NULL,
  `lote` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` date NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `tax` decimal(4,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `missing` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_amount` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_clinical_diagnostics`
--

CREATE TABLE `relation_clinical_diagnostics` (
  `id` int(10) UNSIGNED NOT NULL,
  `clinical_diagnostics_id` int(10) UNSIGNED DEFAULT NULL,
  `diagnosis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('principal','relacionado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'principal',
  `external_cause` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `treatment_plan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_expenses_sheet`
--

CREATE TABLE `relation_expenses_sheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `expenses_sheet_id` int(10) UNSIGNED DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lote` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cant` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_formulation_appointment`
--

CREATE TABLE `relation_formulation_appointment` (
  `id` int(10) UNSIGNED NOT NULL,
  `formulation_appointment_id` int(10) UNSIGNED DEFAULT NULL,
  `formula` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `another_formula` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indications` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formulation` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_laboratory_exams`
--

CREATE TABLE `relation_laboratory_exams` (
  `id` int(10) UNSIGNED NOT NULL,
  `laboratory_exams_id` int(10) UNSIGNED DEFAULT NULL,
  `diagnosis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exam` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_exam` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_liquid_control`
--

CREATE TABLE `relation_liquid_control` (
  `id` int(10) UNSIGNED NOT NULL,
  `liquid_control_id` int(10) UNSIGNED DEFAULT NULL,
  `hour` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_element` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `box` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_medication_control`
--

CREATE TABLE `relation_medication_control` (
  `id` int(10) UNSIGNED NOT NULL,
  `medication_control_id` int(10) UNSIGNED DEFAULT NULL,
  `medicine` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_surgery_expenses_sheet`
--

CREATE TABLE `relation_surgery_expenses_sheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `surgery_expenses_sheet_id` int(10) UNSIGNED DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lote` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `presentation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cant` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relation_treatment_plan`
--

CREATE TABLE `relation_treatment_plan` (
  `id` int(10) UNSIGNED NOT NULL,
  `tratment_plan_id` int(10) UNSIGNED DEFAULT NULL,
  `service_line` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisitions`
--

CREATE TABLE `requisitions` (
  `id` int(10) UNSIGNED NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('no cumplida','cumplida') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no cumplida',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisitions_categories`
--

CREATE TABLE `requisitions_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisitions_products`
--

CREATE TABLE `requisitions_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `requisition_category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation_date`
--

CREATE TABLE `reservation_date` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `responsable_id` int(10) UNSIGNED DEFAULT NULL,
  `option` enum('dias','horas') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_end` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hour_start` time DEFAULT NULL,
  `hour_end` time DEFAULT NULL,
  `motiv` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retention`
--

CREATE TABLE `retention` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `retention`
--

INSERT INTO `retention` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Compras - 2.5', '2.50', '2020-08-26 05:00:00', NULL),
(2, 'Servicios - 2.0', '2.00', '2020-08-26 05:00:00', NULL),
(3, 'Servicios - 1.0', '1.00', '2020-08-26 05:00:00', NULL),
(4, 'Servicios - 4.0', '4.00', '2020-08-26 05:00:00', NULL),
(5, 'Servicios - 6.0', '6.00', '2020-08-26 05:00:00', NULL),
(6, 'Honorarios - 11.0', '11.00', '2020-08-26 05:00:00', NULL),
(7, 'Honorarios - 10.0', '10.00', '2020-08-26 05:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `superadmin` tinyint(1) NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `superadmin`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrador', 1, 'activo', '2019-02-09 17:53:11', '2019-02-09 17:53:11'),
(2, 'Médico', 0, 'activo', '2018-11-14 04:36:05', '2018-11-14 04:36:05'),
(7, 'Ayudante', 0, 'activo', '2019-05-15 22:55:52', '2020-02-11 21:13:15'),
(8, 'Anestesiologo', 0, 'activo', '2019-05-15 22:56:56', '2019-05-15 22:56:56'),
(9, 'Rotador', 0, 'activo', '2019-05-15 22:57:42', '2019-05-15 22:57:42'),
(10, 'Instrumentador', 0, 'activo', '2019-05-15 22:57:42', '2019-05-15 22:57:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  `sub_amount` decimal(19,2) NOT NULL,
  `amount` decimal(19,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL DEFAULT 0.00,
  `type_discount` enum('price','percent') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `qty_products` int(11) NOT NULL,
  `method_payment` enum('efectivo','credito','cheque','consignacion','tarjeta','transferencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_payment_2` enum('efectivo','credito','cheque','consignacion','tarjeta','transferencia') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_1` decimal(19,2) DEFAULT NULL,
  `total_2` decimal(19,2) DEFAULT NULL,
  `number_account` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_account_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_number_2` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','anulada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_of_card` enum('debito','mastercard','visa','american express','dinners club') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved_of_card` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_entity` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive` decimal(19,2) DEFAULT NULL,
  `change` decimal(19,2) DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales_products`
--

CREATE TABLE `sales_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `purchase_product_id` int(10) UNSIGNED NOT NULL,
  `qty` decimal(6,2) NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `discount` decimal(4,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedules`
--

CREATE TABLE `schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `personal_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `contract_id` int(10) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirm_comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('programada','confirmada','fallida','completada','cancelada','en sala','reprogramada','atendida','vencida') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'programada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_pay` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_input` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xpenses_sheet` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipment_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restricted` enum('SI','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SI',
  `contract` enum('SI','NO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SI',
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `electronic_equipment_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_user`
--

CREATE TABLE `service_user` (
  `service_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shopping_centers`
--

CREATE TABLE `shopping_centers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `states`
--

CREATE TABLE `states` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(5, 'ANTIOQUIA'),
(8, 'ATLÁNTICO'),
(11, 'BOGOTÁ, D.C.'),
(13, 'BOLÍVAR'),
(15, 'BOYACÁ'),
(17, 'CALDAS'),
(18, 'CAQUETÁ'),
(19, 'CAUCA'),
(20, 'CESAR'),
(23, 'CÓRDOBA'),
(25, 'CUNDINAMARCA'),
(27, 'CHOCÓ'),
(41, 'HUILA'),
(44, 'LA GUAJIRA'),
(47, 'MAGDALENA'),
(50, 'META'),
(52, 'NARIÑO'),
(54, 'NORTE DE SANTANDER'),
(63, 'QUINDIO'),
(66, 'RISARALDA'),
(68, 'SANTANDER'),
(70, 'SUCRE'),
(73, 'TOLIMA'),
(76, 'VALLE DEL CAUCA'),
(81, 'ARAUCA'),
(85, 'CASANARE'),
(86, 'PUTUMAYO'),
(88, 'ARCHIPIÉLAGO DE SAN ANDRÉS, PROVIDENCIA Y SANTA CATALINA'),
(91, 'AMAZONAS'),
(94, 'GUAINÍA'),
(95, 'GUAVIARE'),
(97, 'VAUPÉS'),
(99, 'VICHADA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucess`
--

CREATE TABLE `sucess` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `observation` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `surgery_expenses_sheet`
--

CREATE TABLE `surgery_expenses_sheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `date_of_surgery` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_patient` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_anesthesia` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_surgery` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surgery` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surgery_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_entry` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time_surgery` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time_surgery` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surgeon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assistant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anesthesiologist` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rotary` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instrument` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `surgical_description`
--

CREATE TABLE `surgical_description` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `diagnosis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preoperative_diagnosis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `postoperative_diagnosis` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `surgeon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anesthesiologist` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assistant` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surgical_instrument` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_cups` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intervention` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `control_compresas` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_anesthesia` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_findings` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `systems`
--

CREATE TABLE `systems` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_observation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `systems_pathologies`
--

CREATE TABLE `systems_pathologies` (
  `id` int(10) UNSIGNED NOT NULL,
  `systems_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `systems_review_relation`
--

CREATE TABLE `systems_review_relation` (
  `id` int(10) UNSIGNED NOT NULL,
  `system_review_id` int(10) UNSIGNED DEFAULT NULL,
  `systems_id` int(10) UNSIGNED DEFAULT NULL,
  `pathology` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `select` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_review`
--

CREATE TABLE `system_review` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `system_head_face_neck` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_respiratory_cardio` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_digestive` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_genito_urinary` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_locomotor` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_nervous` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_integumentary` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` enum('activa','gestionada','vencida') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_user`
--

CREATE TABLE `task_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `text`
--

CREATE TABLE `text` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `text`
--

INSERT INTO `text` (`id`, `text`, `created_at`, `updated_at`) VALUES
(1, '[titulo] [nombreProfesional] [apellidoProfesional] - agendado con el paciente \n        [nombrePaciente] [apellidoPaciente] - servicio: [servicio] - Observaciones: [observaciones]', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(2, 'Su cita con el profesional [nombreProfesional] [apellidoProfesional] para el servicio \n        [servicio] ha sido agendada para el día [fecha] a las [hora]. Smadia clinic', '2019-02-09 17:53:15', '2019-02-09 17:53:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `treatment_plan`
--

CREATE TABLE `treatment_plan` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `patient_id` int(10) UNSIGNED DEFAULT NULL,
  `observations` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types`
--

CREATE TABLE `types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `types`
--

INSERT INTO `types` (`id`, `name`, `type`, `short`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Aceites', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(2, 'Ampolla', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(3, 'Crema', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(4, 'Emulsion', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(5, 'Frasco', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(6, 'Galon', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(7, 'Gel', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(8, 'Gotas', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(9, 'Jeringa prellenada', 'presentation', NULL, 'activo', '2019-02-09 17:53:15', '2019-02-09 17:53:15'),
(10, 'Paquete', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(11, 'Rollo', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(12, 'Shampoo', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(13, 'Sobre', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(14, 'Soluciones', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(15, 'Spray', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(16, 'Tabletas', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(17, 'Tubo', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(18, 'Unguento', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(19, 'Unidad', 'presentation', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(20, 'Accesorios C-Ortiz', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(21, 'Anestesico', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(22, 'Anti-acne', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(23, 'Antiedad', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(24, 'Antioxidante', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(25, 'Aseo', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(26, 'Cafetería', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(27, 'Capilar', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(28, 'Cicatrizante', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(29, 'Clarificante', 'category', NULL, 'activo', '2019-02-09 17:53:16', '2019-02-09 17:53:16'),
(30, 'Demaquillante', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(31, 'Despigmentante', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(32, 'Detoxificante', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(33, 'Dispositivo Medico', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(34, 'Exfoliante', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(35, 'Fajas', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(36, 'Hidratante', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(37, 'Hidratante Piel Grasa', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(38, 'Hidratante Piel Seca', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(39, 'Insumos de cabina', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(40, 'Insumos Medicos', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(41, 'Limpiadora', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(42, 'Medicamento', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(43, 'Medicamento de CE', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(44, 'Medicamentos Post', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(45, 'Medicina Biologica', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(46, 'Papeliería', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(47, 'Protector Solar', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(48, 'Reafirmante', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(49, 'Rellenos Faciales', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(50, 'Renovador Cutaneo', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(51, 'Restaurador Cutaneo', 'category', NULL, 'activo', '2019-02-09 17:53:17', '2019-02-09 17:53:17'),
(52, 'Restaurador Vascular', 'category', NULL, 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(53, 'Suplemento Alimentario', 'category', NULL, 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(54, 'Toxina Botulinica', 'category', NULL, 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(55, 'Productos', 'inventory', NULL, 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(56, 'Insumos', 'inventory', NULL, 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(57, 'Consumibles', 'inventory', NULL, 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(58, 'Miligramos', 'unit', 'Mg', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(59, 'Unidad', 'unit', 'Und', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(60, 'Mililitros', 'unit', 'Ml', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(61, 'Gramos', 'unit', 'Gr', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(62, 'Centimetro', 'unit', 'Cm', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(63, 'Unidades', 'unit', 'Ui', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(64, 'Caja', 'unit', 'Cj', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(65, 'Blister', 'unit', 'Blister', 'activo', '2019-02-09 17:53:18', '2019-02-09 17:53:18'),
(66, 'aceite', 'presentation', NULL, 'activo', '2019-07-22 19:45:17', '2019-07-22 19:45:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_medical_history`
--

CREATE TABLE `type_medical_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `href` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `type_medical_history`
--

INSERT INTO `type_medical_history` (`id`, `name`, `href`, `created_at`, `updated_at`) VALUES
(1, 'Anamnesis', 'anamnesis', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(2, 'Revisión por Sistema', 'system-review', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(3, 'Exámen físico', 'physical-exams', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(4, 'Tabla de medidas', 'measurements', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(5, 'Diagnostico clínico', 'clinical-diagnostics', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(6, 'Plan de Tratamiento', 'treatment-plan', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(7, 'Plan de Medicina Biologica', 'biological-medicine-plan', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(8, 'Ayudas Diagnosticas', 'laboratory-exams', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(9, 'Evolución médica', 'medical-evolutions', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(10, 'Evolución Cosmetológica', 'cosmetological-evolution', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(11, 'Evolución de Enfermería', 'infirmary-evolution', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(12, 'Formulación', 'formulation-appointment', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(13, 'Hoja de Gastos', 'expenses-sheet', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(14, 'Hoja de Gastos de Cirugía', 'surgery-expenses-sheet', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(15, 'Notas de Enfermería', 'infirmary-notes', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(16, 'Descripción Quirúrgica', 'surgical-description', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(17, 'Archivos y Fotografias', 'patient-photographs', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(18, 'Resultados de Laboratorio', 'lab-results', '2019-04-08 21:54:39', '2019-04-08 21:54:39'),
(19, 'Control de medicamentos', 'medication-control', NULL, NULL),
(20, 'Control de liquidos', 'liquid-control', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_services`
--

CREATE TABLE `type_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identy` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_expedition` date NOT NULL,
  `birthday` date NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `gender_id` int(10) UNSIGNED NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urbanization` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_two` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cellphone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cellphone_two` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_two` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `arl_id` int(10) UNSIGNED DEFAULT NULL,
  `pension_id` int(10) UNSIGNED DEFAULT NULL,
  `blood_id` int(10) UNSIGNED NOT NULL,
  `f_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_cellphone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_relationship` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('activo','inactivo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `schedule` enum('si','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `title`, `name`, `lastname`, `username`, `identy`, `date_expedition`, `birthday`, `state_id`, `city_id`, `gender_id`, `address`, `urbanization`, `phone`, `phone_two`, `cellphone`, `cellphone_two`, `email`, `email_two`, `password`, `arl_id`, `pension_id`, `blood_id`, `f_name`, `f_lastname`, `f_address`, `f_phone`, `f_cellphone`, `f_relationship`, `photo`, `color`, `status`, `schedule`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Super', 'Administrador', 'admin', '1111111', '2020-08-26', '2020-08-26', 8, 88, 1, 'Cra', NULL, '000000', NULL, '000000', NULL, 'admin@smadiaclinic.com', NULL, '$2y$10$G7TEcdxd2IAhRlfOvxAaXuAFnH1Llw4MG.3WO3Is4O/cG6.Rhcg6q', NULL, NULL, 1, 'Super', 'Administrador', 'Cra', '0', '', 'N/A', NULL, NULL, 'activo', 'no', NULL, '2020-08-26 21:04:12', '2020-08-26 21:04:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `anamnesis`
--
ALTER TABLE `anamnesis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anamnesis_user_id_index` (`user_id`),
  ADD KEY `anamnesis_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indices de la tabla `balance_box`
--
ALTER TABLE `balance_box`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balance_box_user_id_index` (`user_id`),
  ADD KEY `balance_box_patient_id_index` (`patient_id`),
  ADD KEY `balance_box_con_id_index` (`con_id`);

--
-- Indices de la tabla `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `biological_medicine_plan`
--
ALTER TABLE `biological_medicine_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biological_medicine_plan_user_id_index` (`user_id`),
  ADD KEY `biological_medicine_plan_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `bloods`
--
ALTER TABLE `bloods`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `budgetdashboard`
--
ALTER TABLE `budgetdashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budgets_patient_id_foreign` (`patient_id`),
  ADD KEY `budgets_seller_id_foreign` (`seller_id`),
  ADD KEY `budgets_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `campaign`
--
ALTER TABLE `campaign`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cellars`
--
ALTER TABLE `cellars`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `center_costs`
--
ALTER TABLE `center_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indices de la tabla `clinical_diagnostics`
--
ALTER TABLE `clinical_diagnostics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clinical_diagnostics_user_id_index` (`user_id`),
  ADD KEY `clinical_diagnostics_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `consumed`
--
ALTER TABLE `consumed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consumed_schedule_id_foreign` (`schedule_id`);

--
-- Indices de la tabla `contact_sources`
--
ALTER TABLE `contact_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_patient_id_foreign` (`patient_id`),
  ADD KEY `contracts_seller_id_foreign` (`seller_id`),
  ADD KEY `contracts_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `cosmetological_evolution`
--
ALTER TABLE `cosmetological_evolution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cosmetological_evolution_user_id_index` (`user_id`),
  ADD KEY `cosmetological_evolution_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `diagnostics`
--
ALTER TABLE `diagnostics`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `diagnostic_aids`
--
ALTER TABLE `diagnostic_aids`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `electronic_equipments`
--
ALTER TABLE `electronic_equipments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `email_confirmation`
--
ALTER TABLE `email_confirmation`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_user_id_index` (`user_id`),
  ADD KEY `expenses_provider_id_index` (`provider_id`),
  ADD KEY `expenses_purchase_orders_id_index` (`purchase_orders_id`),
  ADD KEY `expenses_center_costs_id_index` (`center_costs_id`),
  ADD KEY `expenses_retention_id_index` (`retention_id`);

--
-- Indices de la tabla `expenses_sheet`
--
ALTER TABLE `expenses_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_sheet_user_id_index` (`user_id`),
  ADD KEY `expenses_sheet_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formulation_appointment`
--
ALTER TABLE `formulation_appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulation_appointment_user_id_index` (`user_id`),
  ADD KEY `formulation_appointment_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incidents_monitoring_id_index` (`monitoring_id`),
  ADD KEY `incidents_user_id_index` (`user_id`),
  ADD KEY `incidents_responsable_id_index` (`responsable_id`);

--
-- Indices de la tabla `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_patient_id_foreign` (`patient_id`),
  ADD KEY `incomes_contract_id_foreign` (`contract_id`),
  ADD KEY `incomes_seller_id_foreign` (`seller_id`),
  ADD KEY `incomes_responsable_id_foreign` (`responsable_id`),
  ADD KEY `incomes_user_id_foreign` (`user_id`),
  ADD KEY `incomes_center_cost_id_foreign` (`center_cost_id`),
  ADD KEY `incomes_account_id_foreign` (`account_id`),
  ADD KEY `incomes_accounts2_id_fk` (`account_2_id`);

--
-- Indices de la tabla `infirmary_evolution`
--
ALTER TABLE `infirmary_evolution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `infirmary_evolution_user_id_index` (`user_id`),
  ADD KEY `infirmary_evolution_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `infirmary_notes`
--
ALTER TABLE `infirmary_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `infirmary_notes_user_id_index` (`user_id`),
  ADD KEY `infirmary_notes_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_contract_id_foreign` (`contract_id`),
  ADD KEY `items_budget_id_foreign` (`budget_id`),
  ADD KEY `items_service_id_foreign` (`service_id`);

--
-- Indices de la tabla `laboratories`
--
ALTER TABLE `laboratories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `laboratory_exams`
--
ALTER TABLE `laboratory_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratory_exams_user_id_index` (`user_id`),
  ADD KEY `laboratory_exams_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `lab_results`
--
ALTER TABLE `lab_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_results_user_id_index` (`user_id`),
  ADD KEY `lab_results_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `liquid_control`
--
ALTER TABLE `liquid_control`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liquid_control_user_id_index` (`user_id`),
  ADD KEY `liquid_control_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `lote_products`
--
ALTER TABLE `lote_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lote_products_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `measurements_user_id_index` (`user_id`),
  ADD KEY `measurements_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `medical_evolutions`
--
ALTER TABLE `medical_evolutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_evolutions_user_id_index` (`user_id`),
  ADD KEY `medical_evolutions_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `medical_history`
--
ALTER TABLE `medical_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_history_user_id_index` (`user_id`),
  ADD KEY `medical_history_id_type_index` (`id_type`),
  ADD KEY `medical_history_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `medication_control`
--
ALTER TABLE `medication_control`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medication_control_user_id_index` (`user_id`),
  ADD KEY `medication_control_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `monitorings`
--
ALTER TABLE `monitorings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monitorings_patient_id_foreign` (`patient_id`),
  ADD KEY `monitorings_responsable_id_foreign` (`responsable_id`),
  ADD KEY `monitorings_user_id_foreign` (`user_id`),
  ADD KEY `monitorings_issue_id_foreign` (`issue_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_index` (`user_id`),
  ADD KEY `notifications_notified_id_index` (`notified_id`);

--
-- Indices de la tabla `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_products_purchase_order_id_foreign` (`purchase_order_id`),
  ADD KEY `order_products_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_cellphone_unique` (`cellphone`),
  ADD UNIQUE KEY `patients_email_unique` (`email`),
  ADD KEY `patients_state_id_foreign` (`state_id`),
  ADD KEY `patients_city_id_foreign` (`city_id`),
  ADD KEY `patients_gender_id_foreign` (`gender_id`),
  ADD KEY `patients_service_id_foreign` (`service_id`),
  ADD KEY `patients_contact_source_id_foreign` (`contact_source_id`),
  ADD KEY `patients_eps_id_foreign` (`eps_id`),
  ADD KEY `patients_civil_status_id_foreign` (`civil_status_id`);

--
-- Indices de la tabla `patient_photographs`
--
ALTER TABLE `patient_photographs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_photographs_user_id_index` (`user_id`),
  ADD KEY `patient_photographs_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_index` (`user_id`),
  ADD KEY `payments_purchase_id_index` (`purchase_id`);

--
-- Indices de la tabla `payment_assistance`
--
ALTER TABLE `payment_assistance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `physical_exams`
--
ALTER TABLE `physical_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `physical_exams_user_id_index` (`user_id`),
  ADD KEY `physical_exams_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_presentation_id_foreign` (`presentation_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_inventory_id_foreign` (`inventory_id`),
  ADD KEY `products_provider_id_foreign` (`provider_id`);

--
-- Indices de la tabla `products_requisition`
--
ALTER TABLE `products_requisition`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_provider_id_foreign` (`provider_id`),
  ADD KEY `purchases_account_id_foreign` (`account_id`),
  ADD KEY `purchases_center_cost_id_foreign` (`center_cost_id`),
  ADD KEY `purchases_user_id_index` (`user_id`),
  ADD KEY `purchases_cellars_id_fk` (`cellar_id`);

--
-- Indices de la tabla `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders_user_id_foreign` (`user_id`),
  ADD KEY `purchase_orders_receive_id_foreign` (`receive_id`),
  ADD KEY `purchase_orders_provider_id_index` (`provider_id`);

--
-- Indices de la tabla `purchase_products`
--
ALTER TABLE `purchase_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_products_product_id_foreign` (`product_id`),
  ADD KEY `purchase_products_purchase_id_index` (`purchase_id`),
  ADD KEY `purchase_products_cellars_id_fk` (`cellar_id`);

--
-- Indices de la tabla `relation_clinical_diagnostics`
--
ALTER TABLE `relation_clinical_diagnostics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relation_clinical_diagnostics_clinical_diagnostics_id_index` (`clinical_diagnostics_id`);

--
-- Indices de la tabla `relation_expenses_sheet`
--
ALTER TABLE `relation_expenses_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_sheet_index` (`expenses_sheet_id`);

--
-- Indices de la tabla `relation_formulation_appointment`
--
ALTER TABLE `relation_formulation_appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formulation_appointment_index` (`formulation_appointment_id`);

--
-- Indices de la tabla `relation_laboratory_exams`
--
ALTER TABLE `relation_laboratory_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relation_laboratory_exams_laboratory_exams_id_index` (`laboratory_exams_id`);

--
-- Indices de la tabla `relation_liquid_control`
--
ALTER TABLE `relation_liquid_control`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relation_liquid_control_liquid_control_id_index` (`liquid_control_id`);

--
-- Indices de la tabla `relation_medication_control`
--
ALTER TABLE `relation_medication_control`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relation_medication_control_medication_control_id_index` (`medication_control_id`);

--
-- Indices de la tabla `relation_surgery_expenses_sheet`
--
ALTER TABLE `relation_surgery_expenses_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surgery_expenses_sheet_index` (`surgery_expenses_sheet_id`);

--
-- Indices de la tabla `relation_treatment_plan`
--
ALTER TABLE `relation_treatment_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `relation_treatment_plan_tratment_plan_id_index` (`tratment_plan_id`);

--
-- Indices de la tabla `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `requisitions_categories`
--
ALTER TABLE `requisitions_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `requisitions_products`
--
ALTER TABLE `requisitions_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisitions_products_requisition_category_id_foreign` (`requisition_category_id`);

--
-- Indices de la tabla `reservation_date`
--
ALTER TABLE `reservation_date`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_date_user_id_index` (`user_id`),
  ADD KEY `reservation_date_responsable_id_index` (`responsable_id`);

--
-- Indices de la tabla `retention`
--
ALTER TABLE `retention`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_patient_id_index` (`patient_id`),
  ADD KEY `sales_user_id_index` (`user_id`),
  ADD KEY `sales_seller_id_index` (`seller_id`);

--
-- Indices de la tabla `sales_products`
--
ALTER TABLE `sales_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_products_sale_id_index` (`sale_id`),
  ADD KEY `sales_products_product_id_index` (`product_id`),
  ADD KEY `sales_products_purchase_product_id_index` (`purchase_product_id`);

--
-- Indices de la tabla `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_patient_id_foreign` (`patient_id`),
  ADD KEY `schedules_personal_id_foreign` (`personal_id`),
  ADD KEY `schedules_user_id_foreign` (`user_id`),
  ADD KEY `schedules_service_id_foreign` (`service_id`),
  ADD KEY `schedules_contract_id_foreign` (`contract_id`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_electronic_equipment_id_index` (`electronic_equipment_id`);

--
-- Indices de la tabla `service_user`
--
ALTER TABLE `service_user`
  ADD KEY `service_user_service_id_foreign` (`service_id`),
  ADD KEY `service_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);

--
-- Indices de la tabla `shopping_centers`
--
ALTER TABLE `shopping_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sucess`
--
ALTER TABLE `sucess`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sucess_user_id_index` (`user_id`),
  ADD KEY `sucess_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `surgery_expenses_sheet`
--
ALTER TABLE `surgery_expenses_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surgery_expenses_sheet_user_id_index` (`user_id`),
  ADD KEY `surgery_expenses_sheet_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `surgical_description`
--
ALTER TABLE `surgical_description`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surgical_description_user_id_index` (`user_id`),
  ADD KEY `surgical_description_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `systems_pathologies`
--
ALTER TABLE `systems_pathologies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `systems_pathologies_systems_id_foreign` (`systems_id`);

--
-- Indices de la tabla `systems_review_relation`
--
ALTER TABLE `systems_review_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `systems_review_relation_system_review_id_foreign` (`system_review_id`),
  ADD KEY `systems_review_relation_systems_id_foreign` (`systems_id`);

--
-- Indices de la tabla `system_review`
--
ALTER TABLE `system_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_review_user_id_index` (`user_id`),
  ADD KEY `system_review_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_index` (`user_id`);

--
-- Indices de la tabla `task_user`
--
ALTER TABLE `task_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_users_user_id_index` (`user_id`),
  ADD KEY `task_users_task_id_index` (`task_id`);

--
-- Indices de la tabla `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `treatment_plan`
--
ALTER TABLE `treatment_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatment_plan_user_id_index` (`user_id`),
  ADD KEY `treatment_plan_patient_id_index` (`patient_id`);

--
-- Indices de la tabla `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_medical_history`
--
ALTER TABLE `type_medical_history`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type_services`
--
ALTER TABLE `type_services`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_state_id_foreign` (`state_id`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_gender_id_foreign` (`gender_id`),
  ADD KEY `users_arl_id_foreign` (`arl_id`),
  ADD KEY `users_pension_id_foreign` (`pension_id`),
  ADD KEY `users_blood_id_foreign` (`blood_id`),
  ADD KEY `users_role_id_index` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `anamnesis`
--
ALTER TABLE `anamnesis`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `audits`
--
ALTER TABLE `audits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `balance_box`
--
ALTER TABLE `balance_box`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `biological_medicine_plan`
--
ALTER TABLE `biological_medicine_plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bloods`
--
ALTER TABLE `bloods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `budgetdashboard`
--
ALTER TABLE `budgetdashboard`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campaign`
--
ALTER TABLE `campaign`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cellars`
--
ALTER TABLE `cellars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `center_costs`
--
ALTER TABLE `center_costs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1101;

--
-- AUTO_INCREMENT de la tabla `clinical_diagnostics`
--
ALTER TABLE `clinical_diagnostics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consumed`
--
ALTER TABLE `consumed`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contact_sources`
--
ALTER TABLE `contact_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cosmetological_evolution`
--
ALTER TABLE `cosmetological_evolution`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diagnostics`
--
ALTER TABLE `diagnostics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `diagnostic_aids`
--
ALTER TABLE `diagnostic_aids`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `electronic_equipments`
--
ALTER TABLE `electronic_equipments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `email_confirmation`
--
ALTER TABLE `email_confirmation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `expenses_sheet`
--
ALTER TABLE `expenses_sheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `formulation_appointment`
--
ALTER TABLE `formulation_appointment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `infirmary_evolution`
--
ALTER TABLE `infirmary_evolution`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `infirmary_notes`
--
ALTER TABLE `infirmary_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `laboratories`
--
ALTER TABLE `laboratories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `laboratory_exams`
--
ALTER TABLE `laboratory_exams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lab_results`
--
ALTER TABLE `lab_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `liquid_control`
--
ALTER TABLE `liquid_control`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lote_products`
--
ALTER TABLE `lote_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `measurements`
--
ALTER TABLE `measurements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medical_evolutions`
--
ALTER TABLE `medical_evolutions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medical_history`
--
ALTER TABLE `medical_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medication_control`
--
ALTER TABLE `medication_control`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de la tabla `monitorings`
--
ALTER TABLE `monitorings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `patient_photographs`
--
ALTER TABLE `patient_photographs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payment_assistance`
--
ALTER TABLE `payment_assistance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `physical_exams`
--
ALTER TABLE `physical_exams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products_requisition`
--
ALTER TABLE `products_requisition`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `purchase_products`
--
ALTER TABLE `purchase_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_clinical_diagnostics`
--
ALTER TABLE `relation_clinical_diagnostics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_expenses_sheet`
--
ALTER TABLE `relation_expenses_sheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_formulation_appointment`
--
ALTER TABLE `relation_formulation_appointment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_laboratory_exams`
--
ALTER TABLE `relation_laboratory_exams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_liquid_control`
--
ALTER TABLE `relation_liquid_control`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_medication_control`
--
ALTER TABLE `relation_medication_control`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_surgery_expenses_sheet`
--
ALTER TABLE `relation_surgery_expenses_sheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `relation_treatment_plan`
--
ALTER TABLE `relation_treatment_plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `requisitions_categories`
--
ALTER TABLE `requisitions_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `requisitions_products`
--
ALTER TABLE `requisitions_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservation_date`
--
ALTER TABLE `reservation_date`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `retention`
--
ALTER TABLE `retention`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sales_products`
--
ALTER TABLE `sales_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `shopping_centers`
--
ALTER TABLE `shopping_centers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucess`
--
ALTER TABLE `sucess`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `surgery_expenses_sheet`
--
ALTER TABLE `surgery_expenses_sheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `surgical_description`
--
ALTER TABLE `surgical_description`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `systems`
--
ALTER TABLE `systems`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `systems_pathologies`
--
ALTER TABLE `systems_pathologies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `systems_review_relation`
--
ALTER TABLE `systems_review_relation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `system_review`
--
ALTER TABLE `system_review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `task_user`
--
ALTER TABLE `task_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `text`
--
ALTER TABLE `text`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `treatment_plan`
--
ALTER TABLE `treatment_plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `types`
--
ALTER TABLE `types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `type_medical_history`
--
ALTER TABLE `type_medical_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `type_services`
--
ALTER TABLE `type_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

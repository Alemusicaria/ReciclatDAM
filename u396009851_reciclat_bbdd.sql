-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2025 a las 19:46:23
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
-- Base de datos: `u396009851_reciclat_bbdd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `action`, `description`, `data`, `created_at`, `updated_at`) VALUES
(1, 66, 'Ha actualizado el perfil de aaaaaaaa bbbbbcc', NULL, NULL, '2025-05-22 08:00:09', '2025-05-22 08:00:09'),
(2, 66, 'Ha eliminat l\'usuari Aleix Prat', NULL, NULL, '2025-05-22 09:21:10', '2025-05-22 09:21:10'),
(3, 66, 'Ha eliminat user: aaaaaaaa bbbbbcc', NULL, NULL, '2025-05-22 09:32:19', '2025-05-22 09:32:19'),
(4, 66, 'Ha eliminat user: pepe pepers', NULL, NULL, '2025-05-22 09:35:05', '2025-05-22 09:35:05'),
(5, 66, 'Ha eliminat user: Aleix Prat234234243234', NULL, NULL, '2025-05-22 09:35:14', '2025-05-22 09:35:14'),
(6, 66, 'Ha creat un nou event: sdfsdfsdfsd', NULL, NULL, '2025-05-22 10:17:50', '2025-05-22 10:17:50'),
(7, 66, 'Ha creat un nou event: 2222', NULL, NULL, '2025-05-22 10:22:20', '2025-05-22 10:22:20'),
(8, 66, 'Ha creat un nou event: qwewerewqrewrwer', NULL, NULL, '2025-05-22 10:31:06', '2025-05-22 10:31:06'),
(9, 66, 'Ha eliminat event: qwewerewqrewrwer', NULL, NULL, '2025-05-22 10:32:47', '2025-05-22 10:32:47'),
(10, 66, 'Ha actualitzat l\'event: Recollida de RAEE al barri Gòtic', NULL, NULL, '2025-05-22 10:35:15', '2025-05-22 10:35:15'),
(11, 66, 'Ha eliminat user: Aleix pratss', NULL, NULL, '2025-05-22 11:05:19', '2025-05-22 11:05:19'),
(12, 66, 'Ha eliminat premi: provaaaafdfsdf', NULL, NULL, '2025-05-22 11:05:27', '2025-05-22 11:05:27'),
(13, 66, 'Ha eliminat user: mi amor', NULL, NULL, '2025-05-22 11:37:14', '2025-05-22 11:37:14'),
(14, 66, 'Ha eliminat codi: 8423102210153', NULL, NULL, '2025-05-22 11:46:12', '2025-05-22 11:46:12'),
(15, 66, 'Ha eliminat codi: 8423102210154', NULL, NULL, '2025-05-22 11:47:13', '2025-05-22 11:47:13'),
(16, 66, 'Ha eliminat producte: sdfsdfsdfsd3333', NULL, NULL, '2025-05-22 21:17:18', '2025-05-22 21:17:18'),
(17, 66, 'Ha creat un nou punt de recollida: sdsdfsdfsd', NULL, NULL, '2025-05-22 22:13:33', '2025-05-22 22:13:33'),
(18, 66, 'Ha actualitzat el punt de recollida: sdsdfsdfsd44', NULL, NULL, '2025-05-22 22:18:49', '2025-05-22 22:18:49'),
(19, 66, 'Ha eliminat punt-reciclatge: sdsdfsdfsd44', NULL, NULL, '2025-05-22 22:19:06', '2025-05-22 22:19:06'),
(20, 66, 'Ha creat un nou rol: sdfdsfdfs', NULL, NULL, '2025-05-23 07:35:28', '2025-05-23 07:35:28'),
(21, 66, 'Ha actualitzat el rol: sdfdsfdfs444', NULL, NULL, '2025-05-23 07:35:36', '2025-05-23 07:35:36'),
(22, 66, 'Ha eliminat rol: sdfdsfdfs444', NULL, NULL, '2025-05-23 07:35:44', '2025-05-23 07:35:44'),
(23, 66, 'Ha eliminat tipus-alerta: prova', NULL, NULL, '2025-05-23 07:54:19', '2025-05-23 07:54:19'),
(24, 66, 'Ha creat un nou tipus d\'alerta: peocas', NULL, NULL, '2025-05-23 07:55:22', '2025-05-23 07:55:22'),
(25, 66, 'Ha actualitzat el tipus d\'alerta: peocas33', NULL, NULL, '2025-05-23 07:57:26', '2025-05-23 07:57:26'),
(26, 66, 'Ha eliminat tipus-alerta: peocas33', NULL, NULL, '2025-05-23 07:57:30', '2025-05-23 07:57:30'),
(27, 66, 'Ha actualitzat l\'alerta ID: 4', NULL, NULL, '2025-05-23 08:12:44', '2025-05-23 08:12:44'),
(28, 66, 'Ha eliminat alerta-punt: Alerta #4', NULL, NULL, '2025-05-23 08:13:00', '2025-05-23 08:13:00'),
(29, 66, 'Ha creat una nova alerta per al punt de recollida ID: 3', NULL, NULL, '2025-05-23 08:13:12', '2025-05-23 08:13:12'),
(30, 66, 'Ha eliminat alerta-punt: Alerta #5', NULL, NULL, '2025-05-23 08:13:21', '2025-05-23 08:13:21'),
(31, 66, 'Ha creat una nova alerta per al punt de recollida ID: 1', NULL, NULL, '2025-05-23 08:14:25', '2025-05-23 08:14:25'),
(32, 66, 'Ha creat un nou tipus d\'event: prova', NULL, NULL, '2025-05-23 08:22:12', '2025-05-23 08:22:12'),
(33, 66, 'Ha actualitzat el tipus d\'event: prova44', NULL, NULL, '2025-05-23 08:22:25', '2025-05-23 08:22:25'),
(34, 66, 'Ha eliminat tipus-event: prova44', NULL, NULL, '2025-05-23 08:28:43', '2025-05-23 08:28:43'),
(35, 66, 'Ha actualitzat el perfil de Aleix Prat Marin', NULL, NULL, '2025-05-23 09:56:23', '2025-05-23 09:56:23'),
(36, 66, 'Ha aprovat la sol·licitud de premi #4 per a Aleix', NULL, NULL, '2025-05-24 08:38:09', '2025-05-24 08:38:09'),
(37, 66, 'Ha rebutjat la sol·licitud de premi #3 per a Aleix', NULL, NULL, '2025-05-24 08:38:16', '2025-05-24 08:38:16'),
(38, 66, 'Ha aprovat la sol·licitud de premi #3 per a Aleix amb codi de seguiment: TRK-BD2970E8', NULL, NULL, '2025-05-24 08:45:19', '2025-05-24 08:45:19'),
(39, 66, 'Ha actualitzat l\'estat del premi reclamat #2 a procesant', NULL, NULL, '2025-05-24 09:01:51', '2025-05-24 09:01:51'),
(40, 66, 'Ha creat un nou event: profa final', NULL, NULL, '2025-05-24 14:03:53', '2025-05-24 14:03:53'),
(41, 66, 'Ha eliminat event: profa final', NULL, NULL, '2025-05-24 14:04:03', '2025-05-24 14:04:03'),
(42, 66, 'Ha creat un nou usuari: PROVA FINAL PROVA', NULL, NULL, '2025-05-24 17:46:12', '2025-05-24 17:46:12'),
(43, 66, 'Ha actualitzat el perfil de PROVA FINAL33 PROVA33', NULL, NULL, '2025-05-24 17:46:58', '2025-05-24 17:46:58'),
(44, 66, 'Ha eliminat user: PROVA FINAL33 PROVA33', NULL, NULL, '2025-05-24 17:47:21', '2025-05-24 17:47:21'),
(45, 66, 'Ha creat un nou event: PROVA FINAL', NULL, NULL, '2025-05-24 17:47:59', '2025-05-24 17:47:59'),
(46, 66, 'Ha actualitzat l\'event: PROVA FINAL33', NULL, NULL, '2025-05-24 17:49:01', '2025-05-24 17:49:01'),
(47, 66, 'Ha eliminat event: PROVA FINAL33', NULL, NULL, '2025-05-24 17:49:19', '2025-05-24 17:49:19'),
(48, 66, 'Ha eliminat event: Taller de compostatge', NULL, NULL, '2025-05-24 17:49:25', '2025-05-24 17:49:25'),
(49, 60, 'Ha escanejat el codi 8423102210153 i ha guanyat 100 punts', NULL, NULL, '2025-05-25 15:35:54', '2025-05-25 15:35:54'),
(50, 60, 'Ha escanejat el codi 8423102210154 i ha guanyat 16 punts', NULL, NULL, '2025-05-25 15:37:50', '2025-05-25 15:37:50'),
(51, 60, 'Ha escanejat el codi 4002160092556 i ha guanyat 12 punts', NULL, NULL, '2025-05-25 15:39:33', '2025-05-25 15:39:33'),
(52, 60, 'Ha escanejat el codi 59713142 i ha guanyat 19 punts', NULL, NULL, '2025-05-25 15:48:31', '2025-05-25 15:48:31'),
(53, 60, 'Ha escanejat el codi 8411547001085 i ha guanyat 12 punts', NULL, NULL, '2025-05-25 15:48:52', '2025-05-25 15:48:52'),
(54, 60, 'Ha escanejat el codi 8411547001085 i ha guanyat 14 punts', NULL, NULL, '2025-05-25 16:03:57', '2025-05-25 16:03:57'),
(55, 60, 'Ha creat una nova alerta per al punt de recollida ID: 1', NULL, NULL, '2025-05-25 16:23:36', '2025-05-25 16:23:36'),
(56, 60, 'Ha creat una nova alerta per al punt de recollida ID: 2', NULL, NULL, '2025-05-25 16:40:35', '2025-05-25 16:40:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertes_punts_de_recollida`
--

CREATE TABLE `alertes_punts_de_recollida` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `punt_de_recollida_id` int(11) NOT NULL,
  `tipus_alerta_id` int(11) NOT NULL,
  `descripció` varchar(255) NOT NULL,
  `imatge` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alertes_punts_de_recollida`
--

INSERT INTO `alertes_punts_de_recollida` (`id`, `user_id`, `punt_de_recollida_id`, `tipus_alerta_id`, `descripció`, `imatge`, `created_at`, `updated_at`) VALUES
(1, 60, 3, 1, 'Contenidor ple', 'images/alertes_punts_de_recollida/contenidor_ple.jpg', '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(2, 60, 3, 2, 'Contenidor trencat', 'images/alertes_punts_de_recollida/contenidor_trencat.jpg', '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(3, 60, 4, 3, 'Problemes amb l’accés al punt', 'images/alertes_punts_de_recollida/problemes_acces.jpg', '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(6, 60, 1, 2, 'Esa trencat', 'images/alertes/alerta_1747988064_68302e60d7bf4.png', '2025-05-23 08:14:24', '2025-05-23 08:14:24'),
(7, 60, 1, 1, 'Falla el scanner', 'images/alertes/alerta_1748190216_6833440880818.JPG', '2025-05-25 16:23:36', '2025-05-25 16:23:36'),
(8, 60, 2, 1, 'hjmghjmjhg', 'images/alertes/alerta_1748191235_68334803265e3.jpg', '2025-05-25 16:40:35', '2025-05-25 16:40:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codis`
--

CREATE TABLE `codis` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `codi` varchar(255) DEFAULT NULL,
  `punts` int(11) DEFAULT 10,
  `data_escaneig` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codis`
--

INSERT INTO `codis` (`id`, `user_id`, `codi`, `punts`, `data_escaneig`) VALUES
(17, 60, '8423102210153', 100, '2025-05-25 15:35:53'),
(18, 60, 'https://msi.gm/Pulse-16-AI-C1VX-QR', 10, '2025-03-31 10:06:19'),
(19, 60, '8423102210154', 10, '2025-05-22 11:38:00'),
(22, NULL, '8423102210154', 102, '2025-05-22 11:48:00'),
(23, 60, '8423102210154', 16, '2025-05-25 15:37:50'),
(24, 60, '4002160092556', 12, '2025-05-25 15:39:32'),
(25, 60, '59713142', 19, '2025-05-25 15:48:31'),
(26, 60, '8411547001085', 12, '2025-05-25 15:48:52'),
(27, 60, '8411547001085', 14, '2025-05-25 16:03:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `descripcio` text DEFAULT NULL,
  `data_inici` datetime NOT NULL,
  `data_fi` datetime DEFAULT NULL,
  `lloc` varchar(255) DEFAULT NULL,
  `tipus_event_id` int(11) DEFAULT NULL,
  `capacitat` int(11) DEFAULT NULL,
  `punts_disponibles` int(11) DEFAULT NULL,
  `actiu` tinyint(1) DEFAULT 1,
  `imatge` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `nom`, `descripcio`, `data_inici`, `data_fi`, `lloc`, `tipus_event_id`, `capacitat`, `punts_disponibles`, `actiu`, `imatge`, `created_at`, `updated_at`) VALUES
(1, 'Recollida de RAEE al barri Gòtic', 'Porta els teus residus electrònics i guanya punts!', '2025-05-12 10:00:00', '2025-05-12 14:00:00', 'Plaça Reial, Barcelona', 1, 200, 5000, 1, 'events/JHKdODvmowt4NBFxsIRatjDVaMb7AJbTsHgxAWnc.jpg', '2025-05-09 07:36:41', '2025-05-22 10:35:15'),
(3, 'Campanya informativa sobre reciclatge de vidre', 'Descobreix què pots reciclar i què no!', '2025-06-10 09:00:00', '2025-06-10 18:00:00', 'Rambla del Raval', 3, NULL, 300, 1, 'events/neteja_parc.jpg', '2025-05-09 07:36:41', '2025-05-22 10:28:43'),
(4, 'sdfsdfsdfsd', 'prova de tot', '2025-10-22 15:20:00', '2025-10-22 23:30:00', 'Lleida', 2, NULL, 200, 1, 'events/default.jpg', '2025-05-22 10:17:50', '2025-05-22 10:28:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_user`
--

CREATE TABLE `event_user` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `punts` int(11) NOT NULL DEFAULT 0,
  `producte_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `event_user`
--

INSERT INTO `event_user` (`id`, `event_id`, `user_id`, `punts`, `producte_id`, `created_at`, `updated_at`) VALUES
(6, 3, 60, 0, NULL, '2025-05-09 08:21:48', '2025-05-09 08:21:48'),
(8, 3, 66, 0, NULL, '2025-05-15 06:42:08', '2025-05-15 06:42:08'),
(9, 1, 66, 0, NULL, '2025-05-19 08:20:52', '2025-05-19 08:20:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2025_04_29_092744_create_punts_de_recollida_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `navigator_infos`
--

CREATE TABLE `navigator_infos` (
  `id` int(11) NOT NULL,
  `app_code_name` varchar(255) DEFAULT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `app_version` varchar(255) DEFAULT NULL,
  `cookie_enabled` tinyint(1) DEFAULT NULL,
  `hardware_concurrency` int(11) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `languages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`languages`)),
  `max_touch_points` int(11) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `product_sub` varchar(255) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `vendor_sub` varchar(255) DEFAULT NULL,
  `screen_width` int(11) DEFAULT NULL,
  `screen_height` int(11) DEFAULT NULL,
  `screen_avail_width` int(11) DEFAULT NULL,
  `screen_avail_height` int(11) DEFAULT NULL,
  `screen_color_depth` int(11) DEFAULT NULL,
  `screen_pixel_depth` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `navigator_infos`
--

INSERT INTO `navigator_infos` (`id`, `app_code_name`, `app_name`, `app_version`, `cookie_enabled`, `hardware_concurrency`, `language`, `languages`, `max_touch_points`, `platform`, `product`, `product_sub`, `user_agent`, `vendor`, `vendor_sub`, `screen_width`, `screen_height`, `screen_avail_width`, `screen_avail_height`, `screen_color_depth`, `screen_pixel_depth`, `created_at`) VALUES
(1, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:39:48'),
(2, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:39:49'),
(3, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:39:51'),
(4, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:49:08'),
(5, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:52:01'),
(6, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:54:32'),
(7, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1375, 795, 1920, 1032, 24, 24, '2025-05-23 18:54:47'),
(8, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1375, 795, 1920, 1032, 24, 24, '2025-05-23 18:54:48'),
(9, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 400, 629, 400, 629, 24, 24, '2025-05-23 18:55:02'),
(10, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 400, 629, 400, 629, 24, 24, '2025-05-23 18:55:04'),
(11, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 400, 629, 400, 629, 24, 24, '2025-05-23 18:55:07'),
(12, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 1, 22, 'es', '[\"es\",\"es-ES\",\"en\",\"en-GB\",\"en-US\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Google Inc.', NULL, 1034, 850, 1920, 1032, 24, 24, '2025-05-23 18:55:29'),
(13, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 1, 22, 'es', '[\"es\",\"es-ES\",\"en\",\"en-GB\",\"en-US\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Google Inc.', NULL, 1912, 877, 1920, 1032, 24, 24, '2025-05-23 18:55:37'),
(14, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:55:39'),
(15, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 1, 22, 'es', '[\"es\",\"es-ES\",\"en\",\"en-GB\",\"en-US\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Google Inc.', NULL, 1912, 954, 1920, 1032, 24, 24, '2025-05-23 18:55:52'),
(16, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:59:04'),
(17, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 18:59:29'),
(18, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 18:59:39'),
(19, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 18:59:40'),
(20, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 18:59:41'),
(21, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 18:59:43'),
(22, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:46:54'),
(23, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:00'),
(24, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:05'),
(25, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 19:47:08'),
(26, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 19:47:10'),
(27, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:11'),
(28, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-23 19:47:13'),
(29, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:16'),
(30, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:22'),
(31, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:23'),
(32, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-23 19:47:39'),
(33, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:03:18'),
(34, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:03:22'),
(35, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:16:12'),
(36, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:16:21'),
(37, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1745, 828, 1920, 1032, 24, 24, '2025-05-24 08:18:32'),
(38, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:18:35'),
(39, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:27:54'),
(40, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:32:30'),
(41, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:33:02'),
(42, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:37:59'),
(43, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:38:02'),
(44, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:43:51'),
(45, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:45:15'),
(46, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:45:27'),
(47, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:49:22'),
(48, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:49:24'),
(49, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:53:07'),
(50, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:53:09'),
(51, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:53:09'),
(52, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 08:59:21'),
(53, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 09:01:51'),
(54, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 09:17:58'),
(55, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 09:39:57'),
(56, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 09:40:40'),
(57, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 09:40:43'),
(58, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 09:46:21'),
(59, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 10:08:23'),
(60, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 10:24:47'),
(61, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1012, 1920, 1032, 24, 24, '2025-05-24 10:34:22'),
(62, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:34:27'),
(63, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:34:30'),
(64, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:35:15'),
(65, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:35:26'),
(66, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:35:30'),
(67, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:36:57'),
(68, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:37:25'),
(69, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:37:27'),
(70, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:37:30'),
(71, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:37:38'),
(72, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:37:41'),
(73, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:37:44'),
(74, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:38:00'),
(75, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:38:11'),
(76, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:38:18'),
(77, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:39:48'),
(78, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 724, 1492, 400, 824, 24, 24, '2025-05-24 10:40:21'),
(79, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 400, 824, 400, 824, 24, 24, '2025-05-24 10:40:29'),
(80, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:41:03'),
(81, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:51:53'),
(82, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:53:37'),
(83, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:53:57'),
(84, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:54:07'),
(85, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:54:38'),
(86, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 10:57:18'),
(87, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:02:03'),
(88, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:02:59'),
(89, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:03:30'),
(90, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:05:32'),
(91, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:05:38'),
(92, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:05:44'),
(93, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:05:58'),
(94, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:07:52'),
(95, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:07:58'),
(96, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:08:07'),
(97, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:08:13'),
(98, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:08:58'),
(99, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:09:47'),
(100, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:09:49'),
(101, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:09:52'),
(102, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:09:58'),
(103, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:13:46'),
(104, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:13:51'),
(105, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:20:44'),
(106, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:20:46'),
(107, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:20:51'),
(108, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:25:43'),
(109, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:26:14'),
(110, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:28:46'),
(111, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:29:07'),
(112, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:29:24'),
(113, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:29:39'),
(114, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:30:26'),
(115, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:30:49'),
(116, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:31:26'),
(117, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:32:42'),
(118, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:33:16'),
(119, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:33:23'),
(120, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:33:58'),
(121, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:34:29'),
(122, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:35:00'),
(123, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:35:33'),
(124, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:36:06');
INSERT INTO `navigator_infos` (`id`, `app_code_name`, `app_name`, `app_version`, `cookie_enabled`, `hardware_concurrency`, `language`, `languages`, `max_touch_points`, `platform`, `product`, `product_sub`, `user_agent`, `vendor`, `vendor_sub`, `screen_width`, `screen_height`, `screen_avail_width`, `screen_avail_height`, `screen_color_depth`, `screen_pixel_depth`, `created_at`) VALUES
(125, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:36:39'),
(126, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:36:51'),
(127, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:37:25'),
(128, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:37:39'),
(129, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:37:50'),
(130, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:40:10'),
(131, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:40:21'),
(132, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:40:27'),
(133, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:41:29'),
(134, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:41:31'),
(135, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:41:34'),
(136, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:41:45'),
(137, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:43:58'),
(138, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:44:09'),
(139, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:44:22'),
(140, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:44:33'),
(141, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:44:45'),
(142, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:46:10'),
(143, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:46:21'),
(144, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:46:33'),
(145, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:46:45'),
(146, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:46:56'),
(147, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 11:47:03'),
(148, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 13:14:21'),
(149, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 13:14:23'),
(150, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 13:14:38'),
(151, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 13:14:44'),
(152, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 13:15:44'),
(153, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 13:33:50'),
(154, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:02:57'),
(155, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:03:54'),
(156, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:04:07'),
(157, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:42:41'),
(158, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:42:52'),
(159, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:43:03'),
(160, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:44:09'),
(161, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:44:12'),
(162, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 14:53:40'),
(163, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:45:48'),
(164, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:46:13'),
(165, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:46:22'),
(166, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:46:59'),
(167, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:47:28'),
(168, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:48:00'),
(169, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:49:02'),
(170, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:49:29'),
(171, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 17:59:34'),
(172, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:00:05'),
(173, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:02:52'),
(174, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:03:27'),
(175, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:03:30'),
(176, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:05:25'),
(177, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:05:54'),
(178, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:06:05'),
(179, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:12:36'),
(180, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:12:53'),
(181, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:13:05'),
(182, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:13:17'),
(183, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:13:22'),
(184, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:13:34'),
(185, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:21:33'),
(186, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:22:04'),
(187, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 18:22:16'),
(188, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:09:07'),
(189, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:09:09'),
(190, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:26:42'),
(191, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:26:49'),
(192, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:27:13'),
(193, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:27:14'),
(194, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:28:15'),
(195, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:28:24'),
(196, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:35:31'),
(197, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:38:00'),
(198, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:38:28'),
(199, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:41:10'),
(200, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:42:40'),
(201, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:43:21'),
(202, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:44:30'),
(203, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:44:35'),
(204, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:45:52'),
(205, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:45:57'),
(206, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:46:04'),
(207, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 20:46:04'),
(208, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 724, 1492, 400, 824, 24, 24, '2025-05-24 20:52:19'),
(209, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 400, 824, 400, 824, 24, 24, '2025-05-24 20:52:24'),
(210, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 724, 1492, 400, 824, 24, 24, '2025-05-24 20:55:26'),
(211, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 724, 1492, 400, 824, 24, 24, '2025-05-24 21:03:54'),
(212, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 724, 1492, 400, 824, 24, 24, '2025-05-24 21:21:55'),
(213, 'Mozilla', 'Netscape', '5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 1, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Google Inc.', NULL, 724, 1492, 400, 824, 24, 24, '2025-05-24 21:22:05'),
(214, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:33:24'),
(215, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:36:04'),
(216, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:38:46'),
(217, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:40:14'),
(218, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:40:39'),
(219, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:40:53'),
(220, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 21:49:37'),
(221, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:03:40'),
(222, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:07:29'),
(223, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:15:54'),
(224, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:15:55'),
(225, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:17:24'),
(226, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:17:44'),
(227, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:18:19'),
(228, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:19:00'),
(229, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:19:14'),
(230, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:19:28'),
(231, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:19:42'),
(232, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 1080, 1920, 1032, 24, 24, '2025-05-24 22:19:55'),
(233, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:21:19'),
(234, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:22:29'),
(235, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:23:02'),
(236, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:24:52'),
(237, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:27:59'),
(238, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:30:15'),
(239, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:30:39'),
(240, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:31:20'),
(241, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:31:43'),
(242, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:31:56'),
(243, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:32:05'),
(244, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:32:18'),
(245, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:34:50'),
(246, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:36:59'),
(247, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:38:44'),
(248, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:43:31');
INSERT INTO `navigator_infos` (`id`, `app_code_name`, `app_name`, `app_version`, `cookie_enabled`, `hardware_concurrency`, `language`, `languages`, `max_touch_points`, `platform`, `product`, `product_sub`, `user_agent`, `vendor`, `vendor_sub`, `screen_width`, `screen_height`, `screen_avail_width`, `screen_avail_height`, `screen_color_depth`, `screen_pixel_depth`, `created_at`) VALUES
(249, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:46:15'),
(250, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:46:15'),
(251, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:49:03'),
(252, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:49:12'),
(253, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:49:13'),
(254, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:51:02'),
(255, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:51:11'),
(256, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:51:18'),
(257, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:52:22'),
(258, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:52:22'),
(259, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:52:25'),
(260, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:52:34'),
(261, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:52:36'),
(262, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:55:21'),
(263, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:56:20'),
(264, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:56:47'),
(265, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:56:52'),
(266, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:56:54'),
(267, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:56:58'),
(268, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:57:16'),
(269, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:57:18'),
(270, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:57:23'),
(271, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:57:42'),
(272, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:57:46'),
(273, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:05'),
(274, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:13'),
(275, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:17'),
(276, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:22'),
(277, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:25'),
(278, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:54'),
(279, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:58:59'),
(280, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 22:59:57'),
(281, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:00:04'),
(282, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:00:32'),
(283, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:14:46'),
(284, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:15:02'),
(285, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:15:37'),
(286, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 2133, 1018, 1920, 1032, 24, 24, '2025-05-24 23:16:04'),
(287, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:16:16'),
(288, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:16:31'),
(289, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:16:52'),
(290, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:17:02'),
(291, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:17:13'),
(292, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:18:17'),
(293, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:18:23'),
(294, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:24:48'),
(295, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:24:56'),
(296, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:26:59'),
(297, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:27:53'),
(298, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:28:27'),
(299, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:29:05'),
(300, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:32:29'),
(301, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:33:09'),
(302, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:35:26'),
(303, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'es-ES', '[\"es-ES\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 917, 1920, 1032, 24, 24, '2025-05-24 23:39:21'),
(304, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:42:57'),
(305, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:43:03'),
(306, 'Mozilla', 'Netscape', '5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 1, 22, 'ca', '[\"ca\",\"en\",\"es\"]', 0, 'Win32', 'Gecko', '20030107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Google Inc.', NULL, 1920, 911, 1920, 1032, 24, 24, '2025-05-24 23:43:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivells`
--

CREATE TABLE `nivells` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `punts_requerits` int(11) NOT NULL,
  `descripcio` text DEFAULT NULL,
  `icona` varchar(255) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivells`
--

INSERT INTO `nivells` (`id`, `nom`, `punts_requerits`, `descripcio`, `icona`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Principiant', 0, 'Nivell inicial per a tots els usuaris', 'fas fa-seedling', '#4CAF50', '2025-05-15 09:37:29', '2025-05-15 09:37:29'),
(2, 'Aprenent', 100, 'Has començat el teu camí cap a un món més sostenible', 'fas fa-leaf', '#8BC34A', '2025-05-15 09:37:29', '2025-05-15 09:37:29'),
(3, 'Reciclador', 500, 'Estàs fent una diferència real en el medi ambient', 'fas fa-recycle', '#00BCD4', '2025-05-15 09:37:29', '2025-05-15 09:37:29'),
(4, 'Expert', 1000, 'La teva contribució és molt valuosa per al planeta', 'fas fa-award', '#3F51B5', '2025-05-15 09:37:29', '2025-05-15 09:37:29'),
(5, 'Mestre', 2500, 'Ets un exemple a seguir en sostenibilitat', 'fas fa-crown', '#FFC107', '2025-05-15 09:37:29', '2025-05-15 09:37:29'),
(6, 'Llegenda', 5000, 'Has assolit el màxim nivell de conscienciació ambiental', 'fas fa-star', '#FF5722', '2025-05-15 09:37:29', '2025-05-15 09:37:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opinions`
--

CREATE TABLE `opinions` (
  `id` int(11) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `comentari` text NOT NULL,
  `estrelles` decimal(2,1) NOT NULL CHECK (`estrelles` >= 1 and `estrelles` <= 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opinions`
--

INSERT INTO `opinions` (`id`, `autor`, `comentari`, `estrelles`, `created_at`, `updated_at`) VALUES
(1, 'Maria P.', 'M\'encanta aquest servei, és increïble!', 4.8, '2025-04-16 10:40:20', '2025-04-16 10:40:20'),
(2, 'Joan G.', 'Un servei excel·lent, molt recomanable.', 4.5, '2025-04-16 10:40:20', '2025-04-16 10:40:20'),
(3, 'Anna R.', 'La millor experiència que he tingut mai!', 5.0, '2025-04-16 10:40:20', '2025-04-16 10:40:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('alemusicaria@gmail.com', '$2y$12$gEN11kDgK31vg2f5yP407em2eM/vryW1pZAYfqI3Blu6blpN0qNly', '2025-05-25 17:14:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premis`
--

CREATE TABLE `premis` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `descripcio` text DEFAULT NULL,
  `punts_requerits` int(11) DEFAULT NULL,
  `imatge` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `premis`
--

INSERT INTO `premis` (`id`, `nom`, `descripcio`, `punts_requerits`, `imatge`) VALUES
(11, 'Tablet', 'Tablet nova', 3000, 'images/Premis/tablet.jpg'),
(12, 'Moto elèctrica', 'Moto elètrica marca bmw', 10000, 'images/Premis/moto_elèctrica.png'),
(13, 'Patinet elèctric', 'marca tesla', 2000, 'images/Premis/patinet_elèctric.jpg'),
(14, 'bicicleta', 'bicileta nova per estreanr', 40000, 'images/Premis/bicicleta.jpg'),
(15, 'motxilla', 'motxillal per a sortir exterior', 200, 'images/Premis/motxilla.jpg'),
(16, 'provaº', 'dsfds', 23, 'images/Premis/provaº.jpg'),
(17, 'holas', 'shdfhds', 23, 'images/Premis/holas.JPG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premis_reclamats`
--

CREATE TABLE `premis_reclamats` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `premi_id` int(11) NOT NULL,
  `punts_gastats` int(11) NOT NULL,
  `data_reclamacio` timestamp NOT NULL DEFAULT current_timestamp(),
  `estat` enum('pendent','procesant','entregat','cancelat') NOT NULL DEFAULT 'pendent',
  `codi_seguiment` varchar(255) DEFAULT NULL,
  `comentaris` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `premis_reclamats`
--

INSERT INTO `premis_reclamats` (`id`, `user_id`, `premi_id`, `punts_gastats`, `data_reclamacio`, `estat`, `codi_seguiment`, `comentaris`, `created_at`, `updated_at`) VALUES
(1, 60, 15, 200, '2023-04-15 08:30:00', 'entregat', 'REC-2023-0415-3928', 'Entregat al domicili el dia 25/04/2023. Signat pel destinatari.', '2023-04-15 08:30:00', '2023-04-26 07:15:23'),
(2, 60, 16, 23, '2023-05-07 14:45:12', 'procesant', 'REC-2023-0507-6421', 'En procés d\'enviament. Preparat el paquet i pendent de recollida per l\'empresa de transport. A', '2023-05-07 14:45:12', '2025-05-24 09:01:50'),
(3, 66, 17, 23, '2025-05-15 07:24:20', 'procesant', 'TRK-BD2970E8', 'Sol·licitud rebutjada el 24/05/2025 10:38 per Aleix', '2025-05-15 07:24:20', '2025-05-24 08:45:19'),
(4, 66, 17, 23, '2025-05-15 07:30:39', 'procesant', NULL, NULL, '2025-05-15 07:30:39', '2025-05-24 08:38:08'),
(5, 66, 17, 23, '2025-05-24 23:53:28', 'pendent', NULL, NULL, '2025-05-24 23:53:28', '2025-05-24 23:53:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productes`
--

CREATE TABLE `productes` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `categoria` enum('Deixalleria','Envasos','Especial','Medicaments','Organica','Paper','Piles','RAEE','Resta','Vidre') NOT NULL,
  `imatge` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productes`
--

INSERT INTO `productes` (`id`, `nom`, `categoria`, `imatge`, `created_at`, `updated_at`) VALUES
(1, 'Bolígraf', 'Deixalleria', 'images/Reciclatge/Deixalleria/boligraf.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(2, 'Càpsules de cafè', 'Deixalleria', 'images/Reciclatge/Deixalleria/cafe_capsules.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(3, 'Cassola', 'Deixalleria', 'images/Reciclatge/Deixalleria/cassola.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(4, 'CD/DVD', 'Deixalleria', 'images/Reciclatge/Deixalleria/cd_dvd.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(5, 'Cendrer de vidre', 'Deixalleria', 'images/Reciclatge/Deixalleria/cendrer_vidre.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(6, 'Cistell', 'Deixalleria', 'images/Reciclatge/Deixalleria/cistell.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(7, 'Coberts', 'Deixalleria', 'images/Reciclatge/Deixalleria/coberts.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(8, 'Xeringa', 'Deixalleria', 'images/Reciclatge/Deixalleria/deixalleria_xeringa.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(9, 'Disc de vinil', 'Deixalleria', 'images/Reciclatge/Deixalleria/disc_vinil.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(10, 'Espiral de llibreta', 'Deixalleria', 'images/Reciclatge/Deixalleria/espiral_llibreta.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(11, 'Fotos o diapositives', 'Deixalleria', 'images/Reciclatge/Deixalleria/fotos_diapos.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(12, 'Galleda', 'Deixalleria', 'images/Reciclatge/Deixalleria/galleda.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(13, 'Gerro de ceràmica', 'Deixalleria', 'images/Reciclatge/Deixalleria/gerro_ceramica.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(14, 'Joguines', 'Deixalleria', 'images/Reciclatge/Deixalleria/joguines.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(15, 'Mànega', 'Deixalleria', 'images/Reciclatge/Deixalleria/manega.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(16, 'Matalàs', 'Deixalleria', 'images/Reciclatge/Deixalleria/matalas.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(17, 'Mirall', 'Deixalleria', 'images/Reciclatge/Deixalleria/mirall.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(18, 'Mobles de fusta', 'Deixalleria', 'images/Reciclatge/Deixalleria/moble_fusta.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(19, 'Oli de cotxe', 'Deixalleria', 'images/Reciclatge/Deixalleria/oli_cotxe.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(20, 'Oli de cuina', 'Deixalleria', 'images/Reciclatge/Deixalleria/oli_cuina.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(21, 'Paella', 'Deixalleria', 'images/Reciclatge/Deixalleria/paella.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(22, 'Penjador de plàstic', 'Deixalleria', 'images/Reciclatge/Deixalleria/penjador_plastic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(23, 'Pintura', 'Deixalleria', 'images/Reciclatge/Deixalleria/pintura.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(24, 'Pinzell', 'Deixalleria', 'images/Reciclatge/Deixalleria/pinzell.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(25, 'Plats', 'Deixalleria', 'images/Reciclatge/Deixalleria/plats.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(26, 'Pneumàtic', 'Deixalleria', 'images/Reciclatge/Deixalleria/pneumatic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(27, 'Porro', 'Deixalleria', 'images/Reciclatge/Deixalleria/porro.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(28, 'Radiografia', 'Deixalleria', 'images/Reciclatge/Deixalleria/radiografia.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(29, 'Rodet de fotos', 'Deixalleria', 'images/Reciclatge/Deixalleria/rodet_fotos.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(30, 'Runa', 'Deixalleria', 'images/Reciclatge/Deixalleria/runa.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(31, 'Termòmetre', 'Deixalleria', 'images/Reciclatge/Deixalleria/termometre.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(32, 'Test de ceràmica', 'Deixalleria', 'images/Reciclatge/Deixalleria/test_ceramica.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(33, 'Test de plàstic', 'Deixalleria', 'images/Reciclatge/Deixalleria/test_plastic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(34, 'Tòner', 'Deixalleria', 'images/Reciclatge/Deixalleria/toner.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(35, 'Tub de PVC', 'Deixalleria', 'images/Reciclatge/Deixalleria/tub_pvc.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(36, 'Vernís', 'Deixalleria', 'images/Reciclatge/Deixalleria/vernis.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(37, 'Vidre de marc', 'Deixalleria', 'images/Reciclatge/Deixalleria/vidre_marc.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(38, 'Vidre pla', 'Deixalleria', 'images/Reciclatge/Deixalleria/vidre_pla.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(39, 'Aerosol', 'Envasos', 'images/Reciclatge/Envasos/aerosol.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(40, 'Ampolla de plàstic', 'Envasos', 'images/Reciclatge/Envasos/ampolla_plastic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(41, 'Blíster', 'Envasos', 'images/Reciclatge/Envasos/blister.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(42, 'Bossa d\'aperitiu', 'Envasos', 'images/Reciclatge/Envasos/bossa_aperitiu.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(43, 'Bossa de congelats', 'Envasos', 'images/Reciclatge/Envasos/bossa_congelats.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(44, 'Bossa de plàstic', 'Envasos', 'images/Reciclatge/Envasos/bossa_plastic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(45, 'Bric', 'Envasos', 'images/Reciclatge/Envasos/bric.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(46, 'Caixa de fusta', 'Envasos', 'images/Reciclatge/Envasos/caixa_fusta.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(47, 'Capsa de metall per galetes', 'Envasos', 'images/Reciclatge/Envasos/capsa_metall_galetes.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(48, 'Capsa de puros', 'Envasos', 'images/Reciclatge/Envasos/capsa_puros.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(49, 'Cartutxos de cera depilatòria', 'Envasos', 'images/Reciclatge/Envasos/cartutxos_cera_depilatoria.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(50, 'Desodorant', 'Envasos', 'images/Reciclatge/Envasos/desodorant.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(51, 'Embolcall de film d\'alumini', 'Envasos', 'images/Reciclatge/Envasos/embolcall_film_alumini.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(52, 'Embolcall de mocadors de paper', 'Envasos', 'images/Reciclatge/Envasos/embolcall_mocadors_paper.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(53, 'Envàs d\'aliments a granel', 'Envasos', 'images/Reciclatge/Envasos/envas_aliments_granel.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(54, 'Iogurt de plàstic', 'Envasos', 'images/Reciclatge/Envasos/iogurt_plastic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(55, 'Llauna', 'Envasos', 'images/Reciclatge/Envasos/llauna.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(56, 'Llauna de conserva', 'Envasos', 'images/Reciclatge/Envasos/llauna_conserva.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(57, 'Llaunes de ferro', 'Envasos', 'images/Reciclatge/Envasos/llaunes_ferro.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(58, 'Monodosi', 'Envasos', 'images/Reciclatge/Envasos/monodosi.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(59, 'Pot de gel', 'Envasos', 'images/Reciclatge/Envasos/pot_gel.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(60, 'Precinte de cava', 'Envasos', 'images/Reciclatge/Envasos/precinte_cava.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(61, 'Safata d\'alumini', 'Envasos', 'images/Reciclatge/Envasos/safata_alumini.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(62, 'Safata de bombons', 'Envasos', 'images/Reciclatge/Envasos/safata_bombons.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(63, 'Safata de porexpan', 'Envasos', 'images/Reciclatge/Envasos/safata_porex.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(64, 'Tapa de iogurt', 'Envasos', 'images/Reciclatge/Envasos/tapa_iogurt.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(65, 'Taps metàl·lics', 'Envasos', 'images/Reciclatge/Envasos/taps_metalics.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(66, 'Taps de plàstic', 'Envasos', 'images/Reciclatge/Envasos/taps_plastic.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(67, 'Tap de pots', 'Envasos', 'images/Reciclatge/Envasos/tap_pots.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(68, 'Tub de pasta de dents', 'Envasos', 'images/Reciclatge/Envasos/tub_dents.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(69, 'Xarxa de fruita', 'Envasos', 'images/Reciclatge/Envasos/xarxa_fruita.jpg', '2025-04-03 10:58:57', '2025-04-03 10:58:57'),
(70, 'Fibrociment', 'Especial', 'images/Reciclatge/Especial/fibrociment.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(71, 'Capsa de medicaments', 'Medicaments', 'images/Reciclatge/Medicaments/capsa_medicaments.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(72, 'Flascó de medicaments', 'Medicaments', 'images/Reciclatge/Medicaments/flasco_medicaments.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(73, 'Medicaments', 'Medicaments', 'images/Reciclatge/Medicaments/medicaments.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(74, 'Tub de medicaments', 'Medicaments', 'images/Reciclatge/Medicaments/tub_medicaments.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(75, 'Aliment', 'Organica', 'images/Reciclatge/Organica/aliment.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(76, 'Cafè filtre', 'Organica', 'images/Reciclatge/Organica/cafe_filtre.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(77, 'Cafè marro', 'Organica', 'images/Reciclatge/Organica/cafe_marro.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(78, 'Closques', 'Organica', 'images/Reciclatge/Organica/closques.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(79, 'Escuradents', 'Organica', 'images/Reciclatge/Organica/escuradents.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(80, 'Excrements', 'Organica', 'images/Reciclatge/Organica/excrements.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(81, 'Flors', 'Organica', 'images/Reciclatge/Organica/flors.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(82, 'Gespa', 'Organica', 'images/Reciclatge/Organica/gespa.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(83, 'Infusions', 'Organica', 'images/Reciclatge/Organica/infusions.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(84, 'Lluminers de fusta', 'Organica', 'images/Reciclatge/Organica/llumins_fusta.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(85, 'Paper de magdalenes', 'Organica', 'images/Reciclatge/Organica/paper_magdalenes.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(86, 'Pinyols', 'Organica', 'images/Reciclatge/Organica/pinyols.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(87, 'Restes de menjar', 'Organica', 'images/Reciclatge/Organica/restes_menjar.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(88, 'Taps de suro', 'Organica', 'images/Reciclatge/Organica/taps_suro.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(89, 'Terra', 'Organica', 'images/Reciclatge/Organica/terra.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(90, 'Tovalló de paper', 'Organica', 'images/Reciclatge/Organica/tovallo_paper.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(91, 'Bossa de paper', 'Paper', 'images/Reciclatge/Paper/bossa_paper.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(92, 'Caixa de sabates', 'Paper', 'images/Reciclatge/Paper/caixa_sabates.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(93, 'Capsa de cartró', 'Paper', 'images/Reciclatge/Paper/capsa_cartro.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(94, 'Capsa de cereals', 'Paper', 'images/Reciclatge/Paper/capsa_cereals.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(95, 'Etiqueta de paper', 'Paper', 'images/Reciclatge/Paper/etiqueta_paper.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(96, 'Fulls de paper', 'Paper', 'images/Reciclatge/Paper/fulls_paper.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(97, 'Paper de capsa de bombons', 'Paper', 'images/Reciclatge/Paper/paper_capsa_bombons.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(98, 'Paper cartró aliments', 'Paper', 'images/Reciclatge/Paper/paper_cartro_aliments.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(99, 'Paper monodosi', 'Paper', 'images/Reciclatge/Paper/paper_monodosi.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(100, 'Paper de pastís', 'Paper', 'images/Reciclatge/Paper/paper_pastis.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(101, 'Paper de regal', 'Paper', 'images/Reciclatge/Paper/paper_regal.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(102, 'Premsa', 'Paper', 'images/Reciclatge/Paper/premsa.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(103, 'Revista', 'Paper', 'images/Reciclatge/Paper/revista.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(104, 'Sobre de paper', 'Paper', 'images/Reciclatge/Paper/sobre_paper.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(105, 'Bateria de cotxe', 'Piles', 'images/Reciclatge/Piles/bateria_cotxe.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(106, 'Piles alcalines', 'Piles', 'images/Reciclatge/Piles/piles_alcalines.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(107, 'Piles de bateria', 'Piles', 'images/Reciclatge/Piles/piles_bateria.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(108, 'Piles de botó', 'Piles', 'images/Reciclatge/Piles/piles_boto.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(109, 'Piles de liti', 'Piles', 'images/Reciclatge/Piles/piles_liti.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(110, 'Piles de níquel', 'Piles', 'images/Reciclatge/Piles/piles_niquel.jpg', '2025-04-03 11:02:46', '2025-04-03 11:02:46'),
(111, 'Aire condicionat', 'RAEE', 'images/Reciclatge/RAEE/aire_condicionat.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(112, 'Altaveu', 'RAEE', 'images/Reciclatge/RAEE/altaveu.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(113, 'Amplificador', 'RAEE', 'images/Reciclatge/RAEE/amplificador.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(114, 'Aparells de cuina', 'RAEE', 'images/Reciclatge/RAEE/aparells_cuina.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(115, 'Aparells mèdics', 'RAEE', 'images/Reciclatge/RAEE/aparells_medics.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(116, 'Aparell d’aire', 'RAEE', 'images/Reciclatge/RAEE/aparell_aire.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(117, 'Aspirador', 'RAEE', 'images/Reciclatge/RAEE/aspirador.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(118, 'Assecador de cabell', 'RAEE', 'images/Reciclatge/RAEE/assecador_cabell.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(119, 'Auricular', 'RAEE', 'images/Reciclatge/RAEE/auricular.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(120, 'Bàscula', 'RAEE', 'images/Reciclatge/RAEE/bascula.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(121, 'Batedora', 'RAEE', 'images/Reciclatge/RAEE/batedora.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(122, 'Cafetera elèctrica', 'RAEE', 'images/Reciclatge/RAEE/cafetera_electrica.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(123, 'Calculadora', 'RAEE', 'images/Reciclatge/RAEE/calculadora.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(124, 'Caldera termo', 'RAEE', 'images/Reciclatge/RAEE/caldera_termo.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(125, 'Càmera de fotos', 'RAEE', 'images/Reciclatge/RAEE/camera_fotos.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(126, 'Carregador', 'RAEE', 'images/Reciclatge/RAEE/carregador.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(127, 'Cartutxos d’impressora', 'RAEE', 'images/Reciclatge/RAEE/cartutxos_impressora.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(128, 'Consola de videojoc', 'RAEE', 'images/Reciclatge/RAEE/consola_videojoc.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(129, 'Cuines vitroceràmiques', 'RAEE', 'images/Reciclatge/RAEE/cuines_vitro.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(130, 'Dispositiu TPV', 'RAEE', 'images/Reciclatge/RAEE/dispositiu_tpv.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(131, 'Eines elèctriques', 'RAEE', 'images/Reciclatge/RAEE/eines_electriques.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(132, 'Endolls i interruptors', 'RAEE', 'images/Reciclatge/RAEE/endolls_interruptors.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(133, 'Equips de música', 'RAEE', 'images/Reciclatge/RAEE/equips_musica.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(134, 'Equip esportiu', 'RAEE', 'images/Reciclatge/RAEE/equip_esportiu.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(135, 'Estufes i radiadors', 'RAEE', 'images/Reciclatge/RAEE/estufes_radiadors.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(136, 'Forn microones', 'RAEE', 'images/Reciclatge/RAEE/forn_microones.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(137, 'Impressores i fotocopiadores', 'RAEE', 'images/Reciclatge/RAEE/impressores_fotocopiadora.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(138, 'Instruments de música', 'RAEE', 'images/Reciclatge/RAEE/instruments_musica.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(139, 'Joguina elèctrica', 'RAEE', 'images/Reciclatge/RAEE/joguina_electrica.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(140, 'Làmpades', 'RAEE', 'images/Reciclatge/RAEE/lampades.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(141, 'Llibre electrònic', 'RAEE', 'images/Reciclatge/RAEE/llibre_electronic.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(142, 'Lluminàries', 'RAEE', 'images/Reciclatge/RAEE/lluminaries.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(143, 'Màquina d’afaitar', 'RAEE', 'images/Reciclatge/RAEE/maquina_afeitar.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(144, 'Màquina de cosir', 'RAEE', 'images/Reciclatge/RAEE/maquina_cosir.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(145, 'Micròfon', 'RAEE', 'images/Reciclatge/RAEE/microfon.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(146, 'Mòbils', 'RAEE', 'images/Reciclatge/RAEE/mobils.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(147, 'Navegador', 'RAEE', 'images/Reciclatge/RAEE/navegador.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(148, 'Nevera', 'RAEE', 'images/Reciclatge/RAEE/nevera.jpg', '2025-04-03 11:03:27', '2025-04-03 11:03:27'),
(149, 'Ordinador', 'RAEE', 'images/Reciclatge/RAEE/ordinador.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(150, 'Pantalles de TV', 'RAEE', 'images/Reciclatge/RAEE/pantalles_tv.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(151, 'Planxa de cabell', 'RAEE', 'images/Reciclatge/RAEE/planxa_cabell.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(152, 'Planxa de roba', 'RAEE', 'images/Reciclatge/RAEE/planxa_roba.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(153, 'Ràdio', 'RAEE', 'images/Reciclatge/RAEE/radio.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(154, 'Raspall de dents', 'RAEE', 'images/Reciclatge/RAEE/raspall_dents.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(155, 'Rellotge de piles', 'RAEE', 'images/Reciclatge/RAEE/rellotge_piles.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(156, 'Rentadora', 'RAEE', 'images/Reciclatge/RAEE/rentadora.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(157, 'Rentavaixelles', 'RAEE', 'images/Reciclatge/RAEE/rentavaixelles.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(158, 'Reproductors de vídeo/DVD', 'RAEE', 'images/Reciclatge/RAEE/reproductors_video_dvd.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(159, 'Robot de cuina', 'RAEE', 'images/Reciclatge/RAEE/robot_cuina.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(160, 'Router', 'RAEE', 'images/Reciclatge/RAEE/router.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(161, 'Tablet i marcs digitals', 'RAEE', 'images/Reciclatge/RAEE/tablet_marcs.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(162, 'Targeta de memòria', 'RAEE', 'images/Reciclatge/RAEE/targeta_memoria.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(163, 'Teclats i ratolins', 'RAEE', 'images/Reciclatge/RAEE/teclats_ratolins.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(164, 'Televisor', 'RAEE', 'images/Reciclatge/RAEE/televisor.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(165, 'Termòstat', 'RAEE', 'images/Reciclatge/RAEE/termostat.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(166, 'Torradores', 'RAEE', 'images/Reciclatge/RAEE/torradores.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(167, 'Transformador', 'RAEE', 'images/Reciclatge/RAEE/transformador.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(168, 'Ventilador', 'RAEE', 'images/Reciclatge/RAEE/ventilador.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(169, 'Afaitar', 'Resta', 'images/Reciclatge/Resta/afaitar.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(170, 'Agulla de cosir', 'Resta', 'images/Reciclatge/Resta/agulla_cosir.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(171, 'Baieta', 'Resta', 'images/Reciclatge/Resta/baieta.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(172, 'Bastons d’orelles', 'Resta', 'images/Reciclatge/Resta/bastons_orelles.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(173, 'Biberó', 'Resta', 'images/Reciclatge/Resta/bibero.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(174, 'Bijuteria', 'Resta', 'images/Reciclatge/Resta/bijuteria.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(175, 'Bolquers de cel·lulosa', 'Resta', 'images/Reciclatge/Resta/bolquers_celulosa.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(176, 'Bombeta de filament', 'Resta', 'images/Reciclatge/Resta/bombeta_filament.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(177, 'Bossa d’escombraries', 'Resta', 'images/Reciclatge/Resta/bossa_escombraries.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(178, 'Brides de plàstic', 'Resta', 'images/Reciclatge/Resta/brides_plastic.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(179, 'Cendrer de plàstic', 'Resta', 'images/Reciclatge/Resta/cendrer_plastic.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(180, 'Cendrer de porcellana', 'Resta', 'images/Reciclatge/Resta/cendrer_porcellana.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(181, 'Cera', 'Resta', 'images/Reciclatge/Resta/cera.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(182, 'Cigarret', 'Resta', 'images/Reciclatge/Resta/cigarret.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(183, 'Cintes de regal', 'Resta', 'images/Reciclatge/Resta/cintes_regal.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(184, 'Clips metàl·lics', 'Resta', 'images/Reciclatge/Resta/clips_metalics.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(185, 'Cotó', 'Resta', 'images/Reciclatge/Resta/coto.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(186, 'Encenedor', 'Resta', 'images/Reciclatge/Resta/encenedor.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(187, 'Etiqueta adhesiva', 'Resta', 'images/Reciclatge/Resta/etiqueta_adhesiva.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(188, 'Goma d’esborrar', 'Resta', 'images/Reciclatge/Resta/goma_esborrar.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(189, 'Gots de plàstic', 'Resta', 'images/Reciclatge/Resta/gots_plastic.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(190, 'Got de vidre', 'Resta', 'images/Reciclatge/Resta/got_vidre.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(191, 'Guants', 'Resta', 'images/Reciclatge/Resta/guants.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(192, 'Llapis', 'Resta', 'images/Reciclatge/Resta/llapis.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(193, 'Llimador d’ungles', 'Resta', 'images/Reciclatge/Resta/llima_ungles.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(194, 'Màquina de fer punta', 'Resta', 'images/Reciclatge/Resta/maquina_ferpunta.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(195, 'Mascareta', 'Resta', 'images/Reciclatge/Resta/mascareta.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(196, 'Mitges', 'Resta', 'images/Reciclatge/Resta/mitges.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(197, 'Palleta de refresc', 'Resta', 'images/Reciclatge/Resta/palleta_refresc.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(198, 'Pal d’escombra', 'Resta', 'images/Reciclatge/Resta/pal_escombra.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(199, 'Pal de fregar', 'Resta', 'images/Reciclatge/Resta/pal_fregar.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(200, 'Paper plastificat', 'Resta', 'images/Reciclatge/Resta/paper_plastificat.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(201, 'Pols d’escombrar', 'Resta', 'images/Reciclatge/Resta/pols_escombrar.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(202, 'Precinte adhesiu', 'Resta', 'images/Reciclatge/Resta/precinte_adhesiu.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(203, 'Preservatiu', 'Resta', 'images/Reciclatge/Resta/preservatiu.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(204, 'Raspall de dents', 'Resta', 'images/Reciclatge/Resta/raspall_dents.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(205, 'Sorral de gat', 'Resta', 'images/Reciclatge/Resta/sorra_gat.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(206, 'Tovalloletes', 'Resta', 'images/Reciclatge/Resta/tovalloletes.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(207, 'Ulleres', 'Resta', 'images/Reciclatge/Resta/ulleres.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(208, 'Xiclet', 'Resta', 'images/Reciclatge/Resta/xiclet.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(209, 'Xinxeta', 'Resta', 'images/Reciclatge/Resta/xinxeta.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(210, 'Xumet', 'Resta', 'images/Reciclatge/Resta/xumet.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(211, 'Ampolla de vidre', 'Vidre', 'images/Reciclatge/Vidre/ampolla_vidre.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(212, 'Colònia', 'Vidre', 'images/Reciclatge/Vidre/colonia.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(213, 'Iogurt de vidre', 'Vidre', 'images/Reciclatge/Vidre/iogurt_vidre.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(214, 'Pot de conserva', 'Vidre', 'images/Reciclatge/Vidre/pot_conserva.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(215, 'Ampolla de cava', 'Vidre', 'images/Reciclatge/Vidre/vidre_ampolla_cava.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(216, 'Ampolla de colònia', 'Vidre', 'images/Reciclatge/Vidre/vidre_ampolla_colonia.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(217, 'Ampolla d’oli', 'Vidre', 'images/Reciclatge/Vidre/vidre_ampolla_oli.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(218, 'Desodorant de vidre', 'Vidre', 'images/Reciclatge/Vidre/vidre_desodorant.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(219, 'Envàs de cosmètica', 'Vidre', 'images/Reciclatge/Vidre/vidre_envas_cosmetica.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(220, 'Envàs de suc', 'Vidre', 'images/Reciclatge/Vidre/vidre_envas_suc.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15'),
(221, 'Flascó de pintaungles', 'Vidre', 'images/Reciclatge/Vidre/vidre_flasco_pintaungles.jpg', '2025-04-03 11:05:15', '2025-04-03 11:05:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `punts_de_recollida`
--

CREATE TABLE `punts_de_recollida` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `ciutat` varchar(255) NOT NULL,
  `adreca` varchar(255) NOT NULL,
  `latitud` decimal(10,7) NOT NULL,
  `longitud` decimal(10,7) NOT NULL,
  `fraccio` varchar(50) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `punts_de_recollida`
--

INSERT INTO `punts_de_recollida` (`id`, `nom`, `ciutat`, `adreca`, `latitud`, `longitud`, `fraccio`, `disponible`, `created_at`, `updated_at`) VALUES
(1, 'Punt Central', 'Barcelona', 'Carrer de Mallorca, 401', 41.4036000, 2.1744000, 'Paper', 1, '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(2, 'Punt Nord', 'Barcelona', 'Carrer de Provença, 200', 41.4065000, 2.1633000, 'Vidre', 1, '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(3, 'Punt Sud', 'Girona', 'Carrer de la Creu, 15', 41.9794000, 2.8214000, 'Envasos', 0, '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(4, 'Punt Est', 'Tarragona', 'Avinguda Catalunya, 50', 41.1189000, 1.2453000, 'Orgànica', 0, '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(5, 'Punt Oest', 'Lleida', 'Plaça Sant Joan, 1', 41.6145000, 0.6222000, 'Resta', 1, '2025-04-29 09:54:08', '2025-04-29 09:54:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rols`
--

CREATE TABLE `rols` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rols`
--

INSERT INTO `rols` (`id`, `nom`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipus_alertes`
--

CREATE TABLE `tipus_alertes` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipus_alertes`
--

INSERT INTO `tipus_alertes` (`id`, `nom`, `created_at`, `updated_at`) VALUES
(1, 'Capacitat', '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(2, 'Desperfectes', '2025-04-29 09:54:08', '2025-04-29 09:54:08'),
(3, 'Altres', '2025-04-29 09:54:08', '2025-04-29 09:54:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipus_events`
--

CREATE TABLE `tipus_events` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `descripcio` text DEFAULT NULL,
  `color` varchar(7) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipus_events`
--

INSERT INTO `tipus_events` (`id`, `nom`, `descripcio`, `color`, `created_at`, `updated_at`) VALUES
(1, 'Recollida Especial', 'Recollida puntual de residus especials com electrodomèstics.', '#FF5733', '2025-05-09 07:36:06', '2025-05-09 07:36:06'),
(2, 'Tallers Educatius', 'Tallers de sensibilització mediambiental.', '#33C1FF', '2025-05-09 07:36:06', '2025-05-09 07:36:06'),
(3, 'Campanya Informativa', 'Campanya per informar sobre el reciclatge correcte.', '#75FF33', '2025-05-09 07:36:06', '2025-05-09 07:36:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `cognoms` varchar(255) DEFAULT NULL,
  `data_naixement` date DEFAULT NULL,
  `telefon` varchar(15) DEFAULT NULL,
  `ubicacio` text DEFAULT NULL,
  `punts_totals` int(11) DEFAULT 0,
  `punts_actuals` int(11) DEFAULT 0,
  `punts_gastats` int(11) DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `nivell_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nom`, `cognoms`, `data_naixement`, `telefon`, `ubicacio`, `punts_totals`, `punts_actuals`, `punts_gastats`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `rol_id`, `foto_perfil`, `nivell_id`) VALUES
(60, 'Aleix', 'Prat Marin', '2004-10-22', '671426294', 'Cervera', 523, 423, 100, 'aleixpratmarin@gmail.com', NULL, '$2y$12$8w1uRRmzuzc6.bPgN6i8yerw2uGMBJq.wMtLbtIA4OX2bFdWag6ry', 'sHT5vAS8xxaPD866Ws3x8zw63FyBXDZDkjXUKHjtVqVwHM62G1SqnZbTTqOg', '2025-03-27 07:52:18', '2025-05-25 17:15:49', 1, 'profile_photos/xcBTofKUDjjQlzkGsPSl7dCOuSHpj3jM5PEcIDWc.png', 1),
(63, 'Aleix Prat Marin', 'Prat Marin', '2004-10-22', '671426294', 'Cervera', 20, 20, 0, 'aleixpratmarin111@gmail.com', NULL, '$2y$12$3qN.4SRiE.OYl6A7bzkEJeND10XYpnH5On/dhLL6bc.GPEt0UgXeK', NULL, '2025-03-31 07:53:42', '2025-03-31 07:53:42', 2, 'profile_photos/FW18V9UAU5TrHWBqs8iQ8gXCz71g2bvOSPKzeIVG.png', 1),
(64, 'Aleix Prat', NULL, NULL, NULL, NULL, 0, 0, 0, 'aleix.pm.daw@gmail.com', NULL, '$2y$12$bFAVumBlOvDSsrpmjOCiDOa9mC8VH5lW6EkzbuVAG2fWCX.nIZDXK', NULL, '2025-04-03 16:46:23', '2025-04-04 07:40:50', 2, 'profile_photos/QzZHDs5LymQBiRA76DazJVSHACujPC3TX1Rlgs10.png', 1),
(65, 'Aleix', 'Prat Marin', '2004-10-22', '671426294', 'Cervera', 200, 200, 0, 'aleixpratmarin23@gmail.com', NULL, '$2y$12$CjpRlowz2odtc9BrUT5L2O.im70z5xEcwtjtbRBIdoMjD34eGy9ie', NULL, '2025-05-08 07:26:14', '2025-05-23 09:56:23', 2, 'profile_photos/Zz7a8Q0FSBEc8ucH8mFBpsnUWXj4PmkboP98Sz8J.jpg', 1),
(66, 'Aleix', 'Prat', '2025-05-19', '98765421', 'dfhgfhfsd', 280, 234, 46, 'aleixpratmarin1@gmail.com', NULL, '$2y$12$BZvnUYD9mOzxoqqHqwV9VetbuHI/lTsYXX5lKEMU.Ypozizo7X17C', 'iVBrhzUaeCiErOscgJ3710LUIqQd9Sy1HPxoKYL0JRaTfUjpIu1ZnyCpUrXu', '2025-05-12 06:43:37', '2025-05-24 23:53:28', 1, 'profile_photos/qLHW2HJkpbdA45ye1ioerrBZTZjJs9VAS2lVmJm8.png', 1),
(67, 'CES', 'Segarra', NULL, NULL, NULL, 230, 230, 0, 'centreexcursionistalasegarra@gmail.com', NULL, '$2y$12$z68Mye8s61PVCXRa0aOkh.7Inz.Var2VBcURl/8p822Py.M2tFKPi', 'oGzTVj6UfvRfubFJj7u829OH29G6lZmo2odGVEAe1yXOfKcWDcbbt2eDvTDY', '2025-05-15 09:11:40', '2025-05-15 09:32:20', 1, 'https://lh3.googleusercontent.com/a/ACg8ocIK3oA-KyJYXs0rtwdxkEqlLY94A4_IzgKbkulJBjcQX6qLLA=s96-c', 1),
(69, 'Aleix', 'Pratttsss', NULL, NULL, NULL, 0, 0, 0, 'ale@gmail.com', NULL, '$2y$12$AnGlY9I9U5kwntUznvU6O.8Za2dIEWG50MGwCXpwhddjnTIkn4wX6', NULL, '2025-05-21 18:19:04', '2025-05-21 18:19:04', 2, NULL, 1),
(75, 'Aleix', 'Prat Marin', NULL, NULL, NULL, 0, 0, 0, 'alemusicaria@gmail.com', NULL, '$2y$12$drSnkL8D8t4Tm68nKlesw.a8LzhT54YfJ.7tGykllOI.tbqA4UiJa', NULL, '2025-05-25 16:57:06', '2025-05-25 16:57:06', NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `alertes_punts_de_recollida`
--
ALTER TABLE `alertes_punts_de_recollida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `punt_de_recollida_id` (`punt_de_recollida_id`),
  ADD KEY `tipus_alerta_id` (`tipus_alerta_id`),
  ADD KEY `fk_alerts_user` (`user_id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `codis`
--
ALTER TABLE `codis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipus_event_id` (`tipus_event_id`);

--
-- Indices de la tabla `event_user`
--
ALTER TABLE `event_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_event` (`user_id`,`event_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `producte_id` (`producte_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `navigator_infos`
--
ALTER TABLE `navigator_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nivells`
--
ALTER TABLE `nivells`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `premis`
--
ALTER TABLE `premis`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `premis_reclamats`
--
ALTER TABLE `premis_reclamats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `premi_id` (`premi_id`);

--
-- Indices de la tabla `productes`
--
ALTER TABLE `productes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `punts_de_recollida`
--
ALTER TABLE `punts_de_recollida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rols`
--
ALTER TABLE `rols`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipus_alertes`
--
ALTER TABLE `tipus_alertes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipus_events`
--
ALTER TABLE `tipus_events`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `fk_users_rols` (`rol_id`),
  ADD KEY `users_nivell_id_foreign` (`nivell_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `alertes_punts_de_recollida`
--
ALTER TABLE `alertes_punts_de_recollida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `codis`
--
ALTER TABLE `codis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `event_user`
--
ALTER TABLE `event_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `navigator_infos`
--
ALTER TABLE `navigator_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=307;

--
-- AUTO_INCREMENT de la tabla `nivells`
--
ALTER TABLE `nivells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `opinions`
--
ALTER TABLE `opinions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `premis`
--
ALTER TABLE `premis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `premis_reclamats`
--
ALTER TABLE `premis_reclamats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productes`
--
ALTER TABLE `productes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT de la tabla `punts_de_recollida`
--
ALTER TABLE `punts_de_recollida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rols`
--
ALTER TABLE `rols`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipus_alertes`
--
ALTER TABLE `tipus_alertes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipus_events`
--
ALTER TABLE `tipus_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `alertes_punts_de_recollida`
--
ALTER TABLE `alertes_punts_de_recollida`
  ADD CONSTRAINT `alertes_punts_de_recollida_ibfk_1` FOREIGN KEY (`punt_de_recollida_id`) REFERENCES `punts_de_recollida` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `alertes_punts_de_recollida_ibfk_2` FOREIGN KEY (`tipus_alerta_id`) REFERENCES `tipus_alertes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_alerts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`tipus_event_id`) REFERENCES `tipus_events` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `event_user`
--
ALTER TABLE `event_user`
  ADD CONSTRAINT `event_user_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_user_ibfk_3` FOREIGN KEY (`producte_id`) REFERENCES `productes` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `premis_reclamats`
--
ALTER TABLE `premis_reclamats`
  ADD CONSTRAINT `premis_reclamats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `premis_reclamats_ibfk_2` FOREIGN KEY (`premi_id`) REFERENCES `premis` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_rols` FOREIGN KEY (`rol_id`) REFERENCES `rols` (`id`),
  ADD CONSTRAINT `users_nivell_id_foreign` FOREIGN KEY (`nivell_id`) REFERENCES `nivells` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

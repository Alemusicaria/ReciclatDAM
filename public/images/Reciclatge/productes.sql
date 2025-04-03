-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-04-2025 a las 13:07:35
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
(204, 'Raspall de dents', 'Resta', 'images/Reciclatge/Resta/raspall_dents.jpg','2025-04-03 11:05:15', '2025-04-03 11:05:15'),
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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productes`
--
ALTER TABLE `productes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productes`
--
ALTER TABLE `productes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

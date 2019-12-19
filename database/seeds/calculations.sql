-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 19 2019 г., 04:04
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `calculations`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appcomb`
--

CREATE TABLE IF NOT EXISTS `appcomb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL,
  `pageApp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Дамп данных таблицы `appcomb`
--

INSERT INTO `appcomb` (`id`, `id_app`, `pageApp`) VALUES
(61, 216, 195),
(62, 215, 195),
(63, 215, 196),
(87, 209, 196),
(88, 209, 187),
(89, 209, 217),
(90, 209, 224),
(93, 196, 265),
(94, 196, 196),
(95, 210, 224),
(96, 210, 283);

-- --------------------------------------------------------

--
-- Структура таблицы `awwa_d100_05_wp`
--

CREATE TABLE IF NOT EXISTS `awwa_d100_05_wp` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `expCAT` varchar(45) DEFAULT NULL,
  `z` double DEFAULT NULL,
  `K_z` double DEFAULT NULL,
  `I` double DEFAULT NULL,
  `V` double DEFAULT NULL,
  `q_z` double DEFAULT NULL,
  `G` double DEFAULT NULL,
  `G_method` varchar(100) DEFAULT NULL,
  `P_w` double DEFAULT NULL,
  `C_f` double DEFAULT NULL,
  `surfaceType` varchar(100) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Дамп данных таблицы `awwa_d100_05_wp`
--

INSERT INTO `awwa_d100_05_wp` (`RcdNo`, `userscalcPK`, `pageAppNo`, `expCAT`, `z`, `K_z`, `I`, `V`, `q_z`, `G`, `G_method`, `P_w`, `C_f`, `surfaceType`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(75, '78', 224, 'C', 47, 1.09, NULL, 30, 2.888064, 1, 'default', 15, 0.5, 'conical_apex_angle_ge_15', NULL, NULL, '2016-07-18 14:28:12', NULL, '0000-00-00 00:00:00'),
(74, '135', 224, 'C', 1, 1.09, NULL, 10, 0.320896, 1, 'default', 30, 1, 'flat', NULL, NULL, '2016-07-18 14:26:08', NULL, '0000-00-00 00:00:00'),
(76, '136', 224, 'C', 90, 1.234, 1.15, 100, 36.32896, 1, 'default', 21.797376, 0.6, 'cylindrical', '', NULL, '2016-07-20 12:24:52', NULL, '0000-00-00 00:00:00'),
(77, '133', 224, 'C', NULL, 1.09, 1.15, NULL, NULL, 1, 'default', 30, 1, 'flat', NULL, NULL, '2016-08-15 02:12:20', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `ba_ilcs`
--

CREATE TABLE IF NOT EXISTS `ba_ilcs` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `ilc` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `geometry` varchar(255) NOT NULL,
  `component` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `startLocation` varchar(255) NOT NULL,
  `startValue` varchar(255) NOT NULL,
  `endLocation` varchar(255) NOT NULL,
  `endValue` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '1',
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

--
-- Дамп данных таблицы `ba_ilcs`
--

INSERT INTO `ba_ilcs` (`rcdNo`, `userscalcPK`, `pageAppNo`, `ilc`, `geometry`, `component`, `unit`, `startLocation`, `startValue`, `endLocation`, `endValue`, `visibility`, `note`) VALUES
(1, '102', 187, '3', 'Point', 'FY', 'lbf', '238.99', '23', '', '', 1, NULL),
(2, '102', 187, '5r', 'Distributed', 'FY', 'lbf', '100', '44', '200', '25', 1, NULL),
(3, '102', 187, '67', 'Point', 'FY', 'lbf', '50', '20', '', '', 1, NULL),
(6, '102', 187, '3', 'Point', 'MZ', 'lbf-ft', '80', '50', '', '', 1, NULL),
(8, '103', 187, '12', 'Distributed', 'FY', 'lbf', '', '', '', '', 1, NULL),
(9, '5', 187, '3', 'Point', 'FY', 'lbf', '3', '3', '', '', 1, NULL),
(26, '6', 187, 'L1', 'Point', 'FY', 'lbf', '2', '5', '', '', 1, NULL),
(27, '6', 187, 'L2', 'Distributed', 'FY', 'lbf', '2', '5', '7', '-9', 1, NULL),
(28, '6', 187, 'L3', 'Point', 'MZ', 'lbf-ft', '4', '5', '', '', 1, NULL),
(29, '6', 187, 'L4', 'Distributed', 'MZ', 'lbf-ft', '8', '5', '14', '-10', 1, NULL),
(30, '7', 187, 'L1', 'Point', 'FX', 'lbf', '2', '-50', '12', '-50', 1, ''),
(91, '14', 187, 'D', 'Point', 'FX', 'lbf', '2', '9', '', '', 1, ''),
(93, '14', 187, 'WLX', 'Distributed', 'FX', 'lbf', '1', '6', '5', '-8', 1, ''),
(94, '14', 187, 'WLY', 'Distributed', 'MZ', 'kips-ft', '4', '6', '8', '-3', 1, ''),
(95, '14', 187, 'DX', 'Point', 'MZ', 'lbf-ft', '0.5', '3', '', '', 1, ''),
(96, '14', 187, 'DY', 'Point', 'MZ', 'lbf-ft', '9.5', '-6', '', '', 1, ''),
(97, '15', 187, 'D', 'Point', 'FX', 'lbf', '2', '10', '', '', 1, ''),
(99, '76', 211, NULL, 'Point', 'FX', 'lbf', '', '32', '', '', 1, NULL),
(100, '79', 211, NULL, 'Distributed', 'MZ', 'lbf-ft', '78', '25', '', '', 1, NULL),
(102, '74', 211, NULL, 'Point', 'FX', 'lbf', '14', '41', '', '', 1, NULL),
(112, '187', 187, 'D', 'Distributed', 'FX', 'lbf', '0', '4', '3', '-5', 1, ''),
(113, '187', 187, 'WL', 'Distributed', 'MZ', 'lbf-ft', '3.5', '-6', '7', '8', 1, NULL),
(114, '187', 187, 'R', 'Point', 'FX', 'lbf', '4', '9', '', '', 1, NULL),
(115, '187', 187, 'T', 'Point', 'MZ', '', '6', '-10', '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ba_lcs`
--

CREATE TABLE IF NOT EXISTS `ba_lcs` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `lc` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Дамп данных таблицы `ba_lcs`
--

INSERT INTO `ba_lcs` (`rcdNo`, `userscalcPK`, `pageAppNo`, `lc`, `params`, `note`) VALUES
(1, '102', 187, '56', '{"1":"4","2":"3","3":"6767","5":"3","6":"567","67":"345","568":"56","5r":"546"}', NULL),
(3, '102', 187, '85', '{"1":"6","2":"3","3":"711","5":"1","6":"8","67":"25","568":"745","5r":"456"}', NULL),
(5, '102', 187, '56', '{"1":"2","2":"66","3":"23","5":"6","6":"5","67":"11","568":"12","5r":"14"}', NULL),
(6, '102', 187, '64', '{"1":"1","2":"7","3":"56","5":"1","6":"3","67":"1","568":"54","5r":"3"}', NULL),
(7, '102', 187, '33', '{"1":"87111","2":"4","3":"6","5":"8","6":"1"}', NULL),
(9, '103', 187, '12', '{"7":"32"}', NULL),
(10, '5', 187, '3', '', NULL),
(13, '6', 187, '123', '{"26":"12","27":"2","28":"2","29":"2"}', '2'),
(25, '14', 187, 'LC1', '{"91":"1","92":"1","93":"1","94":"1"}', ''),
(26, '14', 187, 'LC2', '{"91":"2","92":"1","93":"1","94":"1"}', ''),
(27, '15', 187, 'LC1', '{"97":"1"}', ''),
(28, '15', 187, 'LC2', '{"97":"2"}', ''),
(31, '6', 187, '2', '{"26":"4","27":"5","28":"3","29":"2"}', '4'),
(32, '6', 187, '2', '{"26":"4","27":"5","28":"2","29":"2"}', '4'),
(33, '7', 187, '1', '{"30":"2"}', '4'),
(34, '76', 211, 'LC1', '{"99":"2"}', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `ba_materials`
--

CREATE TABLE IF NOT EXISTS `ba_materials` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` int(11) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `org` varchar(255) NOT NULL,
  `standard` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `Rho` varchar(255) NOT NULL,
  `G` varchar(255) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `ba_materials`
--

INSERT INTO `ba_materials` (`rcdNo`, `userscalcPK`, `pageAppNo`, `org`, `standard`, `grade`, `name`, `E`, `Rho`, `G`) VALUES
(1, 102, 187, 'ASTM', '260W(250)', '', '260W(250)', '29000000.00', '11200000.00', ''),
(2, 102, 187, 'ASTM', 'A139', '35', 'A139-35', '29000000.00', '11200000.00', ''),
(4, 103, 187, 'ASTM', '260W', '', '260W', '29000000.00', '11200000.00', ''),
(5, 7, 187, 'ASTM', 'A307', '', 'A307', '0.00', '0.00', ''),
(6, 6, 187, 'ASTM', 'A572', '50', 'A572-50', '4176000', '0.283565914', '11200000'),
(7, 14, 187, 'ASTM', 'A572', '60', 'A572-60', '29000000.00', '0.2835659990', '11200000.00'),
(8, 14, 187, 'ASTM', 'A582', '70', 'A582-70', '29000000.00', '0.2835659990', '11200000.00'),
(9, 15, 187, 'ASTM', 'A572', '60', 'A572-60', '4176000', '0.283565999', '11200000'),
(30, 76, 211, 'ASTM', '260W(250)', '', '260W(250)', '4176000', '0.283565999', '11200000'),
(31, 78, 211, 'ASTM', '350W', '', '350W', '4176000', '0.283565999', '11200000'),
(32, 79, 211, 'ASTM', 'F1554', '36', 'F1554-36', '0', '0', '0'),
(33, 74, 211, 'ASTM', '260W(250)', '', '260W(250)', '4176000', '0.283565999', '11200000');

-- --------------------------------------------------------

--
-- Структура таблицы `ba_nodes`
--

CREATE TABLE IF NOT EXISTS `ba_nodes` (
  `rcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `x` double(5,2) DEFAULT NULL,
  `y` double(5,2) DEFAULT NULL,
  `z` double(5,2) DEFAULT NULL,
  `dx` tinyint(4) NOT NULL,
  `dy` tinyint(4) NOT NULL,
  `dz` tinyint(4) NOT NULL,
  `mx` tinyint(4) NOT NULL,
  `my` tinyint(4) NOT NULL,
  `mz` tinyint(4) NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`rcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=201 ;

--
-- Дамп данных таблицы `ba_nodes`
--

INSERT INTO `ba_nodes` (`rcdNo`, `userscalcPK`, `pageAppNo`, `name`, `x`, `y`, `z`, `dx`, `dy`, `dz`, `mx`, `my`, `mz`, `note`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(8, '102', 187, '23', 1.00, 4.00, 5.00, 1, 1, 1, 1, 1, 1, 'et', 0, '2016-01-28 17:58:17', 0, '0000-00-00 00:00:00'),
(6, '102', 187, '1231', 42.00, 62.00, 21.00, 1, 1, 1, 1, 1, 1, 'erf', 0, '2016-01-28 17:13:27', 0, '0000-00-00 00:00:00'),
(7, '102', 187, '435', 4.00, 336.00, 2.00, 1, 1, 1, 1, 1, 1, 'er1111', 0, '2016-01-28 17:13:22', 0, '0000-00-00 00:00:00'),
(26, '5', 187, '33', NULL, 33.00, NULL, 1, 1, 1, 1, 1, 1, NULL, NULL, '2016-02-05 02:17:35', NULL, '0000-00-00 00:00:00'),
(10, '103', 187, '12', 0.00, 2.00, 0.00, 1, 1, 1, 1, 1, 1, '31', 0, '2016-02-05 00:30:48', 0, '0000-00-00 00:00:00'),
(12, '1', 187, '123', 0.00, 2.00, 0.00, 1, 1, 1, 1, 1, 1, '2', 0, '2016-02-05 00:35:31', 0, '0000-00-00 00:00:00'),
(14, '2', 187, '123', 0.00, 123.00, 0.00, 1, 1, 1, 1, 1, 1, '123', 0, '2016-02-05 00:46:02', 0, '0000-00-00 00:00:00'),
(20, '4', 187, 'eee', 0.00, 2.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-05 01:13:39', 0, '0000-00-00 00:00:00'),
(16, '3', 187, '3333', 0.00, 22.00, 0.00, 1, 1, 1, 1, 1, 1, '3333', 0, '2016-02-05 00:53:28', 0, '0000-00-00 00:00:00'),
(25, '5', 187, '4', NULL, 4.00, NULL, 1, 1, 1, 1, 1, 1, NULL, NULL, '2016-02-05 02:14:36', NULL, '0000-00-00 00:00:00'),
(23, '5', 187, '2', 0.00, 2.00, 0.00, 1, 1, 1, 1, 1, 1, '2', 0, '2016-02-05 02:11:59', 0, '0000-00-00 00:00:00'),
(24, '5', 187, '3', 0.00, 2.00, 0.00, 1, 1, 1, 1, 1, 1, '2', 0, '2016-02-05 02:12:31', 0, '0000-00-00 00:00:00'),
(57, '6', 187, 'N1', 0.00, 0.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-13 00:28:44', 0, '0000-00-00 00:00:00'),
(58, '6', 187, 'N2', 0.00, 10.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-13 00:28:48', 0, '0000-00-00 00:00:00'),
(59, '6', 187, 'N3', 0.00, 25.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-13 00:28:54', 0, '0000-00-00 00:00:00'),
(60, '7', 187, 'N1', 0.00, 0.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-13 00:28:44', 0, '0000-00-00 00:00:00'),
(61, '7', 187, 'N2', 0.00, 5.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-13 00:28:48', 0, '0000-00-00 00:00:00'),
(62, '7', 187, 'N3', 0.00, 15.00, 0.00, 1, 1, 1, 1, 1, 1, '', 0, '2016-02-13 00:28:54', 0, '0000-00-00 00:00:00'),
(117, '9', 187, 'N2', 0.00, 1.00, 0.00, 1, 0, 0, 0, 0, 1, '2', 0, '2016-03-08 02:04:45', 0, '0000-00-00 00:00:00'),
(115, '8', 187, 'N1', 0.00, 22.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-20 19:31:20', 0, '0000-00-00 00:00:00'),
(119, '10', 187, 'N1', 0.00, 2.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-03-08 02:05:45', 0, '0000-00-00 00:00:00'),
(173, '14', 187, 'N3', 0.00, 10.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-23 05:46:01', 0, '0000-00-00 00:00:00'),
(127, '21', 187, 'N1', NULL, 222.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-05-23 19:16:59', NULL, '0000-00-00 00:00:00'),
(129, '22', 187, 'N1', NULL, 123.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-05-23 19:36:57', NULL, '0000-00-00 00:00:00'),
(172, '14', 187, 'N2', 0.00, 3.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-23 05:44:47', 0, '0000-00-00 00:00:00'),
(134, '26', 187, 'N1', NULL, 151.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-06-02 15:45:51', NULL, '0000-00-00 00:00:00'),
(135, '26', 187, 'N2', NULL, 33.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-06-02 15:45:56', NULL, '0000-00-00 00:00:00'),
(171, '14', 187, 'N1', 0.00, 0.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-23 05:44:45', 0, '0000-00-00 00:00:00'),
(175, '15', 187, 'N2', 0.00, 4.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-23 05:44:47', 0, '0000-00-00 00:00:00'),
(174, '15', 187, 'N1', 0.00, 0.00, 0.00, 1, 0, 0, 0, 0, 1, '', 0, '2016-02-23 05:44:45', 0, '0000-00-00 00:00:00'),
(178, '68', 187, 'N1', NULL, 0.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-06-25 03:18:48', NULL, '0000-00-00 00:00:00'),
(179, '68', 187, 'N2', NULL, 9.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-06-25 03:18:51', NULL, '0000-00-00 00:00:00'),
(183, '76', 211, 'N1', NULL, 1.00, NULL, 1, 0, 0, 0, 0, 1, 'er', NULL, '2016-06-30 14:54:59', NULL, '0000-00-00 00:00:00'),
(185, '78', 211, 'N2', NULL, 2.00, NULL, 1, 0, 0, 0, 0, 1, 'note', NULL, '2016-07-01 09:11:57', NULL, '0000-00-00 00:00:00'),
(196, '187', 187, 'N1', NULL, 0.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-09-22 16:02:07', NULL, '0000-00-00 00:00:00'),
(197, '187', 187, 'N2', NULL, 5.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-09-22 16:02:10', NULL, '0000-00-00 00:00:00'),
(198, '187', 187, 'N3', NULL, 8.00, NULL, 1, 0, 0, 0, 0, 1, NULL, NULL, '2016-09-22 16:02:12', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `ba_sections`
--

CREATE TABLE IF NOT EXISTS `ba_sections` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `n_start` varchar(255) NOT NULL,
  `n_end` varchar(255) NOT NULL,
  `A_start` varchar(255) NOT NULL,
  `A_end` varchar(255) NOT NULL,
  `e` varchar(255) NOT NULL,
  `crsec` varchar(255) NOT NULL,
  `shape` varchar(255) NOT NULL DEFAULT '',
  `size1` varchar(255) NOT NULL,
  `size2` varchar(255) NOT NULL DEFAULT '',
  `od_start` varchar(255) NOT NULL,
  `od_end` varchar(255) NOT NULL DEFAULT '',
  `width_start` varchar(255) NOT NULL,
  `width_end` varchar(255) NOT NULL,
  `height_start` varchar(255) NOT NULL,
  `height_end` varchar(255) NOT NULL,
  `Ix_start` varchar(256) NOT NULL,
  `Ix_end` varchar(255) NOT NULL,
  `Iy_start` varchar(255) NOT NULL,
  `Iy_end` varchar(255) NOT NULL,
  `rotation` varchar(255) NOT NULL,
  `matID` int(11) NOT NULL,
  `s_eq_e` tinyint(4) NOT NULL,
  `slope` varchar(255) NOT NULL,
  `crfrc_start` varchar(255) DEFAULT NULL,
  `crfrc_end` varchar(255) DEFAULT NULL,
  `f2f_start` varchar(255) DEFAULT NULL,
  `f2f_end` varchar(255) DEFAULT NULL,
  `fwth_start` varchar(255) DEFAULT NULL,
  `fwth_end` varchar(255) DEFAULT NULL,
  `thk` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

--
-- Дамп данных таблицы `ba_sections`
--

INSERT INTO `ba_sections` (`rcdNo`, `userscalcPK`, `pageAppNo`, `n_start`, `n_end`, `A_start`, `A_end`, `e`, `crsec`, `shape`, `size1`, `size2`, `od_start`, `od_end`, `width_start`, `width_end`, `height_start`, `height_end`, `Ix_start`, `Ix_end`, `Iy_start`, `Iy_end`, `rotation`, `matID`, `s_eq_e`, `slope`, `crfrc_start`, `crfrc_end`, `f2f_start`, `f2f_end`, `fwth_start`, `fwth_end`, `thk`) VALUES
(1, '102', 187, '4.00', '62.00', '66', '88', '', 'AISC', 'PIPE', '', 'Pipe8', '', 'Pipe8XXS', '', '34', '75', '44', '', '22', '1', '3', '11', 2, 1, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '102', 187, '62.00', '336.00', '7', '3', '', '8-sided', '784', '45', '4', '77', '7', '12', '31', '11', '55', '', '3', '7', '6', '34', 1, 0, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '5', 187, '2.00', '2.00', '', '', '', 'AISC', '2L', '2L2', '2L2-1/2X1-1/2X1/4LLBB', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', '', ''),
(16, '7', 187, '60', '61', '6', '', '', 'Rectangular', '2L_E', '2L2', '2L2X2X1/4', '2', '', '2', '', '3', '', '4.5', '', '2', '', '', 0, 1, '', '', '', '', '', '', '', ''),
(20, '6', 187, '57', '58', '', '', '', 'AISC', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', '', ''),
(21, '6', 187, '58', '59', '', '', '', 'AISC', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '7', 187, '61', '62', '', '', '', 'Circular', '', '', '', '3', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '', '', '', '', '', '', ''),
(63, '14', 187, '171', '172', '0.25', '', '', 'Rectangular', '', '', '', '', '', '1', '', '0.25', '', '0.0013020833333333', '', '0.020833333333333', '', '', 1, 1, '', '', '', '', '', '', '', ''),
(64, '14', 187, '172', '173', '-1.5', '8', '', 'Rectangular', '', '', '', '', '', '1', '3', '0.25', '0.75', '-0.4453125', '6.6666666666667', '-0.125', '6.6666666666667', '', 1, 0, '', '', '', '', '', '', '', '0'),
(65, '15', 187, '174', '175', '0.25', '', '', 'Rectangular', '', '', '', '', '', '1', '', '0.125', '', '0.0013020833333333', '', '0.020833333333333', '', '', 1, 1, '', '', '', '', '', '', '', ''),
(67, '72', 187, '', '', '', '', '', 'AISC', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, '73', 187, '', '', '', '', '', '12-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '456', '', '', '', '', '', ''),
(70, '74', 187, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '2233', NULL, '123', NULL, NULL, NULL, NULL),
(74, '75', 187, '', '', '150', '', '', 'Rectangular', '', '', '', '', '', '10', '', '15', '', '2812.5', '', '1250', '', '', 0, 1, '', '', '', '', '', '', '', ''),
(77, '76', 187, '', '', '', '', '', '12-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '12', NULL, NULL, NULL, NULL, NULL, NULL),
(84, '76', 211, '', '', '', '', '', 'AISC', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, '77', 211, '', '', '', '', '', 'Customer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, '78', 187, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '2', NULL, '4', NULL, NULL, NULL, NULL),
(89, '74', 187, '', '', '', '', '', '16-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '45', '', '45', '', '', '', '5'),
(91, '87', 211, '', '', '', '', '', 'Circular', '', '', '', '2', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, '2'),
(94, '88', 211, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '123', NULL, '1231', NULL, NULL, NULL, NULL),
(95, '88', 211, '', '', '6', '', '', 'Rectangular', '', '', '', '', '', '2', '', '3', '', '4.5', '', '2', '', '', 0, 1, '', '123', NULL, '1231', NULL, NULL, NULL, '1'),
(98, '89', 211, '', '', '-18', '', '', 'Rectangular', '', '', '', '', '', '1', '', '2', '', '-26', '', '-41.5', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, '3'),
(100, '90', 211, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '12', NULL, '23', NULL, NULL, NULL, NULL),
(103, '91', 211, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '12', NULL, '24', NULL, NULL, NULL, NULL),
(104, '91', 187, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '12', '', '34', '', '', '', ''),
(106, '92', 211, '', '', '', '', '', '12-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '10', NULL, '20', NULL, '30', NULL, NULL),
(108, '93', 211, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '14', NULL, '15', NULL, '16', NULL, NULL),
(111, '94', 211, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '10', NULL, '20', NULL, '30', NULL, NULL),
(113, '95', 211, '', '', '', '', '', 'Rectangular', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, '96', 211, '', '', '', '', '', '12-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '20', NULL, '30', NULL, NULL, NULL, NULL),
(117, '97', 211, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '3', NULL, '3', NULL, NULL, NULL, NULL),
(118, '131', 187, '', '', '120', '', '', 'Rectangular', '', '', '', '', '', '12', '', '10', '', '1000', '', '1440', '', '', 0, 1, '', '', '', '', '', '', '', ''),
(119, '131', 187, '', '', '', '', '', '8-sided', '', '', '', '', '', '12', '', '10', '', '', '', '', '', '', 0, 1, '', '4', '', '56', '', '', '', ''),
(122, '160', 187, '', '', '', '', '', 'Customer', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, '160', 187, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '1', NULL, '2', NULL, NULL, NULL, '4'),
(125, '182', 187, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '1', NULL, '2', NULL, '3', NULL, '4'),
(127, '183', 187, '', '', '', '', '', '12-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '1', NULL, '2', NULL, '4', NULL, '3'),
(128, '175', 187, '', '', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 1, '', '1', NULL, '2', NULL, NULL, NULL, NULL),
(137, '187', 187, '193', '194', '', '', '', 'Circular', '', '', '', '2', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, '1'),
(138, '187', 187, '194', '195', '', '', '', 'Circular', '', '', '', '3', '', '', '', '', '', '', '', '', '', '', 0, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `ba_supports`
--

CREATE TABLE IF NOT EXISTS `ba_supports` (
  `rcdNo` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(255) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `kx` varchar(255) NOT NULL,
  `ky` varchar(255) NOT NULL,
  `kz` varchar(255) NOT NULL,
  `krotx` varchar(255) NOT NULL,
  `kroty` varchar(255) NOT NULL,
  `krotz` varchar(255) NOT NULL,
  PRIMARY KEY (`rcdNo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Дамп данных таблицы `ba_supports`
--

INSERT INTO `ba_supports` (`rcdNo`, `userscalcPK`, `pageAppNo`, `location`, `type`, `kx`, `ky`, `kz`, `krotx`, `kroty`, `krotz`) VALUES
(36, '14', 187, '9', 'Pinned', 'INF', 'INF', 'INF', 'INF', 'INF', '0'),
(37, '6', 187, '2', 'Roller', 'INF', '0', 'INF', 'INF', 'INF', '0'),
(38, '6', 187, '12', 'Fixed', 'INF', 'INF', 'INF', 'INF', 'INF', 'INF'),
(39, '14', 187, '0.5', 'Roller', 'INF', '0', 'INF', 'INF', 'INF', '0'),
(41, '15', 187, '0', 'Pinned', 'INF', 'INF', 'INF', 'INF', 'INF', '0'),
(42, '15', 187, '4', 'Pinned', 'INF', 'INF', 'INF', 'INF', 'INF', '0'),
(45, '74', 211, '', 'Pinned', 'INF', 'INF', 'INF', 'INF', 'INF', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `ba_units`
--

CREATE TABLE IF NOT EXISTS `ba_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbtable` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `var` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `notes` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Дамп данных таблицы `ba_units`
--

INSERT INTO `ba_units` (`id`, `dbtable`, `var`, `unit`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'ba_materials', 'e', 'ksf', '', 0, '2016-01-30 00:37:50', 0, '0000-00-00 00:00:00'),
(2, 'ba_materials', 'rho', 'pcf', '', 0, '2016-01-30 00:37:50', 0, '0000-00-00 00:00:00'),
(3, 'ba_materials', 'g', 'pcf', '', 0, '2016-01-30 00:37:50', 0, '0000-00-00 00:00:00'),
(4, 'ba_nodes', 'x', 'ft.', '', 0, '2016-01-30 00:37:50', 0, '0000-00-00 00:00:00'),
(5, 'ba_nodes', 'y', 'ft', '', 0, '2016-01-30 00:38:20', 0, '0000-00-00 00:00:00'),
(6, 'ba_nodes', 'z', 'ft', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(7, 'ba_sections', 'od_start', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(8, 'ba_sections', 'od_end', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(9, 'ba_sections', 'width_start', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(10, 'ba_sections', 'width_end', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(11, 'ba_sections', 'height_start', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(12, 'ba_sections', 'height_end', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(13, 'ba_sections', 'crfrc_start', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(14, 'ba_sections', 'crfrc_end', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(15, 'ba_sections', 'f2f_start', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(16, 'ba_sections', 'f2f_end', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(17, 'ba_sections', 'fwth_start', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(18, 'ba_sections', 'fwth_end', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(19, 'ba_sections', 'thk', 'in.', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(20, 'ba_sections', 'slope', 'in/ft', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(21, 'ba_sections', 'rotation', 'degree', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(22, 'ba_sections', 'A_start', 'in.^2', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(23, 'ba_sections', 'A_end', 'in.^2', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(24, 'ba_sections', 'Ix_start', 'in.^4', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(25, 'ba_sections', 'Ix_end', 'in.^4', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(26, 'ba_sections', 'Iy_start', 'in.^4', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(27, 'ba_sections', 'Iy_end', 'in.^4', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(28, 'ba_sections', 'Iz_start', 'in.^4', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(29, 'ba_sections', 'Iz_end', 'in.^4', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(30, 'ba_ilcs', 'startLocation', 'ft', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00'),
(31, 'ba_ilcs', 'endLocation', 'ft', '', 0, '2016-01-30 00:38:32', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `bc2d`
--

CREATE TABLE IF NOT EXISTS `bc2d` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `show_plot` int(1) DEFAULT NULL,
  `simplified` int(1) DEFAULT NULL,
  `cnvs_minsidelth` double DEFAULT NULL,
  `design_code` varchar(50) DEFAULT NULL,
  `lrfd_type` varchar(50) DEFAULT NULL,
  `g_phi_bolt` double DEFAULT NULL,
  `g_phi_rod` double DEFAULT NULL,
  `g_phi_plate` double DEFAULT NULL,
  `R_code` varchar(50) DEFAULT NULL,
  `R_M` double DEFAULT NULL,
  `R_P` double DEFAULT NULL,
  `R_V` double DEFAULT NULL,
  `R_V_dir_angle` double DEFAULT NULL,
  `pc_mftr` varchar(50) DEFAULT NULL,
  `pc_shape` varchar(50) DEFAULT NULL,
  `pc_c_od` double DEFAULT NULL,
  `pc_rp_nbr_sides` int(2) DEFAULT NULL,
  `pc_rp_od_f2f` double DEFAULT NULL,
  `pc_rp_od_c2c` double DEFAULT NULL,
  `pc_rp_first_cnr_angle` double DEFAULT NULL,
  `pc_crcmfrc` double DEFAULT NULL,
  `pc_steel_shape_type` varchar(20) DEFAULT NULL,
  `pc_steel_shape_size` varchar(50) DEFAULT NULL,
  `pc_steel_shape_roty` double DEFAULT NULL,
  `pc_thk` double DEFAULT NULL,
  `pc_mat` varchar(20) DEFAULT NULL,
  `pc_mat_fy` double DEFAULT NULL,
  `pc_mat_fu` double DEFAULT NULL,
  `pc_mat_rho` double DEFAULT NULL,
  `pc_mat_e` double DEFAULT NULL,
  `pc_mat_c` double DEFAULT NULL,
  `pc_area` varchar(50) DEFAULT NULL,
  `pc_amoi` varchar(100) DEFAULT NULL,
  `pc_reinf_weld_fillet` varchar(5) DEFAULT NULL,
  `pc_reinf_weld_fillet_size` double DEFAULT NULL,
  `bp_shape` varchar(50) DEFAULT NULL,
  `bp_c_od` double DEFAULT NULL,
  `bp_rp_nbr_sides` int(2) DEFAULT NULL,
  `bp_rp_od_f2f` double DEFAULT NULL,
  `bp_rp_od_c2c` double DEFAULT NULL,
  `bp_rp_first_cnr_angle` double DEFAULT NULL,
  `bp_crcmfrc` double DEFAULT NULL,
  `bp_rect_dx` double DEFAULT NULL,
  `bp_rect_dz` double DEFAULT NULL,
  `bp_rect_roty` double DEFAULT NULL,
  `bp_ihole_dia` double DEFAULT NULL,
  `bp_thk` double DEFAULT NULL,
  `bp_mat` varchar(20) DEFAULT NULL,
  `bp_mat_fy` double DEFAULT NULL,
  `bp_mat_fu` double DEFAULT NULL,
  `bp_eff_wth` varchar(55) DEFAULT NULL,
  `bp_mat_rho` double DEFAULT NULL,
  `bp_mat_e` double DEFAULT NULL,
  `bp_mat_c` double DEFAULT NULL,
  `abr_layout_shape` varchar(50) DEFAULT NULL,
  `abr_rect_nbr_x` int(2) DEFAULT NULL,
  `abr_rect_nbr_z` int(2) DEFAULT NULL,
  `abr_rect_sx` double DEFAULT NULL,
  `abr_rect_sz` double DEFAULT NULL,
  `abr_rect_roty` double DEFAULT NULL,
  `abr_nbr_grp_circ` int(2) DEFAULT NULL,
  `abr_nbr_eagrp_circ` int(2) DEFAULT NULL,
  `abr_angle_1stAbr_1stGrp` double DEFAULT NULL,
  `abr_angle_spcn_eagrp` double DEFAULT NULL,
  `abr_linear_dist_eagrp` double DEFAULT NULL,
  `abr_nbr_eacirc` int(2) DEFAULT NULL,
  `abr_first_abr_angle` double DEFAULT NULL,
  `abr_nbr_circs` int(2) DEFAULT NULL,
  `abr_spcn_btw_circs` int(2) DEFAULT NULL,
  `abr_icirc_dia` int(2) DEFAULT NULL,
  `abr_dia` double DEFAULT NULL,
  `abr_nbr_nuts_abv_bp` int(2) DEFAULT NULL,
  `abr_nbr_nuts_blw_bp` int(2) DEFAULT NULL,
  `abr_lth_abv_bp_top` double DEFAULT NULL,
  `abr_mat` varchar(20) DEFAULT NULL,
  `abr_mat_fy` double DEFAULT NULL,
  `abr_mat_fu` double DEFAULT NULL,
  `abr_mat_rho` double DEFAULT NULL,
  `abr_mat_e` double DEFAULT NULL,
  `abr_mat_c` double DEFAULT NULL,
  `abr_tn_avabl` varchar(55) DEFAULT NULL,
  `abr_tn_max` varchar(55) DEFAULT NULL,
  `stfnr_status` int(2) DEFAULT NULL,
  `stfnr_layout_ptrn` varchar(10) DEFAULT NULL,
  `stfnr_d1` double DEFAULT NULL,
  `stfnr_d3` double DEFAULT NULL,
  `stfnr_thk` double DEFAULT NULL,
  `stfnr_notch` double DEFAULT NULL,
  `stfnr_mat` varchar(20) DEFAULT NULL,
  `stfnr_mat_fy` double DEFAULT NULL,
  `stfnr_mat_fu` double DEFAULT NULL,
  `stfnr_mat_rho` double DEFAULT NULL,
  `stfnr_mat_e` double DEFAULT NULL,
  `stfnr_mat_c` double DEFAULT NULL,
  `stfnr_weld_type` varchar(20) DEFAULT NULL,
  `stfnr_weld_grv_dpth` double DEFAULT NULL,
  `stfnr_weld_grv_angle` double DEFAULT NULL,
  `stfnr_weld_fillet_H` double DEFAULT NULL,
  `stfnr_weld_fillet_V` double DEFAULT NULL,
  `stfnr_weld_mat` varchar(20) DEFAULT NULL,
  `stfnr_weld_mat_fy` double DEFAULT NULL,
  `stfnr_weld_mat_fu` double DEFAULT NULL,
  `bf_shape` varchar(50) DEFAULT NULL,
  `bf_c_od` double DEFAULT NULL,
  `bf_rect_dx` double DEFAULT NULL,
  `bf_rect_dz` double DEFAULT NULL,
  `bf_rect_roty` double DEFAULT NULL,
  `bf_rp_nbr_sides` int(2) DEFAULT NULL,
  `bf_rp_od_f2f` double DEFAULT NULL,
  `bf_rp_od_c2c` double DEFAULT NULL,
  `bf_rp_1st_cnr_angle` double DEFAULT NULL,
  `bf_crcmfrc` double DEFAULT NULL,
  `grt_status` int(2) DEFAULT NULL,
  `grt_mat` varchar(20) DEFAULT NULL,
  `grt_mat_fcp` double DEFAULT NULL,
  `grt_spcn` double DEFAULT NULL,
  `grt_thk` double DEFAULT NULL,
  `grt_delta_d1` double DEFAULT NULL,
  `grt_delta_d2` double DEFAULT NULL,
  `design_method` varchar(50) DEFAULT NULL,
  `R_method` varchar(55) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `abc_ndx` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=148 ;

--
-- Дамп данных таблицы `bc2d`
--

INSERT INTO `bc2d` (`id`, `userscalcPK`, `pageAppNo`, `show_plot`, `simplified`, `cnvs_minsidelth`, `design_code`, `lrfd_type`, `g_phi_bolt`, `g_phi_rod`, `g_phi_plate`, `R_code`, `R_M`, `R_P`, `R_V`, `R_V_dir_angle`, `pc_mftr`, `pc_shape`, `pc_c_od`, `pc_rp_nbr_sides`, `pc_rp_od_f2f`, `pc_rp_od_c2c`, `pc_rp_first_cnr_angle`, `pc_crcmfrc`, `pc_steel_shape_type`, `pc_steel_shape_size`, `pc_steel_shape_roty`, `pc_thk`, `pc_mat`, `pc_mat_fy`, `pc_mat_fu`, `pc_mat_rho`, `pc_mat_e`, `pc_mat_c`, `pc_area`, `pc_amoi`, `pc_reinf_weld_fillet`, `pc_reinf_weld_fillet_size`, `bp_shape`, `bp_c_od`, `bp_rp_nbr_sides`, `bp_rp_od_f2f`, `bp_rp_od_c2c`, `bp_rp_first_cnr_angle`, `bp_crcmfrc`, `bp_rect_dx`, `bp_rect_dz`, `bp_rect_roty`, `bp_ihole_dia`, `bp_thk`, `bp_mat`, `bp_mat_fy`, `bp_mat_fu`, `bp_eff_wth`, `bp_mat_rho`, `bp_mat_e`, `bp_mat_c`, `abr_layout_shape`, `abr_rect_nbr_x`, `abr_rect_nbr_z`, `abr_rect_sx`, `abr_rect_sz`, `abr_rect_roty`, `abr_nbr_grp_circ`, `abr_nbr_eagrp_circ`, `abr_angle_1stAbr_1stGrp`, `abr_angle_spcn_eagrp`, `abr_linear_dist_eagrp`, `abr_nbr_eacirc`, `abr_first_abr_angle`, `abr_nbr_circs`, `abr_spcn_btw_circs`, `abr_icirc_dia`, `abr_dia`, `abr_nbr_nuts_abv_bp`, `abr_nbr_nuts_blw_bp`, `abr_lth_abv_bp_top`, `abr_mat`, `abr_mat_fy`, `abr_mat_fu`, `abr_mat_rho`, `abr_mat_e`, `abr_mat_c`, `abr_tn_avabl`, `abr_tn_max`, `stfnr_status`, `stfnr_layout_ptrn`, `stfnr_d1`, `stfnr_d3`, `stfnr_thk`, `stfnr_notch`, `stfnr_mat`, `stfnr_mat_fy`, `stfnr_mat_fu`, `stfnr_mat_rho`, `stfnr_mat_e`, `stfnr_mat_c`, `stfnr_weld_type`, `stfnr_weld_grv_dpth`, `stfnr_weld_grv_angle`, `stfnr_weld_fillet_H`, `stfnr_weld_fillet_V`, `stfnr_weld_mat`, `stfnr_weld_mat_fy`, `stfnr_weld_mat_fu`, `bf_shape`, `bf_c_od`, `bf_rect_dx`, `bf_rect_dz`, `bf_rect_roty`, `bf_rp_nbr_sides`, `bf_rp_od_f2f`, `bf_rp_od_c2c`, `bf_rp_1st_cnr_angle`, `bf_crcmfrc`, `grt_status`, `grt_mat`, `grt_mat_fcp`, `grt_spcn`, `grt_thk`, `grt_delta_d1`, `grt_delta_d2`, `design_method`, `R_method`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(144, '217', 266, NULL, NULL, NULL, 'TIA-222-G', 'AISC', NULL, NULL, NULL, 'TIA-222-G', 6200, 25, 48, 125, 'other', 'circular', 39, 12, NULL, NULL, 45, 122.52, NULL, NULL, NULL, 0.4688, 'A572-65', 65, 80, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'circular', 54, 12, 0, 0, 0.79, 169.65, 42, 42, NULL, NULL, 1.5, 'A572-65', 50, 65, NULL, NULL, NULL, NULL, 'circular', NULL, NULL, NULL, NULL, 0, 4, 4, 45, 15, 0, 8, 15, NULL, NULL, 23, 2.25, 1, 0, 4, 'A615-J', 75, 100, NULL, NULL, NULL, NULL, NULL, 1, '1p2', 8, 18, 0.5, 0.5, 'A36', 36, 0, NULL, NULL, NULL, 'fillet', NULL, NULL, 0.5, 0.31, NULL, 70, 0, 'rectangular', 72, 96, 72, 20, NULL, NULL, NULL, NULL, 336, 1, 'C40', 4, 3, 3, 2, 3, 'LRFD', 'LRFD', NULL, NULL, '2017-02-21 15:41:19', NULL, '0000-00-00 00:00:00'),
(145, '212', 266, NULL, NULL, NULL, 'TIA-222-G', 'AISC', NULL, NULL, NULL, 'TIA-222-G', 6200, 25, 48, 30, 'other', 'polygon', 36, 12, 36, 37.27, 35, 0, NULL, NULL, 0, 0.4688, 'A572-65', 65, 80, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'circular', 54, 12, 0, 0, 0.79, 169.65, 42, 42, NULL, NULL, 1.5, 'A572-65', 50, 65, NULL, NULL, NULL, NULL, 'circgrp', NULL, NULL, NULL, NULL, 0, 4, 4, 45, 15, 0, 12, 45, NULL, NULL, 23, 2.25, 1, 1, 8, 'A615-J', 75, 100, NULL, NULL, NULL, NULL, NULL, 1, '1p2', 8, 18, 0.5, 0.5, 'A36', 36, 0, NULL, NULL, NULL, 'fillet', NULL, NULL, 0.5, 0.31, NULL, 70, 0, 'circular', 72, 48, 60, 20, NULL, NULL, NULL, NULL, 226.19, 1, 'C40', 4, 3, 3, 2, 3, 'LRFD', 'LRFD', NULL, NULL, '2017-02-21 15:43:14', NULL, '0000-00-00 00:00:00'),
(146, '216', 266, NULL, NULL, NULL, 'TIA-222-G', 'AISC', NULL, NULL, NULL, 'TIA-222-G', 6200, 25, 48, 30, 'other', 'polygon', 36, 12, 36, 37.27, 35, 0, NULL, NULL, 0, 0.4688, 'A572-65', 65, 80, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'circular', 54, 12, 0, 0, 0.79, 169.65, 42, 42, NULL, NULL, 1.5, 'A572-65', 50, 65, NULL, NULL, NULL, NULL, 'circgrp', NULL, NULL, NULL, NULL, 0, 4, 4, 45, 15, 0, 12, 45, NULL, NULL, 23, 2.25, 1, 1, 8, 'A615-J', 75, 100, NULL, NULL, NULL, NULL, NULL, 1, '1p2', 8, 18, 0.5, 0.5, 'A36', 36, 0, NULL, NULL, NULL, 'fillet', NULL, NULL, 0.5, 0.31, NULL, 70, 0, 'circular', 72, 48, 60, 20, NULL, NULL, NULL, NULL, 226.19, 1, 'C40', 4, 3, 3, 2, 3, 'LRFD', 'LRFD', NULL, NULL, '2017-02-21 15:43:24', NULL, '0000-00-00 00:00:00'),
(147, '216', 266, NULL, NULL, NULL, 'TIA-222-G', 'AISC', NULL, NULL, NULL, 'TIA-222-G', 6201, 25, 48, 30, 'other', 'polygon', 36, 12, 36, 37.27, 35, 0, NULL, NULL, NULL, 0.4688, 'A572-65', 65, 80, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'circular', 54, NULL, 0, 0, NULL, 169.65, NULL, NULL, NULL, NULL, 1.5, 'A572-65', 50, 65, NULL, NULL, NULL, NULL, 'circgrp', NULL, NULL, NULL, NULL, NULL, 4, 4, 45, 15, 0, 12, 45, NULL, NULL, 23, 2.25, 1, 1, 8, 'A615-J', 75, 100, NULL, NULL, NULL, NULL, NULL, 1, '1p2', 8, 18, 0.5, 0.5, 'A36', 36, 0, NULL, NULL, NULL, 'fillet', NULL, NULL, 0.5, 0.31, NULL, NULL, NULL, 'circular', 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 226.19, 1, 'concrete', 4, 3, 3, 2, 3, 'LRFD', 'LRFD', NULL, NULL, '2017-02-21 15:43:29', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `bc2d_units`
--

CREATE TABLE IF NOT EXISTS `bc2d_units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbtable` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `var` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `notes` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Дамп данных таблицы `bc2d_units`
--

INSERT INTO `bc2d_units` (`id`, `dbtable`, `var`, `unit`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'bc2d', 'cnvs_minsidelth', 'pts', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(2, 'bc2d', 'pc_circ_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(3, 'bc2d', 'pc_rp_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(4, 'bc2d', 'pc_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(5, 'bc2d', 'pc_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(6, 'bc2d', 'pc_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(7, 'bc2d', 'pc_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(8, 'bc2d', 'pc_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(9, 'bc2d', 'pc_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(10, 'bc2d', 'pc_1st_cnr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(11, 'bc2d', 'pc_reinf_weld_fillet', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(12, 'bc2d', 'stfnr_d1', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(13, 'bc2d', 'stfnr_d2', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(14, 'bc2d', 'stfnr_d3', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(15, 'bc2d', 'stfnr_d4', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(16, 'bc2d', 'stfnr_d5', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(17, 'bc2d', 'stfnr_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(18, 'bc2d', 'stfnr_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(19, 'bc2d', 'stfnr_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(20, 'bc2d', 'stfnr_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(21, 'bc2d', 'stfnr_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(22, 'bc2d', 'stfnr_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(23, 'bc2d', 'bp_circ_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(24, 'bc2d', 'bp_rp_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(26, 'bc2d', 'bp_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(27, 'bc2d', 'bp_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(28, 'bc2d', 'bp_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(29, 'bc2d', 'bp_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(30, 'bc2d', 'bp_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(31, 'bc2d', 'bp_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(32, 'bc2d', 'bp_1st_cnr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(33, 'bc2d', 'bp_hole_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(34, 'bc2d', 'abr_dia', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(35, 'bc2d', 'abr_area', 'in.^2', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(36, 'bc2d', 'abr_nbr_r_spcn', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(37, 'bc2d', 'abr_1st_abr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(38, 'bc2d', 'abr_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(39, 'bc2d', 'abr_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(40, 'bc2d', 'abr_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(41, 'bc2d', 'abr_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(42, 'bc2d', 'abr_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(43, 'bc2d', 'abr_lth_abv_bptop', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(44, 'bc2d', 'grt_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(45, 'bc2d', 'grt_spcn', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(46, 'bc2d', 'grt_delta_d1', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(47, 'bc2d', 'grt_delta_d2', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(48, 'bc2d', 'grt_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(49, 'bc2d', 'grt_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(50, 'bc2d', 'grt_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(51, 'bc2d', 'grt_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(52, 'bc2d', 'grt_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(53, 'bc2d', 'bf_circ_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(54, 'bc2d', 'bf_rect_dx', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(55, 'bc2d', 'bf_rect_dz', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(56, 'bc2d', 'bf_rp_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(57, 'bc2d', 'bf_1st_cnr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `concmix`
--

CREATE TABLE IF NOT EXISTS `concmix` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `cmnt_sp_gr` double DEFAULT NULL,
  `fly_ash_slag_sp_gr` double DEFAULT NULL,
  `silica_fume_sp_gr` double DEFAULT NULL,
  `ca1_ssd_sp_gr` double DEFAULT NULL,
  `ca1_abs` double DEFAULT NULL,
  `ca1_druw` double DEFAULT NULL,
  `ca2_ssd_sp_gr` double DEFAULT NULL,
  `ca2_abs` double DEFAULT NULL,
  `ca2_druw` double DEFAULT NULL,
  `fa_ssd_sp_gr` double DEFAULT NULL,
  `fa_abs` double DEFAULT NULL,
  `fa_fm` double DEFAULT NULL,
  `max_w_cm_ratio` double DEFAULT NULL,
  `min_cmt_factor` double DEFAULT NULL,
  `pzln_slag_pcrt` double DEFAULT NULL,
  `silica_fume_pcrt` double DEFAULT NULL,
  `expsr_air_entr` varchar(45) DEFAULT NULL,
  `trgt_slump` varchar(45) DEFAULT NULL,
  `ca_nom_max_size` varchar(45) DEFAULT NULL,
  `admix1_dose` double DEFAULT NULL,
  `admix2_dose` double DEFAULT NULL,
  `admix3_dose` double DEFAULT NULL,
  `b_ov_bo_trial_ov_other_auto` double DEFAULT NULL,
  `b_ov_bo_trial_ov_other_ipt` double DEFAULT NULL,
  `cmnt_lot` double DEFAULT NULL,
  `cmnt_desptn` varchar(45) DEFAULT NULL,
  `cmnt_qpcy_design` double DEFAULT NULL,
  `cmnt_qpcy_abs` double DEFAULT NULL,
  `fly_ash_slag_lot` double DEFAULT NULL,
  `fly_ash_slag_desptn` varchar(45) DEFAULT NULL,
  `fly_ash_slag_qpcy_design` double DEFAULT NULL,
  `fly_ash_slag_qpcy_abs` double DEFAULT NULL,
  `silica_fume_lot` double DEFAULT NULL,
  `silica_fume_desptn` varchar(45) DEFAULT NULL,
  `silica_fume_qpcy_design` double DEFAULT NULL,
  `silica_fume_qpcy_abs` double DEFAULT NULL,
  `ssd_ca_lot` double DEFAULT NULL,
  `ssd_ca_desptn` varchar(45) DEFAULT NULL,
  `ssd_ca_qpcy_design` double DEFAULT NULL,
  `ssd_ca_qpcy_abs` double DEFAULT NULL,
  `ssd_ca1_lot` double DEFAULT NULL,
  `ssd_ca1_desptn` varchar(45) DEFAULT NULL,
  `ssd_ca1_pcrt` double DEFAULT NULL,
  `ssd_ca1_qpcy_design` double DEFAULT NULL,
  `ssd_ca1_qpcy_abs` double DEFAULT NULL,
  `ssd_ca2_lot` double DEFAULT NULL,
  `ssd_ca2_desptn` varchar(45) DEFAULT NULL,
  `ssd_ca2_pcrt` double DEFAULT NULL,
  `ssd_ca2_qpcy_design` double DEFAULT NULL,
  `ssd_ca2_qpcy_abs` double DEFAULT NULL,
  `ssd_fa_lot` double DEFAULT NULL,
  `ssd_fa_desptn` varchar(45) DEFAULT NULL,
  `ssd_fa_qpcy_design` double DEFAULT NULL,
  `ssd_fa_qpcy_abs` double DEFAULT NULL,
  `mixing_water_lot` double DEFAULT NULL,
  `mixing_water_desptn` double DEFAULT NULL,
  `mixing_water_w_cm` double DEFAULT NULL,
  `mixing_water_vol_in_admix` double DEFAULT NULL,
  `mixing_water_lbs_ex_admix` double DEFAULT NULL,
  `mixing_water_qpcy_design` double DEFAULT NULL,
  `mixing_water_qpcy_abs` double DEFAULT NULL,
  `air_content_lot` double DEFAULT NULL,
  `air_content_desptn` varchar(45) DEFAULT NULL,
  `air_content_qpcy_design` double DEFAULT NULL,
  `air_content_qpcy_abs` double DEFAULT NULL,
  `admix 1_lot` double DEFAULT NULL,
  `admix 1_desptn` varchar(45) DEFAULT NULL,
  `admix 1_qpcy_design` double DEFAULT NULL,
  `admix 1_qpcy_abs` double DEFAULT NULL,
  `admix 2_lot` double DEFAULT NULL,
  `admix 2_desptn` varchar(45) DEFAULT NULL,
  `admix 2_qpcy_design` double DEFAULT NULL,
  `admix 2_qpcy_abs` double DEFAULT NULL,
  `admix 3_lot` double DEFAULT NULL,
  `admix 3_desptn` varchar(45) DEFAULT NULL,
  `admix 3_qpcy_design` double DEFAULT NULL,
  `admix 3_qpcy_abs` double DEFAULT NULL,
  `fiber_lot` double DEFAULT NULL,
  `fiber_desptn` varchar(45) DEFAULT NULL,
  `fiber_qpcy_design` double DEFAULT NULL,
  `fiber_qpcy_abs` double DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gsi_sites`
--

CREATE TABLE IF NOT EXISTS `gsi_sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `street` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `state` varchar(20) NOT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `long` varchar(20) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `gsi_sites`
--

INSERT INTO `gsi_sites` (`id`, `userscalcPK`, `pageAppNo`, `street`, `city`, `state`, `zip`, `lat`, `long`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(5, '210', NULL, 'Street', '', '', '', '', '', NULL, '2017-02-21 12:54:48', NULL, '0000-00-00 00:00:00'),
(6, '218', NULL, 'Street', 'City123', '', '', '', '', NULL, '2017-02-24 09:20:27', NULL, '0000-00-00 00:00:00'),
(7, '219', NULL, '', '', 'KS', '', '39.0119', '-98.4842', NULL, '2017-02-24 16:21:02', NULL, '0000-00-00 00:00:00'),
(8, '220', NULL, '101 cuvasion Ct', 'Cary', 'NC', '27519', '35.7949', '-78.8792', NULL, '2017-03-06 17:49:40', NULL, '0000-00-00 00:00:00'),
(9, '221', NULL, '1600 Pennsylvania Ave NW', 'Washington', 'DC', '20500', '38.8977', '-77.0365', NULL, '2017-03-08 18:10:34', NULL, '0000-00-00 00:00:00'),
(10, '222', NULL, '1600 Pennsylvania Ave NW', 'Washington', 'DC', '20500', '38.8977', '-77.0365', NULL, '2017-03-08 18:11:15', NULL, '0000-00-00 00:00:00'),
(11, '223', NULL, '101 cuvasion ct', 'cary', 'NC', '27519', '35.7949', '-78.8792', NULL, '2017-03-11 02:56:51', NULL, '0000-00-00 00:00:00'),
(12, '340', NULL, '101 Cuvasion Ct', 'Cary', 'NC', '27519', '35.7949', '-78.8792', NULL, '2017-08-12 00:19:53', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `gsi_site_bhs`
--

CREATE TABLE IF NOT EXISTS `gsi_site_bhs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` varchar(100) DEFAULT NULL,
  `bh_id` int(11) DEFAULT NULL,
  `bh_name` varchar(55) DEFAULT NULL,
  `soil_clasfctn_type` varchar(60) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `long` double DEFAULT NULL,
  `description` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Дамп данных таблицы `gsi_site_bhs`
--

INSERT INTO `gsi_site_bhs` (`id`, `site_id`, `bh_id`, `bh_name`, `soil_clasfctn_type`, `lat`, `long`, `description`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(5, '5', NULL, 'name', NULL, NULL, NULL, 'description', NULL, '2017-02-21 12:58:07', NULL, '0000-00-00 00:00:00'),
(6, '6', NULL, 'Name', NULL, NULL, NULL, 'TestBoring', NULL, '2017-02-24 09:20:27', NULL, '0000-00-00 00:00:00'),
(7, '5', NULL, 'name2', NULL, NULL, NULL, 'descr', NULL, '2017-02-24 11:21:57', NULL, '0000-00-00 00:00:00'),
(8, '6', NULL, '2B', NULL, NULL, NULL, 'test', NULL, '2017-02-24 13:38:41', NULL, '0000-00-00 00:00:00'),
(9, '7', 0, 'EAST', NULL, NULL, NULL, '', 0, '2017-02-24 16:21:02', 0, '0000-00-00 00:00:00'),
(10, '7', NULL, 'WEST', NULL, NULL, NULL, '', NULL, '2017-02-24 16:54:33', NULL, '0000-00-00 00:00:00'),
(11, '8', NULL, 'A', NULL, NULL, NULL, '', NULL, '2017-03-06 17:50:27', NULL, '0000-00-00 00:00:00'),
(12, '8', NULL, 'B', NULL, NULL, NULL, '', NULL, '2017-03-06 17:50:29', NULL, '0000-00-00 00:00:00'),
(13, '9', NULL, 'a', NULL, NULL, NULL, '', NULL, '2017-03-08 18:10:34', NULL, '0000-00-00 00:00:00'),
(14, '9', NULL, 'b', NULL, NULL, NULL, '', NULL, '2017-03-08 18:10:34', NULL, '0000-00-00 00:00:00'),
(15, '10', 0, 'East', NULL, NULL, NULL, 'TRE', 0, '2017-03-08 18:11:15', 0, '0000-00-00 00:00:00'),
(16, '10', 0, 'West', NULL, NULL, NULL, 'GRF', 0, '2017-03-08 18:11:15', 0, '0000-00-00 00:00:00'),
(17, '11', NULL, 'sdf', NULL, NULL, NULL, '', NULL, '2017-03-11 02:56:51', NULL, '0000-00-00 00:00:00'),
(18, '11', NULL, 'de', NULL, NULL, NULL, '', NULL, '2017-03-11 02:56:51', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `gsi_site_bh_p`
--

CREATE TABLE IF NOT EXISTS `gsi_site_bh_p` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh_id` int(3) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `top` double DEFAULT NULL,
  `bot` double DEFAULT NULL,
  `thk` double DEFAULT NULL,
  `clasfctn` varchar(50) DEFAULT NULL,
  `eftv_unit_wt` double DEFAULT NULL,
  `udrnd_cohesion` double DEFAULT NULL,
  `ndfot_e50` double DEFAULT NULL,
  `J_ftr` double DEFAULT NULL,
  `ndfot_k` double DEFAULT NULL,
  `frtn_angle` double DEFAULT NULL,
  `spt_bc` double DEFAULT NULL,
  `rsdl_strgth` double DEFAULT NULL,
  `e50` double DEFAULT NULL,
  `uniaxial_cmpr_strength` double DEFAULT NULL,
  `initial_mdls_rock_mass` double DEFAULT NULL,
  `rqd` double DEFAULT NULL,
  `k_rm` double DEFAULT NULL,
  `soil_test_type` varchar(20) DEFAULT NULL,
  `cone_tip_rstnc` double DEFAULT NULL,
  `dltmtr_mdls` double DEFAULT NULL,
  `prsrmtr_mdls` double DEFAULT NULL,
  `rock_type` varchar(20) DEFAULT NULL,
  `poisn_ratio` double DEFAULT NULL,
  `gsi` double DEFAULT NULL,
  `intact_rock_mdls` double DEFAULT NULL,
  `rock_mass_mdls` double DEFAULT NULL,
  `elastic_subgrade_ractn` double DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `abc_ndx` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `gsi_site_bh_p`
--

INSERT INTO `gsi_site_bh_p` (`id`, `bh_id`, `type`, `top`, `bot`, `thk`, `clasfctn`, `eftv_unit_wt`, `udrnd_cohesion`, `ndfot_e50`, `J_ftr`, `ndfot_k`, `frtn_angle`, `spt_bc`, `rsdl_strgth`, `e50`, `uniaxial_cmpr_strength`, `initial_mdls_rock_mass`, `rqd`, `k_rm`, `soil_test_type`, `cone_tip_rstnc`, `dltmtr_mdls`, `prsrmtr_mdls`, `rock_type`, `poisn_ratio`, `gsi`, `intact_rock_mdls`, `rock_mass_mdls`, `elastic_subgrade_ractn`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 5, 'stiff_clay_wofwto', 2, 12, 10, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-07 08:56:30', 0, '0000-00-00 00:00:00'),
(2, 15, 'sand_reese', 0, 10, 10, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-08 18:19:22', 0, '0000-00-00 00:00:00'),
(3, 15, 'silt', 10, 70, 60, '', 150, 50, 0, 0, 0, 0, 0, 0, 25, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-08 18:19:31', 0, '0000-00-00 00:00:00'),
(4, 15, 'massive_rock', 70, 150, 80, '', 54, 23, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-11 02:38:48', 0, '0000-00-00 00:00:00'),
(5, 17, 'soft_clay_m', 3, 4, 10, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-11 02:56:51', 0, '0000-00-00 00:00:00'),
(6, 17, 'soft_clay_m', NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-11 03:00:03', NULL, '0000-00-00 00:00:00'),
(7, 16, 'weak_rock', 0, 15, 15, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-21 02:44:02', 0, '0000-00-00 00:00:00'),
(8, 15, 'sand_reese', 150, 190, 40, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-21 19:03:05', 0, '0000-00-00 00:00:00'),
(9, 5, 'sand_reese', 12, 27, 15, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-22 15:50:47', 0, '0000-00-00 00:00:00'),
(10, 16, 'lifquifiable_sand_hybrid', 20, 43, 23, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, 0, '', 0, '2017-03-22 18:57:03', 0, '0000-00-00 00:00:00'),
(11, 16, 'stiff_clay_wofwto', NULL, NULL, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-22 18:57:11', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `gsi_site_files`
--

CREATE TABLE IF NOT EXISTS `gsi_site_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` int(11) NOT NULL,
  `site_id` varchar(100) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `description` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `gsi_site_files`
--

INSERT INTO `gsi_site_files` (`id`, `userscalcPK`, `site_id`, `file_id`, `file_name`, `file_type`, `description`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(12, 210, NULL, NULL, 'phones.png', NULL, 'test', NULL, '2017-02-22 15:21:59', NULL, '0000-00-00 00:00:00'),
(14, 219, NULL, NULL, '16-046-Structural-Analysis.pdf', 'doc', NULL, NULL, '2017-02-24 16:21:52', NULL, '0000-00-00 00:00:00'),
(15, 219, NULL, NULL, '6A---Watertown-CUP-Amendment-CC_8.11.2016.pdf', 'doc', NULL, NULL, '2017-02-24 16:34:07', NULL, '0000-00-00 00:00:00'),
(16, 223, NULL, NULL, '07-GB_Column_Bases.pdf', 'doc', NULL, NULL, '2017-03-11 03:01:11', NULL, '0000-00-00 00:00:00'),
(41, 210, NULL, NULL, 'landscape-mountains-nature-clouds.jpg', 'photo', NULL, NULL, '2017-03-30 14:36:48', NULL, '0000-00-00 00:00:00'),
(38, 222, NULL, NULL, '2017-01-25 21.04.01.jpg', 'doc', NULL, NULL, '2017-03-24 19:29:18', NULL, '0000-00-00 00:00:00'),
(20, 218, NULL, NULL, 'Dryshampoo.png', 'photo', '', NULL, '2017-03-20 15:30:03', NULL, '0000-00-00 00:00:00'),
(21, 222, NULL, NULL, 'ä½¿ç”¨è¯´æ˜Ž.txt', 'doc', NULL, NULL, '2017-03-20 15:37:40', NULL, '0000-00-00 00:00:00'),
(22, 222, NULL, NULL, 'Piano.docx', 'doc', NULL, NULL, '2017-03-20 15:39:33', NULL, '0000-00-00 00:00:00'),
(23, 222, NULL, NULL, 'UWS6-NP%20(Assembly).pdf', 'doc', NULL, NULL, '2017-03-20 15:47:33', NULL, '0000-00-00 00:00:00'),
(40, 210, NULL, NULL, 'test.txt', 'doc', NULL, NULL, '2017-03-29 14:39:00', NULL, '0000-00-00 00:00:00'),
(39, 210, NULL, NULL, 'about_image_temp.jpg', 'doc', NULL, NULL, '2017-03-29 14:17:36', NULL, '0000-00-00 00:00:00'),
(32, 222, NULL, NULL, 'bass-staff-letters.jpg', 'photo', '', NULL, '2017-03-20 18:41:36', NULL, '0000-00-00 00:00:00'),
(30, 222, NULL, NULL, 'treble-staff-letters.jpg', 'photo', 'dfe', NULL, '2017-03-20 18:40:07', NULL, '0000-00-00 00:00:00'),
(31, 222, NULL, NULL, '13.png', 'photo', '', NULL, '2017-03-20 18:41:29', NULL, '0000-00-00 00:00:00'),
(34, 222, NULL, NULL, 'base-plate-design.jpg', 'photo', '', NULL, '2017-03-22 19:15:26', NULL, '0000-00-00 00:00:00'),
(42, 340, NULL, NULL, 'COVER.jpg', 'photo', '', NULL, '2017-08-12 00:20:25', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `menutree`
--

CREATE TABLE IF NOT EXISTS `menutree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT '0',
  `tab` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `company` varchar(256) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `calcAppName` varchar(255) NOT NULL,
  `accessLevel` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `tooltip` varchar(255) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=327 ;

--
-- Дамп данных таблицы `menutree`
--

INSERT INTO `menutree` (`id`, `id_parent`, `id_user`, `tab`, `type`, `company`, `owner`, `name`, `link`, `url`, `calcAppName`, `accessLevel`, `status`, `notes`, `tooltip`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(105, 92, 0, 'Code', 'file', NULL, NULL, 'DP of Steel Shapes', 'ALL/code/AISC/SCM/dim_and_properties.php', 'SteelShape', '', 'basic', 'active', 'Dim and properties notes', 'Dim and properties', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:52:55'),
(138, 0, 0, 'Favorite', 'link', NULL, NULL, '', '105', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-05-24 08:50:29'),
(139, 0, 0, 'Application', 'link', NULL, NULL, '', '105', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-05-24 08:50:36'),
(151, 166, 0, 'Code', 'file', NULL, NULL, 'Velocity Pressure', 'ALL/code/TIA/222/G/VP/velocity_pressure.php', 'TIA-222-G-VP', 'VP', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:53:01'),
(155, 0, 71, 'Discipline', 'folder', NULL, NULL, 'Mechanical', '', 'M', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-05-18 02:20:13'),
(156, 0, 71, 'Discipline', 'folder', NULL, NULL, 'Civil', '', 'C', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(157, 0, 71, 'Discipline', 'folder', NULL, NULL, 'Structural', '', 'S', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(158, 157, 71, 'Discipline', 'folder', NULL, NULL, 'Concrete', '', 'C', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(159, 157, 71, 'Discipline', 'folder', NULL, NULL, 'Steel', '', 'S', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(160, 0, 71, 'Favorite', 'link', NULL, NULL, '', '105', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-05-24 08:49:38'),
(162, 0, 135, 'Favorite', 'link', NULL, NULL, '', '105', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-05-24 08:49:47'),
(165, 153, 71, 'Code', 'folder', NULL, NULL, '222', '', '2', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(166, 165, 71, 'Code', 'folder', NULL, NULL, 'G', '', 'G', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(173, 0, 119, 'Favorite', 'link', NULL, NULL, '', '151', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(174, 0, 134, 'Discipline', 'file', '', NULL, '123', '123', '123', '123', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(175, 0, 119, 'Code', 'folder', NULL, NULL, 'Code', '', 'C', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-13 08:54:18'),
(176, 0, 119, 'Code', 'folder', '', NULL, 'Discipline', '', 'D', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(177, 175, 119, 'Code', 'folder', NULL, NULL, 'AISC', '', 'A', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-13 08:54:20'),
(178, 177, 119, 'Code', 'file', '', 'Jiazhu Hu', 'DP of Steel Shapes', 'ALL/code/AISC/SCM/dim_and_properties.php', 'DPoSS', 'DPoSS', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:53:09'),
(179, 175, 119, 'Code', 'folder', '', NULL, 'TIA', '', 'T', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(180, 179, 119, 'Code', 'folder', '', NULL, '222', '', '2', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(181, 180, 119, 'Code', 'folder', '', NULL, 'G', '', 'G', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(184, 0, 119, 'Code', 'folder', '', NULL, 'Application', '', 'A', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(192, 0, 119, 'Favorite', 'link', '', NULL, '', '178', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-13 08:54:54'),
(195, 0, 119, 'Private', 'file', '1', NULL, 'Velocity Pressure', 'ALL/code/TIA/222/G/VP/velocity_pressure.php', 'VP', 'TIA-222-G-VP', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:53:16'),
(198, 0, 134, 'Favorite', 'link', '', NULL, '', '178', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-13 08:54:59'),
(210, 180, 119, 'Code', 'appcomb', '', 'Jiazhu Hu', 'Wind Load', '', 'WL', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-02-02 10:45:01'),
(218, 0, 0, 'Private', 'folder', '1', NULL, 'Test', '', 'T', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-14 09:13:15'),
(219, 0, 0, 'Favorite', 'folder', '', NULL, 'A', '', '', '', 'basic', 'active', '', 'A', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(220, 0, 0, 'Favorite', 'folder', '', NULL, 'B', '', '', '', 'basic', 'active', '', 'B', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(221, 175, 0, 'Code', 'folder', '', NULL, 'AWWA', '', 'A', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(222, 221, 0, 'Code', 'folder', '', NULL, 'D100', '', 'D', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(223, 222, 0, 'Code', 'folder', '', NULL, '05', '', '0', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(224, 223, 0, 'Code', 'file', '', 'Jiazhu Hu', 'Wind Pressure', 'ALL/code/AWWA/D100/05/wind_pressure.php', 'AWWA_D100_05_WP', 'awwa-d100-05-wp', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-05-08 01:58:24'),
(228, 0, 119, 'Favorite', 'folder', '', NULL, 'Structural Design', '', '', '', 'basic', 'active', '', 'Structural Design', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(232, 0, 131, 'Favorite', 'folder', '', NULL, 'Structural', '', '', '', 'basic', 'active', '', 'Structural', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(237, 0, 131, 'Private', 'folder', '2', 'Jack Hu', 'Company AB', '', 'CA', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-14 09:13:12'),
(240, 237, 140, 'Private', 'file', '2', '', 'Test Private App1', '123', 'VP', 'VP', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-12-20 22:08:56'),
(244, 218, 140, 'Private', 'file', '1', '', 'Test e3c', 'ALL/code/AISC/SCM/dim_and_properties.php', 'TE', 't e c', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:53:37'),
(246, 0, 0, 'Private', 'folder', '1', '', 'Engineering3C', '', 'E', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2016-09-13 12:05:20'),
(247, 0, 0, 'Private', 'folder', '2', NULL, 'STIM', '', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(250, 237, 140, 'Private', 'file', '2', '', 'Test Privat App2', '', 'TPA2', 'TPA2', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2016-12-20 22:09:44'),
(252, 218, 140, 'Private', 'file', '1', NULL, 'node 001 e3c', '', 'N0E', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(253, 237, 140, 'Private', 'file', '2', NULL, 't p a03', '', 'TPA', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(254, 0, 131, '', 'folder', '', NULL, 'Chemical', '', 'C', '', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(255, 0, 155, 'Favorite', 'link', '', NULL, 'DP of Steel Shapes', '178', 'DPoSS', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(257, 232, 131, 'Favorite', 'link', '', NULL, 'DP of Steel Shapes', '178', 'DPoSS', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(259, 0, 131, '', 'folder', '', NULL, 'FDHVelocitel', '', 'F', '', '', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(260, 0, 131, '', 'file', '', NULL, 'Base Connection', '', 'BC', '', '', '', '', 'Base Connection', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(265, 181, 155, 'Code', 'file', '', NULL, 'Velocity Pressure', 'ALL/code/TIA/222/G/VP/velocity_pressure.php', 'TIA-222-G-VP', 'TIA-222-G-VP', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:53:44'),
(266, 184, 155, 'Code', 'file', '', 'Data Manager', 'Base Connection 2D', 'ALL/application/bc2d/bc2d.php', 'BC2D', 'BC2D', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:53:55'),
(267, 0, 100, 'Favorite', 'link', '', NULL, 'Base Connection (Simplified)', '266', 'BC(', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(268, 0, 100, 'Favorite', 'link', '', NULL, 'Velocity Pressure', '265', 'TIA-222-G-VP', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(269, 0, 100, 'Favorite', 'folder', '', NULL, 'Structure', '', '', '', 'basic', 'active', '', 'Structure', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(270, 269, 100, 'Favorite', 'link', '', NULL, 'Velocity Pressure', '265', 'TIA-222-G-VP', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(276, 0, 131, 'Favorite', 'link', '', NULL, 'Velocity Pressure', '265', 'TIA-222-G-VP', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(285, 0, 131, '', 'folder', '', NULL, 'Geotechnical', '', 'G', '', 'free', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(286, 0, 131, '', 'folder', '', NULL, 'Geotechnical', '', 'G', '', 'free', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(287, 0, 131, '', 'file', '', NULL, '', '', '', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(288, 0, 131, '', 'folder', '', NULL, 'Geotechnical', '', 'G', '', 'free', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(289, 0, 131, '', 'folder', '', NULL, 'Geotechnical', '', 'G', '', 'free', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(291, 0, 131, '', 'folder', '', NULL, 'Geotechnical', '', 'G', '', 'free', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(292, 0, 131, '', 'folder', '', NULL, 'Geotechnical', '', 'G', '', 'free', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(293, 0, 131, '', 'folder', '', NULL, 'test', '', 'T', '', 'free', 'active', '', 's', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(294, 0, 131, '', 'folder', '', NULL, 'g', '', 'G', '', 'free', 'active', '', 'g', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(295, 0, 131, '', 'folder', '', NULL, 'g', '', 'G', '', 'free', 'active', '', 'g', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(296, 0, 131, '', 'folder', '', NULL, 'G', '', 'G', '', 'basic', 'active', '', 'G', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(297, 0, 131, '', 'folder', '', NULL, 'g', '', 'G', '', 'free', 'active', '', 'g', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(302, 176, 155, 'Code', 'folder', '', 'Data Manager', 'Geotechnical', '', 'G', '', 'basic', 'active', '', 'Geotechnical', 0, '0000-00-00 00:00:00', 0, '2017-02-07 17:17:14'),
(303, 302, 155, 'Code', 'file', '', 'Data Manager', 'Site Investigation', 'ALL/discipline/geotechnical/site_invstgtn/site_invstgtn.php', 'GSI', 'GSI', 'basic', 'active', '', 'Soil Profile', 0, '0000-00-00 00:00:00', 0, '2017-04-18 15:54:23'),
(304, 0, 131, '', 'file', '', NULL, 'Report', '', 'R', 'GRPT', 'free', 'active', '', 'Geotechnical Report', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(305, 0, 131, '', 'folder', '', NULL, 'Mechanical', '', 'M', '', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(306, 232, 131, 'Favorite', 'link', '', NULL, 'Base Connection 2D', '266', 'BC2D', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(307, 0, 131, '', 'file', '', NULL, 'WL-Discrete', '', 'WD', 'WL-D', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(308, 0, 131, '', 'file', '', NULL, 'Wind Load on Discrete Appurtenance', '', 'WL_D', 'WL_D', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(309, 181, 155, 'Code', 'file', '', 'Data Manager', 'Wind Load Discrete Appurtenance', 'ALL/code/TIA/222/G/WL/DA/wl_da.php', 'WLDA', 'Wind Load for D.A.', 'basic', 'active', '', 'Discrete Appurtenance', 0, '0000-00-00 00:00:00', 0, '2017-07-15 21:27:49'),
(310, 0, 131, '', 'folder', '', NULL, 'test', '', 'T', '', '', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(311, 0, 131, '', 'folder', '', NULL, 'xx', '', 'X', '', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(312, 232, 131, 'Favorite', 'link', '', NULL, 'Velocity Pressure', '265', 'TIA-222-G-VP', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(313, 176, 155, 'Code', 'folder', '', 'Data Manager', 'Material', '', 'M', '', 'basic', 'active', '', 'Material', 0, '0000-00-00 00:00:00', 0, '2017-04-18 20:31:44'),
(315, 313, 155, 'Code', 'file', '', 'Data Manager', 'ConcMix', 'ALL/discipline/material/concrete/concmix/concmix.php', 'ConcMix', 'ConcMix', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-19 03:25:31'),
(316, 0, 131, 'Favorite', 'link', '', NULL, 'Concrete Mixture Design', '315', 'ConcMix', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2017-04-20 00:18:37'),
(322, 323, 0, 'Code', 'file', '', NULL, 'Wind Pressure', 'ALL/code/AWWA/D100/11/wind_pressure.php', 'AWWA_D100_11_WP', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, '2017-05-08 01:58:42'),
(323, 222, 0, 'Code', 'folder', '', NULL, '11', '', '1', '', 'free', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-05-08 01:56:12'),
(325, 181, 131, 'Code', 'file', '', 'Jiazhu Hu', 'Wind Load Structural Component', 'ALL/code/TIA/222/G/WL/SC/wl_sc.php', 'WLSC', 'WL_SC', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '2017-07-15 21:29:21'),
(326, 177, 140, 'Code', 'file', '', NULL, 'qweqwe', 'qweqe', 'Q', 'qweqe', 'basic', 'active', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `private_access`
--

CREATE TABLE IF NOT EXISTS `private_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitelok_PK` varchar(50) DEFAULT NULL,
  `menutree_PK` int(11) DEFAULT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `private_access`
--

INSERT INTO `private_access` (`id`, `sitelok_PK`, `menutree_PK`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, '140', 247, NULL, NULL, '2016-09-08 12:22:16', NULL, '0000-00-00 00:00:00'),
(2, '140', 246, NULL, NULL, '2016-09-09 13:26:01', NULL, '0000-00-00 00:00:00'),
(3, '141', 247, NULL, NULL, '2016-09-08 16:22:16', NULL, '0000-00-00 00:00:00'),
(4, '100', 246, NULL, NULL, '2016-09-09 17:26:01', NULL, '0000-00-00 00:00:00'),
(5, '100', 244, NULL, NULL, '2016-09-09 17:26:01', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `sp`
--

CREATE TABLE IF NOT EXISTS `sp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `boring_id` varchar(55) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `elev_top` double DEFAULT NULL,
  `elev_bot` double DEFAULT NULL,
  `thk` double DEFAULT NULL,
  `clasfctn` varchar(50) DEFAULT NULL,
  `eftv_unit_wt` double DEFAULT NULL,
  `friction_angle` double DEFAULT NULL,
  `cohesion` double DEFAULT NULL,
  `p_y_modulus` double DEFAULT NULL,
  `e50` double DEFAULT NULL,
  `er` double DEFAULT NULL,
  `unaxial_cmpr_strength` double DEFAULT NULL,
  `rqd` double DEFAULT NULL,
  `k_rm` double DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `abc_ndx` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `sp`
--

INSERT INTO `sp` (`id`, `userscalcPK`, `pageAppNo`, `boring_id`, `type`, `elev_top`, `elev_bot`, `thk`, `clasfctn`, `eftv_unit_wt`, `friction_angle`, `cohesion`, `p_y_modulus`, `e50`, `er`, `unaxial_cmpr_strength`, `rqd`, `k_rm`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(10, '210', 0, 'bid_2ef2729a7c89020e', 'clay', 0, 0, 40, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, '2017-02-17 11:47:21', 0, '0000-00-00 00:00:00'),
(11, '210', NULL, 'bid_2ef2729a7c89020e', 'clay_water', NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-02-17 11:47:38', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tia_222_g_gust_effect`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_gust_effect` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) NOT NULL,
  `strTYP` varchar(45) DEFAULT NULL,
  `str_type` varchar(45) DEFAULT NULL,
  `h` double DEFAULT NULL,
  `str_sptd_on_other_str` varchar(45) DEFAULT NULL,
  `G_h` double DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Дамп данных таблицы `tia_222_g_gust_effect`
--

INSERT INTO `tia_222_g_gust_effect` (`RcdNo`, `userscalcPK`, `pageAppNo`, `strTYP`, `str_type`, `h`, `str_sptd_on_other_str`, `G_h`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(71, '184', 196, NULL, 'latticed', 1, NULL, 0.85, NULL, NULL, '2016-08-31 12:55:11', NULL, '0000-00-00 00:00:00'),
(72, '63', 196, NULL, 'latticed', 90, NULL, 0.85, NULL, NULL, '2016-12-12 01:41:03', NULL, '0000-00-00 00:00:00'),
(73, '193', 196, NULL, 'latticed', 90, NULL, 0.85, NULL, NULL, '2016-12-12 19:38:55', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tia_222_g_vp`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_vp` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `expCAT` varchar(45) DEFAULT NULL,
  `z_g` double DEFAULT NULL,
  `alpha` double DEFAULT NULL,
  `K_zmin` double DEFAULT NULL,
  `K_e` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `K_z` double DEFAULT NULL,
  `topCAT` int(2) DEFAULT NULL,
  `K_t` double DEFAULT NULL,
  `f` double DEFAULT NULL,
  `H_crest` double DEFAULT NULL,
  `K_h` double DEFAULT NULL,
  `K_zt` double DEFAULT NULL,
  `K_zt5` double DEFAULT NULL,
  `K_d` double DEFAULT NULL,
  `windspeed_src` varchar(25) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `county` varchar(30) DEFAULT NULL,
  `loc_by` varchar(20) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `zipcode` int(5) DEFAULT NULL,
  `lat_long_format` varchar(10) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `lat_deg` double DEFAULT NULL,
  `long_min` double DEFAULT NULL,
  `lat_min` double DEFAULT NULL,
  `long_sec` double DEFAULT NULL,
  `lat_sec` double DEFAULT NULL,
  `long_deg` double DEFAULT NULL,
  `V` double DEFAULT NULL,
  `I` double DEFAULT NULL,
  `q_z` double DEFAULT NULL,
  `str_type` varchar(255) DEFAULT NULL,
  `purpose_of_calculation` varchar(100) DEFAULT NULL,
  `str_cros_sec` varchar(255) DEFAULT NULL,
  `str_class` varchar(255) DEFAULT NULL,
  `h_str` double DEFAULT NULL,
  `str_sptd_on_other_str` varchar(45) DEFAULT NULL,
  `G_h` double DEFAULT NULL,
  `t_i` double DEFAULT NULL,
  `K_iz` double DEFAULT NULL,
  `t_iz` double DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=172 ;

--
-- Дамп данных таблицы `tia_222_g_vp`
--

INSERT INTO `tia_222_g_vp` (`RcdNo`, `userscalcPK`, `pageAppNo`, `expCAT`, `z_g`, `alpha`, `K_zmin`, `K_e`, `z`, `K_z`, `topCAT`, `K_t`, `f`, `H_crest`, `K_h`, `K_zt`, `K_zt5`, `K_d`, `windspeed_src`, `state`, `county`, `loc_by`, `street`, `city`, `zipcode`, `lat_long_format`, `latitude`, `longitude`, `lat_deg`, `long_min`, `lat_min`, `long_sec`, `lat_sec`, `long_deg`, `V`, `I`, `q_z`, `str_type`, `purpose_of_calculation`, `str_cros_sec`, `str_class`, `h_str`, `str_sptd_on_other_str`, `G_h`, `t_i`, `K_iz`, `t_iz`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(135, '224', 265, 'C', 900, 9.5, 0.85, 1, 20, 0.9, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 15.86, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-23 18:13:24', NULL, '0000-00-00 00:00:00'),
(136, '225', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 14.98, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-03-23 18:14:53', NULL, '0000-00-00 00:00:00'),
(137, '226', 265, 'C', 900, 9.5, 0.85, 1, 90, 1.24, 3, 0.53, 2, NULL, 7.39, 1.15, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 25.13, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, '', 0.85, NULL, NULL, NULL, '', NULL, '2017-03-23 18:16:24', NULL, '0000-00-00 00:00:00'),
(138, '227', 265, 'C', 900, 9.5, 0.85, 1, 230, 1.51, 3, 0.53, 2, NULL, 2.27, 1.52, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 122, 0, 74.34, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2017-03-23 18:47:55', NULL, '0000-00-00 00:00:00'),
(139, '228', 265, 'D', 700, 11.5, 1.03, 1.1, 40, 1.22, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 190, 0, 95.84, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-03-24 14:45:24', NULL, '0000-00-00 00:00:00'),
(140, '229', 265, 'C', 900, 9.5, 0.85, 1, 20, 0.9, 3, 0.53, 2, 90, 1.56, 1.79, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 540, 0, 1022.21, 'latticed', 'wl_wIce', 'triangular', 'I', 2340, '', 1, NULL, NULL, NULL, '', NULL, '2017-03-24 14:47:44', NULL, '0000-00-00 00:00:00'),
(141, '236', 265, 'D', 700, 11.5, 1.03, 1.1, 9, 1.03, 3, 0.53, 2, 9, 7.39, 1.16, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 99, 0, 25.48, 'latticed', 'wl_wIce', 'triangular', 'I', 9, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-03-27 18:32:16', NULL, '0000-00-00 00:00:00'),
(142, '244', 265, 'B', 1200, 7, 0.7, 0.9, 123, 1.05, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, 0, 22.85, 'latticed', 'wl_wIce', 'triangular', 'I', 190, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:10:37', NULL, '0000-00-00 00:00:00'),
(143, '245', 265, 'B', 1200, 7, 0.7, 0.9, NULL, 0.7, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 12.34, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:12:57', NULL, '0000-00-00 00:00:00'),
(144, '246', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 1, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:26:18', NULL, '0000-00-00 00:00:00'),
(145, '247', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 2, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:31:47', NULL, '0000-00-00 00:00:00'),
(146, '248', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 2, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:32:53', NULL, '0000-00-00 00:00:00'),
(147, '249', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 2, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:33:18', NULL, '0000-00-00 00:00:00'),
(148, '250', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 2, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-10 14:33:55', NULL, '0000-00-00 00:00:00'),
(149, '252', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 2, 0.43, 1.25, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 14.98, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-04-19 12:25:19', NULL, '0000-00-00 00:00:00'),
(150, '255', 265, 'C', 900, 9.5, 0.85, 1, 0, 0.85, 3, 0.53, 2, 2, 1, 2.34, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', 0, '', 0.85, NULL, NULL, NULL, '', NULL, '2017-04-20 11:25:04', NULL, '0000-00-00 00:00:00'),
(151, '279', 265, 'C', 900, 9.5, 0.85, 1, 100, 1.27, 3, 0.53, 2, 20, 22003.64, 1, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 22.38, 'latticed', 'wl_wIce', 'triangular', 'I', 100, '', 0.85, 0.35, 0.8714, 0.61, '', NULL, '2017-05-29 23:42:07', NULL, '0000-00-00 00:00:00'),
(152, '281', 265, 'C', 900, 9.5, 0.85, 1, 90, 1.24, 3, 0.53, 2, 2500, 1.07, 2.24, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 85, 1, 43.67, 'latticed', 'wl_woIce', 'triangular', 'II', 100, '', 0.85, NULL, NULL, NULL, '', NULL, '2017-06-15 02:13:29', NULL, '0000-00-00 00:00:00'),
(153, '188', 265, 'C', 900, 9.5, 0.85, 1, 5, 0.85, 3, 0.53, 2, 2500, 1, 2.3409, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.0708, 'latticed', 'wl_wIce', 'triangular', 'I', 100, '', 0.85, 0, 0.6458, 0, '', NULL, '2017-06-17 16:36:56', NULL, '0000-00-00 00:00:00'),
(154, '190', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 15, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-06-26 11:56:00', NULL, '0000-00-00 00:00:00'),
(155, '286', 265, 'C', 900, 9.5, 0.85, 1, 45, 1.07, 1, 0, 0, 0, 0, 1, 0, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 89, 1, 20.61, 'str_sptd_on_other_str', 'wl_woIce', 'others', 'II', 0, 'ballast_RT', 1, NULL, NULL, NULL, '', NULL, '2017-06-26 20:52:29', NULL, '0000-00-00 00:00:00'),
(156, '288', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, 15, 1, 2.34, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 35.06, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-06-27 07:46:46', NULL, '0000-00-00 00:00:00'),
(157, '300', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 14.98, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-06-28 15:13:40', NULL, '0000-00-00 00:00:00'),
(158, '301', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 14.98, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-06-28 15:14:34', NULL, '0000-00-00 00:00:00'),
(159, '302', 265, 'C', 900, 9.5, 0.85, 1, NULL, 0.85, 3, 0.53, 2, NULL, NULL, 1, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 14.98, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-06-28 15:26:38', NULL, '0000-00-00 00:00:00'),
(160, '305', 265, 'C', 900, 9.5, 0.85, 1, 90, 1.24, 3, 0.53, 2, 1600, 1.12, 2.17, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 47.43, 'latticed', 'wl_wIce', 'triangular', 'I', 90, '', 0.85, NULL, NULL, NULL, '', NULL, '2017-06-30 01:03:06', NULL, '0000-00-00 00:00:00'),
(161, '310', 265, 'C', 900, 9.5, 0.85, 1, 100, 1.27, 3, 0.53, 2, 1200, 1.18, 2.1, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 47.01, 'latticed', 'wl_wIce', 'triangular', 'I', 90, '', 0.85, NULL, NULL, NULL, '', NULL, '2017-07-04 13:48:27', NULL, '0000-00-00 00:00:00'),
(162, '313', 265, 'C', 900, 9.5, 0.85, 1, 100, 1.27, 3, 0.53, 2, 1200, 1.18, 2.1, 0, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 47.01, 'latticed', 'wl_wlce', 'triangular', 'I', 90, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, '2017-07-05 12:30:16', NULL, '0000-00-00 00:00:00'),
(163, '318', 265, 'C', 900, 9.5, 0.85, 1, 296, 1.59, 1, 0, 0, 0, 0, 1, 0, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 98, 1, 37.14, 'appurtenance', 'wl_woIce', 'triangular', 'II', 300, '', 0.95, NULL, NULL, NULL, '', NULL, '2017-07-10 13:23:27', NULL, '0000-00-00 00:00:00'),
(164, '319', 265, 'B', 1200, 7, 0.7, 0.9, 190, 1.19, 1, NULL, NULL, NULL, 0, 1, NULL, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 89, 1, 22.92, 'appurtenance', 'wl_woIce', 'triangular', 'II', 300, NULL, 0.95, NULL, NULL, NULL, NULL, NULL, '2017-07-10 16:27:47', NULL, '0000-00-00 00:00:00'),
(165, '320', 265, 'C', 900, 9.5, 0.85, 1, 275, 1.57, 2, 0.43, 1.25, 0, 0, 1, 0, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 94, 1, 33.74, 'appurtenance', 'wl_wIce', 'triangular', 'II', 0, '', 0.95, 0.75, 0.9642, 1.4463, '', NULL, '2017-07-26 20:21:33', NULL, '0000-00-00 00:00:00'),
(166, '323', 265, 'C', 900, 9.5, 0.85, 1, 184, 1.44, 1, NULL, NULL, NULL, NULL, 1, NULL, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 105, 0, 38.61, 'appurtenance', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.95, NULL, 0.9262, 0, NULL, NULL, '2017-07-30 20:14:28', NULL, '0000-00-00 00:00:00'),
(167, '329', 265, 'C', 900, 9.5, 0.85, 1, 40, 1.0436, 1, 0, 0, 0, 0, 1, 0, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 102, 1, 26.4057, 'tubular_pole', 'wl_woIce', 'triangular', 'II', 0, '', 1.1, 0, 0.7951, 0, '', NULL, '2017-08-08 14:32:36', NULL, '0000-00-00 00:00:00'),
(168, '332', 265, 'D', 700, 11.5, 1.03, 1.1, 103, 1.4403, 1, NULL, NULL, NULL, NULL, 1, NULL, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 109.2, 1, 41.7697, 'tubular_pole', 'wl_woIce', 'triangular', 'II', NULL, NULL, 1.1, NULL, 0.874, 0, NULL, NULL, '2017-08-09 15:42:16', NULL, '0000-00-00 00:00:00'),
(169, '338', 265, 'B', 1200, 7, 0.7, 0.9, 140, 1.088, 1, NULL, NULL, NULL, NULL, 1, NULL, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 108.4, 1, 31.0922, 'tubular_pole', 'wl_wIce', 'triangular', 'II', NULL, NULL, 1.1, NULL, 0.9012, 0, NULL, NULL, '2017-08-11 19:25:29', NULL, '0000-00-00 00:00:00'),
(170, '342', 265, 'C', 900, 9.5, 0.85, 1, 120, 1.3151, 1, NULL, NULL, NULL, NULL, 1, NULL, 0.95, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 25.9064, 'tubular_pole', 'wl_wIce', 'triangular', 'I', NULL, NULL, 1.1, NULL, 0.8875, 0, NULL, NULL, '2017-08-21 13:39:51', NULL, '0000-00-00 00:00:00'),
(171, '345', 265, 'B', 1200, 7, 0.7, 0.9, NULL, 0.7, 3, 0.53, 2, 154, 1, 2.1815, NULL, 0.85, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 90, 0, 26.9152, 'latticed', 'wl_wIce', 'triangular', 'I', NULL, NULL, 0.85, NULL, 0, 0, NULL, NULL, '2017-09-27 15:21:09', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tia_222_g_wl_da`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_wl_da` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userscalcPK` int(11) NOT NULL,
  `pageAppNo` int(11) DEFAULT NULL,
  `vp_calc` double DEFAULT NULL,
  `ice_thk` double DEFAULT NULL,
  `wind_dir` double DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

--
-- Дамп данных таблицы `tia_222_g_wl_da`
--

INSERT INTO `tia_222_g_wl_da` (`id`, `userscalcPK`, `pageAppNo`, `vp_calc`, `ice_thk`, `wind_dir`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(112, 237, NULL, 190, 0.5, 3, NULL, NULL, '2017-05-27 14:25:24', NULL, '0000-00-00 00:00:00'),
(120, 280, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-30 03:43:26', NULL, '0000-00-00 00:00:00'),
(121, 282, NULL, 188, 0.25, 50, NULL, NULL, '2017-06-17 20:37:34', NULL, '0000-00-00 00:00:00'),
(122, 283, NULL, NULL, NULL, NULL, NULL, NULL, '2017-06-20 20:30:19', NULL, '0000-00-00 00:00:00'),
(123, 285, NULL, NULL, NULL, NULL, NULL, NULL, '2017-06-24 06:08:54', NULL, '0000-00-00 00:00:00'),
(133, 298, NULL, NULL, NULL, NULL, NULL, NULL, '2017-06-27 14:10:50', NULL, '0000-00-00 00:00:00'),
(134, 306, NULL, 305, 0.25, NULL, NULL, NULL, '2017-06-30 05:04:09', NULL, '0000-00-00 00:00:00'),
(135, 311, NULL, 310, 0.35, 30, NULL, NULL, '2017-07-04 17:48:52', NULL, '0000-00-00 00:00:00'),
(136, 321, NULL, 320, 0, 0, NULL, NULL, '2017-07-27 03:47:01', NULL, '0000-00-00 00:00:00'),
(137, 330, NULL, 329, 0, 0, NULL, NULL, '2017-08-08 14:34:08', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tia_222_g_wl_da_lib`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_wl_da_lib` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tia_222_g_wl_da_PK` int(11) DEFAULT NULL,
  `db_pro_PK` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=163 ;

--
-- Дамп данных таблицы `tia_222_g_wl_da_lib`
--

INSERT INTO `tia_222_g_wl_da_lib` (`id`, `tia_222_g_wl_da_PK`, `db_pro_PK`, `name`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(110, 112, 21950, 't1', '', NULL, '2017-05-27 10:25:25', NULL, '0000-00-00 00:00:00'),
(119, 120, 2912, 'A', '', NULL, '2017-05-29 23:43:26', NULL, '0000-00-00 00:00:00'),
(120, 121, 2912, 'A', '', NULL, '2017-06-17 16:37:34', NULL, '0000-00-00 00:00:00'),
(122, 122, 2912, 'A', '', NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(123, 122, 2915, 'B', '', NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(124, 122, 2903, 'C', '', NULL, '2017-06-20 19:41:11', NULL, '0000-00-00 00:00:00'),
(136, 112, 2883, 't2', '', NULL, '2017-06-22 15:28:04', NULL, '0000-00-00 00:00:00'),
(137, 123, 2912, 'A', '', NULL, '2017-06-24 02:08:54', NULL, '0000-00-00 00:00:00'),
(151, 133, 2900, 'DA1', '', NULL, '2017-06-27 10:10:50', NULL, '0000-00-00 00:00:00'),
(152, 134, 2912, 'A', '', NULL, '2017-06-30 01:05:01', NULL, '0000-00-00 00:00:00'),
(153, 135, 2912, 'A', '', NULL, '2017-07-04 13:48:52', NULL, '0000-00-00 00:00:00'),
(154, 136, 2943, 'B', 'GSM+UMTS', NULL, '2017-07-27 03:47:01', NULL, '0000-00-00 00:00:00'),
(155, 136, 2928, 'D', '', NULL, '2017-07-27 03:47:01', NULL, '0000-00-00 00:00:00'),
(156, 136, 2933, 'C', '', NULL, '2017-07-27 03:47:01', NULL, '0000-00-00 00:00:00'),
(157, 136, 2936, 'A', 'GSM+UMTS', NULL, '2017-07-27 03:47:01', NULL, '0000-00-00 00:00:00'),
(158, 137, 2944, 'A', '', NULL, '2017-08-08 14:34:08', NULL, '0000-00-00 00:00:00'),
(159, 137, 29381, 'B', '', NULL, '2017-08-08 14:53:23', NULL, '0000-00-00 00:00:00'),
(160, 121, 2936, 'B', '', NULL, '2017-08-09 00:52:46', NULL, '0000-00-00 00:00:00'),
(162, 112, 17519, 't3', '', NULL, '2017-08-23 08:45:17', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tia_222_g_wl_ida`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_wl_ida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tia_222_g_wl_da_PK` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `tia_222_g_wl_da_lib_PK` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `frt_azm` double DEFAULT NULL,
  `ctr_elev` double DEFAULT NULL,
  `ice_thk` double DEFAULT NULL,
  `q_z` double DEFAULT NULL,
  `g_h` double DEFAULT NULL,
  `k_a` double DEFAULT NULL,
  `epa_a` double DEFAULT NULL,
  `dwf` double DEFAULT NULL,
  `quantity` int(2) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=488 ;

--
-- Дамп данных таблицы `tia_222_g_wl_ida`
--

INSERT INTO `tia_222_g_wl_ida` (`id`, `tia_222_g_wl_da_PK`, `name`, `tia_222_g_wl_da_lib_PK`, `status`, `frt_azm`, `ctr_elev`, `ice_thk`, `q_z`, `g_h`, `k_a`, `epa_a`, `dwf`, `quantity`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(259, 110, 'EQ2', 108, 'future', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, '2017-05-27 09:38:04', NULL, '0000-00-00 00:00:00'),
(267, 112, 'Test1', 110, 'reserved', 5, 2, 0.51, 38.58, 0, 1, 21.57, 0, 1, NULL, NULL, '2017-05-29 14:19:22', NULL, '0000-00-00 00:00:00'),
(269, 120, 'FA1', 119, 'existing', 0, 0, 0, 10, 0.95, 2, 5469.6, 0, 1, NULL, NULL, '2017-05-29 23:43:26', NULL, '0000-00-00 00:00:00'),
(270, 120, 'FA2', 119, 'tbrmvd', 1, 1, 0, 10, 0.95, 2, 5469.6, 10939.2, 1, NULL, NULL, '2017-05-29 23:55:20', NULL, '0000-00-00 00:00:00'),
(271, 120, 'FA2', 119, 'tbrmvd', 1, 1, 0, 10, 0.95, 2, 5469.6, 10939.2, 1, NULL, NULL, '2017-05-29 23:55:20', NULL, '0000-00-00 00:00:00'),
(276, 122, 'FA1', 122, 'existing', 0, 32, 1, 1, 0.95, 2, 14803.724444444, 0, 1, NULL, NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(288, 123, 'fa1', 137, '', 0, 5, 0, 0, 0.95, 1, 7401.8622222222, 0, 1, NULL, NULL, '2017-06-24 02:09:41', NULL, '0000-00-00 00:00:00'),
(289, 123, 'fa2', 137, '', 0, 9, 0, 2, 0.95, 1, 7401.8622222222, 0, 1, NULL, NULL, '2017-06-24 02:10:01', NULL, '0000-00-00 00:00:00'),
(290, 123, 'fa3', 137, '', 0, 0, 0, 3, 0.95, 1, 7401.8622222222, 0, 1, NULL, NULL, '2017-06-24 03:23:07', NULL, '0000-00-00 00:00:00'),
(291, 123, 'fa4', 137, '', 5, 88, 2, 9, 0.95, 1, 9734.5111111111, 0, 1, NULL, NULL, '2017-06-24 03:25:49', NULL, '0000-00-00 00:00:00'),
(292, 123, 'fa5', 137, '', 5, 5, 45, 2, 0.95, 1, 95914.56, 0, 1, NULL, NULL, '2017-06-24 03:30:11', NULL, '0000-00-00 00:00:00'),
(293, 123, 'fa6', 137, 'proposed', 9, 9, 9, 443, 0.95, 1, 18909.173333333, 0, 1, NULL, NULL, '2017-06-24 03:32:11', NULL, '0000-00-00 00:00:00'),
(294, 123, 'fa7', 137, '', 99, 99, 0, 2, 0.95, 1, 7401.8622222222, 0, 1, NULL, NULL, '2017-06-24 03:37:04', NULL, '0000-00-00 00:00:00'),
(314, 122, 'FA2', 122, 'tbrmvd', 5, 20, 0, 0, 0.95, 1, 0, 0, 1, NULL, NULL, '2017-06-29 03:44:43', NULL, '0000-00-00 00:00:00'),
(315, 134, 'fa1', 152, 'existing', 5, 90, 0, 0, 0.95, 1, 0, 0, 1, NULL, NULL, '2017-06-30 01:05:32', NULL, '0000-00-00 00:00:00'),
(316, 134, 'fa2', 152, 'tbrmvd', 9, 20, 0, 0, 0.95, 1, 0, 0, 1, NULL, NULL, '2017-06-30 01:08:03', NULL, '0000-00-00 00:00:00'),
(326, 134, 'fa8', 152, 'tbrmvd', 7, 7, 79.021014070687, 0, 0.95, 1, 0, 0, 1, NULL, NULL, '2017-07-02 03:42:28', NULL, '0000-00-00 00:00:00'),
(333, 134, 'fa4', 152, 'existing', 9, 9, 0, NULL, 0.95, 1, 0, 0, 1, NULL, NULL, '2017-07-03 20:11:34', NULL, '0000-00-00 00:00:00'),
(334, 134, 'fa5', 152, 'tbrmvd', 8, 8, 0, NULL, 0.95, 1, 0, 0, 1, NULL, NULL, '2017-07-04 01:15:18', NULL, '0000-00-00 00:00:00'),
(335, 135, 'fa1', 153, 'existing', 5, 90, 1.01, 75.12, 0.95, 1, 2590.14, 1.2837, 1, NULL, NULL, '2017-07-04 13:49:16', NULL, '0000-00-00 00:00:00'),
(346, 135, 'fa2', 153, 'tbrmvd', 5, 100, 1.01, 74.35, 0.95, 1, 2592.18, 1.2714, 1, NULL, NULL, '2017-07-05 03:16:08', NULL, '0000-00-00 00:00:00'),
(446, 135, 'fa4', 153, 'proposed', 5, 50, 0.69, 71.99, 0.95, 1, 2497.35, 1.186, 1, NULL, NULL, '2017-07-10 12:59:00', NULL, '0000-00-00 00:00:00'),
(460, 135, 'fa5', 153, 'tbrmvd', 5, 5, 0.56, 46.63, 0.95, 1, 2459.21, 0.7565, 1, NULL, NULL, '2017-07-11 14:10:04', NULL, '0000-00-00 00:00:00'),
(461, 135, 'fa6', 153, 'proposed', 5, 6, 0.57, 48.39, 1, 1, 2462.1, 0.8274, 1, NULL, NULL, '2017-07-11 14:10:36', NULL, '0000-00-00 00:00:00'),
(466, 135, 'fa7', 153, 'proposed', 0, 0, 0, 0, 0, 0, 0, 0, 1, NULL, NULL, '2017-07-13 13:23:38', NULL, '0000-00-00 00:00:00'),
(472, 136, 'GSM1', 157, 'existing', 0, 275, 2.38, 88.33, 0.95, 1, 802.89, 0.47, 1, NULL, NULL, '2017-07-27 03:48:50', NULL, '0000-00-00 00:00:00'),
(473, 136, 'LTE-RRU1', 154, 'existing', 0, 275, 2.38, 88.33, 0.95, 1, 288.13, 0.17, 1, NULL, NULL, '2017-07-27 03:49:26', NULL, '0000-00-00 00:00:00'),
(474, 136, 'LTE-RRU2', 156, 'proposed', 0, 275, 2.38, 88.33, 0.95, 1, 638.9, 0.37, 1, NULL, NULL, '2017-07-27 03:49:44', NULL, '0000-00-00 00:00:00'),
(475, 136, 'GMS-ANT1', 155, 'existing', 0, 275, 2.38, 88.33, 0.95, 1, 646.83, 0.38, 1, NULL, NULL, '2017-07-27 03:50:40', NULL, '0000-00-00 00:00:00'),
(476, 135, 'fa55', 153, 'proposed', 5, 5, 0.78, 46.63, 0.95, 1, 15.96, 0.71, 1, NULL, NULL, '2017-07-31 09:15:31', NULL, '0000-00-00 00:00:00'),
(477, 137, 'FA1', 158, 'existing', 5, 5, 0, 28.76, 0.95, 1, 5.4889, 0.15, 1, NULL, NULL, '2017-08-08 14:34:24', NULL, '0000-00-00 00:00:00'),
(478, 137, 'FA2', 159, 'existing', 0, 25, 0, 40.36, 0.95, 1, 5.5085, 0.2112, 1, NULL, NULL, '2017-08-08 14:53:58', NULL, '0000-00-00 00:00:00'),
(479, 137, 'FA3', 158, 'existing', 0, 25, 0, 40.36, 0.95, 1, 5.5085, 0.2112, 1, NULL, NULL, '2017-08-08 14:55:38', NULL, '0000-00-00 00:00:00'),
(480, 137, 'FA4', 159, 'existing', 0, 25, 0, 40.36, 0.95, 1, 5.5085, 0.2112, 1, NULL, NULL, '2017-08-08 14:55:48', NULL, '0000-00-00 00:00:00'),
(481, 121, 'FA1', 120, 'existing', 5, 5, 0.56, 5, 0.95, 1, 13.9523, 0.0663, 1, NULL, NULL, '2017-08-09 00:53:13', NULL, '0000-00-00 00:00:00'),
(482, 121, 'FA2', 160, 'existing', 5, 5, 0.56, 46.77, 0.95, 1, 2.9775, 0.1323, 1, NULL, NULL, '2017-08-09 00:53:24', NULL, '0000-00-00 00:00:00'),
(483, 121, 'FA3', 120, 'existing', 5, 5, 0.56, 46.77, 0.95, 1, 13.9523, 0.6199, 1, NULL, NULL, '2017-08-09 01:20:14', NULL, '0000-00-00 00:00:00'),
(484, 121, 'FA4', 160, 'existing', 5, 5, 0.56, 46.77, 0.95, 1, 2.9775, 0.1323, 1, NULL, NULL, '2017-08-09 01:20:23', NULL, '0000-00-00 00:00:00'),
(485, 121, 'FA5', 120, 'existing', 5, 5, 0.56, 46.77, 0.95, 1, 13.9523, 0.6199, 1, NULL, NULL, '2017-08-09 02:35:41', NULL, '0000-00-00 00:00:00'),
(487, 112, 'Test10', 136, 'existing', 2, 3, 0.53, 34.95, 0.95, 1, 0, 0, 1, NULL, NULL, '2018-01-22 09:32:46', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tia_222_g_wl_ida_faces`
--

CREATE TABLE IF NOT EXISTS `tia_222_g_wl_ida_faces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `tia_222_g_wl_ida_PK` int(11) NOT NULL,
  `inclusion` int(2) DEFAULT NULL,
  `face_name` varchar(20) DEFAULT NULL,
  `face_shape` varchar(60) NOT NULL,
  `display` int(2) DEFAULT NULL,
  `face_azm` double DEFAULT NULL,
  `angle_btw` double DEFAULT NULL,
  `exposed` int(2) DEFAULT NULL,
  `p_a` double DEFAULT NULL,
  `aspect_ratio` double DEFAULT NULL,
  `c_a` double DEFAULT NULL,
  `epa_a` varchar(20) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1452 ;

--
-- Дамп данных таблицы `tia_222_g_wl_ida_faces`
--

INSERT INTO `tia_222_g_wl_ida_faces` (`id`, `name`, `tia_222_g_wl_ida_PK`, `inclusion`, `face_name`, `face_shape`, `display`, `face_azm`, `angle_btw`, `exposed`, `p_a`, `aspect_ratio`, `c_a`, `epa_a`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(750, '', 269, 0, 'normal', 'rectangular', 0, 5, NULL, 1, 1568.8, 7.1621621621622, 1.2, '1568.8', '', NULL, '2017-05-29 23:43:26', NULL, '0000-00-00 00:00:00'),
(751, '', 269, 0, 'side', 'rectangular', 0, 95, NULL, 1, 710.2, 15.820895522388, 1.2, '710.2', '', NULL, '2017-05-29 23:43:26', NULL, '0000-00-00 00:00:00'),
(752, 'FA2', 270, 1, 'normal', 'rectangular', 1, 0, NULL, 1, 0, 7.1621621621622, 0, '0', '0', NULL, '2017-05-29 23:55:20', NULL, '0000-00-00 00:00:00'),
(753, 'FA2', 270, 1, 'side', 'rectangular', 1, 0, NULL, 1, 0, 15.820895522388, 0, '0', '0', NULL, '2017-05-29 23:55:20', NULL, '0000-00-00 00:00:00'),
(754, 'FA2', 271, 1, 'normal', 'rectangular', 1, 0, NULL, 1, 0, 7.1621621621622, 0, '0', '0', NULL, '2017-05-29 23:55:20', NULL, '0000-00-00 00:00:00'),
(755, 'FA2', 271, 1, 'side', 'rectangular', 1, 0, NULL, 1, 0, 15.820895522388, 0, '0', '0', NULL, '2017-05-29 23:55:20', NULL, '0000-00-00 00:00:00'),
(756, 'FA1', 272, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.65, 0, '0', '0', NULL, '2017-06-17 16:37:59', NULL, '0000-00-00 00:00:00'),
(757, 'FA1', 272, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.229885057471, 0, '0', '0', NULL, '2017-06-17 16:37:59', NULL, '0000-00-00 00:00:00'),
(758, 'FA1', 272, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.65, 0, '0', '0', NULL, '2017-06-17 16:37:59', NULL, '0000-00-00 00:00:00'),
(759, 'FA1', 272, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.229885057471, 0, '0', '0', NULL, '2017-06-17 16:37:59', NULL, '0000-00-00 00:00:00'),
(760, 'FA2', 273, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 1.7741935483871, 0, '0', '0', NULL, '2017-06-17 16:38:15', NULL, '0000-00-00 00:00:00'),
(761, 'FA2', 273, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 2.3404255319149, 0, '0', '0', NULL, '2017-06-17 16:38:15', NULL, '0000-00-00 00:00:00'),
(762, 'FA2', 273, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 1.7741935483871, 0, '0', '0', NULL, '2017-06-17 16:38:15', NULL, '0000-00-00 00:00:00'),
(763, 'FA2', 273, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 2.3404255319149, 0, '0', '0', NULL, '2017-06-17 16:38:15', NULL, '0000-00-00 00:00:00'),
(764, 'FA3', 274, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 1.7741935483871, 0, '0', '0', NULL, '2017-06-17 18:29:31', NULL, '0000-00-00 00:00:00'),
(765, 'FA3', 274, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 2.3404255319149, 0, '0', '0', NULL, '2017-06-17 18:29:31', NULL, '0000-00-00 00:00:00'),
(766, 'FA3', 274, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 1.7741935483871, 0, '0', '0', NULL, '2017-06-17 18:29:31', NULL, '0000-00-00 00:00:00'),
(767, 'FA3', 274, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 2.3404255319149, 0, '0', '0', NULL, '2017-06-17 18:29:31', NULL, '0000-00-00 00:00:00'),
(768, '', 276, 0, 'front', 'rectangular', 0, 0, NULL, 1, 1653.6, 6.7948717948718, 1.3908831908832, '1653.6', '', NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(769, '', 276, 0, 'right', 'rectangular', 0, 90, NULL, 1, 879.8, 12.771084337349, 1.5923694779116, '879.8', '', NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(770, '', 276, 0, 'back', 'rectangular', 0, 180, NULL, 1, 1653.6, 6.7948717948718, 1.3908831908832, '1653.6', '', NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(771, '', 276, 0, 'left', 'rectangular', 0, 270, NULL, 1, 879.8, 12.771084337349, 1.5923694779116, '879.8', '', NULL, '2017-06-20 16:30:19', NULL, '0000-00-00 00:00:00'),
(800, 'fa1', 288, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-24 02:09:41', NULL, '0000-00-00 00:00:00'),
(801, 'fa1', 288, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-24 02:09:41', NULL, '0000-00-00 00:00:00'),
(802, 'fa1', 288, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-24 02:09:41', NULL, '0000-00-00 00:00:00'),
(803, 'fa1', 288, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-24 02:09:41', NULL, '0000-00-00 00:00:00'),
(804, 'fa2', 289, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-24 02:10:01', NULL, '0000-00-00 00:00:00'),
(805, 'fa2', 289, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-24 02:10:01', NULL, '0000-00-00 00:00:00'),
(806, 'fa2', 289, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-24 02:10:01', NULL, '0000-00-00 00:00:00'),
(807, 'fa2', 289, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-24 02:10:02', NULL, '0000-00-00 00:00:00'),
(824, 'fa7', 294, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-24 03:37:04', NULL, '0000-00-00 00:00:00'),
(825, 'fa7', 294, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-24 03:37:04', NULL, '0000-00-00 00:00:00'),
(826, 'fa7', 294, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-24 03:37:04', NULL, '0000-00-00 00:00:00'),
(827, 'fa7', 294, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-24 03:37:04', NULL, '0000-00-00 00:00:00'),
(836, 'FA4', 299, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 5.6122448979592, 0, '0', '0', NULL, '2017-06-27 00:06:18', NULL, '0000-00-00 00:00:00'),
(837, 'FA4', 299, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 8.9430894308943, 0, '0', '0', NULL, '2017-06-27 00:06:18', NULL, '0000-00-00 00:00:00'),
(838, 'FA4', 299, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 5.6122448979592, 0, '0', '0', NULL, '2017-06-27 00:06:18', NULL, '0000-00-00 00:00:00'),
(839, 'FA4', 299, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 8.9430894308943, 0, '0', '0', NULL, '2017-06-27 00:06:18', NULL, '0000-00-00 00:00:00'),
(848, 'FA2', 314, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-29 03:44:43', NULL, '0000-00-00 00:00:00'),
(849, 'FA2', 314, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-29 03:44:43', NULL, '0000-00-00 00:00:00'),
(850, 'FA2', 314, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-29 03:44:43', NULL, '0000-00-00 00:00:00'),
(851, 'FA2', 314, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-29 03:44:43', NULL, '0000-00-00 00:00:00'),
(852, 'fa1', 315, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-30 01:05:32', NULL, '0000-00-00 00:00:00'),
(853, 'fa1', 315, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-30 01:05:32', NULL, '0000-00-00 00:00:00'),
(854, 'fa1', 315, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-30 01:05:32', NULL, '0000-00-00 00:00:00'),
(855, 'fa1', 315, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-30 01:05:32', NULL, '0000-00-00 00:00:00'),
(856, 'fa2', 316, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-30 01:08:03', NULL, '0000-00-00 00:00:00'),
(857, 'fa2', 316, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-30 01:08:03', NULL, '0000-00-00 00:00:00'),
(858, 'fa2', 316, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-06-30 01:08:03', NULL, '0000-00-00 00:00:00'),
(859, 'fa2', 316, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-06-30 01:08:03', NULL, '0000-00-00 00:00:00'),
(896, 'fa8', 326, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 1.5206112884514, 0, '0', '0', NULL, '2017-07-02 03:42:28', NULL, '0000-00-00 00:00:00'),
(897, 'fa8', 326, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 1.5873440470316, 0, '0', '0', NULL, '2017-07-02 03:42:28', NULL, '0000-00-00 00:00:00'),
(898, 'fa8', 326, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 1.5206112884514, 0, '0', '0', NULL, '2017-07-02 03:42:28', NULL, '0000-00-00 00:00:00'),
(899, 'fa8', 326, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 1.5873440470316, 0, '0', '0', NULL, '2017-07-02 03:42:28', NULL, '0000-00-00 00:00:00'),
(900, 'test3', 328, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 1, 0, '0', '0', NULL, '2017-07-03 13:51:30', NULL, '0000-00-00 00:00:00'),
(901, 'test3', 328, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 1, 0, '0', '0', NULL, '2017-07-03 13:51:30', NULL, '0000-00-00 00:00:00'),
(902, 'test3', 328, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 1, 0, '0', '0', NULL, '2017-07-03 13:51:30', NULL, '0000-00-00 00:00:00'),
(903, 'test3', 328, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 1, 0, '0', '0', NULL, '2017-07-03 13:51:30', NULL, '0000-00-00 00:00:00'),
(904, 'fa4', 333, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-07-03 20:11:34', NULL, '0000-00-00 00:00:00'),
(905, 'fa4', 333, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-07-03 20:11:34', NULL, '0000-00-00 00:00:00'),
(906, 'fa4', 333, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-07-03 20:11:34', NULL, '0000-00-00 00:00:00'),
(907, 'fa4', 333, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-07-03 20:11:34', NULL, '0000-00-00 00:00:00'),
(908, 'fa5', 334, 1, 'front', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-07-04 01:15:18', NULL, '0000-00-00 00:00:00'),
(909, 'fa5', 334, 1, 'right', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-07-04 01:15:18', NULL, '0000-00-00 00:00:00'),
(910, 'fa5', 334, 1, 'back', 'rectangular', 1, 0, NULL, 1, 0, 6.7948717948718, 0, '0', '0', NULL, '2017-07-04 01:15:18', NULL, '0000-00-00 00:00:00'),
(911, 'fa5', 334, 1, 'left', 'rectangular', 1, 0, NULL, 1, 0, 12.771084337349, 0, '0', '0', NULL, '2017-07-04 01:15:18', NULL, '0000-00-00 00:00:00'),
(1120, 'fa5', 460, 1, 'front', 'rectangular', 1, 0.087266462599716, NULL, 0, 1735.24275192, 6.5570112356124, 1.3803116104717, '0', '0', NULL, '2017-07-11 14:10:04', NULL, '0000-00-00 00:00:00'),
(1121, 'fa5', 460, 1, 'right', 'rectangular', 1, 90.0872664626, NULL, 0, 956.56826825606, 11.894609719386, 1.5631536573129, '0', '0', NULL, '2017-07-11 14:10:04', NULL, '0000-00-00 00:00:00'),
(1122, 'fa5', 460, 1, 'back', 'rectangular', 1, 180.0872664626, NULL, 1, 1735.24275192, 6.5570112356124, 1.3803116104717, '2395.175717462', '0', NULL, '2017-07-11 14:10:04', NULL, '0000-00-00 00:00:00'),
(1123, 'fa5', 460, 1, 'left', 'rectangular', 1, 270.0872664626, NULL, 0, 956.56826825606, 11.894609719386, 1.5631536573129, '0', '0', NULL, '2017-07-11 14:10:04', NULL, '0000-00-00 00:00:00'),
(1124, 'fa6', 461, 1, 'front', 'rectangular', 1, 0.087266462599716, NULL, 0, 1735.24275192, 6.5570112356124, 1.3803116104717, '0', '0', NULL, '2017-07-11 14:10:36', NULL, '0000-00-00 00:00:00'),
(1125, 'fa6', 461, 1, 'right', 'rectangular', 1, 90.0872664626, NULL, 0, 956.56826825606, 11.894609719386, 1.5631536573129, '0', '0', NULL, '2017-07-11 14:10:36', NULL, '0000-00-00 00:00:00'),
(1126, 'fa6', 461, 1, 'back', 'rectangular', 1, 180.0872664626, NULL, 1, 1735.24275192, 6.5570112356124, 1.3803116104717, '2395.175717462', '0', NULL, '2017-07-11 14:10:36', NULL, '0000-00-00 00:00:00'),
(1127, 'fa6', 461, 1, 'left', 'rectangular', 1, 270.0872664626, NULL, 0, 956.56826825606, 11.894609719386, 1.5631536573129, '0', '0', NULL, '2017-07-11 14:10:36', NULL, '0000-00-00 00:00:00'),
(1140, 'fa7', 466, 1, 'front', 'rectangular', 1, 0.14, NULL, 0, 1796.63, 6.392170734792, 1.3729853659908, '0.00', '0', NULL, '2017-07-13 13:23:38', NULL, '0000-00-00 00:00:00'),
(1141, 'fa7', 466, 1, 'right', 'rectangular', 1, 90.14, NULL, 0, 1014.32, 11.322187725167, 1.5440729241722, '0.00', '0', NULL, '2017-07-13 13:23:38', NULL, '0000-00-00 00:00:00'),
(1142, 'fa7', 466, 1, 'back', 'rectangular', 1, 180.14, NULL, 1, 1796.63, 6.392170734792, 1.3729853659908, '2466.74', '0', NULL, '2017-07-13 13:23:38', NULL, '0000-00-00 00:00:00'),
(1143, 'fa7', 466, 1, 'left', 'rectangular', 1, 270.14, NULL, 0, 1014.32, 11.322187725167, 1.5440729241722, '0.00', '0', NULL, '2017-07-13 13:23:38', NULL, '0000-00-00 00:00:00'),
(1184, 'GSM-TMA', 472, 1, 'front', 'rectangular', 1, 0, NULL, 0, 312.93, 8.4098360655738, 1.4469945355191, '0.00', '0', NULL, '2017-07-27 03:51:23', NULL, '0000-00-00 00:00:00'),
(1185, 'GSM-TMA', 472, 1, 'right', 'rectangular', 1, 90, NULL, 0, 138.51, 19, 1.8, '0.00', '0', NULL, '2017-07-27 03:51:23', NULL, '0000-00-00 00:00:00'),
(1186, 'GSM-TMA', 472, 1, 'back', 'rectangular', 1, 180, NULL, 1, 312.93, 8.4098360655738, 1.4469945355191, '452.81', '0', NULL, '2017-07-27 03:51:23', NULL, '0000-00-00 00:00:00'),
(1187, 'GSM-TMA', 472, 1, 'left', 'rectangular', 1, 270, NULL, 0, 138.51, 19, 1.8, '0.00', '0', NULL, '2017-07-27 03:51:23', NULL, '0000-00-00 00:00:00'),
(1188, 'LTE-RRU1', 473, 1, 'front', 'rectangular', 1, 0, NULL, 0, 115, 0.8695652173913, 1.2, '0.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1189, 'LTE-RRU1', 473, 1, 'right', 'rectangular', 1, 90, NULL, 0, 60, 1.6666666666667, 1.2, '0.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1190, 'LTE-RRU1', 473, 1, 'back', 'rectangular', 1, 180, NULL, 1, 115, 0.8695652173913, 1.2, '138.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1191, 'LTE-RRU1', 473, 1, 'left', 'rectangular', 1, 270, NULL, 0, 60, 1.6666666666667, 1.2, '0.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1192, 'LTE-RRU2', 474, 1, 'front', 'rectangular', 1, 0, NULL, 0, 334.9, 1.1588235294118, 1.2, '0.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1193, 'LTE-RRU2', 474, 1, 'right', 'rectangular', 1, 90, NULL, 0, 141.84, 2.7361111111111, 1.2104938271605, '0.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1194, 'LTE-RRU2', 474, 1, 'back', 'rectangular', 1, 180, NULL, 1, 334.9, 1.1588235294118, 1.2, '401.88', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1195, 'LTE-RRU2', 474, 1, 'left', 'rectangular', 1, 270, NULL, 0, 141.84, 2.7361111111111, 1.2104938271605, '0.00', '0', NULL, '2017-07-27 03:51:36', NULL, '0000-00-00 00:00:00'),
(1196, 'GMS-ANT1', 475, 1, 'front', 'rectangular', 1, 0, NULL, 0, 329.12, 2.2479338842975, 1.2, '0.00', '0', NULL, '2017-07-27 03:51:37', NULL, '0000-00-00 00:00:00'),
(1197, 'GMS-ANT1', 475, 1, 'right', 'rectangular', 1, 90, NULL, 0, 190.4, 3.8857142857143, 1.2615873015873, '0.00', '0', NULL, '2017-07-27 03:51:37', NULL, '0000-00-00 00:00:00'),
(1198, 'GMS-ANT1', 475, 1, 'back', 'rectangular', 1, 180, NULL, 1, 329.12, 2.2479338842975, 1.2, '394.94', '0', NULL, '2017-07-27 03:51:37', NULL, '0000-00-00 00:00:00'),
(1199, 'GMS-ANT1', 475, 1, 'left', 'rectangular', 1, 270, NULL, 0, 190.4, 3.8857142857143, 1.2615873015873, '0.00', '0', NULL, '2017-07-27 03:51:37', NULL, '0000-00-00 00:00:00'),
(1208, 'fa55', 476, 1, 'front', 'rectangular', 1, 0.09, NULL, 0, 1845.49, 6.2686627088817, 1.3674961203947, '0.00', '0', NULL, '2017-07-31 09:15:31', NULL, '0000-00-00 00:00:00'),
(1209, 'fa55', 476, 1, 'right', 'rectangular', 1, 90.09, NULL, 0, 1060.31, 10.910677971612, 1.5303559323871, '0.00', '0', NULL, '2017-07-31 09:15:31', NULL, '0000-00-00 00:00:00'),
(1210, 'fa55', 476, 1, 'back', 'rectangular', 1, 180.09, NULL, 1, 1845.49, 6.2686627088817, 1.3674961203947, '1892.77', '0', NULL, '2017-07-31 09:15:32', NULL, '0000-00-00 00:00:00'),
(1211, 'fa55', 476, 1, 'left', 'rectangular', 1, 270.09, NULL, 1, 1060.31, 10.910677971612, 1.5303559323871, '405.66', '0', NULL, '2017-07-31 09:15:32', NULL, '0000-00-00 00:00:00'),
(1212, 'fa4', 446, 1, 'front', 'rectangular', 1, 0.09, NULL, 0, 1845.49, 6.2686627088817, 1.3674961203947, '0.00', '0', NULL, '2017-07-31 11:36:15', NULL, '0000-00-00 00:00:00'),
(1213, 'fa4', 446, 1, 'right', 'rectangular', 1, 90.09, NULL, 0, 1060.31, 10.910677971612, 1.5303559323871, '0.00', '0', NULL, '2017-07-31 11:36:15', NULL, '0000-00-00 00:00:00'),
(1214, 'fa4', 446, 1, 'back', 'rectangular', 1, 180.09, NULL, 1, 1845.49, 6.2686627088817, 1.3674961203947, '1892.77', '0', NULL, '2017-07-31 11:36:15', NULL, '0000-00-00 00:00:00'),
(1215, 'fa4', 446, 1, 'left', 'rectangular', 1, 270.09, NULL, 1, 1060.31, 10.910677971612, 1.5303559323871, '405.66', '0', NULL, '2017-07-31 11:36:15', NULL, '0000-00-00 00:00:00'),
(1220, 'fa1', 335, 1, 'front', 'rectangular', 1, 0.09, NULL, 0, 1902.5, 6.132426444165, 1.3614411752962, '0.00', '0', NULL, '2017-07-31 11:37:02', NULL, '0000-00-00 00:00:00'),
(1221, 'fa1', 335, 1, 'right', 'rectangular', 1, 90.09, NULL, 0, 1114, 10.473019576446, 1.5157673192149, '0.00', '0', NULL, '2017-07-31 11:37:02', NULL, '0000-00-00 00:00:00'),
(1222, 'fa1', 335, 1, 'back', 'rectangular', 1, 180.09, NULL, 1, 1902.5, 6.132426444165, 1.3614411752962, '1942.60', '0', NULL, '2017-07-31 11:37:02', NULL, '0000-00-00 00:00:00'),
(1223, 'fa1', 335, 1, 'left', 'rectangular', 1, 270.09, NULL, 1, 1114, 10.473019576446, 1.5157673192149, '422.14', '0', NULL, '2017-07-31 11:37:02', NULL, '0000-00-00 00:00:00'),
(1224, 'fa2', 346, 1, 'front', 'rectangular', 1, 0.09, NULL, 0, 1891.66, 6.1577070923039, 1.362564759658, '0.00', '0', NULL, '2017-07-31 11:37:18', NULL, '0000-00-00 00:00:00'),
(1225, 'fa2', 346, 1, 'right', 'rectangular', 1, 90.09, NULL, 0, 1103.79, 10.552986476328, 1.5184328825443, '0.00', '0', NULL, '2017-07-31 11:37:18', NULL, '0000-00-00 00:00:00'),
(1226, 'fa2', 346, 1, 'back', 'rectangular', 1, 180.09, NULL, 1, 1891.66, 6.1577070923039, 1.362564759658, '1933.13', '0', NULL, '2017-07-31 11:37:18', NULL, '0000-00-00 00:00:00'),
(1227, 'fa2', 346, 1, 'left', 'rectangular', 1, 270.09, NULL, 1, 1103.79, 10.552986476328, 1.5184328825443, '419.01', '0', NULL, '2017-07-31 11:37:18', NULL, '0000-00-00 00:00:00'),
(1276, 'FA3', 479, 1, 'front', 'rectangular', 1, 0, NULL, 0, 4.2014, 5, 1.31, '0.0000', '0', NULL, '2017-08-08 14:55:38', NULL, '0000-00-00 00:00:00'),
(1277, 'FA3', 479, 1, 'right', 'rectangular', 1, 90, NULL, 0, 1.9097, 11, 1.53, '0.0000', '0', NULL, '2017-08-08 14:55:38', NULL, '0000-00-00 00:00:00'),
(1278, 'FA3', 479, 1, 'back', 'rectangular', 1, 180, NULL, 1, 4.2014, 5, 1.31, '5.5085', '0', NULL, '2017-08-08 14:55:38', NULL, '0000-00-00 00:00:00'),
(1279, 'FA3', 479, 1, 'left', 'rectangular', 1, 270, NULL, 1, 1.9097, 11, 1.53, '0.0000', '0', NULL, '2017-08-08 14:55:38', NULL, '0000-00-00 00:00:00'),
(1280, 'FA4', 480, 1, 'front', 'rectangular', 1, 0, NULL, 0, 4.2014, 5, 1.31, '0.0000', '0', NULL, '2017-08-08 14:55:48', NULL, '0000-00-00 00:00:00'),
(1281, 'FA4', 480, 1, 'right', 'rectangular', 1, 90, NULL, 0, 1.5278, 13.75, 1.63, '0.0000', '0', NULL, '2017-08-08 14:55:48', NULL, '0000-00-00 00:00:00'),
(1282, 'FA4', 480, 1, 'back', 'rectangular', 1, 180, NULL, 1, 4.2014, 5, 1.31, '5.5085', '0', NULL, '2017-08-08 14:55:48', NULL, '0000-00-00 00:00:00'),
(1283, 'FA4', 480, 1, 'left', 'rectangular', 1, 270, NULL, 1, 1.5278, 13.75, 1.63, '0.0000', '0', NULL, '2017-08-08 14:55:48', NULL, '0000-00-00 00:00:00'),
(1284, 'FA1', 477, 1, 'front', 'rectangular', 1, 5, NULL, 0, 4.2, 5, 1.3111111111111, '0.00', '0', NULL, '2017-08-08 14:58:05', NULL, '0000-00-00 00:00:00'),
(1285, 'FA1', 477, 1, 'right', 'rectangular', 1, 95, NULL, 1, 1.91, 11, 1.5333333333333, '0.02', '0', NULL, '2017-08-08 14:58:05', NULL, '0000-00-00 00:00:00'),
(1286, 'FA1', 477, 1, 'back', 'rectangular', 1, 185, NULL, 1, 4.2, 5, 1.3111111111111, '5.47', '0', NULL, '2017-08-08 14:58:05', NULL, '0000-00-00 00:00:00'),
(1287, 'FA1', 477, 1, 'left', 'rectangular', 1, 275, NULL, 0, 1.91, 11, 1.5333333333333, '0.00', '0', NULL, '2017-08-08 14:58:05', NULL, '0000-00-00 00:00:00'),
(1288, 'FA2', 478, 1, 'front', 'rectangular', 1, 0, NULL, 0, 4.2, 5, 1.3111111111111, '0.00', '0', NULL, '2017-08-08 14:58:06', NULL, '0000-00-00 00:00:00'),
(1289, 'FA2', 478, 1, 'right', 'rectangular', 1, 90, NULL, 0, 1.53, 13.75, 1.625, '0.00', '0', NULL, '2017-08-08 14:58:06', NULL, '0000-00-00 00:00:00'),
(1290, 'FA2', 478, 1, 'back', 'rectangular', 1, 180, NULL, 1, 4.2, 5, 1.3111111111111, '5.51', '0', NULL, '2017-08-08 14:58:06', NULL, '0000-00-00 00:00:00'),
(1291, 'FA2', 478, 1, 'left', 'rectangular', 1, 270, NULL, 1, 1.53, 13.75, 1.625, '0.00', '0', NULL, '2017-08-08 14:58:06', NULL, '0000-00-00 00:00:00'),
(1356, 'FA5', 485, 1, 'front', 'rectangular', 1, 5, NULL, 0, 12.43, 6.4086197297426, 1.373716432433, '0.00', '0', NULL, '2017-08-09 02:36:12', NULL, '0000-00-00 00:00:00'),
(1357, 'FA5', 485, 1, 'right', 'rectangular', 1, 95, NULL, 0, 7, 11.378092957995, 1.5459364319332, '0.00', '0', NULL, '2017-08-09 02:36:12', NULL, '0000-00-00 00:00:00'),
(1358, 'FA5', 485, 1, 'back', 'rectangular', 1, 185, NULL, 1, 12.43, 6.4086197297426, 1.373716432433, '8.54', '0', NULL, '2017-08-09 02:36:12', NULL, '0000-00-00 00:00:00'),
(1359, 'FA5', 485, 1, 'left', 'rectangular', 1, 275, NULL, 1, 7, 11.378092957995, 1.5459364319332, '5.41', '0', NULL, '2017-08-09 02:36:12', NULL, '0000-00-00 00:00:00'),
(1376, 'FA2', 482, 1, 'front', 'rectangular', 1, 5, NULL, 0, 2.63, 7.2655417112188, 1.408851390374, '0.00', '0', NULL, '2017-08-09 02:58:13', NULL, '0000-00-00 00:00:00'),
(1377, 'FA2', 482, 1, 'right', 'rectangular', 1, 95, NULL, 0, 1.39, 13.742323787957, 1.6247441262652, '0.00', '0', NULL, '2017-08-09 02:58:13', NULL, '0000-00-00 00:00:00'),
(1378, 'FA2', 482, 1, 'back', 'rectangular', 1, 185, NULL, 1, 2.63, 7.2655417112188, 1.408851390374, '1.85', '0', NULL, '2017-08-09 02:58:13', NULL, '0000-00-00 00:00:00'),
(1379, 'FA2', 482, 1, 'left', 'rectangular', 1, 275, NULL, 1, 1.39, 13.742323787957, 1.6247441262652, '1.13', '0', NULL, '2017-08-09 02:58:13', NULL, '0000-00-00 00:00:00'),
(1388, 'FA3', 483, 1, 'front', 'rectangular', 1, 5, NULL, 0, 12.47, 6.3964548777213, 1.3731757723432, '0.00', '0', NULL, '2017-08-09 02:58:37', NULL, '0000-00-00 00:00:00'),
(1389, 'FA3', 483, 1, 'right', 'rectangular', 1, 95, NULL, 0, 7.03, 11.336722900017, 1.5445574300006, '0.00', '0', NULL, '2017-08-09 02:58:37', NULL, '0000-00-00 00:00:00'),
(1390, 'FA3', 483, 1, 'back', 'rectangular', 1, 185, NULL, 1, 12.47, 6.3964548777213, 1.3731757723432, '8.56', '0', NULL, '2017-08-09 02:58:37', NULL, '0000-00-00 00:00:00'),
(1391, 'FA3', 483, 1, 'left', 'rectangular', 1, 275, NULL, 1, 7.03, 11.336722900017, 1.5445574300006, '5.43', '0', NULL, '2017-08-09 02:58:37', NULL, '0000-00-00 00:00:00'),
(1404, 'FA4', 484, 1, 'front', 'rectangular', 1, 5, NULL, 0, 2.65, 7.2082848374621, 1.4069428279154, '0.00', '0', NULL, '2017-08-09 03:04:04', NULL, '0000-00-00 00:00:00'),
(1405, 'FA4', 484, 1, 'right', 'rectangular', 1, 95, NULL, 0, 1.41, 13.52385657942, 1.6174618859807, '0.00', '0', NULL, '2017-08-09 03:04:04', NULL, '0000-00-00 00:00:00'),
(1406, 'FA4', 484, 1, 'back', 'rectangular', 1, 185, NULL, 1, 2.65, 7.2082848374621, 1.4069428279154, '1.87', '0', NULL, '2017-08-09 03:04:04', NULL, '0000-00-00 00:00:00'),
(1407, 'FA4', 484, 1, 'left', 'rectangular', 1, 275, NULL, 1, 1.41, 13.52385657942, 1.6174618859807, '1.14', '0', NULL, '2017-08-09 03:04:04', NULL, '0000-00-00 00:00:00'),
(1412, 'FA1', 481, 1, 'front', 'rectangular', 1, 5, NULL, 0, 12.47, 6.3964548777213, 1.3731757723432, '0.00', '0', NULL, '2017-08-09 03:07:03', NULL, '0000-00-00 00:00:00'),
(1413, 'FA1', 481, 1, 'right', 'rectangular', 1, 95, NULL, 0, 7.03, 11.336722900017, 1.5445574300006, '0.00', '0', NULL, '2017-08-09 03:07:03', NULL, '0000-00-00 00:00:00'),
(1414, 'FA1', 481, 1, 'back', 'rectangular', 1, 185, NULL, 1, 12.47, 6.3964548777213, 1.3731757723432, '8.56', '0', NULL, '2017-08-09 03:07:03', NULL, '0000-00-00 00:00:00'),
(1415, 'FA1', 481, 1, 'left', 'rectangular', 1, 275, NULL, 1, 7.03, 11.336722900017, 1.5445574300006, '5.43', '0', NULL, '2017-08-09 03:07:03', NULL, '0000-00-00 00:00:00'),
(1416, 'fa6', 293, 1, 'front', 'rectangular', 1, 9, 171, 0, 28.9333, 3.69, 1.25, '0.0000', '0', NULL, '2017-08-10 03:29:44', NULL, '0000-00-00 00:00:00'),
(1417, 'fa6', 293, 1, 'right', 'rectangular', 1, 99, 81, 1, 22.6472, 4.71, 1.3, '0.7196', '0', NULL, '2017-08-10 03:29:44', NULL, '0000-00-00 00:00:00'),
(1418, 'fa6', 293, 1, 'back', 'rectangular', 1, 189, 9, 1, 28.9333, 3.69, 1.25, '35.3637', '0', NULL, '2017-08-10 03:29:44', NULL, '0000-00-00 00:00:00'),
(1419, 'fa6', 293, 1, 'left', 'rectangular', 1, 279, 99, 0, 22.6472, 4.71, 1.3, '0.0000', '0', NULL, '2017-08-10 03:29:44', NULL, '0000-00-00 00:00:00'),
(1420, 'fa4', 291, 1, 'front', 'rectangular', 1, 5, 175, 0, 14.9722, 5.61, 1.34, '0.0000', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1421, 'fa4', 291, 1, 'right', 'rectangular', 1, 95, 85, 1, 9.3958, 8.94, 1.46, '0.1045', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1422, 'fa4', 291, 1, 'back', 'rectangular', 1, 185, 5, 1, 14.9722, 5.61, 1.34, '19.8854', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1423, 'fa4', 291, 1, 'left', 'rectangular', 1, 275, 95, 0, 9.3958, 8.94, 1.46, '0.0000', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1424, 'fa5', 292, 1, 'front', 'rectangular', 1, 5, 175, 0, 143.7333, 1.86, 1.2, '0.0000', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1425, 'fa5', 292, 1, 'right', 'rectangular', 1, 95, 85, 1, 133.7972, 1.99, 1.2, '1.2196', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1426, 'fa5', 292, 1, 'back', 'rectangular', 1, 185, 5, 1, 143.7333, 1.86, 1.2, '171.1698', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1427, 'fa5', 292, 1, 'left', 'rectangular', 1, 275, 95, 0, 133.7972, 1.99, 1.2, '0.0000', '0', NULL, '2017-08-10 03:30:24', NULL, '0000-00-00 00:00:00'),
(1432, 'fa3', 290, 1, 'front', 'rectangular', 1, 0, 180, 0, 11.4833, 6.79, 1.39, '0.0000', '0', NULL, '2017-08-10 03:30:38', NULL, '0000-00-00 00:00:00'),
(1433, 'fa3', 290, 1, 'right', 'rectangular', 1, 90, 90, 0, 6.1097, 12.77, 1.59, '0.0000', '0', NULL, '2017-08-10 03:30:38', NULL, '0000-00-00 00:00:00'),
(1434, 'fa3', 290, 1, 'back', 'rectangular', 1, 180, 0, 1, 11.4833, 6.79, 1.39, '15.9720', '0', NULL, '2017-08-10 03:30:38', NULL, '0000-00-00 00:00:00'),
(1435, 'fa3', 290, 1, 'left', 'rectangular', 1, 270, 90, 1, 6.1097, 12.77, 1.59, '0.0000', '0', NULL, '2017-08-10 03:30:38', NULL, '0000-00-00 00:00:00'),
(1444, 'FA2', 2, 1, 'front', 'rectangular', 1, 5, 175, 0, 2.1731, 8.41, 1.45, '0.0000', '0', NULL, '2017-08-10 03:40:51', NULL, '0000-00-00 00:00:00'),
(1445, 'FA2', 2, 1, 'right', 'rectangular', 1, 95, 85, 1, 0.9619, 19, 1.8, '0.0132', '0', NULL, '2017-08-10 03:40:51', NULL, '0000-00-00 00:00:00'),
(1446, 'FA2', 2, 1, 'back', 'rectangular', 1, 185, 5, 1, 2.1731, 8.41, 1.45, '3.1206', '0', NULL, '2017-08-10 03:40:51', NULL, '0000-00-00 00:00:00'),
(1447, 'FA2', 2, 1, 'left', 'rectangular', 1, 275, 95, 0, 0.9619, 19, 1.8, '0.0000', '0', NULL, '2017-08-10 03:40:51', NULL, '0000-00-00 00:00:00'),
(1448, 'Test1', 267, 1, 'front', 'rectangular', 1, 5, 178, 0, 14.088, 4.73, 1.3, '0.0000', '0', NULL, '2018-01-22 09:34:53', NULL, '0000-00-00 00:00:00'),
(1449, 'Test1', 267, 1, 'right', 'rectangular', 1, 95, 88, 1, 7.9001, 8.43, 1.45, '0.0139', '0', NULL, '2018-01-22 09:34:53', NULL, '0000-00-00 00:00:00'),
(1450, 'Test1', 267, 1, 'back', 'rectangular', 1, 185, 2, 1, 14.088, 4.73, 1.3, '18.2772', '0', NULL, '2018-01-22 09:34:53', NULL, '0000-00-00 00:00:00'),
(1451, 'Test1', 267, 1, 'left', 'rectangular', 1, 275, 92, 0, 7.9001, 8.43, 1.45, '0.0000', '0', NULL, '2018-01-22 09:34:53', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbtable` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `var` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `unit` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `notes` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96 ;

--
-- Дамп данных таблицы `units`
--

INSERT INTO `units` (`id`, `dbtable`, `var`, `unit`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'ba_materials', 'e', 'ksf', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(2, 'ba_materials', 'rho', 'pcf', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(3, 'ba_materials', 'g', 'pcf', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(4, 'ba_nodes', 'x', 'ft.', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(5, 'ba_nodes', 'y', 'ft', '', 0, '2016-01-30 05:38:20', 0, '0000-00-00 00:00:00'),
(6, 'ba_nodes', 'z', 'ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(7, 'ba_sections', 'od_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(8, 'ba_sections', 'od_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(9, 'ba_sections', 'width_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(10, 'ba_sections', 'width_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(11, 'ba_sections', 'height_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(12, 'ba_sections', 'height_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(13, 'ba_sections', 'crfrc_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(14, 'ba_sections', 'crfrc_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(15, 'ba_sections', 'f2f_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(16, 'ba_sections', 'f2f_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(17, 'ba_sections', 'fwth_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(18, 'ba_sections', 'fwth_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(19, 'ba_sections', 'thk', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(20, 'ba_sections', 'slope', 'in/ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(21, 'ba_sections', 'rotation', 'degree', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(22, 'ba_sections', 'A_start', 'in.^2', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(23, 'ba_sections', 'A_end', 'in.^2', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(24, 'ba_sections', 'Ix_start', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(25, 'ba_sections', 'Ix_end', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(26, 'ba_sections', 'Iy_start', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(27, 'ba_sections', 'Iy_end', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(28, 'ba_sections', 'Iz_start', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(29, 'ba_sections', 'Iz_end', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(30, 'ba_ilcs', 'startLocation', 'ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(31, 'ba_ilcs', 'endLocation', 'ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(32, 'bc2d', 'cnvs_minsidelth', 'pts', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(33, 'bc2d', 'pc_circ_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(34, 'bc2d', 'pc_rp_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(35, 'bc2d', 'pc_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(36, 'bc2d', 'pc_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(37, 'bc2d', 'pc_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(38, 'bc2d', 'pc_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(39, 'bc2d', 'pc_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(40, 'bc2d', 'pc_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(41, 'bc2d', 'pc_1st_cnr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(42, 'bc2d', 'pc_reinf_weld_fillet', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(43, 'bc2d', 'stfnr_d1', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(44, 'bc2d', 'stfnr_d2', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(45, 'bc2d', 'stfnr_d3', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(46, 'bc2d', 'stfnr_d4', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(47, 'bc2d', 'stfnr_d5', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(48, 'bc2d', 'stfnr_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(49, 'bc2d', 'stfnr_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(50, 'bc2d', 'stfnr_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(51, 'bc2d', 'stfnr_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(52, 'bc2d', 'stfnr_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(53, 'bc2d', 'stfnr_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(54, 'bc2d', 'bp_circ_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(55, 'bc2d', 'bp_rp_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(56, 'bc2d', 'bp_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(57, 'bc2d', 'bp_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(58, 'bc2d', 'bp_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(59, 'bc2d', 'bp_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(60, 'bc2d', 'bp_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(61, 'bc2d', 'bp_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(62, 'bc2d', 'bp_1st_cnr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(63, 'bc2d', 'bp_hole_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(64, 'bc2d', 'abr_dia', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(65, 'bc2d', 'abr_area', 'in.^2', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(66, 'bc2d', 'abr_nbr_r_spcn', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(67, 'bc2d', 'abr_1st_abr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(68, 'bc2d', 'abr_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(69, 'bc2d', 'abr_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(70, 'bc2d', 'abr_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(71, 'bc2d', 'abr_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(72, 'bc2d', 'abr_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(73, 'bc2d', 'abr_lth_abv_bptop', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(74, 'bc2d', 'grt_thk', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(75, 'bc2d', 'grt_delta_d1', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(76, 'bc2d', 'grt_delta_d2', 'in.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(77, 'bc2d', 'grt_mat_fy', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(78, 'bc2d', 'grt_mat_fu', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(79, 'bc2d', 'grt_mat_rho', 'kcf', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(80, 'bc2d', 'grt_mat_e', 'ksi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(81, 'bc2d', 'grt_mat_c', 'pc', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(82, 'bc2d', 'bf_circ_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(83, 'bc2d', 'bf_rect_dx', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(84, 'bc2d', 'bf_rect_dz', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(85, 'bc2d', 'bf_rp_od', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(86, 'bc2d', 'bf_1st_cnr_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(87, 'sp', 'dth_fr', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(88, 'sp', 'dth_to', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(89, 'sp', 'dth', 'ft', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(90, 'sp', 'effective_unit_wt', 'pci', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(91, 'sp', 'friction_angle', 'deg.', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(92, 'sp', 'cohesion', 'psi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(93, 'sp', 'k_p_y_modulus', 'pci', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(94, 'sp', 'young_modulus_er', 'psi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00'),
(95, 'sp', 'unaxial_cmpr_strengt', 'psi', '', 0, '2017-01-16 10:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `userscalc`
--

CREATE TABLE IF NOT EXISTS `userscalc` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) DEFAULT NULL,
  `projectID` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CalcID` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `parentID` int(10) DEFAULT NULL,
  `usersname4Calc` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `calcAppName` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `calcAppTable` varchar(50) DEFAULT NULL,
  `iconText` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `node_type` varchar(50) DEFAULT NULL,
  `calc_type` varchar(50) DEFAULT NULL,
  `headerPK` int(11) DEFAULT NULL,
  `footerPK` int(11) DEFAULT NULL,
  `headerStylePK` int(11) DEFAULT NULL,
  `footerStylePK` int(11) DEFAULT NULL,
  `Info1` varchar(45) DEFAULT NULL,
  `Info2` varchar(45) DEFAULT NULL,
  `Info3` varchar(45) DEFAULT NULL,
  `Info4` varchar(45) DEFAULT NULL,
  `display` varchar(20) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=346 ;

--
-- Дамп данных таблицы `userscalc`
--

INSERT INTO `userscalc` (`RcdNo`, `userID`, `projectID`, `CalcID`, `parentID`, `usersname4Calc`, `calcAppName`, `calcAppTable`, `iconText`, `node_type`, `calc_type`, `headerPK`, `footerPK`, `headerStylePK`, `footerStylePK`, `Info1`, `Info2`, `Info3`, `Info4`, `display`, `type`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(310, 131, '79', '20170704C001', 312, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 171, 159, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-04 13:47:00', NULL, '2017-07-04 13:47:00'),
(303, 155, '67', '20170629C001', 0, 'x', NULL, NULL, NULL, 'folder', NULL, 164, 152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 155, '2017-06-29 23:56:27', NULL, '0000-00-00 00:00:00'),
(299, 140, '61', '20170628C001', 0, 'folder3', NULL, NULL, NULL, 'folder', NULL, 156, 144, NULL, NULL, '1', '2', '3', NULL, 'true', 'template', NULL, 140, '2017-06-28 15:02:05', NULL, '0000-00-00 00:00:00'),
(300, 140, '61', '20170628C002', 201, 'testVP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 161, 149, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 140, '2017-06-28 22:12:35', NULL, '2017-06-28 22:12:35'),
(301, 140, '61', '20170628C003', 299, 'testVP1', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 162, 150, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2017-06-28 22:12:35', NULL, '2017-06-28 22:12:35'),
(143, 119, '37', '20160720C003', 0, 'TIA', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-20 15:52:15', NULL, '0000-00-00 00:00:00'),
(308, 131, '79', '20170630C002', 0, 'DSW', NULL, NULL, NULL, 'folder', NULL, 169, 157, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-06-30 18:11:11', NULL, '0000-00-00 00:00:00'),
(25, 119, '37', '20160531CNaN', 178, 'VP(tnxTower)', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 28, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T-Frame on 151-ft SST', 119, '2016-05-31 21:21:40', NULL, '2016-05-31 21:21:40'),
(23, 119, '36', '20160531CNaN', 62, 'Loreley', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T-Frame on 151-ft SST', 119, '2016-05-31 21:21:40', NULL, '2016-05-31 21:21:40'),
(24, 119, '37', '20160531CNaN', 178, 'VP(AECOM)', 'TIA-222-G-VP', 'tia_222_g_gust_effect', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'T-Frame on 151-ft SST', 119, '2016-05-31 21:21:40', NULL, '2016-05-31 21:21:40'),
(309, 131, '79', '20170630C003', 0, '10049241', NULL, NULL, NULL, 'folder', NULL, 170, 158, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-06-30 18:11:21', NULL, '0000-00-00 00:00:00'),
(285, 131, '79', '20170623C002', 314, 'tests', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 142, 130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-06-24 02:06:54', NULL, '2017-06-24 02:06:54'),
(286, 131, '79', '20170626C001', 287, 'Hailey', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 143, 131, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-06-26 20:41:19', NULL, '2017-06-26 20:41:19'),
(287, 131, '79', '20170626C002', 0, 'Hailey', NULL, NULL, NULL, 'folder', NULL, 144, 132, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-06-26 20:53:35', NULL, '0000-00-00 00:00:00'),
(14, 119, '33', '20160707C001', 0, 'BA_14', 'BA2D', NULL, NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-07 15:57:25', NULL, '2016-07-07 15:57:25'),
(62, 131, '36', '20160624C001', 62, 'X', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2016-06-24 19:06:38', NULL, '0000-00-00 00:00:00'),
(63, 119, '36', '20160624C002', 0, 'TSITE', 'TIA-222-G-GUST', 'tia_222_g_gust_effect', NULL, 'calc', NULL, 40, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-06-24 17:25:55', NULL, '2016-06-24 17:25:55'),
(177, 119, '37', '20160815C004', 143, '222', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-08-16 01:07:16', NULL, '0000-00-00 00:00:00'),
(136, 119, '37', '20160716C001', 180, 'WP', 'awwa-d100-05-wp', 'awwa_d100_05_wp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-16 14:08:45', NULL, '2016-07-16 14:08:45'),
(100, 119, '33', '20160709C003', 0, 'EX1', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-09 04:20:30', NULL, '0000-00-00 00:00:00'),
(102, 119, '33', '20160709C003', 0, 'EX2', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-09 04:27:25', NULL, '0000-00-00 00:00:00'),
(144, 119, '37', '20160720C004', 0, 'AWWA', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-20 15:52:25', NULL, '0000-00-00 00:00:00'),
(133, 119, '37', '20160715C003', 178, 'TEST_COMB', 'Wind Load', 'tia_222_g_vp', NULL, 'calc', NULL, 38, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-15 14:35:09', NULL, '2016-07-15 14:35:09'),
(126, 137, '47', '20160714C001', 0, 'Test', NULL, NULL, NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 137, '2016-07-14 14:26:05', NULL, '0000-00-00 00:00:00'),
(129, 119, '37', '20160714C003', 178, 'WL_Comb', 'Wind Load', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-07-14 19:13:40', NULL, '2016-07-14 19:13:40'),
(148, 131, '55', '20160721C001', 0, 'KC', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2016-07-22 02:46:31', NULL, '0000-00-00 00:00:00'),
(158, 138, '60', '20160728C001', 0, 'test Calc 2', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-07-28 14:46:25', NULL, '2016-07-28 14:46:25'),
(159, 138, '58', '20160728C002', 0, 'calc3', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-07-28 15:26:40', NULL, '2016-07-28 15:26:40'),
(160, 138, '58', '20160728C003', 0, 'Beam Analysis', 'BA2D', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-07-28 21:01:12', NULL, '2016-07-28 21:01:12'),
(157, 138, '60', '20160725C002', 156, 'calc1', 'TIA-222-G-VP', NULL, NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-07-25 07:05:26', NULL, '0000-00-00 00:00:00'),
(156, 138, '60', '20160725C001', 0, 'folder', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-07-25 07:05:20', NULL, '0000-00-00 00:00:00'),
(161, 138, '60', '20160802C001', 0, 'GE save test 1', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 138, '2016-08-02 21:16:14', NULL, '2016-08-02 21:16:14'),
(307, 131, '79', '20170630C001', 0, 'RMR', NULL, NULL, NULL, 'folder', NULL, 168, 156, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-06-30 18:11:02', NULL, '0000-00-00 00:00:00'),
(169, 138, '58', '20160804C003', 0, 'VP SAVE TEST', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-08-04 14:41:58', NULL, '0000-00-00 00:00:00'),
(284, 131, '79', '20170623C001', 0, 'McClure', NULL, NULL, NULL, 'folder', NULL, 141, 129, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-06-24 02:07:46', NULL, '0000-00-00 00:00:00'),
(313, 140, '61', '20170705C001', 336, 'VPtest', 'TIA-222-G-VP', 'tia_222_g_vp', '1', 'calc', NULL, 173, 161, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 140, '2017-07-05 12:28:57', NULL, '0000-00-00 00:00:00'),
(314, 131, '79', '20170709C001', 309, 'X', NULL, NULL, NULL, 'folder', NULL, 174, 162, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-09 13:36:44', NULL, '0000-00-00 00:00:00'),
(172, 119, '37', '20160805C001', 144, 'X', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-08-05 11:37:54', NULL, '0000-00-00 00:00:00'),
(173, 138, '60', '20160805C002', 0, 'Test footer bug', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 138, '2016-08-05 18:54:05', NULL, '2016-08-05 18:54:05'),
(174, 140, '61', '20160815C001', 0, 'folder', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2016-08-15 09:01:26', NULL, '0000-00-00 00:00:00'),
(182, 140, '61', '20160830C001', 174, 'BA1', 'BA2D', NULL, NULL, 'calc', NULL, 33, 22, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2016-08-30 14:51:34', NULL, '2016-08-30 14:51:34'),
(178, 119, '37', '20160815C005', 177, 'G', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-08-16 01:07:21', NULL, '0000-00-00 00:00:00'),
(179, 119, '37', '20160815C006', 144, 'D100', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-08-16 01:07:32', NULL, '0000-00-00 00:00:00'),
(180, 119, '37', '20160815C007', 179, '05', NULL, NULL, NULL, 'folder', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-08-16 01:07:40', NULL, '0000-00-00 00:00:00'),
(187, 119, '64', '20160922C001', 0, 'Beam Analysis', 'BA2D', NULL, NULL, 'calc', NULL, 29, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-09-22 16:01:34', NULL, '2016-09-22 16:01:34'),
(188, 155, '65', '20161111C001', 0, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 30, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 155, '2016-11-12 04:24:19', NULL, '0000-00-00 00:00:00'),
(189, 119, '37', '20161114C001', 0, 'htr', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 31, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 119, '2016-11-14 14:32:01', NULL, '2016-11-14 14:32:01'),
(190, 140, '61', '20161115C001', 336, 'VP01', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 32, 21, 6, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2016-11-15 21:47:50', NULL, '2016-11-15 21:47:50'),
(193, 131, '55', '20161212C002', 148, 'tgx', 'TIA-222-G-GUST', 'tia_222_g_gust_effect', NULL, 'calc', NULL, 44, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'tg', 131, '2016-12-12 19:18:48', NULL, '2016-12-12 19:18:48'),
(311, 131, '79', '20170704C002', 312, 'WL_DA', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 172, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-04 13:47:00', NULL, '2017-07-04 13:47:00'),
(312, 131, '79', '20170704C003', 308, 'Hailey', NULL, NULL, NULL, 'folder', NULL, 173, 161, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-07-04 13:56:44', NULL, '0000-00-00 00:00:00'),
(304, 131, '79', '20170629C002', 0, 'x', NULL, NULL, NULL, 'folder', NULL, 165, 153, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-06-30 01:02:29', NULL, '0000-00-00 00:00:00'),
(200, 154, '72', '20161219C001', 0, 'TR', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 52, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 154, '2016-12-19 20:02:40', NULL, '2016-12-19 20:02:40'),
(201, 140, '0', '20161220C001', 0, 'test', NULL, NULL, NULL, 'folder', NULL, 53, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 140, '2016-12-20 13:44:19', NULL, '0000-00-00 00:00:00'),
(202, 157, '75', '20161220C002', 0, 'test calc', NULL, NULL, NULL, 'calc', NULL, 54, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 157, '2016-12-20 13:45:01', NULL, '0000-00-00 00:00:00'),
(206, 100, '77', '20161221C004', 0, '1st calc', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 58, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 100, '2016-12-21 16:26:07', NULL, '2016-12-21 16:26:07'),
(305, 131, '79', '20170629C003', 304, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 166, 154, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-06-29 23:55:54', NULL, '2017-06-29 23:55:54'),
(223, 131, '57', '20170310C001', 0, 'ert', 'GSI', 'SP', NULL, 'calc', NULL, 79, 67, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-03-11 01:33:01', NULL, '2017-03-11 01:33:01'),
(318, 131, '86', '20170710C003', 333, '147-117', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 178, 166, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-07-10 13:20:54', NULL, '2017-07-10 13:20:54'),
(319, 131, '86', '20170710C004', 334, '074-042(FA10019171)', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 179, 167, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-07-10 13:20:54', NULL, '2017-07-10 13:20:54'),
(320, 131, '79', '20170726C001', 309, '382-050', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 184, 172, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FA10049241', 131, '2017-07-26 20:18:14', NULL, '2017-07-26 20:18:14'),
(228, 131, '57', '20170324C001', 0, 'VPE', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 84, 72, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-03-24 14:43:18', NULL, '2017-03-24 14:43:18'),
(229, 131, '57', '20170324C002', 0, 'vpa', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 85, 73, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-03-24 14:46:38', NULL, '2017-03-24 14:46:38'),
(317, 131, '79', '20170710C002', 316, 'NC', NULL, NULL, NULL, 'folder', NULL, 177, 165, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-10 13:21:13', NULL, '0000-00-00 00:00:00'),
(316, 131, '79', '20170710C001', 0, 'MA', NULL, NULL, NULL, 'folder', NULL, 176, 164, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-10 13:21:03', NULL, '0000-00-00 00:00:00'),
(232, 131, '57', '20170327C003', 315, 'werq', 'BC2D', 'bc2d', NULL, 'calc', NULL, 88, 76, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-03-27 17:47:38', NULL, '2017-03-27 17:47:38'),
(315, 131, '57', '20170709C002', 0, 'X', NULL, NULL, NULL, 'folder', NULL, 175, 163, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-07-09 13:43:55', NULL, '0000-00-00 00:00:00'),
(235, 131, '57', '20170327C001', 0, 'BCTEST4', 'BC2D', 'bc2d', NULL, 'calc', NULL, 91, 79, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-03-27 16:57:38', NULL, '2017-03-27 16:57:38'),
(237, 140, '61', '20170403C001', 336, 'WLDA 001', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 93, 81, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2017-04-03 21:57:22', NULL, '2017-04-03 21:57:22'),
(283, 131, '44', '20170620C001', 0, 'wl_da', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 140, 128, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-06-20 16:26:01', NULL, '2017-06-20 16:26:01'),
(326, 131, '82', '20170729C005', 325, 'ATT', NULL, NULL, NULL, 'folder', NULL, 190, 178, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-29 14:55:41', NULL, '0000-00-00 00:00:00'),
(325, 131, '82', '20170729C004', 0, '10016586', NULL, NULL, NULL, 'folder', NULL, 189, 177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-29 14:54:59', NULL, '0000-00-00 00:00:00'),
(323, 131, '82', '20170729C002', 324, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 187, 175, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-07-29 14:46:06', NULL, '0000-00-00 00:00:00'),
(324, 131, '82', '20170729C003', 0, '10016586', NULL, NULL, NULL, 'folder', NULL, 188, 176, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-07-29 14:47:05', NULL, '0000-00-00 00:00:00'),
(306, 131, '79', '20170629C004', 304, 'wl_da', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 167, 155, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-06-29 23:55:54', NULL, '2017-06-29 23:55:54'),
(282, 155, '65', '20170617C001', 0, 'WL_DA', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 139, 127, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 155, '2017-06-17 00:02:02', NULL, '2017-06-17 00:02:02'),
(331, 131, '82', '20170809C001', 0, '10069464', NULL, NULL, NULL, 'folder', NULL, 195, 183, NULL, NULL, 'Hyde Park', '158ft Monopole', NULL, NULL, NULL, NULL, NULL, 131, '2017-08-09 15:38:45', NULL, '0000-00-00 00:00:00'),
(332, 131, '82', '20170809C002', 331, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 196, 184, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-08-09 15:38:58', NULL, '0000-00-00 00:00:00'),
(281, 131, '79', '20170614C001', 284, 'McClureMtn', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 138, 126, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mount Analsyis', 131, '2017-06-14 18:09:41', NULL, '2017-06-14 18:09:41'),
(302, 140, '61', '20170628C004', 174, 'testVP2', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 163, 151, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2017-06-28 22:25:25', NULL, '2017-06-28 22:25:25'),
(298, 140, '68', '20170627C002', 0, 'testwlda', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 155, 143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 140, '2017-06-27 17:09:07', NULL, '2017-06-27 17:09:07'),
(321, 131, '79', '20170726C002', 309, 'WL_DA', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 185, 173, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '382-050', 131, '2017-07-27 03:37:49', NULL, '2017-07-27 03:37:49'),
(322, 131, '79', '20170729C001', 0, 'FL', NULL, NULL, NULL, 'folder', NULL, 186, 174, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-07-29 14:44:50', NULL, '0000-00-00 00:00:00'),
(263, 155, '66', '20170512C001', 0, 'rr', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 120, 108, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 155, '2017-05-13 00:40:46', NULL, '2017-05-13 00:40:46'),
(327, 131, '79', '20170808C001', 308, '10115165', NULL, NULL, NULL, 'folder', NULL, 191, 179, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-08 14:30:28', NULL, '0000-00-00 00:00:00'),
(328, 131, '79', '20170808C002', 308, '10115165', NULL, NULL, NULL, 'folder', NULL, 192, 180, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-08 14:30:54', NULL, '0000-00-00 00:00:00'),
(329, 131, '79', '20170808C003', 328, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 193, 181, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-08-08 14:31:17', NULL, '0000-00-00 00:00:00'),
(330, 131, '79', '20170808C004', 328, 'WL_DA', 'Wind Load for D.A.', 'wl_2d', NULL, 'calc', NULL, 194, 182, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-08-08 14:33:15', NULL, '0000-00-00 00:00:00'),
(333, 131, '86', '20170809C003', 0, '10018573', NULL, NULL, NULL, 'folder', NULL, 197, 185, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-10 03:08:46', NULL, '0000-00-00 00:00:00'),
(337, 131, '82', '20170811C001', 0, '10015976', NULL, NULL, NULL, 'folder', NULL, 201, 189, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-08-11 19:23:38', NULL, '0000-00-00 00:00:00'),
(334, 131, '86', '20170809C004', 0, '10019171', NULL, NULL, NULL, 'folder', NULL, 198, 186, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-10 03:09:14', NULL, '0000-00-00 00:00:00'),
(335, 131, '79', '20170809C003', 317, '10018573', NULL, NULL, NULL, 'folder', NULL, 199, 187, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-10 03:16:24', NULL, '0000-00-00 00:00:00'),
(336, 140, '61', '20170810C001', 0, 'hc', NULL, NULL, NULL, 'folder', NULL, 200, 188, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2017-08-10 11:20:46', NULL, '0000-00-00 00:00:00'),
(338, 131, '82', '20170811C002', 337, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 202, 190, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-08-11 19:23:54', NULL, '0000-00-00 00:00:00'),
(339, 131, '86', '20170811C003', 0, 'HM', NULL, NULL, NULL, 'folder', NULL, 203, 191, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-12 00:19:28', NULL, '0000-00-00 00:00:00'),
(340, 131, '86', '20170811C004', 339, 'TEST', 'GSI', 'SP', NULL, 'calc', NULL, 204, 192, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-12 00:17:41', NULL, '2017-08-12 00:17:41'),
(341, 131, '86', '20170821C001', 0, '10019507', NULL, NULL, NULL, 'folder', NULL, 205, 193, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-08-21 13:38:47', NULL, '0000-00-00 00:00:00'),
(342, 131, '86', '20170821C002', 341, 'VP', 'TIA-222-G-VP', 'tia_222_g_vp', NULL, 'calc', NULL, 206, 194, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 131, '2017-08-21 13:39:04', NULL, '0000-00-00 00:00:00'),
(343, 131, '86', '20170821C003', 0, '10019252', NULL, NULL, NULL, 'folder', NULL, 207, 195, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 131, '2017-08-21 15:54:15', NULL, '0000-00-00 00:00:00'),
(344, 131, '86', '20170821C004', 343, 'VP', 'TIA-222-G-VP', NULL, NULL, 'calc', NULL, 208, 196, NULL, NULL, NULL, NULL, NULL, NULL, 'false', NULL, NULL, 131, '2017-08-21 15:54:25', NULL, '0000-00-00 00:00:00'),
(345, 140, '61', '20170927C001', 0, '123', 'WL_SC', 'tia_222_g_vp', NULL, 'calc', NULL, 209, 197, NULL, NULL, NULL, NULL, NULL, NULL, 'true', NULL, NULL, 140, '2017-09-27 22:19:02', NULL, '2017-09-27 22:19:02');

-- --------------------------------------------------------

--
-- Структура таблицы `vp`
--

CREATE TABLE IF NOT EXISTS `vp` (
  `RcdNo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userscalcPK` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `expCAT` varchar(45) DEFAULT NULL,
  `Z_g` double DEFAULT NULL,
  `alpha` double DEFAULT NULL,
  `K_zmin` double DEFAULT NULL,
  `K_e` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `K_z` double DEFAULT NULL,
  `topCAT` int(2) DEFAULT NULL,
  `K_t` double NOT NULL,
  `f` double NOT NULL,
  `H` double DEFAULT NULL,
  `K_h` double DEFAULT NULL,
  `K_zt` double DEFAULT NULL,
  `strTYP` varchar(45) DEFAULT NULL,
  `crosSEC` varchar(45) DEFAULT NULL,
  `K_d` double DEFAULT NULL,
  `V` double DEFAULT NULL,
  `strCLAS` varchar(45) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`RcdNo`),
  UNIQUE KEY `abc_ndx` (`RcdNo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Дамп данных таблицы `vp`
--

INSERT INTO `vp` (`RcdNo`, `userscalcPK`, `expCAT`, `Z_g`, `alpha`, `K_zmin`, `K_e`, `z`, `K_z`, `topCAT`, `K_t`, `f`, `H`, `K_h`, `K_zt`, `strTYP`, `crosSEC`, `K_d`, `V`, `strCLAS`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(85, '118', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(84, '117', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(65, '98', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:01:42', NULL, '0000-00-00 00:00:00'),
(78, '111', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(76, '109', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(77, '110', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(86, '119', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(103, '137', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:43:44', NULL, '0000-00-00 00:00:00'),
(104, '138', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, NULL, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:18:57', NULL, '0000-00-00 00:00:00'),
(105, '139', 'C', 900, 5, 0.5, 0.8, 0, 0.5, 3, 0.53, 2, 0, 0, 0, '', '', 0.85, 90, '', '', 0, '2015-11-19 07:18:57', 0, '0000-00-00 00:00:00'),
(93, '126', 'C', 900, 5, 0.5, 0.8, NULL, 0.5, 3, 0.53, 2, NULL, NULL, 1, NULL, NULL, 0.85, 90, NULL, NULL, NULL, '2015-11-19 07:43:44', NULL, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

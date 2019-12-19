-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 19 2019 г., 04:06
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ba`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ilcs`
--

CREATE TABLE IF NOT EXISTS `ilcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersba_id` varchar(255) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

--
-- Дамп данных таблицы `ilcs`
--

INSERT INTO `ilcs` (`id`, `usersba_id`, `ilc`, `geometry`, `component`, `unit`, `startLocation`, `startValue`, `endLocation`, `endValue`, `visibility`, `note`) VALUES
(116, '278', 'ilc1', 'Point', 'FX', 'lbf', '3', '5', '', '', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `lcs`
--

CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersba_id` varchar(255) NOT NULL,
  `lc` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Дамп данных таблицы `lcs`
--

INSERT INTO `lcs` (`id`, `usersba_id`, `lc`, `params`, `note`) VALUES
(36, '278', 'LC1', '{"116":"12"}', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersba_id` int(11) NOT NULL,
  `org` varchar(255) NOT NULL,
  `standard` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `Rho` varchar(255) NOT NULL,
  `G` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `usersba_id`, `org`, `standard`, `grade`, `name`, `E`, `Rho`, `G`) VALUES
(35, 278, 'ASTM', '260W', '', '260W', '29000000', '0.283565999', '11200000');

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersba_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `n_start` varchar(255) NOT NULL,
  `n_end` varchar(255) NOT NULL,
  `sec_id` int(11) NOT NULL,
  `slope` varchar(255) DEFAULT NULL,
  `rotation` varchar(255) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `members`
--

INSERT INTO `members` (`id`, `usersba_id`, `name`, `n_start`, `n_end`, `sec_id`, `slope`, `rotation`, `mat_id`) VALUES
(3, '278', 'm1', '199', '200', 1, '13', '12', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usersba_id` varchar(255) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=214 ;

--
-- Дамп данных таблицы `nodes`
--

INSERT INTO `nodes` (`id`, `usersba_id`, `name`, `x`, `y`, `z`, `dx`, `dy`, `dz`, `mx`, `my`, `mz`, `note`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(199, '278', 'N1', NULL, 4.00, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, '2016-11-21 13:46:36', NULL, '0000-00-00 00:00:00'),
(200, '278', 'N2', NULL, 8.00, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, '2016-11-21 13:46:42', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersba_id` varchar(255) NOT NULL,
  `s_eq_e` tinyint(4) NOT NULL,
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
  `slope` varchar(255) NOT NULL,
  `crfrc_start` varchar(255) DEFAULT NULL,
  `crfrc_end` varchar(255) DEFAULT NULL,
  `f2f_start` varchar(255) DEFAULT NULL,
  `f2f_end` varchar(255) DEFAULT NULL,
  `fwth_start` varchar(255) DEFAULT NULL,
  `fwth_end` varchar(255) DEFAULT NULL,
  `thk` varchar(255) DEFAULT NULL,
  `A_start` varchar(255) NOT NULL,
  `A_end` varchar(255) NOT NULL,
  `Ix_start` varchar(256) NOT NULL,
  `Ix_end` varchar(255) NOT NULL,
  `Iy_start` varchar(255) NOT NULL,
  `Iy_end` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`id`, `usersba_id`, `s_eq_e`, `crsec`, `shape`, `size1`, `size2`, `od_start`, `od_end`, `width_start`, `width_end`, `height_start`, `height_end`, `slope`, `crfrc_start`, `crfrc_end`, `f2f_start`, `f2f_end`, `fwth_start`, `fwth_end`, `thk`, `A_start`, `A_end`, `Ix_start`, `Ix_end`, `Iy_start`, `Iy_end`) VALUES
(1, '278', 0, 'AISC', '2L_LLBB', '2L3-1/2', '2L3-1/2X2-1/2X1/2X3/4LLBB', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', ''),
(2, '0', 0, 'AISC', 'S', 'S6', 'S6X12.5', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `sections_old_bu`
--

CREATE TABLE IF NOT EXISTS `sections_old_bu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=143 ;

--
-- Дамп данных таблицы `sections_old_bu`
--

INSERT INTO `sections_old_bu` (`id`, `userspc_id`, `n_start`, `n_end`, `A_start`, `A_end`, `e`, `crsec`, `shape`, `size1`, `size2`, `od_start`, `od_end`, `width_start`, `width_end`, `height_start`, `height_end`, `Ix_start`, `Ix_end`, `Iy_start`, `Iy_end`, `rotation`, `matID`, `s_eq_e`, `slope`, `crfrc_start`, `crfrc_end`, `f2f_start`, `f2f_end`, `fwth_start`, `fwth_end`, `thk`) VALUES
(139, '278', '199', '200', '', '', '', '8-sided', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', '1', NULL, '2', NULL, NULL, NULL, NULL),
(140, '0', '', '', '', '', '', 'AISC', '2L_E', '2L3', '2L3X2-1/2X1/4X3/4SLBB', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, '0', '', '', '', '', '', 'AISC', '2L_E', '2L3', '2L3X2-1/2X1/4X3/4SLBB', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, '0', '', '', '', '', '', 'AISC', 'C', 'C7', 'C7X12.25', '', '', '', '', '', '', '', '', '', '', '', 0, 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `supports`
--

CREATE TABLE IF NOT EXISTS `supports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usersba_id` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `kx` varchar(255) NOT NULL,
  `ky` varchar(255) NOT NULL,
  `kz` varchar(255) NOT NULL,
  `krotx` varchar(255) NOT NULL,
  `kroty` varchar(255) NOT NULL,
  `krotz` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `supports`
--

INSERT INTO `supports` (`id`, `usersba_id`, `location`, `type`, `kx`, `ky`, `kz`, `krotx`, `kroty`, `krotz`) VALUES
(47, '278', 'oop', 'Pinned', 'INF', 'INF', 'INF', 'INF', 'INF', '0');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Дамп данных таблицы `units`
--

INSERT INTO `units` (`id`, `dbtable`, `var`, `unit`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 'materials', 'e', 'ksf', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(2, 'materials', 'rho', 'pcf', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(3, 'materials', 'g', 'pcf', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(4, 'nodes', 'x', 'ft.', '', 0, '2016-01-30 05:37:50', 0, '0000-00-00 00:00:00'),
(5, 'nodes', 'y', 'ft', '', 0, '2016-01-30 05:38:20', 0, '0000-00-00 00:00:00'),
(6, 'nodes', 'z', 'ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(7, 'sections', 'od_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(8, 'sections', 'od_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(9, 'sections', 'width_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(10, 'sections', 'width_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(11, 'sections', 'height_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(12, 'sections', 'height_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(13, 'sections', 'crfrc_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(14, 'sections', 'crfrc_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(15, 'sections', 'f2f_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(16, 'sections', 'f2f_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(17, 'sections', 'fwth_start', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(18, 'sections', 'fwth_end', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(19, 'sections', 'thk', 'in.', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(20, 'sections', 'slope', 'in/ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(21, 'sections', 'rotation', 'degree', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(22, 'sections', 'A_start', 'in.^2', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(23, 'sections', 'A_end', 'in.^2', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(24, 'sections', 'Ix_start', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(25, 'sections', 'Ix_end', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(26, 'sections', 'Iy_start', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(27, 'sections', 'Iy_end', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(28, 'sections', 'Iz_start', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(29, 'sections', 'Iz_end', 'in.^4', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(30, 'ilcs', 'startLocation', 'ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00'),
(31, 'ilcs', 'endLocation', 'ft', '', 0, '2016-01-30 05:38:32', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `userspc`
--

CREATE TABLE IF NOT EXISTS `userspc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `usersname4pc` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `project_id` varchar(20) DEFAULT NULL,
  `pcid` varchar(50) DEFAULT NULL,
  `iconText` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `headerPK` int(11) DEFAULT NULL,
  `footerPK` int(11) DEFAULT NULL,
  `headerStylePK` int(11) DEFAULT NULL,
  `footerStylePK` int(11) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=281 ;

--
-- Дамп данных таблицы `userspc`
--

INSERT INTO `userspc` (`id`, `userID`, `parent_id`, `usersname4pc`, `project_id`, `pcid`, `iconText`, `type`, `headerPK`, `footerPK`, `headerStylePK`, `footerStylePK`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(256, 0, 0, 'VP01', '12', '20160830C001', NULL, 'calc', 2, 26, 4, 1, '123', 0, '2016-08-30 15:33:31', NULL, '2016-08-30 15:33:31'),
(278, 140, 0, 'BA01', '61', '20161111C000', NULL, 'calc', 34, 23, 4, 1, NULL, 140, '2016-11-21 13:45:23', NULL, '0000-00-00 00:00:00'),
(279, 140, 0, 'folder1', '61', '20161111C000', NULL, 'folder', 35, 24, NULL, NULL, NULL, 140, '2016-11-21 13:50:15', NULL, '0000-00-00 00:00:00'),
(280, 140, 279, 'BA02', '61', '20161125C001', NULL, 'calc', 39, 28, NULL, NULL, NULL, 140, '2016-11-25 15:41:48', NULL, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

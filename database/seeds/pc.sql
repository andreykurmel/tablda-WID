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
-- База данных: `pc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ilcs`
--

CREATE TABLE IF NOT EXISTS `ilcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ilc_atchmt`
--

CREATE TABLE IF NOT EXISTS `ilc_atchmt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
  `node_name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `eqpt_name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `dx` double(5,2) DEFAULT NULL,
  `dy` double(5,2) DEFAULT NULL,
  `dz` double(5,2) DEFAULT NULL,
  `rotx` double(5,2) DEFAULT NULL,
  `roty` double(5,2) DEFAULT NULL,
  `rotz` double(5,2) DEFAULT NULL,
  `notes` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ilc_eqpt`
--

CREATE TABLE IF NOT EXISTS `ilc_eqpt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `userspc_id` varchar(255) NOT NULL,
  `wid_db_pro_PK` int(11) NOT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `createdBy` int(10) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(10) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `lcs`
--

CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
  `lc` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
  `org` varchar(255) NOT NULL,
  `standard` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `Rho` varchar(255) NOT NULL,
  `G` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `userspc_id`, `org`, `standard`, `grade`, `name`, `E`, `Rho`, `G`) VALUES
(36, '281', 'ASTM', '260W(250)', '', '260W(250)', '29000000', '0.283565999', '11200000');

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `n_start` varchar(255) NOT NULL,
  `n_end` varchar(255) NOT NULL,
  `sec_id` int(11) NOT NULL,
  `slope` varchar(255) DEFAULT NULL,
  `rotation` varchar(255) DEFAULT NULL,
  `mat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `members`
--

INSERT INTO `members` (`id`, `userspc_id`, `name`, `n_start`, `n_end`, `sec_id`, `slope`, `rotation`, `mat_id`) VALUES
(2, '281', '1', '204', '205', 1, '10', '11', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
  `name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `x` double(5,2) DEFAULT NULL,
  `y` double(5,2) DEFAULT NULL,
  `z` double(5,2) DEFAULT NULL,
  `dx` tinyint(4) NOT NULL,
  `dy` tinyint(4) NOT NULL,
  `dz` tinyint(4) NOT NULL,
  `rx` tinyint(4) NOT NULL,
  `ry` tinyint(4) NOT NULL,
  `rz` tinyint(4) NOT NULL,
  `note` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=206 ;

--
-- Дамп данных таблицы `nodes`
--

INSERT INTO `nodes` (`id`, `userspc_id`, `name`, `x`, `y`, `z`, `dx`, `dy`, `dz`, `rx`, `ry`, `rz`, `note`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(204, '281', 'N1', NULL, 5.00, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, '2017-02-06 15:58:39', NULL, '0000-00-00 00:00:00'),
(205, '281', 'N2', NULL, 0.00, NULL, 0, 0, 0, 0, 0, 0, NULL, NULL, '2017-02-06 15:58:42', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`id`, `userspc_id`, `s_eq_e`, `crsec`, `shape`, `size1`, `size2`, `od_start`, `od_end`, `width_start`, `width_end`, `height_start`, `height_end`, `slope`, `crfrc_start`, `crfrc_end`, `f2f_start`, `f2f_end`, `fwth_start`, `fwth_end`, `thk`, `A_start`, `A_end`, `Ix_start`, `Ix_end`, `Iy_start`, `Iy_end`) VALUES
(1, '281', 0, 'AISC', '2L_E', '2L3-1/2', '2L3-1/2X2-1/2X1/4LLBB', '', '', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `supports`
--

CREATE TABLE IF NOT EXISTS `supports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userspc_id` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `kx` varchar(255) NOT NULL,
  `ky` varchar(255) NOT NULL,
  `kz` varchar(255) NOT NULL,
  `krotx` varchar(255) NOT NULL,
  `kroty` varchar(255) NOT NULL,
  `krotz` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
(1, 'materials', 'e', 'ksf', '', 0, '2016-01-30 10:37:50', 0, '0000-00-00 00:00:00'),
(2, 'materials', 'rho', 'pcf', '', 0, '2016-01-30 10:37:50', 0, '0000-00-00 00:00:00'),
(3, 'materials', 'g', 'pcf', '', 0, '2016-01-30 10:37:50', 0, '0000-00-00 00:00:00'),
(4, 'nodes', 'x', 'ft.', '', 0, '2016-01-30 10:37:50', 0, '0000-00-00 00:00:00'),
(5, 'nodes', 'y', 'ft', '', 0, '2016-01-30 10:38:20', 0, '0000-00-00 00:00:00'),
(6, 'nodes', 'z', 'ft', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(7, 'sections', 'od_start', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(8, 'sections', 'od_end', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(9, 'sections', 'width_start', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(10, 'sections', 'width_end', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(11, 'sections', 'height_start', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(12, 'sections', 'height_end', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(13, 'sections', 'crfrc_start', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(14, 'sections', 'crfrc_end', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(15, 'sections', 'f2f_start', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(16, 'sections', 'f2f_end', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(17, 'sections', 'fwth_start', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(18, 'sections', 'fwth_end', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(19, 'sections', 'thk', 'in.', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(20, 'sections', 'slope', 'in/ft', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(21, 'sections', 'rotation', 'degree', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(22, 'sections', 'A_start', 'in.^2', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(23, 'sections', 'A_end', 'in.^2', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(24, 'sections', 'Ix_start', 'in.^4', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(25, 'sections', 'Ix_end', 'in.^4', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(26, 'sections', 'Iy_start', 'in.^4', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(27, 'sections', 'Iy_end', 'in.^4', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(28, 'sections', 'Iz_start', 'in.^4', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(29, 'sections', 'Iz_end', 'in.^4', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(30, 'ilcs', 'startLocation', 'ft', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00'),
(31, 'ilcs', 'endLocation', 'ft', '', 0, '2016-01-30 10:38:32', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `userspc`
--

CREATE TABLE IF NOT EXISTS `userspc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `project_id` varchar(20) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `pcID` varchar(20) DEFAULT NULL,
  `pc_type` varchar(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `usersname4pc` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `iconText` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `headerPK` int(11) DEFAULT NULL,
  `footerPK` int(11) DEFAULT NULL,
  `notes` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifiedBy` int(11) DEFAULT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=282 ;

--
-- Дамп данных таблицы `userspc`
--

INSERT INTO `userspc` (`id`, `type`, `project_id`, `parent_id`, `pcID`, `pc_type`, `userid`, `usersname4pc`, `iconText`, `headerPK`, `footerPK`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(281, 'calc', '61', 0, '20170206C001', NULL, 140, 'Testcalc', NULL, 63, 51, NULL, 140, '2017-02-06 15:58:31', NULL, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

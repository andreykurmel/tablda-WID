-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 19 2019 г., 04:08
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `quiz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_node` int(11) NOT NULL,
  `id_answer_options` varchar(50) NOT NULL,
  `explanation` varchar(255) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Дамп данных таблицы `answer`
--

INSERT INTO `answer` (`id`, `id_node`, `id_answer_options`, `explanation`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(5, 30, '["11"]', 'Explanation 1-1 aess additional information', 0, '0000-00-00 00:00:00', 0, '2017-06-28 13:03:09'),
(6, 32, '["14"]', 'Explanation 1-2', 0, '0000-00-00 00:00:00', 0, '2017-06-21 14:04:12'),
(7, 33, '["16"]', 'Explanation 1-3', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(8, 34, '["19"]', 'Explanation 1-4', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(9, 35, '["21"]', 'Explanation 1-5', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, 36, '["26"]', 'Explanation 2-1', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, 37, '["27"]', 'Explanation 2-2', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, 38, '["31"]', 'Explanation 2-3', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, 39, '["33"]', 'Explanation 2-4', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, 40, '["37"]', 'Explanation 2-5', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(15, 41, '["41"]', 'Explanation 3-1', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(16, 42, '["44"]', 'Explanation 3-2', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(17, 43, '["45"]', 'Explanation 3-3', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(18, 45, '["49"]', 'Explanation 3-4', 0, '0000-00-00 00:00:00', 0, '2017-06-30 07:55:44'),
(19, 46, '["51"]', 'Explanation 3-5', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(32, 169, '[]', 'Section 2.1 of the AISC Code of Standard Practice contains a definition and detailed list of items that are elements of the structural frame and are classified as structural steel. Section 2.2 lists other steel, iron or metal items. The general distinctio', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(33, 172, '[]', 'limit state in a flexural member whereby the compression flange is braced at a concentrated load and the web is squeezed into compression. This results in the tension flange buckling. Please refer to Section J10.4 in the AISC Specification for the web des', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(34, 174, '[]', 'ASTM A94, also historically known as silicon steel. During retrofits, one can find mention of silicon steel in old structural design drawings. One of the first high-strength steels, silicon steel had a yield strength of 45 ksi and a tensile strength of 80', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(35, 178, '[]', 'Ductility is related to the number of threads in the grip. Most of the bolt elongation occurs in the threaded portion below the nut. This relationship is described in the 2nd Edition of the Guide to Design Criteria for Bolted and Riveted Joints (a free do', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(36, 181, '[]', 'Maximum acceptable velocity is 5 miles per hour. If expected wind velocity is higher, a temporary shelter can be used for protection. (See AWS D1.1 Clause 5.12.1)', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 180, '[]', 'The glossary of the RCSC Specification (a free download at www.boltcouncil.org) defines firm contact as the condition that exists on a faying surface when the plies are solidly seated against each other, but not necessarily in continuous contact.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 183, '[]', '38-in. See Table B4.1b in the AISC Specification for limiting width-thickness ratio for compact flange cover plates.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 184, '[]', 'It would be 1.5 75 in. See Table 10-13 in the 14th Edition Steel Construction Manual. Note that bent plates exhibit better ductility and require a smaller bending radius when bent perpendicular to their rolling direction.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 185, '[]', 'Grip is defined in the glossary of the RCSC Specification as the total thickness of the plies of a joint through which the bolt passes, exclusive of washers or direct-tension indicators.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 186, '[]', 'In accordance with the AISC Specification Section M2.2, the minimum preheat temperature is +150 ç™‹ (+66 ç™ˆ). In addition, the Commentary to Section M2.2 states that preheat tends to minimize the hard surface layer and the initiation of cracks.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 190, '[]', 'As noted in the Commentary of Section J1.8 of the AISC Specification, The heat of welding near bolts will not alter the mechanical properties of the bolts.Metallurgy and heat treatment of bolts must be investigated prior welding on bolts.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 191, '[]', 'Page 2-37 of the 14th Edition AISC Steel Construction Manual states: Cambering and curving induce residual stresses similar to those that develop in rolled structural shapes as elements of the shape cool from the rolling temperature at different rates. Th', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(44, 194, '[]', 'Per Section 5.22.4.3 of AWS D1.1, Root openings greater than those allowed in 5.22.4.1, but not greater than twice the thickness of the thinner part or mm], whichever is less, may be corrected by welding to acceptable dimensions prior to joining the parts', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(45, 195, '[]', 'This practice is not recommended as it defeats all the purposes for which the weld access hole was used in the first place (except access for welding). Commentary Section 5.16.1 of AWS D1.1 states: When weld access holes are required to be closed for cosm', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(46, 196, '[]', 'Every fillet weld segment has a start and stop, and each start and stop has a crater in the weld. Craters serve as crack initiators in fatigue applications. Thus, the fewer starts and stops, the fewer crack initiators.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(47, 197, '[]', 'The AISC Code of Standard Practice for Steel Buildings and Bridges (ANSI/AISC 303-16) states, in Section 6.2.1: The thermal cutting of structural steel by hand-guided or mechanically guided means is permitted.The Code is available as a free download at ww', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(48, 198, '[]', 'The Code (see answer 1) states, in Section 7.14: The correction of minor misfits by moderate amounts of reaming, grinding, welding or cutting, and the drawing of elements into line with drift pins, shall be considered to be normal erection operations.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(49, 203, '[]', 'For bridges in cold-weather applications, notch toughness is the primary means of ensuring that the steel will perform properly. This may be necessary in cases where the steel is exposed, and the specifier should consult ASTM A709 Section 10 (including Ta', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(50, 201, '[]', 'Compressible materials can prevent proper snugtightening and pretensioning, when required, from being achieved during installation of high-strength bolts. A compressible element also creates a service condition different than that assumed in the AISC and ', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(51, 202, '[]', 'When thick plates and heavy shapes are used in applications loaded in tension, the core area has to be notch tough to ensure brittle fracture will not occur. CVN testing requirements are given in the AISC Specification (available at www.aisc.org/specifica', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(52, 205, '[]', 'Weld access holes serve multiple functions. One function is to permit the access needed to continue welds past the web. Another function is to provide a transition that accommodates shrinkage strains from weld cooling. The weld access hole extends to a lo', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(53, 167, '["70"]', 'unless it can be shown by analysis that the restraint is not required. This provision can be found in Section B3.4 of the 2016 AISC Specification (Section B3.6 in the 2010 AISC Specification).', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(54, 168, '["73"]', 'and c.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(55, 170, '["77"]', 'A mil is equivalent to 1/1000 in.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(56, 171, '["78"]', 'When fillet-welded edge details are used, the actual thickness of the doubler plate is adjusted to allow for proper beveling of the plate to clear the column flange-to-web fillet. Refer to Section 4.4 of AISC Design Guide 13: Stiffening of Wide-Flange Col', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(57, 173, '["80"]', 'a.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(58, 175, '["85"]', 'Many shop-applied coatings (and field-applied coatings, for that matter) are incompatible with common fire-protection materials, causing them to adhere poorly to the steel. In most cases, unprimed steel is the best surface to receive applied fireprotectio', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(59, 177, '["92"]', 'A mil is 11000 of an inch.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(60, 176, '["87"]', 'b.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(61, 179, '["94"]', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(62, 182, '["96"]', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(63, 187, '["101"]', 'Torque cannot be used to measure the pretension in a bolt unless it is calibrated (as for the calibrated wrench method). Depending on the conditions of the threads and surfaces in contact between the nut and washer/steel, for a given torque, pretension ca', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(64, 188, '["104"]', 'b.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(65, 193, '["110"]', 'San Antonio, Texas, March 22 el quiz Everyone is welcome to submit questions and answers for', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(66, 199, '["117"]', 'None of the above. ASTM A786 is the standard specification for rolled steel floor plates. The plate will often be supplied without specific mechanical properties (see the AISC Steel Construction Manual, 14th Edition, page 2-25, for discussion).', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(67, 200, '["118"]', 'Cables for permanent bracing (i.e., tension-only bracing) or suspension systems are considered other steel, iron or metal items per Section 2.2 of the Code.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(68, 204, '["121"]', 'per RCSC Specification Commentary Section 3.3.4.', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `answer_options`
--

CREATE TABLE IF NOT EXISTS `answer_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_node` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=122 ;

--
-- Дамп данных таблицы `answer_options`
--

INSERT INTO `answer_options` (`id`, `id_node`, `id_option`, `body`, `type`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(9, 30, 0, 'additional information', '', 0, '0000-00-00 00:00:00', 0, '2017-06-28 12:59:32'),
(10, 30, 0, 'aess', '', 0, '0000-00-00 00:00:00', 0, '2017-06-28 12:59:36'),
(11, 30, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, 32, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, 32, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, 32, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(15, 33, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(16, 33, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(17, 33, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(18, 34, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(19, 34, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(20, 34, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(21, 35, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(22, 35, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(23, 35, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(24, 36, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(25, 36, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(26, 36, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(27, 37, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(28, 37, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(29, 37, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(30, 38, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(31, 38, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(32, 38, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(33, 39, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(34, 39, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(35, 39, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(36, 40, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 40, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 40, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 41, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 41, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 41, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 42, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 42, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(44, 42, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(45, 43, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(46, 43, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(47, 43, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(48, 45, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(49, 45, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(50, 45, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(51, 46, 0, 'option1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(52, 46, 0, 'option2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(53, 46, 0, 'option3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(70, 167, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(71, 167, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(72, 168, 0, 'not affected by location of applied concentrated forces', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(73, 168, 0, 'caused by compressive and tensile forces', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(74, 168, 0, 'caused by compressive forces only', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(75, 168, 0, 'affected by location of applied concentrated force', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(76, 170, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(77, 170, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(78, 171, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(79, 171, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(80, 173, 0, 'Charpy V-notch impact test', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(81, 173, 0, 'Drop-weight test', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(82, 173, 0, 'Magnetic particle test', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(83, 173, 0, 'Pendulum fracture test', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(84, 175, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(85, 175, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(86, 176, 0, 'Slender section', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(87, 176, 0, 'Non-compact section', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(88, 176, 0, 'Compact section', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(89, 176, 0, 'Super-compact section', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(90, 177, 0, 'cm', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(91, 177, 0, 'feet', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(92, 177, 0, 'mils', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(93, 177, 0, 'coats', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(94, 179, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(95, 179, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(96, 182, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(97, 182, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(98, 187, 0, '5 ft-lb', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(99, 187, 0, '50 ft-lb', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(100, 187, 0, '500 ft-lb', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(101, 187, 0, 'Torque varies and is not a suitable measure of pretension', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(102, 188, 0, 'shall be done for all welds only if it is specified in the contract documents', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(103, 188, 0, 'shall be done only for 50% of welds if it is not specified in the contract documents', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(104, 188, 0, 'shall be done for all welds', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(105, 188, 0, 'is not required if ultrasonic inspection is specified', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(106, 192, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(107, 192, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(108, 193, 0, 'Allright, Illinois', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(109, 193, 0, 'Okay, Oklahoma', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(110, 193, 0, 'San Antonio, Texas', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(111, 193, 0, 'Whynot, North Carolina', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(112, 193, 0, 'Why, Arizona', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(113, 199, 0, 'ASTM A36', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(114, 199, 0, 'ASTM A572', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(115, 199, 0, 'ASTM A992', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(116, 199, 0, 'All of the above', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(117, 199, 0, 'None of the above', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(118, 200, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(119, 200, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(120, 204, 0, 'True', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(121, 204, 0, 'False', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_node` int(11) NOT NULL,
  `body` varchar(255) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `keywords`
--

INSERT INTO `keywords` (`id`, `id_node`, `body`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(1, 9, 'key1', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 9, 'key2', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 9, 'key3', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 9, 'key4', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 9, 'key5', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 21, 'keyword1', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

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
  `id_node` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `accessLevel` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=244 ;

--
-- Дамп данных таблицы `menutree`
--

INSERT INTO `menutree` (`id`, `id_parent`, `id_user`, `tab`, `type`, `id_node`, `name`, `accessLevel`, `status`, `notes`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(2, 0, 140, 'public', 'folder', 0, 'folder', '', '', '', 0, '0000-00-00 00:00:00', 0, '2017-06-30 09:02:50'),
(25, 2, 140, 'public', 'folder', 0, '1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(26, 2, 140, 'public', 'folder', 0, '2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(27, 2, 140, 'public', 'folder', 0, '3', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(28, 2, 140, 'public', 'folder', 0, '4', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(30, 25, 140, 'public', 'file', 0, '1-1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(32, 25, 140, 'public', 'file', 0, '1-2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(33, 25, 140, 'public', 'file', 0, '1-3', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(34, 25, 140, 'public', 'file', 0, '1-4', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(35, 25, 140, 'public', 'file', 0, '1-5', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(36, 26, 140, 'public', 'file', 0, '2-1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 26, 140, 'public', 'file', 0, '2-2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 26, 140, 'public', 'file', 0, '2-3', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 26, 140, 'public', 'file', 0, '2-4', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 26, 140, 'public', 'file', 0, '2-5', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 27, 140, 'public', 'file', 0, '3-1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 27, 140, 'public', 'file', 0, '3-2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 27, 140, 'public', 'file', 0, '3-3', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(44, 28, 140, 'public', 'file', 0, '4-1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(45, 27, 140, 'public', 'file', 0, '3-4', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(46, 27, 140, 'public', 'file', 0, '3-5', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(47, 28, 140, 'public', 'file', 0, '4-2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(48, 28, 140, 'public', 'file', 0, '4-3', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(49, 28, 140, 'public', 'file', 0, '4-4', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(50, 28, 140, 'public', 'file', 0, '4-5', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(162, 240, 0, 'public', 'folder', 0, '2017', '', '', '', 0, '0000-00-00 00:00:00', 0, '2017-07-09 18:49:34'),
(163, 162, 0, 'public', 'folder', 0, 'MARCH', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(164, 162, 0, 'public', 'folder', 0, 'JANUARY', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(165, 162, 0, 'public', 'folder', 0, 'FEBRUARY', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(166, 162, 0, 'public', 'folder', 0, 'APRIL', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(167, 163, 0, 'public', 'file', 0, '02', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(168, 163, 0, 'public', 'file', 0, '03', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(169, 163, 0, 'public', 'file', 0, '01', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(170, 163, 0, 'public', 'file', 0, '05', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(171, 163, 0, 'public', 'file', 0, '04', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(172, 163, 0, 'public', 'file', 0, '06', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(173, 163, 0, 'public', 'file', 0, '08', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(174, 163, 0, 'public', 'file', 0, '07', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(175, 164, 0, 'public', 'file', 0, '10', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(176, 163, 0, 'public', 'file', 0, '09', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(177, 164, 0, 'public', 'file', 0, '01', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(178, 164, 0, 'public', 'file', 0, '02', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(179, 164, 0, 'public', 'file', 0, '06', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(180, 164, 0, 'public', 'file', 0, '07', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(181, 164, 0, 'public', 'file', 0, '03', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(182, 164, 0, 'public', 'file', 0, '05', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(183, 164, 0, 'public', 'file', 0, '04', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(184, 164, 0, 'public', 'file', 0, '08', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(185, 164, 0, 'public', 'file', 0, '09', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(186, 165, 0, 'public', 'file', 0, '03', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(187, 165, 0, 'public', 'file', 0, '04', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(188, 165, 0, 'public', 'file', 0, '02', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(189, 165, 0, 'public', 'file', 0, '01', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(190, 165, 0, 'public', 'file', 0, '05', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(191, 165, 0, 'public', 'file', 0, '06', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(192, 165, 0, 'public', 'file', 0, '07', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(193, 165, 0, 'public', 'file', 0, '09', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(194, 165, 0, 'public', 'file', 0, '08', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(195, 166, 0, 'public', 'file', 0, '10', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(196, 166, 0, 'public', 'file', 0, '11', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(197, 166, 0, 'public', 'file', 0, '01', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(198, 166, 0, 'public', 'file', 0, '02', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(199, 166, 0, 'public', 'file', 0, '03', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(200, 166, 0, 'public', 'file', 0, '05', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(201, 166, 0, 'public', 'file', 0, '04', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(202, 166, 0, 'public', 'file', 0, '06', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(203, 166, 0, 'public', 'file', 0, '07', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(204, 166, 0, 'public', 'file', 0, '09', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(205, 166, 0, 'public', 'file', 0, '08', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(208, 0, 140, 'favorite', 'folder', 0, '1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(215, 0, 140, 'favorite', 'folder', 0, '2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(227, 215, 140, 'favorite', 'folder', 0, '1', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(233, 227, 140, 'favorite', 'folder', 0, '2', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(239, 0, 131, 'public', 'folder', 0, 'Steel', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(240, 239, 131, 'public', 'folder', 0, 'MSC', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(241, 240, 131, 'public', 'folder', 0, '2016', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(243, 0, 131, 'favorite', 'link', 167, '02', '', '', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_node` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `type` varchar(10) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `id_node`, `body`, `type`, `createdBy`, `createdOn`, `modifiedBy`, `modifiedOn`) VALUES
(7, 30, 'Architecturally Exposed Structural Steel according to Section 10 of the AISC Code of Standard Practice, what additional information must be shown in the contract documents when specifying architecturally Exposed Structural Steel (AESS) ?', '', 0, '0000-00-00 00:00:00', 0, '2017-06-28 12:45:29'),
(8, 32, 'Question 1-2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(9, 33, 'Question 1-3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, 34, 'Question 1-4', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, 35, 'Question 1-5', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, 36, 'Question 2-1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, 37, 'Question 2-2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, 38, 'Question 2-3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(15, 39, 'Question 2-4', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(16, 40, 'Question 2-5', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(17, 41, 'Question 3-1', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(18, 42, 'Question 3-2', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(19, 43, 'Question 3-3', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(20, 45, 'Question 3-4', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(21, 46, 'Question 3-5', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 167, 'True or False: Restraint against longitudinal rotation is required at beam or girder supports.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 168, 'Which of the following statements are incorrect? Web crippling is:', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 169, 'What is the difference between structural steel and other steel, iron or metal items?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 170, 'True or False: A milis a common measure for paint and coating thickness.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 171, 'True or False: Doubler plates can be fillet welded to column flanges.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 173, 'There is a standard dynamic test in which a notched specimen is struck and broken by a single blow in a specially designed testing machine. The measured test values may be the energy absorbed, the percentage shear fracture, the lateral expansion opposite the notch or a combination thereof. Which test is this?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 172, 'What is web sidesway buckling?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(44, 174, 'What was one of the first high-strength steels used in 1915 in the Metropolis Bridge (Illinois) and later in portions of the Golden Gate Bridge?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(45, 175, 'True or False: Spray-applied fire protection material should always be applied over primed steel.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(46, 176, 'A section that can develop the yield stress in compression elements before local buckling occurs but will not resist inelastic local buckling at strain levels required for a fully plastic stress distribution is called a:', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(47, 177, 'Paint thickness is commonly measured in which unit?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(48, 178, 'Why would a bolt stick through requirement decrease the ductility (ability to stretch) of F3125 Grade A325 and A490 bolts?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(49, 179, 'True or False: The shear and tensile strengths of a bolt are not affected by pretension in the bolt.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(50, 181, 'What is the maximum acceptable wind velocity in the vicinity of the weld when the FCAW-G process is used?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(51, 180, 'What is meant by firm contactin a bolted connection?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(52, 182, 'True or False: Written WPSs are required for all prequalified shop and field welds.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(53, 183, 'What is the minimum thickness of a compact 10 in. wide A572 Gr. 50 flange cover plate welded to the top of a W24 ?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(54, 184, 'What is the generally accepted minimum insidebending radius for cold bent 6) plate when bending is transverse to the direction of rolling.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(55, 186, 'What is the minimum required preheat temperature for thermally cutting beam copes and weld access holes in ASTM A6/A6M hot-rolled shapes with a flange thickness exceeding 2 in.?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(56, 185, 'How is gripdefined?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(57, 187, 'What is the correct torque to pretension a 3 iameter ASTM F3125 Grade A325 bolt?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(58, 188, 'Which of the following statements is correct? Visual weld inspection performed by the fabricator/erector:', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(59, 189, 'Who is responsible for grouting base plates?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(60, 191, 'How does cambering affect the design strength of beams?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(61, 190, 'How does the heat of welding near F3125 Grade A325 and A490 bolts affect the mechanical properties of these bolts?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(62, 192, 'True or False: Truss camber should be inspected immediately after it is received in the field.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(63, 193, 'Bonus question (not from 2002): Where is the 2017 North American Steel Construction Conference going to be held?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(64, 194, 'Is it acceptable to use welding to correct an excessively large root opening for a complete joint penetration (CJP) groove weld?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(65, 195, 'Is it acceptable to fill weld access holes with weld metal for cosmetic or corrosion-protection reasons?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(66, 196, 'Why is a continuous fillet weld preferable to an intermittent fillet weld when considering fatigue in design?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(67, 197, 'Is hand-guided thermal cutting an allowable method for shop fabrication of structural steel?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(68, 198, 'Is thermal cutting allowed as a field modification method for correcting minor fabrication errors?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(69, 199, 'What material type is commonly specified for floor plate?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(70, 200, 'True or False: Cables used for permanent bracing or suspension of systems are not considered structural steel.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(71, 201, 'Why are compressible materials prohibited in connected plies of bolted parts?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(72, 203, 'What notch-toughness requirements are appropriate for exterior exposed steel in structural steel bridges?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(73, 202, 'What is the purpose of performing CVN (Charpy V-notch) tests on members and plates?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(74, 204, 'True or False: When finger shims are used in bolted joints, the requirements for long-slotted holes are applicable.', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(75, 205, 'The AISC Specification for Structural Steel Buildings (ANSI/ AISC 360) Section J1.6 specifies dimensions for weld access holes. Why are these specific dimensions required?', '', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `id_node` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modifiedBy` int(11) NOT NULL,
  `modifiedOn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

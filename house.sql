-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-07-24 09:58:03
-- 服务器版本： 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `house`
--

-- --------------------------------------------------------

--
-- 表的结构 `house_building`
--

CREATE TABLE IF NOT EXISTS `house_building` (
  `project_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `building_structure` varchar(32) NOT NULL,
  `building_height` int(4) NOT NULL,
  PRIMARY KEY (`project_id`,`building_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `house_building`
--

INSERT INTO `house_building` (`project_id`, `building_id`, `building_structure`, `building_height`) VALUES
(1, 1, '钢砼', 13),
(1, 2, '钢砼', 14),
(1, 4, '钢砼', 13),
(2, 6, '钢砼', 25),
(3, 23, '钢砼', 27),
(3, 25, '钢砼', 27),
(4, 3, '钢砼', 31),
(5, 14, '钢砼', 18),
(5, 16, '钢砼', 18),
(5, 21, '钢砼', 18);

-- --------------------------------------------------------

--
-- 表的结构 `house_project`
--

CREATE TABLE IF NOT EXISTS `house_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(128) NOT NULL,
  `project_type` tinyint(4) NOT NULL,
  `project_address` varchar(256) NOT NULL,
  `project_city` varchar(16) NOT NULL,
  `project_district` varchar(32) NOT NULL,
  `project_block` varchar(32) NOT NULL,
  `project_function` varchar(32) NOT NULL,
  `project_number` varchar(16) NOT NULL,
  `project_area` int(11) NOT NULL,
  `project_total_suite` int(11) NOT NULL,
  `project_reserve` text,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `house_project`
--

INSERT INTO `house_project` (`project_id`, `project_name`, `project_type`, `project_address`, `project_city`, `project_district`, `project_block`, `project_function`, `project_number`, `project_area`, `project_total_suite`, `project_reserve`) VALUES
(1, '郡枫绿园', 0, '江干区丁桥', '杭州', '江干区', '丁桥', '保障', '30000222', 2222211, 1000, NULL),
(2, '万家名城', 1, '余杭区良渚街道锦江路西', '杭州', '余杭区', '良渚', '商业', '22000222', 3333222, 600, NULL),
(3, '香醍溪岸花苑', 1, '余杭区S304省道与宏达路交汇处', '杭州', '余杭区', '临平', '住宅', '30220222', 1223554, 500, NULL),
(4, '旭辉府', 1, '余杭区崇贤街道崇杭街北侧', '杭州', '余杭区', '崇贤', '住宅', '00334411', 1223332, 930, NULL),
(5, '竹海水韵花园春风里', 1, '余杭区闲林镇', '杭州', '余杭区', '闲林', '住宅', '02144452', 6445443, 588, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `house_record`
--

CREATE TABLE IF NOT EXISTS `house_record` (
  `record_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `building_id` int(11) NOT NULL,
  `record_floor` int(4) NOT NULL,
  `record_price` double NOT NULL,
  `record_area` double NOT NULL,
  `record_time` date NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `project_id` (`project_id`,`building_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- 转存表中的数据 `house_record`
--

INSERT INTO `house_record` (`record_id`, `project_id`, `building_id`, `record_floor`, `record_price`, `record_area`, `record_time`) VALUES
(1, 1, 4, 1, 188146, 63.06, '2014-05-08'),
(2, 1, 4, 1, 188146, 63.06, '2014-05-13'),
(3, 1, 4, 1, 188146, 63.06, '2014-05-13'),
(4, 1, 4, 1, 185784, 62.65, '2014-05-13'),
(5, 1, 4, 1, 185784, 62.65, '2014-05-16'),
(6, 1, 4, 1, 188146, 63.06, '2014-05-13'),
(7, 1, 4, 1, 188146, 63.06, '2014-05-14'),
(8, 1, 2, 1, 185899, 62.67, '2014-05-07'),
(9, 1, 2, 1, 187627, 62.97, '2014-05-07'),
(10, 2, 6, 3, 1009644, 89.85, '2014-05-13'),
(11, 2, 6, 14, 1117464, 89.85, '2014-05-13'),
(12, 2, 6, 3, 1009981, 89.88, '2014-05-13'),
(13, 2, 6, 15, 1478448, 118.77, '2014-05-13'),
(14, 2, 6, 5, 1404217, 118.77, '2014-05-13'),
(15, 2, 6, 7, 1067507, 89.85, '2014-05-13'),
(16, 2, 6, 9, 1461702, 118.77, '2014-05-12'),
(17, 2, 6, 8, 1081524, 89.85, '2014-05-12'),
(18, 2, 6, 18, 1146599, 89.88, '2014-05-12'),
(19, 2, 6, 9, 1713161, 127.42, '2014-05-12'),
(20, 2, 6, 10, 1099861, 89.88, '2014-05-12'),
(21, 3, 23, 26, 749112, 138.68, '2014-05-16'),
(22, 3, 23, 26, 533303, 88.28, '2014-05-15'),
(23, 3, 23, 4, 723532, 138.18, '2014-05-15'),
(24, 3, 25, 26, 709164, 138.68, '2014-05-29'),
(25, 3, 25, 8, 710000, 138.68, '2014-05-29'),
(26, 3, 25, 21, 500000, 88.28, '2014-05-29'),
(27, 3, 25, 11, 543786, 88.28, '2014-05-28'),
(28, 4, 3, 6, 809365, 89.04, '2014-05-20'),
(29, 4, 3, 11, 1093760, 110.7, '2014-05-19'),
(30, 4, 3, 13, 819486, 87.89, '2014-05-19'),
(31, 4, 3, 11, 810923, 87.89, '2014-05-19'),
(32, 4, 3, 3, 790000, 89.04, '2014-05-16'),
(33, 4, 3, 6, 809365, 89.04, '2014-05-13'),
(34, 4, 3, 8, 790171, 87.89, '2014-05-12'),
(35, 4, 3, 3, 790000, 89.04, '2014-05-11'),
(36, 5, 16, 12, 1030000, 119.53, '2014-05-29'),
(37, 5, 17, 12, 1030000, 120.16, '2014-05-26'),
(38, 5, 16, 17, 1010000, 122.64, '2014-05-26'),
(39, 5, 17, 11, 1113581, 120.74, '2014-05-20'),
(40, 5, 21, 4, 834000, 87.14, '2014-05-29'),
(41, 5, 21, 7, 1098785, 123.34, '2014-05-22'),
(42, 5, 21, 2, 780892, 86.66, '2014-05-22'),
(43, 5, 21, 9, 1020000, 108.06, '2014-05-20'),
(44, 5, 21, 8, 880000, 87.14, '2014-05-17'),
(45, 5, 21, 4, 816620, 87.14, '2014-05-11'),
(46, 5, 21, 4, 965341, 108.06, '2014-05-11'),
(47, 5, 21, 11, 1022710, 108.06, '2014-05-11'),
(48, 5, 21, 9, 1150000, 123.34, '2014-05-07'),
(49, 5, 21, 8, 885000, 87.14, '2014-05-07'),
(50, 5, 21, 11, 900000, 87.58, '2014-05-07'),
(51, 5, 21, 2, 915309, 107.71, '2014-05-03'),
(52, 5, 21, 9, 976631, 108.06, '2014-05-01');

--
-- 限制导出的表
--

--
-- 限制表 `house_building`
--
ALTER TABLE `house_building`
  ADD CONSTRAINT `house_building_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `house_project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `house_record`
--
ALTER TABLE `house_record`
  ADD CONSTRAINT `house_record_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `house_project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

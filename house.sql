-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-07-25 09:44:54
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
  `project_id` int(10) NOT NULL,
  `building_id` varchar(12) NOT NULL,
  `building_structure` varchar(32) NOT NULL,
  `building_height` int(4) NOT NULL,
  `project_number` varchar(16) NOT NULL,
  `project_area` int(11) NOT NULL,
  `project_total_suit` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`building_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `house_project`
--

CREATE TABLE IF NOT EXISTS `house_project` (
  `project_id` int(10) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(128) NOT NULL,
  `project_type` tinyint(4) NOT NULL,
  `project_address` varchar(256) NOT NULL,
  `project_city` varchar(16) NOT NULL,
  `project_district` varchar(32) NOT NULL,
  `project_block` varchar(32) NOT NULL,
  `project_function` varchar(32) NOT NULL,
  `project_reserve` text,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `house_record`
--

CREATE TABLE IF NOT EXISTS `house_record` (
  `record_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `building_id` varchar(12) NOT NULL,
  `record_floor` int(4) NOT NULL,
  `record_price` double NOT NULL,
  `record_area` double NOT NULL,
  `record_time` date NOT NULL,
  PRIMARY KEY (`record_id`),
  KEY `project_id` (`project_id`,`building_id`),
  KEY `building_id` (`building_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

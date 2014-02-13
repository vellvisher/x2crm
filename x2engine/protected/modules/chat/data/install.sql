-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2014 at 04:53 PM
-- Server version: 5.6.15
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `x2engine`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatroom_invite`
--

CREATE TABLE IF NOT EXISTS `chatroom_invite` (
  `chatroom_id` varchar(30) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `poster_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`chatroom_id`,`user_id`),
  UNIQUE KEY `poster_id` (`poster_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Change x2_users to InnoDB
--
ALTER TABLE `x2_users` ENGINE = InnoDB;

--
-- Constraints for table `chatroom_invite`
--
ALTER TABLE `chatroom_invite`
  ADD CONSTRAINT `chatroom_invite_ibfk_2` FOREIGN KEY (`poster_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chatroom_invite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `x2_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

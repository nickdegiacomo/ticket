-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2013 at 07:33 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `_bd_andreidesign`
--

-- --------------------------------------------------------

--
-- Table structure for table `reset_keys`
--

CREATE TABLE IF NOT EXISTS `reset_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reset_key` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`reset_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(20) NOT NULL,
  `username` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `timestamp` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_id` (`unique_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `unique_id`, `username`, `ip`, `timestamp`) VALUES
(48, 'lLd4x9b0rBJB2aO2wzzN', 'jdoe', '127.0.0.1', '1323602170');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(48) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` varchar(13) NOT NULL DEFAULT 'regular',
  `last_ip` varchar(15) NOT NULL,
  `last_access` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `role`, `last_ip`, `last_access`) VALUES
(1, 'John', 'Doe', 'jdoe', 'contact@andreidesign.com', '$1$Tu..gj3.$WxM2kWO5J8pR6XPay8ZIc/', 'administrator', '::1', '2013-03-30 21:02:51');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

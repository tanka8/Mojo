-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2013 at 09:15 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mojo`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_details`
--

CREATE TABLE IF NOT EXISTS `client_details` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `client_id_UNIQUE` (`client_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `client_product`
--

CREATE TABLE IF NOT EXISTS `client_product` (
  `client_product_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_group` varchar(255) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  PRIMARY KEY (`client_product_id`),
  UNIQUE KEY `product_id_UNIQUE` (`client_product_id`),
  KEY `client_id_idx` (`client_id`),
  KEY `product_id_idx` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE IF NOT EXISTS `product_details` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_group` varchar(255) NOT NULL,
  `product_vendor` varchar(255) NOT NULL,
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client_product`
--
ALTER TABLE `client_product`
  ADD CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `client_details` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product_details` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

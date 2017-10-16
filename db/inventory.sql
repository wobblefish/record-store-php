-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2011 at 05:07 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE IF NOT EXISTS `admin_info` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(36) NOT NULL,
  `password` varchar(36) NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_id`, `username`, `password`, `active`) VALUES
(1, 'testUser', 'datadata', 1);

-- --------------------------------------------------------

--
-- Table structure for table `current_session`
--

CREATE TABLE IF NOT EXISTS `current_session` (
  `session_key` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(25) NOT NULL,
  `session_num` varchar(50) NOT NULL,
  `current_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `current_session`
--

INSERT INTO `current_session` (`session_key`, `user_id`, `session_num`, `current_time`) VALUES
(1, '1', 'npsskpvhmk3hb55omf6g12hqp5', '2011-02-16 21:59:29'),
(2, '1', 'vtdjhn10kmg3avqljj5jt2v9o5', '2011-02-16 22:13:47'),
(3, '1', 'kdgced7jn17jubvrmuknjd71s6', '2011-02-16 22:14:39'),
(4, '1', 'ojd93a0oeihc6amthckqhmna35', '2011-02-16 22:15:09'),
(5, '1', 'qb9toqaas39hnlaehse78os7g4', '2011-03-02 00:08:05'),
(6, '1', '5rvukdcakae9mnjro9fpv1dku7', '2011-03-02 01:41:15'),
(7, '1', 'qb9toqaas39hnlaehse78os7g4', '2011-03-02 02:08:53'),
(8, '1', '5rvukdcakae9mnjro9fpv1dku7', '2011-03-02 23:53:09'),
(9, '1', 'a6mji2akvs7p1111vc1tto7ui0', '2011-03-02 23:54:08'),
(10, '1', 'td4dlkpkcg4te9up7e76164n80', '2011-03-07 22:12:34'),
(11, '1', 'td4dlkpkcg4te9up7e76164n80', '2011-03-07 22:26:19'),
(12, '1', 'td4dlkpkcg4te9up7e76164n80', '2011-03-08 01:30:47'),
(13, '1', '03qjvbngb5hrcf8bou3otbv5f7', '2011-03-08 23:24:10'),
(14, '1', 'ofjvs5chhntosjl6pq5sn7jil4', '2011-03-10 01:29:12'),
(15, '1', 'dufj8i6tccgjflf9n93vjp4j81', '2011-03-22 01:07:41'),
(16, '1', '3n2jueu0uv2762rpktqhj3tea0', '2011-03-22 01:24:49'),
(17, '1', 'n1t4i4t445k32e6ihej3odu8m3', '2011-03-22 01:27:22'),
(18, '1', 'nr0ltceh1salviopnbcvvkl5l7', '2011-03-22 01:28:39'),
(19, '1', '7qbuhdkn0p17jsglctllivt2s2', '2011-03-22 01:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(72) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`category_id`, `category`) VALUES
(1, 'Dubstep'),
(2, 'Glitch-Hop'),
(3, 'Trance'),
(5, 'Drum N Bass');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `Category` int(11) NOT NULL,
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(72) NOT NULL,
  `description` varchar(128) NOT NULL,
  `price` varchar(24) NOT NULL,
  `quantity` varchar(16) NOT NULL,
  `sku` varchar(32) NOT NULL,
  `image` varchar(128) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `category` (`Category`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Category`, `item_id`, `title`, `description`, `price`, `quantity`, `sku`, `image`) VALUES
(5, 23, 'Dieselboy - The Dungeonmaster''s Guide', 'Dieselboy Classic Mixtape. Get it!', '7.99', '994', 'DNB4ME', '/images/products/Dieselboy.jpg'),
(3, 22, 'Ferry Corsten - We Belong', 'Trancypants Anthems', '12.99', '995', 'TRANCE1234', '/images/products/Ferry Corsten - We Belong_front.jpg'),
(2, 21, 'The Glitch Mob - Drink The Sea', 'Glitchy N Scratchy', '7.99', '996', 'GL1TCH', '/images/products/glitch_mob.jpg'),
(2, 7, 'Opiuo - Slurp & Giggle', '<p>\r\n	Groovy Glitch Hop.</p>\r\n', '5.49', '495', 'GL1TCH', '/images/products/opiuo-slurp&giggle.jpg'),
(1, 8, 'Excision & Datsik - Swagga', 'The two dubstep badasses team up.', '5.99', '996', 'DUBBER', '/images/products/excision-swagga.jpg'),
(5, 13, 'Original Sin - Grow Your Wings', 'Drum & Bass has never been so heavy and in your face.', '8.99', '9999', 'GYWDNB', '/images/products/Original-Sin-Grow-Your-Wings.jpg'),
(3, 14, 'Infected Mushroom - Classical Mushroom', '<p>\r\n	Psytrance/Goa classics</p>\r\n', '6.99', '993', 'PSYGOA', '/images/products/Infected Mushroom.jpg'),
(5, 15, 'Sub Focus - Timewarp/Follow The Dots', 'Crisp DnB', '12.99', '998', 'SUBFCS', '/images/products/sub-focus_timewarp.jpg'),
(5, 16, 'Drum&Bass Arena: Summer Selection', 'The freshest sounds of Summer 2010!', '5.99', '999', 'DNBARENA', '/images/products/dnba - summer selection.jpg'),
(1, 17, 'Rusko - Babylon EP', 'Rusko is the man.', '7.99', '999', 'DUB4U', '/images/products/Rusko - Babylon Volume One (EP).jpg'),
(5, 24, 'Dieselboy - The Dungeonmaster''s Guide', 'Dieselboy Classic Mixtape. Get it!', '7.99', '999', 'DNB4ME', '/images/products/Dieselboy.jpg'),
(5, 25, 'Clipz - Loud & Dirty/Push It Up', 'Classic D&B Anthems', '4.99', '1000', 'LDNDRTY', '/images/products/clipz.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `items_sold`
--

CREATE TABLE IF NOT EXISTS `items_sold` (
  `item_id` varchar(32) NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `item_price` varchar(32) NOT NULL,
  `quantity` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items_sold`
--

INSERT INTO `items_sold` (`item_id`, `order_id`, `item_price`, `quantity`) VALUES
('7', '8', '5.49', '1'),
('22', '8', '12.99', '1'),
('14', '8', '13.98', '2'),
('23', '8', '7.99', '1'),
('21', '8', '7.99', '1'),
('8', '8', '5.99', '1'),
('7', '10', '5.49', '1'),
('7', '11', '5.49', '1'),
('22', '11', '12.99', '1'),
('14', '11', '13.98', '2'),
('23', '11', '7.99', '1'),
('21', '11', '7.99', '1'),
('8', '11', '5.99', '1'),
('7', '12', '5.49', '1'),
('22', '12', '12.99', '1'),
('14', '12', '13.98', '2'),
('23', '12', '7.99', '1'),
('21', '12', '7.99', '1'),
('8', '12', '5.99', '1'),
('7', '13', '10.98', '2'),
('22', '13', '25.98', '2'),
('14', '13', '20.97', '3'),
('23', '13', '15.98', '2'),
('21', '13', '15.98', '2'),
('8', '13', '11.98', '2'),
('13', '13', '8.99', '1'),
('15', '13', '12.99', '1'),
('17', '13', '7.99', '1'),
('16', '13', '5.99', '1'),
('24', '13', '7.99', '1'),
('23', '14', '15.98', '2'),
('22', '14', '12.99', '1'),
('15', '14', '12.99', '1');

-- --------------------------------------------------------

--
-- Table structure for table `order_info`
--

CREATE TABLE IF NOT EXISTS `order_info` (
  `order_id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_session` varchar(128) NOT NULL,
  `customer_ip` varchar(128) NOT NULL,
  `fname` varchar(128) NOT NULL,
  `lname` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `order_info`
--

INSERT INTO `order_info` (`order_id`, `customer_session`, `customer_ip`, `fname`, `lname`, `phone`, `email`) VALUES
(1, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'Test', 'User', '902-555-4444', 'testUser@example.com'),
(2, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'Test', 'User', '902-555-4444', 'testUser@example.com'),
(3, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'Test', 'User', '902-555-4444', 'testUser@example.com'),
(4, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'Test', 'User', '902-555-4444', 'testUser@example.com'),
(5, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'Test', 'n', 'a', 'n'),
(6, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(7, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(8, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(9, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(10, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(11, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(12, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(13, 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 'a', 'b', 'c', 'd'),
(14, '03qjvbngb5hrcf8bou3otbv5f7', '127.0.0.1', 'Test', 'User', '902-555-4444', 'testUser@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE IF NOT EXISTS `shopping_cart` (
  `item_id` varchar(16) NOT NULL,
  `customer_session` varchar(76) NOT NULL,
  `customer_ip` varchar(32) NOT NULL,
  `quantity` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`item_id`, `customer_session`, `customer_ip`, `quantity`) VALUES
('7', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 2),
('22', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 3),
('14', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 3),
('23', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 2),
('21', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 2),
('8', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 2),
('13', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 1),
('15', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 1),
('17', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 1),
('16', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 1),
('24', 'td4dlkpkcg4te9up7e76164n80', '127.0.0.1', 1),
('23', '03qjvbngb5hrcf8bou3otbv5f7', '127.0.0.1', 2),
('22', '03qjvbngb5hrcf8bou3otbv5f7', '127.0.0.1', 3),
('15', '03qjvbngb5hrcf8bou3otbv5f7', '127.0.0.1', 1),
('22', 'dufj8i6tccgjflf9n93vjp4j81', '127.0.0.1', 3);

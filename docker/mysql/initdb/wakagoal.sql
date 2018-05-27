-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 05:34 PM
-- Server version: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wakatime`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` mediumint(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `language` varchar(30) DEFAULT NULL,
  `total_seconds` mediumint(8) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `user_id`, `language`, `total_seconds`, `day`) VALUES
(1, 1, 'LESS', 2986, '2018-05-20'),
(2, 1, 'PHP', 285, '2018-05-20'),
(3, 1, 'LESS', 11758, '2018-05-21'),
(4, 1, 'PHP', 1864, '2018-05-21'),
(5, 1, 'LESS', 16643, '2018-05-22'),
(6, 1, 'PHP', 3098, '2018-05-22'),
(7, 1, 'JavaScript', 460, '2018-05-22'),
(8, 1, 'Apache Config', 59, '2018-05-22'),
(9, 1, 'LESS', 7416, '2018-05-23'),
(10, 1, 'PHP', 5363, '2018-05-23'),
(11, 1, 'JavaScript', 483, '2018-05-23'),
(12, 1, 'PHP', 9486, '2018-05-24'),
(13, 1, 'LESS', 8815, '2018-05-24'),
(14, 1, 'JavaScript', 1859, '2018-05-24'),
(15, 1, 'YAML', 1519, '2018-05-24'),
(16, 1, 'Bash', 97, '2018-05-24'),
(17, 1, 'JSON', 63, '2018-05-24'),
(18, 1, 'Git Config', 35, '2018-05-24'),
(19, 1, 'LESS', 3924, '2018-05-25'),
(20, 1, 'PHP', 1624, '2018-05-25'),
(21, 1, 'YAML', 631, '2018-05-25'),
(22, 1, 'PHP', 11698, '2018-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` mediumint(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `total_seconds` mediumint(8) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `name`, `total_seconds`, `day`) VALUES
(1, 1, 'Easily-Blog', 13084, '2018-05-21'),
(2, 1, 'Consumer_API', 358, '2018-05-21'),
(3, 1, 'Patient_API', 179, '2018-05-21'),
(4, 1, 'Bhubejhr-API-Old', 4, '2018-05-21'),
(5, 1, 'Easily-Blog', 20262, '2018-05-22'),
(6, 1, 'Easily-Blog', 13261, '2018-05-23'),
(7, 1, 'Easily-Blog', 20691, '2018-05-24'),
(8, 1, 'dinsorsee', 1148, '2018-05-24'),
(9, 1, 'provinces', 34, '2018-05-24'),
(10, 1, 'Easily-Blog', 5547, '2018-05-25'),
(11, 1, 'cpa_dental', 631, '2018-05-25'),
(12, 1, 'wakatime', 11162, '2018-05-26'),
(13, 1, 'Easily-Blog', 536, '2018-05-26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL,
  `name` text,
  `email` text,
  `website` text,
  `registered` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `flag` int(2) NOT NULL DEFAULT '0',
  `checking_time` datetime DEFAULT NULL,
  `waka_id` text,
  `access_token` text,
  `refresh_token` text,
  `expires_in` int(11) NOT NULL DEFAULT '0',
  `photo` text,
  `goal_month` int(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `website`, `registered`, `updated`, `flag`, `checking_time`, `waka_id`, `access_token`, `refresh_token`, `expires_in`, `photo`, `goal_month`) VALUES
(1, 'Puwadon Sricharoen', 'jimmy18dev@gmail.com', 'http://igensite.com', '2018-05-26 16:25:46', '2018-05-26 16:25:46', 27, '2018-05-27 15:47:46', '227bba27-7635-449d-95a3-475bf4b584f5', 'sec_bJYZCIi0dzrMxUSCGtA2FMH993dHuiC8fUpuYC5xL38TdCTzFuZ7XsbTVxlOYzyE4OVS6ZO5FiUQ1qnW', 'ref_lCgBg70hzCCItLhXMNTsaVMJigR4F0DQFxv2tTPM2zPJahsoZhEJCTigF1HZwF1upj6lcWFlZk6xFZEE', 1532510746, 'https://wakatime.com/gravatar/e7a057a8622f0505a583c875d4cdff53', 120);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

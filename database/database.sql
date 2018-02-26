-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2018 at 03:51 PM
-- Server version: 5.5.31
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igensit2_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` mediumint(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `language` varchar(30) DEFAULT NULL,
  `total_seconds` mediumint(8) NOT NULL,
  `day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `user_id`, `language`, `total_seconds`, `day`) VALUES
(1, 1, 'PHP', 9131, '2018-02-22'),
(2, 1, 'LESS', 6960, '2018-02-22'),
(3, 1, 'JavaScript', 6707, '2018-02-22'),
(4, 1, 'Other', 1372, '2018-02-22'),
(5, 1, 'YAML', 398, '2018-02-22'),
(6, 1, 'Nginx configuration file', 97, '2018-02-22'),
(7, 1, 'PHP', 13683, '2018-02-23'),
(8, 1, 'JSON', 1023, '2018-02-23'),
(9, 1, 'JavaScript', 42, '2018-02-23'),
(10, 1, 'PHP', 10249, '2018-02-24'),
(11, 1, 'LESS', 175, '2018-02-24'),
(12, 1, 'JavaScript', 16, '2018-02-24'),
(13, 1, 'JSON', 8, '2018-02-24'),
(14, 2, 'Vue.js', 5636, '2018-02-22'),
(15, 2, 'Java Server Page', 1880, '2018-02-22'),
(16, 2, 'YAML', 1063, '2018-02-22'),
(17, 2, 'JavaScript', 962, '2018-02-22'),
(18, 2, 'JSON', 733, '2018-02-22'),
(19, 2, 'Other', 160, '2018-02-22'),
(20, 2, 'HTML', 15, '2018-02-22'),
(21, 2, 'JavaScript', 7090, '2018-02-23'),
(22, 2, 'Java Server Page', 3066, '2018-02-23'),
(23, 2, 'HTML', 2, '2018-02-23'),
(24, 2, 'YAML', 0, '2018-02-23'),
(25, 2, 'Go', 6244, '2018-02-24'),
(26, 2, 'JavaScript', 1334, '2018-02-24'),
(27, 2, 'Docker', 44, '2018-02-24'),
(28, 1, 'LESS', 6116, '2018-02-19'),
(29, 1, 'PHP', 5508, '2018-02-19'),
(30, 1, 'JavaScript', 5472, '2018-02-19'),
(31, 1, 'Vue.js', 3585, '2018-02-19'),
(32, 1, 'PHP', 8520, '2018-02-20'),
(33, 1, 'LESS', 7393, '2018-02-20'),
(34, 1, 'JavaScript', 2005, '2018-02-20'),
(35, 1, 'Apache Config', 1213, '2018-02-20'),
(36, 1, 'Other', 7, '2018-02-20'),
(37, 1, 'PHP', 9468, '2018-02-21'),
(38, 1, 'LESS', 2052, '2018-02-21'),
(39, 1, 'JavaScript', 394, '2018-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(8) NOT NULL,
  `name` text,
  `email` text,
  `website` text,
  `registered` datetime NOT NULL,
  `waka_id` text,
  `access_token` text,
  `refresh_token` text,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `website`, `registered`, `waka_id`, `access_token`, `refresh_token`, `updated`) VALUES
(1, 'Puwadon Sricharoen', 'jimmy18dev@gmail.com', 'http://igensite.com', '2018-02-24 17:25:43', '227bba27-7635-449d-95a3-475bf4b584f5', 'sec_JhfpnZhct0sf6UzdziH4phaaZg4IFYiMNUswiK1OewzaxyO1g1ZFzcSnPSaPKQv1dhC8c9qVbXgeAEQh', 'ref_Gj42sh8dt6nssFFVyvJVI8lyL28GdR5XOpV2za0PVgVojfgX44RL4LAxuUJGi2hXqa4OcIECCxWW1mVH', '2018-02-25 15:07:52'),
(2, 'Prakhan Jansawang', 'gooit12@gmail.com', NULL, '2018-02-24 17:32:59', 'd50759fb-d775-4c23-af9b-2140f4d66d49', 'sec_5gAoiunxlpf3ujZT2A9j834hV0pISH4e8G2BkwxezHBldVpumLBhm2CcGmetl0zHUxSweHHsJvEpXvIq', 'ref_rtN7X7oN4HCyIUd7vLCpzkrsSdfOpam7Z2SC26o7OtZTbfmB9NXioe4QgFN5DlZYTo6keUWZbfBUgUq0', '2018-02-25 15:08:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
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
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

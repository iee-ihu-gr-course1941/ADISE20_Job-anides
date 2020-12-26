-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2020 at 07:30 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `default_game_board`
--

CREATE TABLE `default_game_board` (
  `row` tinyint(1) NOT NULL,
  `column` tinyint(1) NOT NULL,
  `tile_colour` enum('r','y','w') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `default_game_board`
--

INSERT INTO `default_game_board` (`row`, `column`, `tile_colour`) VALUES
(0, 0, 'w'),
(0, 1, 'w'),
(0, 2, 'w'),
(0, 3, 'w'),
(0, 4, 'w'),
(0, 5, 'w'),
(0, 6, 'w'),
(1, 0, 'w'),
(1, 1, 'w'),
(1, 2, 'w'),
(1, 3, 'w'),
(1, 4, 'w'),
(1, 5, 'w'),
(1, 6, 'w'),
(2, 0, 'w'),
(2, 1, 'w'),
(2, 2, 'w'),
(2, 3, 'w'),
(2, 4, 'w'),
(2, 5, 'w'),
(2, 6, 'w'),
(3, 0, 'w'),
(3, 1, 'w'),
(3, 2, 'w'),
(3, 3, 'w'),
(3, 4, 'w'),
(3, 5, 'w'),
(3, 6, 'w'),
(4, 0, 'w'),
(4, 1, 'w'),
(4, 2, 'w'),
(4, 3, 'w'),
(4, 4, 'w'),
(4, 5, 'w'),
(4, 6, 'w'),
(5, 0, 'w'),
(5, 1, 'w'),
(5, 2, 'w'),
(5, 3, 'w'),
(5, 4, 'w'),
(5, 5, 'w'),
(5, 6, 'w');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `default_game_board`
--
ALTER TABLE `default_game_board`
  ADD PRIMARY KEY (`row`,`column`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

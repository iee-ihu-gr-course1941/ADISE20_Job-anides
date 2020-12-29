-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2020 at 09:17 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_board` ()  BEGIN REPLACE INTO game_board SELECT * FROM default_game_board;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `default_game_board`
--

CREATE TABLE `default_game_board` (
  `row` tinyint(1) NOT NULL,
  `column` tinyint(1) NOT NULL,
  `tile_colour` enum('r','y') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `default_game_board`
--

INSERT INTO `default_game_board` (`row`, `column`, `tile_colour`) VALUES
(0, 0, ''),
(0, 1, ''),
(0, 2, ''),
(0, 3, ''),
(0, 4, ''),
(0, 5, ''),
(0, 6, ''),
(1, 0, ''),
(1, 1, ''),
(1, 2, ''),
(1, 3, ''),
(1, 4, ''),
(1, 5, ''),
(1, 6, ''),
(2, 0, ''),
(2, 1, ''),
(2, 2, ''),
(2, 3, ''),
(2, 4, ''),
(2, 5, ''),
(2, 6, ''),
(3, 0, ''),
(3, 1, ''),
(3, 2, ''),
(3, 3, ''),
(3, 4, ''),
(3, 5, ''),
(3, 6, ''),
(4, 0, ''),
(4, 1, ''),
(4, 2, ''),
(4, 3, ''),
(4, 4, ''),
(4, 5, ''),
(4, 6, ''),
(5, 0, ''),
(5, 1, ''),
(5, 2, ''),
(5, 3, ''),
(5, 4, ''),
(5, 5, ''),
(5, 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `game_board`
--

CREATE TABLE `game_board` (
  `row` tinyint(1) NOT NULL,
  `column` tinyint(1) NOT NULL,
  `tile_colour` enum('r','y') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `game_status`
--

CREATE TABLE `game_status` (
  `status` enum('not active','initialized','started','ended','aborted') COLLATE utf8_bin NOT NULL DEFAULT 'not active',
  `player_turn` enum('r','y') COLLATE utf8_bin DEFAULT NULL,
  `result` enum('r','y') COLLATE utf8_bin DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Triggers `game_status`
--
DELIMITER $$
CREATE TRIGGER `game_status_update` BEFORE UPDATE ON `game_status` FOR EACH ROW BEGIN SET NEW.last_change = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `username` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `player_colour` enum('r','y') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `default_game_board`
--
ALTER TABLE `default_game_board`
  ADD PRIMARY KEY (`row`,`column`);

--
-- Indexes for table `game_board`
--
ALTER TABLE `game_board`
  ADD PRIMARY KEY (`row`,`column`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_colour`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

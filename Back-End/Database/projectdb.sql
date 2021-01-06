-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 06 Ιαν 2021 στις 18:05:55
-- Έκδοση διακομιστή: 10.4.14-MariaDB
-- Έκδοση PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `projectdb`
--

DELIMITER $$
--
-- Διαδικασίες
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_board` ()  BEGIN REPLACE INTO game_board SELECT * FROM default_game_board;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `default_game_board`
--

CREATE TABLE `default_game_board` (
  `row` tinyint(1) NOT NULL,
  `column` tinyint(1) NOT NULL,
  `tile_colour` enum('r','y') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Άδειασμα δεδομένων του πίνακα `default_game_board`
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
-- Δομή πίνακα για τον πίνακα `game_board`
--

CREATE TABLE `game_board` (
  `row` tinyint(1) NOT NULL,
  `column` tinyint(1) NOT NULL,
  `tile_colour` enum('r','y') COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Άδειασμα δεδομένων του πίνακα `game_board`
--

INSERT INTO `game_board` (`row`, `column`, `tile_colour`) VALUES
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
-- Δομή πίνακα για τον πίνακα `game_status`
--

CREATE TABLE `game_status` (
  `status` enum('not active','initialized','started','ended','aborted') COLLATE utf8_bin NOT NULL DEFAULT 'not active',
  `player_turn` enum('r','y') COLLATE utf8_bin DEFAULT NULL,
  `result` enum('r','y','d') COLLATE utf8_bin DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Άδειασμα δεδομένων του πίνακα `game_status`
--

INSERT INTO `game_status` (`status`, `player_turn`, `result`, `last_change`) VALUES
('initialized', 'r', NULL, '2021-01-05 11:11:25');

--
-- Δείκτες `game_status`
--
DELIMITER $$
CREATE TRIGGER `game_status_update` BEFORE UPDATE ON `game_status` FOR EACH ROW BEGIN SET NEW.last_change = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `players`
--

CREATE TABLE `players` (
  `username` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `player_colour` enum('r','y') COLLATE utf8_bin NOT NULL,
  `token` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `last_action` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Άδειασμα δεδομένων του πίνακα `players`
--

INSERT INTO `players` (`username`, `player_colour`, `token`, `last_action`) VALUES
(NULL, 'r', NULL, NULL),
(NULL, 'y', NULL, NULL);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `default_game_board`
--
ALTER TABLE `default_game_board`
  ADD PRIMARY KEY (`row`,`column`);

--
-- Ευρετήρια για πίνακα `game_board`
--
ALTER TABLE `game_board`
  ADD PRIMARY KEY (`row`,`column`);

--
-- Ευρετήρια για πίνακα `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_colour`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

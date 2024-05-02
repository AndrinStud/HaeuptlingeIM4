

-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 02. Mai 2024 um 11:31
-- Server-Version: 10.3.31-MariaDB-0+deb10u1
-- PHP-Version: 7.0.33-57+0~20211119.61+debian10~1.gbp5d8ba5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `108840_5_1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Vehicles`
--

CREATE TABLE `Vehicles` (
  `id` char(36) NOT NULL,
  `name` int(11) NOT NULL,
  `available` int(11) NOT NULL,
  `xCoordinates` float NOT NULL,
  `yCoordinates` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- TRUNCATE Tabelle vor dem Einfügen `Vehicles`
--

TRUNCATE TABLE `Vehicles`;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `Vehicles`
  ADD PRIMARY KEY (`id`);
 

INSERT INTO `Vehicles` (id, name, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18ec','some vehicle' , 1, 47.5109, 8.696504);
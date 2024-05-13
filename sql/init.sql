-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Server-Version: 10.3.31-MariaDB-0+deb10u1
-- PHP-Version: 7.0.33-57+0~20211119.61+debian10~1.gbp5d8ba5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Lösche bestehende Tabellen;
--
DROP TABLE IF EXISTS Vehicles;
DROP TABLE IF EXISTS Providers;


--
-- Erstelle und fülle Tabelle Providers
--
CREATE TABLE Providers (
  id char(36) NOT NULL,
  text_id varchar(32) NOT NULL,
  full_name varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE Providers
  ADD PRIMARY KEY (id);

INSERT INTO Providers (id, text_id, full_name) VALUES ('a6cf8b5f-ced8-4638-8168-c10db85ebe14','bolt_winterthur', 'Bolt Technology OÜ');
INSERT INTO Providers (id, text_id, full_name) VALUES ('3c76342c-f35e-4ec6-bb37-dd0384726ee0','tier_winterthur', 'Tier WINTERTHUR');
INSERT INTO Providers (id, text_id, full_name) VALUES ('40421aad-ffea-4c54-8223-893d6b02fa17','2em_cars', '2EM Car Sharing');
INSERT INTO Providers (id, text_id, full_name) VALUES ('1eb2096e-6d2c-4172-993c-9ea52d1b7a0d','carvelo2go', 'carvelo eCargo-Bike Sharing');
INSERT INTO Providers (id, text_id, full_name) VALUES ('c737d0d8-0ed8-4a72-9ebd-2ce234ebf147','mobility', 'Mobility');
INSERT INTO Providers (id, text_id, full_name) VALUES ('93f241a8-c89f-4c0f-984e-8705bd435189','voiscooters.com', 'Voi Technology AB');
INSERT INTO Providers (id, text_id, full_name) VALUES ('36192988-3a8a-4a9d-982c-9dc4b38c6057','other', 'Other Providers');


--
-- Erstelle und fülle Tabelle Vehicles
--
CREATE TABLE Vehicles (
  id char(36) NOT NULL,
  time datetime NOT NULL,
  provider_id char(36) NOT NULL,
  available int(11) NOT NULL,
  xCoordinates float NOT NULL,
  yCoordinates float NOT NULL,
  PRIMARY KEY (id, time),
  FOREIGN KEY (provider_id) REFERENCES Providers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('103a48c7-4951-4cfe-983a-acb95845895d', '2024-05-13 17:30:00' ,'a6cf8b5f-ced8-4638-8168-c10db85ebe14', 1, 47.498505, 8.743115);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('d2479fa5-618e-4971-8d04-f685326fb419', '2024-05-13 17:30:00' ,'93f241a8-c89f-4c0f-984e-8705bd435189', 1, 47.498826, 8.735857);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('133d7630-b956-4aa4-bbf5-8b6dd6340946', '2024-05-13 17:30:00' ,'3c76342c-f35e-4ec6-bb37-dd0384726ee0', 0, 47.49399, 8.736313);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('5c6521a9-fcd9-45d8-b443-215ad1fbdb66', '2024-05-13 17:30:00' ,'1eb2096e-6d2c-4172-993c-9ea52d1b7a0d', 2, 47.498645, 8.731882);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('103a48c7-4951-4cfe-983a-acb95845895d', '2024-05-13 17:45:00' ,'a6cf8b5f-ced8-4638-8168-c10db85ebe14', 1, 47.497505, 8.742115);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('d2479fa5-618e-4971-8d04-f685326fb419', '2024-05-13 17:45:00' ,'93f241a8-c89f-4c0f-984e-8705bd435189', 1, 47.497826, 8.736857);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('133d7630-b956-4aa4-bbf5-8b6dd6340946', '2024-05-13 17:45:00' ,'3c76342c-f35e-4ec6-bb37-dd0384726ee0', 0, 47.49499, 8.737313);
INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES ('5c6521a9-fcd9-45d8-b443-215ad1fbdb66', '2024-05-13 17:45:00' ,'1eb2096e-6d2c-4172-993c-9ea52d1b7a0d', 2, 47.499645, 8.730882);
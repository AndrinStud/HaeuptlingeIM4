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
  provider_id char(36) NOT NULL,
  available int(11) NOT NULL,
  time datetime NOT NULL DEFAULT current_timestamp(),
  xCoordinates float NOT NULL,
  yCoordinates float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE Vehicles
  ADD PRIMARY KEY (id),
  ADD FOREIGN KEY (provider_id) REFERENCES Providers(id);

INSERT INTO Vehicles (id, provider_id, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18ec','3c76342c-f35e-4ec6-bb37-dd0384726ee0', 1, 47.5109, 8.696504);
INSERT INTO Vehicles (id, provider_id, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18dr','a6cf8b5f-ced8-4638-8168-c10db85ebe14' , 1, 47.5119, 8.696510);	
INSERT INTO Vehicles (id, provider_id, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18er','93f241a8-c89f-4c0f-984e-8705bd435189' , 0, 47.5129, 8.696514);
INSERT INTO Vehicles (id, provider_id, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18fr','3c76342c-f35e-4ec6-bb37-dd0384726ee0' , 2, 47.5139, 8.696518);
INSERT INTO Vehicles (id, provider_id, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18gr','1eb2096e-6d2c-4172-993c-9ea52d1b7a0d' , 1, 47.5149, 8.696522);
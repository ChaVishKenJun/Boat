-- phpMyAdmin SQL Dump
-- version 4.4.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jan 2017 um 10:41
-- Server-Version: 5.6.24
-- PHP-Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `chahanlibrary`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logindata`
--

CREATE TABLE IF NOT EXISTS `logindata` (
  `Id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `logindata`
--

INSERT INTO `logindata` (`Id`, `firstName`, `lastName`, `password`) VALUES
(1, 'Chantal', 'Ochiai', 'fa6d139ae8e977f784a0018143cda2a0'),
(2, 'Ivica', 'Brnic', '03ce7f557ecec60ce8183a8341fd0516');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `logindata`
--
ALTER TABLE `logindata`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `logindata`
--
ALTER TABLE `logindata`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

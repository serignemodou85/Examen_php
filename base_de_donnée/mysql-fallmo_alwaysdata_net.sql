-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-fallmo.alwaysdata.net
-- Generation Time: Mar 21, 2024 at 08:25 PM
-- Server version: 10.6.16-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fallmo_gm`
--
CREATE DATABASE IF NOT EXISTS `fallmo_gm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fallmo_gm`;

-- --------------------------------------------------------

--
-- Table structure for table `autorisations`
--

CREATE TABLE `autorisations` (
  `AutorisationID` int(11) NOT NULL,
  `MémoireID` int(11) DEFAULT NULL,
  `UtilisateurID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `domaines`
--

CREATE TABLE `domaines` (
  `DomaineID` int(11) NOT NULL,
  `NomDomaine` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mémoires`
--

CREATE TABLE `mémoires` (
  `MémoireID` int(11) NOT NULL,
  `Titre` varchar(255) DEFAULT NULL,
  `Auteur` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `ThèmeID` int(11) NOT NULL,
  `DomaineID` int(11) NOT NULL,
  `Fichier` blob DEFAULT NULL,
  `DateSoumission` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thèmes`
--

CREATE TABLE `thèmes` (
  `ThèmeID` int(11) NOT NULL,
  `NomThème` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `téléchargements`
--

CREATE TABLE `téléchargements` (
  `TéléchargementID` int(11) NOT NULL,
  `MémoireID` int(11) DEFAULT NULL,
  `UtilisateurID` int(11) DEFAULT NULL,
  `DateTéléchargement` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `UtilisateurID` int(11) NOT NULL,
  `NomUtilisateur` varchar(255) DEFAULT NULL,
  `TypeUtilisateur` enum('Admin','Étudiant') DEFAULT NULL,
  `MotDePasse` varchar(255) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`UtilisateurID`, `NomUtilisateur`, `TypeUtilisateur`, `MotDePasse`, `prenom`, `nom`) VALUES
(11, 'ballabeye', 'Étudiant', 'azerty123', 'Balla', 'beye'),
(13, 'kya@gmail.com', NULL, '$2y$10$vYvq0qOK/6fyQ/7O6xWrwuwLv1VuHcWv8b9a3qe1fHi8C2/NdXWsq', 'rokhaya', 'diaw'),
(14, 'tellofall@gmail.com', 'Admin', 'Moustapha', 'Modou', 'Fall');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autorisations`
--
ALTER TABLE `autorisations`
  ADD PRIMARY KEY (`AutorisationID`),
  ADD KEY `MémoireID` (`MémoireID`),
  ADD KEY `UtilisateurID` (`UtilisateurID`);

--
-- Indexes for table `domaines`
--
ALTER TABLE `domaines`
  ADD PRIMARY KEY (`DomaineID`);

--
-- Indexes for table `mémoires`
--
ALTER TABLE `mémoires`
  ADD PRIMARY KEY (`MémoireID`),
  ADD KEY `ThèmeID` (`ThèmeID`),
  ADD KEY `DomaineID` (`DomaineID`);

--
-- Indexes for table `thèmes`
--
ALTER TABLE `thèmes`
  ADD PRIMARY KEY (`ThèmeID`);

--
-- Indexes for table `téléchargements`
--
ALTER TABLE `téléchargements`
  ADD PRIMARY KEY (`TéléchargementID`),
  ADD KEY `MémoireID` (`MémoireID`),
  ADD KEY `UtilisateurID` (`UtilisateurID`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`UtilisateurID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autorisations`
--
ALTER TABLE `autorisations`
  MODIFY `AutorisationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `domaines`
--
ALTER TABLE `domaines`
  MODIFY `DomaineID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mémoires`
--
ALTER TABLE `mémoires`
  MODIFY `MémoireID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `thèmes`
--
ALTER TABLE `thèmes`
  MODIFY `ThèmeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `téléchargements`
--
ALTER TABLE `téléchargements`
  MODIFY `TéléchargementID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `UtilisateurID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `autorisations`
--
ALTER TABLE `autorisations`
  ADD CONSTRAINT `autorisations_ibfk_1` FOREIGN KEY (`MémoireID`) REFERENCES `mémoires` (`MémoireID`),
  ADD CONSTRAINT `autorisations_ibfk_2` FOREIGN KEY (`UtilisateurID`) REFERENCES `utilisateurs` (`UtilisateurID`);

--
-- Constraints for table `mémoires`
--
ALTER TABLE `mémoires`
  ADD CONSTRAINT `mémoires_ibfk_1` FOREIGN KEY (`ThèmeID`) REFERENCES `thèmes` (`ThèmeID`),
  ADD CONSTRAINT `mémoires_ibfk_2` FOREIGN KEY (`DomaineID`) REFERENCES `domaines` (`DomaineID`);

--
-- Constraints for table `téléchargements`
--
ALTER TABLE `téléchargements`
  ADD CONSTRAINT `téléchargements_ibfk_1` FOREIGN KEY (`MémoireID`) REFERENCES `mémoires` (`MémoireID`),
  ADD CONSTRAINT `téléchargements_ibfk_2` FOREIGN KEY (`UtilisateurID`) REFERENCES `utilisateurs` (`UtilisateurID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

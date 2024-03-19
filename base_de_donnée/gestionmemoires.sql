-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 19 mars 2024 à 18:55
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionmemoires`
--

-- --------------------------------------------------------

--
-- Structure de la table `autorisations`
--

CREATE TABLE `autorisations` (
  `AutorisationID` int(11) NOT NULL,
  `MémoireID` int(11) DEFAULT NULL,
  `UtilisateurID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `domaines`
--

CREATE TABLE `domaines` (
  `DomaineID` int(11) NOT NULL,
  `NomDomaine` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mémoires`
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
-- Structure de la table `thèmes`
--

CREATE TABLE `thèmes` (
  `ThèmeID` int(11) NOT NULL,
  `NomThème` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `téléchargements`
--

CREATE TABLE `téléchargements` (
  `TéléchargementID` int(11) NOT NULL,
  `MémoireID` int(11) DEFAULT NULL,
  `UtilisateurID` int(11) DEFAULT NULL,
  `DateTéléchargement` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
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
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`UtilisateurID`, `NomUtilisateur`, `TypeUtilisateur`, `MotDePasse`, `prenom`, `nom`) VALUES
(11, 'ballabeye', 'Étudiant', 'azerty123', 'Balla', 'beye'),
(12, 'Moustaphagueye', 'Admin', 'azerty456', 'Gueye', 'Moustapha');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `autorisations`
--
ALTER TABLE `autorisations`
  ADD PRIMARY KEY (`AutorisationID`),
  ADD KEY `MémoireID` (`MémoireID`),
  ADD KEY `UtilisateurID` (`UtilisateurID`);

--
-- Index pour la table `domaines`
--
ALTER TABLE `domaines`
  ADD PRIMARY KEY (`DomaineID`);

--
-- Index pour la table `mémoires`
--
ALTER TABLE `mémoires`
  ADD PRIMARY KEY (`MémoireID`),
  ADD KEY `ThèmeID` (`ThèmeID`),
  ADD KEY `DomaineID` (`DomaineID`);

--
-- Index pour la table `thèmes`
--
ALTER TABLE `thèmes`
  ADD PRIMARY KEY (`ThèmeID`);

--
-- Index pour la table `téléchargements`
--
ALTER TABLE `téléchargements`
  ADD PRIMARY KEY (`TéléchargementID`),
  ADD KEY `MémoireID` (`MémoireID`),
  ADD KEY `UtilisateurID` (`UtilisateurID`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`UtilisateurID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `autorisations`
--
ALTER TABLE `autorisations`
  MODIFY `AutorisationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `domaines`
--
ALTER TABLE `domaines`
  MODIFY `DomaineID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mémoires`
--
ALTER TABLE `mémoires`
  MODIFY `MémoireID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `thèmes`
--
ALTER TABLE `thèmes`
  MODIFY `ThèmeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `téléchargements`
--
ALTER TABLE `téléchargements`
  MODIFY `TéléchargementID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `UtilisateurID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `autorisations`
--
ALTER TABLE `autorisations`
  ADD CONSTRAINT `autorisations_ibfk_1` FOREIGN KEY (`MémoireID`) REFERENCES `mémoires` (`MémoireID`),
  ADD CONSTRAINT `autorisations_ibfk_2` FOREIGN KEY (`UtilisateurID`) REFERENCES `utilisateurs` (`UtilisateurID`);

--
-- Contraintes pour la table `mémoires`
--
ALTER TABLE `mémoires`
  ADD CONSTRAINT `mémoires_ibfk_1` FOREIGN KEY (`ThèmeID`) REFERENCES `thèmes` (`ThèmeID`),
  ADD CONSTRAINT `mémoires_ibfk_2` FOREIGN KEY (`DomaineID`) REFERENCES `domaines` (`DomaineID`);

--
-- Contraintes pour la table `téléchargements`
--
ALTER TABLE `téléchargements`
  ADD CONSTRAINT `téléchargements_ibfk_1` FOREIGN KEY (`MémoireID`) REFERENCES `mémoires` (`MémoireID`),
  ADD CONSTRAINT `téléchargements_ibfk_2` FOREIGN KEY (`UtilisateurID`) REFERENCES `utilisateurs` (`UtilisateurID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

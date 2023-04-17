-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 17 avr. 2023 à 14:56
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `subscriber01`
--

-- --------------------------------------------------------

--
-- Structure de la table `subscriber`
--

CREATE TABLE `subscriber` (
  `id` int(11) NOT NULL,
  `idOrigin` int(11) DEFAULT NULL,
  `idInterest` int(11) DEFAULT NULL,
  `dateCreate` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `subscriber`
--

INSERT INTO `subscriber` (`id`, `idOrigin`, `idInterest`, `dateCreate`, `email`, `firstname`, `lastname`) VALUES
(1, NULL, NULL, '2023-02-08 00:00:00', 'alfred.dupont@gmail.com', 'Alfred', 'Dupont'),
(2, NULL, NULL, '2023-02-08 00:00:00', 'b.lav@hotmail.fr', 'Bertrand', 'Lavoisier'),
(3, NULL, NULL, '2023-02-08 00:00:00', 'sarahlamine@gmail.com', 'Sarah', 'Lamine'),
(4, NULL, NULL, '2023-02-08 00:00:00', 'mo78@laposte.net', 'Mohamed', 'Ben Salam');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_origin` (`idOrigin`),
  ADD KEY `fk_interest` (`idInterest`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `subscriber`
--
ALTER TABLE `subscriber`
  ADD CONSTRAINT `fk_interest` FOREIGN KEY (`idInterest`) REFERENCES `interest` (`id`),
  ADD CONSTRAINT `fk_origin` FOREIGN KEY (`idOrigin`) REFERENCES `origins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

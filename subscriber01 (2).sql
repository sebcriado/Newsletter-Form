-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 09 fév. 2023 à 09:28
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
-- Structure de la table `interest`
--

CREATE TABLE `interest` (
  `id` int(11) NOT NULL,
  `interestLabel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `interest`
--

INSERT INTO `interest` (`id`, `interestLabel`) VALUES
(1, 'Peinture'),
(2, 'Sculpture'),
(3, 'Photographie'),
(4, 'Art contemporain'),
(5, 'Films'),
(6, 'Art numérique\r\n'),
(7, 'Installations');

-- --------------------------------------------------------

--
-- Structure de la table `origins`
--

CREATE TABLE `origins` (
  `id` int(11) NOT NULL,
  `origineLabel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `origins`
--

INSERT INTO `origins` (`id`, `origineLabel`) VALUES
(1, '---'),
(2, 'Un ami m’en a parlé'),
(3, 'Recherche sur Internet'),
(4, 'Publicité sur un magazine');

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

-- --------------------------------------------------------

--
-- Structure de la table `subscriberInterest`
--

CREATE TABLE `subscriberInterest` (
  `subscriberId` int(11) NOT NULL,
  `interestId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `interest`
--
ALTER TABLE `interest`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `origins`
--
ALTER TABLE `origins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_origin` (`idOrigin`),
  ADD KEY `fk_interest` (`idInterest`);

--
-- Index pour la table `subscriberInterest`
--
ALTER TABLE `subscriberInterest`
  ADD KEY `fk_subscriber` (`subscriberId`),
  ADD KEY `fk_interest_id` (`interestId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `interest`
--
ALTER TABLE `interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `origins`
--
ALTER TABLE `origins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `subscriber`
--
ALTER TABLE `subscriber`
  ADD CONSTRAINT `fk_interest` FOREIGN KEY (`idInterest`) REFERENCES `interest` (`id`),
  ADD CONSTRAINT `fk_origin` FOREIGN KEY (`idOrigin`) REFERENCES `origins` (`id`);

--
-- Contraintes pour la table `subscriberInterest`
--
ALTER TABLE `subscriberInterest`
  ADD CONSTRAINT `fk_interest_id` FOREIGN KEY (`interestId`) REFERENCES `interest` (`id`),
  ADD CONSTRAINT `fk_subscriber` FOREIGN KEY (`subscriberId`) REFERENCES `subscriber` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 10 déc. 2019 à 08:20
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `story_heroes`
--

-- --------------------------------------------------------

--
-- Structure de la table `choix`
--

DROP TABLE IF EXISTS `choix`;
CREATE TABLE IF NOT EXISTS `choix` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `destination` int(10) DEFAULT NULL,
  `fk_id_etape` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CHOIX_ETAPE_FK` (`fk_id_etape`),
  KEY `CHOIX_NEXT_ETAPE_FK` (`destination`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `choix_etape`
--

DROP TABLE IF EXISTS `choix_etape`;
CREATE TABLE IF NOT EXISTS `choix_etape` (
  `fk_id_etape` int(10) NOT NULL,
  `fk_id_choix` int(10) NOT NULL,
  PRIMARY KEY (`fk_id_etape`,`fk_id_choix`),
  KEY `CHOIX_ETAPE_CHOIX_FK` (`fk_id_choix`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etape`
--

DROP TABLE IF EXISTS `etape`;
CREATE TABLE IF NOT EXISTS `etape` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_une_fin` tinyint(1) DEFAULT NULL,
  `fk_id_story` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `fk_id_user` int(10) NOT NULL,
  `fk_id_story` int(10) NOT NULL,
  `etape_en_cours` int(10) DEFAULT NULL,
  PRIMARY KEY (`fk_id_user`,`fk_id_story`),
  KEY `HISTORIQUE_STORY_FK` (`fk_id_story`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `progression`
--

DROP TABLE IF EXISTS `progression`;
CREATE TABLE IF NOT EXISTS `progression` (
  `fk_id_user` int(10) NOT NULL,
  `fk_id_story` int(10) NOT NULL,
  `fin_valide` int(10) NOT NULL,
  PRIMARY KEY (`fk_id_user`,`fk_id_story`),
  KEY `PROGRESSION_STORY_FK` (`fk_id_story`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `story`
--

DROP TABLE IF EXISTS `story`;
CREATE TABLE IF NOT EXISTS `story` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `resume` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `est_publie` tinyint(1) DEFAULT NULL,
  `image` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fk_id_auteur` int(10) NOT NULL,
  PRIMARY KEY (`id`,`fk_id_auteur`),
  KEY `STORY_USER_FK` (`fk_id_auteur`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `story_etape`
--

DROP TABLE IF EXISTS `story_etape`;
CREATE TABLE IF NOT EXISTS `story_etape` (
  `fk_id_story` int(10) NOT NULL,
  `fk_id_etape` int(10) NOT NULL,
  `num_etape` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`fk_id_story`,`fk_id_etape`),
  KEY `STORY_ETAPE_ETAPE_FK` (`fk_id_etape`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `story_genre`
--

DROP TABLE IF EXISTS `story_genre`;
CREATE TABLE IF NOT EXISTS `story_genre` (
  `fk_id_story` int(10) NOT NULL,
  `fk_id_genre` int(10) NOT NULL,
  PRIMARY KEY (`fk_id_story`,`fk_id_genre`),
  KEY `STORY_GENRE_GENRE_FK` (`fk_id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `choix`
--
ALTER TABLE `choix`
  ADD CONSTRAINT `CHOIX_ETAPE_FK` FOREIGN KEY (`fk_id_etape`) REFERENCES `etape` (`id`),
  ADD CONSTRAINT `CHOIX_NEXT_ETAPE_FK` FOREIGN KEY (`destination`) REFERENCES `etape` (`id`);

--
-- Contraintes pour la table `choix_etape`
--
ALTER TABLE `choix_etape`
  ADD CONSTRAINT `CHOIX_ETAPE_CHOIX_FK` FOREIGN KEY (`fk_id_choix`) REFERENCES `choix` (`id`),
  ADD CONSTRAINT `CHOIX_ETAPE_ETAPE_FK` FOREIGN KEY (`fk_id_etape`) REFERENCES `etape` (`id`);

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `HISTORIQUE_STORY_FK` FOREIGN KEY (`fk_id_story`) REFERENCES `story` (`id`),
  ADD CONSTRAINT `HISTORIQUE_USER_FK` FOREIGN KEY (`fk_id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `progression`
--
ALTER TABLE `progression`
  ADD CONSTRAINT `PROGRESSION_STORY_FK` FOREIGN KEY (`fk_id_story`) REFERENCES `story` (`id`),
  ADD CONSTRAINT `PROGRESSION_USER_FK` FOREIGN KEY (`fk_id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `story`
--
ALTER TABLE `story`
  ADD CONSTRAINT `STORY_USER_FK` FOREIGN KEY (`fk_id_auteur`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `story_etape`
--
ALTER TABLE `story_etape`
  ADD CONSTRAINT `STORY_ETAPE_ETAPE_FK` FOREIGN KEY (`fk_id_etape`) REFERENCES `etape` (`id`),
  ADD CONSTRAINT `STORY_ETAPE_STORY_FK` FOREIGN KEY (`fk_id_story`) REFERENCES `story` (`id`);

--
-- Contraintes pour la table `story_genre`
--
ALTER TABLE `story_genre`
  ADD CONSTRAINT `STORY_GENRE_GENRE_FK` FOREIGN KEY (`fk_id_genre`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `STORY_GENRE_STORY_FK` FOREIGN KEY (`fk_id_story`) REFERENCES `story` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

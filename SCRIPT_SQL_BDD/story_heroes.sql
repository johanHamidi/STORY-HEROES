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

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `CRUD_ETAPE_DELETE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_ETAPE_DELETE` (IN `pId` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD DELETE de la table etape'
DELETE FROM `etape`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_INSERT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_ETAPE_INSERT` (IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pDescription` VARCHAR(500) CHARSET utf8, IN `pImage` VARCHAR(100) CHARSET utf8, IN `pEstUneFin` TINYINT(1), IN `pFkIdStory` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table etape'
INSERT INTO etape (titre, description, image, est_une_fin, fk_id_story)
Values (pTitre, pDescription, pImage, pEstUneFin, pFkIdStory)$$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_READ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_ETAPE_READ` (IN `pId` INT(10))  NO SQL
    COMMENT 'CRUD READ de la table etape'
IF pId = 0 THEN
	SELECT * FROM etape;
ELSE
	SELECT * FROM etape
    WHERE id = pId;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_UPDATE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_ETAPE_UPDATE` (IN `pId` INT(10), IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pDescription` VARCHAR(500) CHARSET utf8, IN `pImage` VARCHAR(100) CHARSET utf8, IN `pEstUneFin` TINYINT(1))  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table etape'
UPDATE etape
SET titre = pTitre, description = pDescription, image = pImage, est_une_fin = pEstUneFin
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_GENRE_DELETE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_GENRE_DELETE` (IN `pId` INT(10))  NO SQL
    COMMENT 'CRUD DELETE de la table genre'
DELETE FROM `genre`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_GENRE_INSERT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_GENRE_INSERT` (IN `pLibelle` VARCHAR(50))  NO SQL
    COMMENT 'CRUD INSERT de la table genre'
INSERT INTO genre (libelle)
Values (pLibelle)$$

DROP PROCEDURE IF EXISTS `CRUD_GENRE_READ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_GENRE_READ` (IN `pId` INT(10))  NO SQL
    COMMENT 'CRUD READ de la table genre'
IF pId = 0 THEN
	SELECT * FROM genre;
ELSE
	SELECT * FROM genre
    WHERE id = pId;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_GENRE_UPDATE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_GENRE_UPDATE` (IN `pId` INT(10), IN `pLibelle` VARCHAR(50))  NO SQL
    COMMENT 'CRUD UPDATE de la table genre'
UPDATE genre
SET libelle = pLibelle
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_DELETE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_DELETE` (IN `pId` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD DELETE de la table story'
DELETE FROM `story`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_ETAPE_READ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_ETAPE_READ` (IN `pId_Story` INT(10))  NO SQL
    COMMENT 'Récupère toutes les étapes d''une histoire'
SELECT id,titre, description, est_une_fin,image, num_etape
FROM etape e
LEFT JOIN story_etape se
ON e.fk_id_story = se.fk_id_story AND e.id = se.fk_id_etape
WHERE e.fk_id_story = pId_Story$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_GENRE_INSERT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_GENRE_INSERT` (IN `pIdStory` INT(10), IN `pIdGenre` INT(10))  NO SQL
    COMMENT 'CRUD INSERT de la table story_genre'
INSERT INTO story_genre (fk_id_story, fk_id_genre)
VALUES (pIdStory, pIdGenre)$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_INSERT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_INSERT` (IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pResume` VARCHAR(500) CHARSET utf8, IN `pEst_publie` TINYINT(1), `pIdAuteur` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table story'
INSERT INTO story (titre, resume, est_publie, fk_id_auteur)
Values (pTitre, pResume, pEst_publie, pIdAuteur)$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_READ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_READ` (IN `pId` INT(10))  NO SQL
IF pId = 0 THEN
	SELECT * FROM story;
ELSE
	SELECT * FROM story
    WHERE id = pId ;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_UPDATE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_UPDATE` (IN `pId` INT(10), IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pResume` VARCHAR(500) CHARSET utf8, IN `pEst_publie` TINYINT(1))  MODIFIES SQL DATA
    COMMENT 'CRUD UPDATE de la table user'
UPDATE story
SET titre = pTitre, resume = pResume, est_publie = pEst_publie
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_USER_DELETE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_USER_DELETE` (IN `pId` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD DELETE de la table user'
DELETE FROM `user`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_USER_INSERT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_USER_INSERT` (IN `pPseudo` VARCHAR(20) CHARSET utf8, IN `pMdp` VARCHAR(300) CHARSET utf8, IN `pMail` VARCHAR(50) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table user'
INSERT INTO user (pseudo, mdp, mail)
Values (pPseudo, pMdp, pMail)$$

DROP PROCEDURE IF EXISTS `CRUD_USER_READ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_USER_READ` (IN `pId` VARCHAR(20))  NO SQL
IF pId = "0" THEN
	SELECT * FROM user;
ELSE
	SELECT * FROM user
    WHERE id = CONVERT(pId, SIGNED INTEGER) OR pseudo = pId;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_USER_UPDATE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_USER_UPDATE` (IN `pId` INT(10), IN `pPseudo` VARCHAR(20) CHARSET utf8, IN `pMdp` VARCHAR(20) CHARSET utf8, IN `pMail` VARCHAR(50) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'CRUD UPDATE de la table user'
UPDATE user
SET pseudo = pPseudo, mdp = pMdp, mail = pMail
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `SPEC_STORY_GENRE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SPEC_STORY_GENRE` (IN `pIdStory` INT(10))  NO SQL
    COMMENT 'Retourne les genres correspondants à une histoire '
SELECT sg.fk_id_story, sg.fk_id_genre ,s.titre, g.libelle
FROM story_genre sg
INNER JOIN story s
ON sg.fk_id_story = s.id
INNER JOIN genre g
ON sg.fk_id_genre = g.id
WHERE sg.fk_id_story = pIdStory$$

DROP PROCEDURE IF EXISTS `SPEC_STORY_INDEX`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SPEC_STORY_INDEX` (IN `pId` VARCHAR(20))  NO SQL
    COMMENT 'Récupère une histoire avec son auteur'
IF pId = "0" THEN
	SELECT s.id, s.titre, s.resume, s.est_publie, u.pseudo, u.mail
    FROM story s
    INNER JOIN user u
    ON s.fk_id_auteur = u.id;
ELSE
	SELECT s.id, s.titre, s.resume, s.est_publie, u.pseudo, u.mail
    FROM story s
    INNER JOIN user u
    ON s.fk_id_auteur = u.id
    WHERE u.id = CONVERT(pId, SIGNED INTEGER) OR u.pseudo = pId;
END IF$$

DELIMITER ;

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


--
-- Procédures
--
DELIMITER $$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_DELETE`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_ETAPE_DELETE` (IN `pId` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD DELETE de la table etape'
DELETE FROM `etape`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_INSERT`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_ETAPE_INSERT` (IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pDescription` VARCHAR(500) CHARSET utf8, IN `pImage` VARCHAR(100) CHARSET utf8, IN `pEstUneFin` TINYINT(1), IN `pFkIdStory` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table etape'
INSERT INTO etape (titre, description, image, est_une_fin, fk_id_story)
Values (pTitre, pDescription, pImage, pEstUneFin, pFkIdStory)$$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_READ`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_ETAPE_READ` (IN `pId` INT(10))  NO SQL
    COMMENT 'CRUD READ de la table etape'
IF pId = 0 THEN
	SELECT * FROM etape;
ELSE
	SELECT * FROM etape
    WHERE id = pId;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_ETAPE_UPDATE`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_ETAPE_UPDATE` (IN `pId` INT(10), IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pDescription` VARCHAR(500) CHARSET utf8, IN `pImage` VARCHAR(100) CHARSET utf8, IN `pEstUneFin` TINYINT(1))  MODIFIES SQL DATA
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
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_GENRE_INSERT` (IN `pLibelle` VARCHAR(50))  NO SQL
    COMMENT 'CRUD INSERT de la table genre'
INSERT INTO genre (libelle)
Values (pLibelle)$$

DROP PROCEDURE IF EXISTS `CRUD_GENRE_READ`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_GENRE_READ` (IN `pId` INT(10))  NO SQL
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
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_STORY_DELETE` (IN `pId` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD DELETE de la table story'
DELETE FROM `story`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_ETAPE_READ`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_ETAPE_READ` (IN `pId_Story` INT(10))  NO SQL
    COMMENT 'Récupère toutes les étapes d''une histoire'
SELECT id, num_etape, titre
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
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_STORY_INSERT` (IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pResume` VARCHAR(500) CHARSET utf8, IN `pEst_publie` TINYINT(1), `pIdAuteur` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table story'
INSERT INTO story (titre, resume, est_publie, fk_id_auteur)
Values (pTitre, pResume, pEst_publie, pIdAuteur)$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_READ`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_STORY_READ` (IN `pId` INT(10))  NO SQL
IF pId = 0 THEN
	SELECT * FROM story;
ELSE
	SELECT * FROM story
    WHERE id = pId ;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_UPDATE`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_STORY_UPDATE` (IN `pId` INT(10), IN `pTitre` VARCHAR(50) CHARSET utf8, IN `pResume` VARCHAR(500) CHARSET utf8, IN `pEst_publie` TINYINT(1))  MODIFIES SQL DATA
    COMMENT 'CRUD UPDATE de la table user'
UPDATE story
SET titre = pTitre, resume = pResume, est_publie = pEst_publie
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_USER_DELETE`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_USER_DELETE` (IN `pId` INT(10))  MODIFIES SQL DATA
    COMMENT 'CRUD DELETE de la table user'
DELETE FROM `user`
WHERE id = pId$$

DROP PROCEDURE IF EXISTS `CRUD_USER_INSERT`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_USER_INSERT` (IN `pPseudo` VARCHAR(20) CHARSET utf8, IN `pMdp` VARCHAR(300) CHARSET utf8, IN `pMail` VARCHAR(50) CHARSET utf8)  MODIFIES SQL DATA
    COMMENT 'CRUD INSERT de la table user'
INSERT INTO user (pseudo, mdp, mail)
Values (pPseudo, pMdp, pMail)$$

DROP PROCEDURE IF EXISTS `CRUD_USER_READ`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_USER_READ` (IN `pId` VARCHAR(20))  NO SQL
IF pId = "0" THEN
	SELECT * FROM user;
ELSE
	SELECT * FROM user
    WHERE id = CONVERT(pId, SIGNED INTEGER) OR pseudo = pId;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_USER_UPDATE`$$
CREATE DEFINER=`story_heroes`@`localhost` PROCEDURE `CRUD_USER_UPDATE` (IN `pId` INT(10), IN `pPseudo` VARCHAR(20) CHARSET utf8, IN `pMdp` VARCHAR(20) CHARSET utf8, IN `pMail` VARCHAR(50) CHARSET utf8)  MODIFIES SQL DATA
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `SPEC_STORY_INDEX`(IN `pId` VARCHAR(20))
    NO SQL
    COMMENT 'Récupère une histoire avec son auteur'
IF pId = "0" THEN
	SELECT s.id, s.titre, s.resume, s.est_publie, s.image,u.pseudo, u.mail
    FROM story s
    INNER JOIN user u
    ON s.fk_id_auteur = u.id;
ELSE
	SELECT s.id, s.titre, s.resume, s.est_publie, s.image,u.pseudo, u.mail
    FROM story s
    INNER JOIN user u
    ON s.fk_id_auteur = u.id
    WHERE u.id = CONVERT(pId, SIGNED INTEGER) OR u.pseudo = pId;
END IF$$

DROP PROCEDURE IF EXISTS `CRUD_STORY_GENRE_DELETE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD_STORY_GENRE_DELETE`(IN `pFk_id_story` INT(10), IN `pFk_id_genre` INT(10))
    NO SQL
DELETE FROM `story_genre`
WHERE fk_id_story = pFk_id_story
AND fk_id_genre = pFk_id_genre$$;


-- TRIGERS --

--
-- Déclencheurs AFTER INSERT de la table `etape`
--
DROP TRIGGER IF EXISTS `AFTER_INSERT_ETAPE`$$
CREATE TRIGGER `AFTER_INSERT_ETAPE` AFTER INSERT ON `etape` FOR EACH ROW BEGIN
    -- Instructions
    DECLARE id_etape int ;
DECLARE id_story int ;
DECLARE pnum_etape int ; 
DECLARE last_etape int ;

SET id_etape = New.id;
SET id_story = New.fk_id_story;
SET last_etape = 0;

SELECT max(num_etape) AS `last_etape` INTO last_etape FROM `story_etape` WHERE fk_id_story=id_story;
                 
IF last_etape >0 THEN

	SET pnum_etape = last_etape + 1;

ELSE

	SET pnum_etape = 1;
	
END IF;

INSERT INTO story_etape(fk_id_story, fk_id_etape, num_etape)
VALUES (id_story, id_etape, pnum_etape);


END $$
                 


DELIMITER ;

-- --------------------------------------------------------

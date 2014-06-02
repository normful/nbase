-- MySQL dump 10.13  Distrib 5.5.36, for linux2.6 (x86_64)
--
-- Host: localhost    Database: nba
-- ------------------------------------------------------
-- Server version	5.5.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `division` (
  `divisionName` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`divisionName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `division`
--

LOCK TABLES `division` WRITE;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` VALUES ('Atlantic'),('Central'),('Northwest'),('Pacific'),('Southeast'),('Southwest');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nbagame_plays_playedat`
--

DROP TABLE IF EXISTS `nbagame_plays_playedat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nbagame_plays_playedat` (
  `gameDate` date NOT NULL DEFAULT '0000-00-00',
  `homeScore` int(11) DEFAULT NULL,
  `awayScore` int(11) DEFAULT NULL,
  `homeTeam` char(3) NOT NULL,
  `awayTeam` char(3) NOT NULL,
  `venueName` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  PRIMARY KEY (`gameDate`,`homeTeam`,`awayTeam`),
  KEY `homeTeam` (`homeTeam`),
  KEY `awayTeam` (`awayTeam`),
  KEY `venueName` (`venueName`,`city`),
  CONSTRAINT `nbagame_plays_playedat_ibfk_1` FOREIGN KEY (`homeTeam`) REFERENCES `nbateam_belongsto` (`abbreviation`) ON DELETE CASCADE,
  CONSTRAINT `nbagame_plays_playedat_ibfk_2` FOREIGN KEY (`awayTeam`) REFERENCES `nbateam_belongsto` (`abbreviation`) ON DELETE CASCADE,
  CONSTRAINT `nbagame_plays_playedat_ibfk_3` FOREIGN KEY (`venueName`, `city`) REFERENCES `venue` (`venueName`, `city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nbagame_plays_playedat`
--

LOCK TABLES `nbagame_plays_playedat` WRITE;
/*!40000 ALTER TABLE `nbagame_plays_playedat` DISABLE KEYS */;
INSERT INTO `nbagame_plays_playedat` VALUES ('2014-04-20',90,85,'SAS','DAL','AT&T Center','San Antonio, TX'),('2014-05-06',116,92,'SAS','POR','AT&T Center','San Antonio, TX'),('2014-05-07',105,122,'OKC','LAC','Cheasapeake Energy Arena','Oklahoma City, OK'),('2014-05-10',103,118,'POR','SAS','Moda Center','Portland, OR'),('2014-05-11',104,105,'LAC','OKC','Staples Center','Los Angeles, CA');
/*!40000 ALTER TABLE `nbagame_plays_playedat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nbaplayer_playsfor`
--

DROP TABLE IF EXISTS `nbaplayer_playsfor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nbaplayer_playsfor` (
  `number` int(11) NOT NULL DEFAULT '0',
  `position` char(2) DEFAULT NULL,
  `firstName` varchar(30) DEFAULT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `draftYear` year(4) DEFAULT NULL,
  `team` char(3) NOT NULL,
  PRIMARY KEY (`number`,`team`),
  KEY `team` (`team`),
  CONSTRAINT `nbaplayer_playsfor_ibfk_1` FOREIGN KEY (`team`) REFERENCES `nbateam_belongsto` (`abbreviation`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nbaplayer_playsfor`
--

LOCK TABLES `nbaplayer_playsfor` WRITE;
/*!40000 ALTER TABLE `nbaplayer_playsfor` DISABLE KEYS */;
INSERT INTO `nbaplayer_playsfor` VALUES (12,'C','Steven','Adams',84,255,2013,'OKC'),(12,'PF','LaMarcus','Aldridge',83,240,2009,'POR'),(21,'PF','Tim','Duncan',83,250,1997,'SAS'),(22,'SF','Matt','Barnes',79,226,2012,'LAC'),(41,'PF','Dirk','Nowitzki',84,237,1998,'DAL');
/*!40000 ALTER TABLE `nbaplayer_playsfor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nbareferee`
--

DROP TABLE IF EXISTS `nbareferee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nbareferee` (
  `number` int(11) NOT NULL DEFAULT '0',
  `firstName` varchar(30) DEFAULT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nbareferee`
--

LOCK TABLES `nbareferee` WRITE;
/*!40000 ALTER TABLE `nbareferee` DISABLE KEYS */;
INSERT INTO `nbareferee` VALUES (10,'Ron','Garretson'),(12,'Violet','Palmer'),(13,'Monty','McCutchen'),(15,'Bennett','Salvatore'),(17,'Joe','Crawford'),(27,'Dick','Bavetta'),(28,'Zach','Zarba'),(32,'Eddie','Rush'),(40,'Leon','Wood');
/*!40000 ALTER TABLE `nbareferee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nbastaff_worksfor`
--

DROP TABLE IF EXISTS `nbastaff_worksfor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nbastaff_worksfor` (
  `firstName` varchar(30) NOT NULL DEFAULT '',
  `lastName` varchar(30) NOT NULL DEFAULT '',
  `job` varchar(30) DEFAULT NULL,
  `team` char(3) NOT NULL,
  PRIMARY KEY (`firstName`,`lastName`,`team`),
  KEY `team` (`team`),
  CONSTRAINT `nbastaff_worksfor_ibfk_1` FOREIGN KEY (`team`) REFERENCES `nbateam_belongsto` (`abbreviation`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nbastaff_worksfor`
--

LOCK TABLES `nbastaff_worksfor` WRITE;
/*!40000 ALTER TABLE `nbastaff_worksfor` DISABLE KEYS */;
INSERT INTO `nbastaff_worksfor` VALUES ('Alvin ','Gentry','Assistant Coach','LAC'),('Gregg','Popovich','Head Coach','SAS'),('Jay','Triano','Assistant Coach','POR'),('Rick','Carlisle','Head Coach','DAL'),('Scott','Brooks','Head Coach','OKC');
/*!40000 ALTER TABLE `nbastaff_worksfor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nbateam_belongsto`
--

DROP TABLE IF EXISTS `nbateam_belongsto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nbateam_belongsto` (
  `abbreviation` char(3) NOT NULL DEFAULT '',
  `city` varchar(30) DEFAULT NULL,
  `teamName` varchar(30) DEFAULT NULL,
  `divisionName` varchar(10) NOT NULL,
  PRIMARY KEY (`abbreviation`),
  KEY `divisionName` (`divisionName`),
  CONSTRAINT `nbateam_belongsto_ibfk_1` FOREIGN KEY (`divisionName`) REFERENCES `division` (`divisionName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nbateam_belongsto`
--

LOCK TABLES `nbateam_belongsto` WRITE;
/*!40000 ALTER TABLE `nbateam_belongsto` DISABLE KEYS */;
INSERT INTO `nbateam_belongsto` VALUES ('DAL','Dallas, TX','Mavericks','Southwest'),('LAC','Los Angeles, CA','Clippers','Pacific'),('OKC','Oklahoma City, OK','Thunder','Northwest'),('POR','Portland, OR','Blazers','Northwest'),('SAS','San Antonio, TX','Spurs','Southwest');
/*!40000 ALTER TABLE `nbateam_belongsto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referees`
--

DROP TABLE IF EXISTS `referees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referees` (
  `refNumber` int(11) NOT NULL DEFAULT '0',
  `gameDate` date NOT NULL DEFAULT '0000-00-00',
  `homeTeam` char(3) NOT NULL DEFAULT '',
  `awayTeam` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`refNumber`,`gameDate`,`homeTeam`,`awayTeam`),
  KEY `gameDate` (`gameDate`,`homeTeam`,`awayTeam`),
  CONSTRAINT `referees_ibfk_1` FOREIGN KEY (`refNumber`) REFERENCES `nbareferee` (`number`),
  CONSTRAINT `referees_ibfk_2` FOREIGN KEY (`gameDate`, `homeTeam`, `awayTeam`) REFERENCES `nbagame_plays_playedat` (`gameDate`, `homeTeam`, `awayTeam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referees`
--

LOCK TABLES `referees` WRITE;
/*!40000 ALTER TABLE `referees` DISABLE KEYS */;
INSERT INTO `referees` VALUES (10,'2014-04-20','SAS','DAL'),(40,'2014-04-20','SAS','DAL'),(10,'2014-05-06','SAS','POR'),(12,'2014-05-06','SAS','POR'),(13,'2014-05-07','OKC','LAC'),(15,'2014-05-07','OKC','LAC'),(17,'2014-05-10','POR','SAS'),(27,'2014-05-10','POR','SAS'),(28,'2014-05-11','LAC','OKC'),(32,'2014-05-11','LAC','OKC');
/*!40000 ALTER TABLE `referees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sponsor_endorses`
--

DROP TABLE IF EXISTS `sponsor_endorses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sponsor_endorses` (
  `company` varchar(30) NOT NULL DEFAULT '',
  `team` char(3) NOT NULL,
  PRIMARY KEY (`company`,`team`),
  KEY `team` (`team`),
  CONSTRAINT `sponsor_endorses_ibfk_1` FOREIGN KEY (`team`) REFERENCES `nbateam_belongsto` (`abbreviation`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sponsor_endorses`
--

LOCK TABLES `sponsor_endorses` WRITE;
/*!40000 ALTER TABLE `sponsor_endorses` DISABLE KEYS */;
INSERT INTO `sponsor_endorses` VALUES ('AMERICAN AIRLINES','DAL'),('ANHEUSER-BUSCH','DAL'),('AT&T','DAL'),('AUDI','DAL'),('COCA-COLA','DAL'),('DR PEPPER SNAPPLE GROUP','DAL'),('MILLERCOORS','DAL'),('PLAINS CAPITAL BANK','DAL'),('TEXAS FORD DEALERS','DAL'),('TXU','DAL'),('DODGE','LAC'),('KIA','LAC'),('MERCEDEZ BENZ','LAC'),('STATE FARM INSURANCE','LAC'),('CHESAPEAKE ENERGY','OKC'),('DEVON ENERGY','OKC'),('HERTZ','OKC'),('LOVE\'S COUNTRY\'S','OKC'),('MIDFIRST BANK','OKC'),('RIVERWIND CASINO','OKC'),('SANDRIDGE ENERGY','OKC'),('COMCAST','POR'),('KIA','POR'),('NORTHWEST FORD STORES','POR'),('SPIRIT MOUNTAIN CASINO','POR'),('WELLS FARGO','POR'),('BROWN AUTO GROUP','SAS'),('H-E-B','SAS'),('SILVER EAGLE DISTRIBUTOR','SAS'),('SWBC','SAS'),('USAA','SAS'),('VALERO','SAS');
/*!40000 ALTER TABLE `sponsor_endorses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venue`
--

DROP TABLE IF EXISTS `venue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venue` (
  `venueName` varchar(30) NOT NULL DEFAULT '',
  `city` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`venueName`,`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venue`
--

LOCK TABLES `venue` WRITE;
/*!40000 ALTER TABLE `venue` DISABLE KEYS */;
INSERT INTO `venue` VALUES ('American Airlines Center','Dallas, TX','2500 Victory Avenue'),('AT&T Center','San Antonio, TX','1 AT&T Center Parkway'),('Chesapeake Energy Arena','Oklahoma City, OK','100 West Reno Avenue'),('Moda Center','Portland, OR','1 Center Court'),('Staples Center','Los Angeles, CA','1111 S. Figueroa Street');
/*!40000 ALTER TABLE `venue` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-02  5:25:39

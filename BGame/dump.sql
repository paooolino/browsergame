-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: bgame
-- ------------------------------------------------------
-- Server version 	5.7.19
-- Date: Tue, 14 May 2019 21:55:27 +0000

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `leagues`
--

DROP TABLE IF EXISTS `leagues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leagues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leagues`
--

LOCK TABLES `leagues` WRITE;
/*!40000 ALTER TABLE `leagues` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `leagues` VALUES (1,'Serie A'),(2,'Serie B'),(3,'Lega Pro'),(4,'Campionato Nazionale Dilettanti');
/*!40000 ALTER TABLE `leagues` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `leagues` with 4 row(s)
--

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_team1` int(10) unsigned DEFAULT NULL,
  `id_team2` int(10) unsigned DEFAULT NULL,
  `scheduled_turn` int(10) unsigned DEFAULT '0',
  `goals_team1` int(10) unsigned DEFAULT '0',
  `goals_team2` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `matches` with 0 row(s)
--

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `players` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_team` int(10) unsigned DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `role` varchar(1) DEFAULT NULL,
  `ability` int(11) DEFAULT '0',
  `form` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `players` VALUES (1,1,'Chiellini','Giorgio','D',0,0),(2,1,'Ronaldo','Cristiano','A',0,0);
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `players` with 2 row(s)
--

--
-- Table structure for table `standings`
--

DROP TABLE IF EXISTS `standings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `standings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_league` int(10) unsigned DEFAULT NULL,
  `id_team` int(10) unsigned DEFAULT NULL,
  `points` int(10) unsigned DEFAULT '0',
  `played` int(10) unsigned DEFAULT '0',
  `wins` int(10) unsigned DEFAULT '0',
  `draws` int(10) unsigned DEFAULT '0',
  `loss` int(10) unsigned DEFAULT '0',
  `goals_scored` int(10) unsigned DEFAULT '0',
  `goals_taken` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standings`
--

LOCK TABLES `standings` WRITE;
/*!40000 ALTER TABLE `standings` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `standings` VALUES (1,1,1,0,0,0,0,0,0,0),(2,1,2,0,0,0,0,0,0,0),(3,1,3,0,0,0,0,0,0,0),(4,1,4,0,0,0,0,0,0,0),(5,2,5,0,0,0,0,0,0,0),(6,2,6,0,0,0,0,0,0,0),(7,2,7,0,0,0,0,0,0,0),(8,2,8,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `standings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `standings` with 8 row(s)
--

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `teams` VALUES (1,'Juventus'),(2,'Milan'),(3,'Inter'),(4,'Napoli'),(5,'Roma'),(6,'Lazio'),(7,'Fiorentina'),(8,'Parma'),(9,'Torino'),(10,'Atalanta'),(11,'Udinese'),(12,'Bologna'),(13,'Genoa'),(14,'Sampdoria'),(15,'Empoli'),(16,'Chievo'),(17,'Hellas Verona'),(18,'Brescia'),(19,'Sassuolo');
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `teams` with 19 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Tue, 14 May 2019 21:55:27 +0000

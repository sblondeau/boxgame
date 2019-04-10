CREATE DATABASE  IF NOT EXISTS `boxgame` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `boxgame`;
-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: boxgame
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `level`
--

DROP TABLE IF EXISTS `level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `sizeX` int(11) NOT NULL,
  `sizeY` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `level_id_uindex` (`id`),
  UNIQUE KEY `level_number_uindex` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level`
--

LOCK TABLES `level` WRITE;
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` VALUES (1,1,9,7),(2,2,4,5);
/*!40000 ALTER TABLE `level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tile`
--

DROP TABLE IF EXISTS `tile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `type` varchar(80) NOT NULL,
  `level_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tile_id_uindex` (`id`),
  KEY `tile_level_id_fk` (`level_id`),
  CONSTRAINT `tile_level_id_fk` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tile`
--

LOCK TABLES `tile` WRITE;
/*!40000 ALTER TABLE `tile` DISABLE KEYS */;
INSERT INTO `tile` VALUES (115,9,7,'Finish',1),(116,7,0,'Box',1),(117,1,1,'Box',1),(118,2,1,'Box',1),(119,6,1,'Box',1),(120,8,1,'Box',1),(121,2,2,'Box',1),(122,5,2,'Box',1),(123,9,2,'Box',1),(124,1,3,'Box',1),(125,3,3,'Box',1),(126,0,4,'Box',1),(127,3,4,'Box',1),(129,9,4,'Box',1),(130,1,5,'Box',1),(131,4,5,'Box',1),(132,6,5,'Box',1),(133,7,5,'Box',1),(134,3,6,'Box',1),(135,9,6,'Box',1),(136,1,7,'Box',1),(137,4,7,'Box',1),(138,5,7,'Box',1),(139,6,7,'Hammer',1),(140,2,0,'Wall',1),(141,0,1,'Wall',1),(142,4,1,'Wall',1),(143,4,2,'Wall',1),(144,7,2,'Wall',1),(148,5,5,'Wall',1),(149,8,5,'Wall',1),(150,5,6,'Wall',1),(151,8,6,'Wall',1),(152,8,7,'Wall',1),(153,5,3,'Hole',1),(154,9,3,'Hole',1),(155,9,5,'Hole',1),(156,1,6,'Hole',1),(157,2,4,'Wall',1),(158,8,3,'Wall',1),(159,4,3,'Finish',2),(160,0,1,'Box',2);
/*!40000 ALTER TABLE `tile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-10 18:42:34

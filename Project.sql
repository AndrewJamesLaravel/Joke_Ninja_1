-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 192.168.10.10    Database: joker
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1

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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'Andy Palms','example1@email.com',NULL),(2,'John Smith','example2@email.com',NULL),(7,'James','jamesbond@gmail.com','$2y$10$uY5t5DKK2hIC0G2965Rxqe9OoipJhppRdMu3KCyX6NrIquAzjO6jK');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joke`
--

DROP TABLE IF EXISTS `joke`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joke` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joketext` text CHARACTER SET latin1,
  `jokedate` date DEFAULT NULL,
  `authorId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joke`
--

LOCK TABLES `joke` WRITE;
/*!40000 ALTER TABLE `joke` DISABLE KEYS */;
INSERT INTO `joke` VALUES (1,'A programmer was found dead in the shower. The instructions\nread: lather, rinse, repeat.','2015-04-02',1),(3,'Why did the programmer quit his job? He didn\'t get arrays.','2015-04-02',1),(4,'If you want to fuck for funny, fuck yourself and hold your money!','2018-11-30',2),(5,'Pusy cat, pusy cat, can you catch that bad fat rat?\nIf you catch that bad fat rat, I will give you milk\nfor that!','2018-08-03',2),(6,'Can a cangaroo jump higher than a house?\r\n           -\r\nOf course, a house doesn\'t jump at all.','2018-11-29',1),(7,'Doctor: \"I\'m sorry but you suffer from a terminal illness and have only 10 to live.\"\r\n-\r\nPatient: \"What do you mean, 10? 10 what? Months? Weeks?!\"\r\n-Doctor: \"Nine.\"','2018-11-29',2),(11,'                Just another try to maintain this update function.))        ','2018-12-02',1),(18,'A new joke now! After refresh 9-th time.','2018-12-03',1),(19,'After the names editted.    ','2018-12-04',1),(21,'The loadTemplate added. It\'s all works!                ','2018-12-06',1),(23,'email: jamesbond@gmail.com\r\npass:\r\nBond007                ','2018-12-10',1),(24,'The first joke after embedding jokes to authors.Edited.                ','2018-12-11',7);
/*!40000 ALTER TABLE `joke` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-12 15:24:34

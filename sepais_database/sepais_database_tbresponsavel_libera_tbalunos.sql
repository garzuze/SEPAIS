-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sepais_database
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbresponsavel_libera_tbalunos`
--

DROP TABLE IF EXISTS `tbresponsavel_libera_tbalunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbresponsavel_libera_tbalunos` (
  `tbResponsavel_email` varchar(144) NOT NULL,
  `tbAlunos_id` int NOT NULL,
  `data` datetime NOT NULL,
  `tbMotivos_motivos` varchar(45) NOT NULL,
  PRIMARY KEY (`tbResponsavel_email`,`tbAlunos_id`,`data`),
  KEY `fk_tbResponsavel_has_tbAlunos_tbAlunos1_idx` (`tbAlunos_id`),
  KEY `fk_tbResponsavel_has_tbAlunos_tbResponsavel_idx` (`tbResponsavel_email`),
  KEY `fk_tbResponsavel_libera_tbAlunos_tbMotivos1_idx` (`tbMotivos_motivos`),
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbAlunos1` FOREIGN KEY (`tbAlunos_id`) REFERENCES `tbalunos` (`id`),
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbResponsavel` FOREIGN KEY (`tbResponsavel_email`) REFERENCES `tbresponsavel` (`email`),
  CONSTRAINT `fk_tbResponsavel_libera_tbAlunos_tbMotivos1` FOREIGN KEY (`tbMotivos_motivos`) REFERENCES `tbmotivos` (`motivos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbresponsavel_libera_tbalunos`
--

LOCK TABLES `tbresponsavel_libera_tbalunos` WRITE;
/*!40000 ALTER TABLE `tbresponsavel_libera_tbalunos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbresponsavel_libera_tbalunos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-05  9:18:02

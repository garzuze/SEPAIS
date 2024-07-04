CREATE DATABASE  IF NOT EXISTS `sepaisdb` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sepaisdb`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: sepaisdb
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
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(144) NOT NULL,
  `foto_path` varchar(144) NOT NULL,
  `turma_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aluno_turma1_idx` (`turma_id`),
  CONSTRAINT `fk_aluno_turma1` FOREIGN KEY (`turma_id`) REFERENCES `turma` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'Mateus','nenhum',1),(2,'Mariana','nenhum',4),(3,'Paulo','nenhum',5),(4,'Luan','nenhum',6),(5,'Mario','nenhum',2),(6,'Luigi','nenhum',2),(7,'Wario','nenhum',3),(8,'Waluigi','nenhum',7),(10,'Sonic','nenhum',8),(11,'Bart Simpson','nenhum',2),(12,'Homer Simpson','nenhum',5),(13,'Marge Simpson','nenhum',1),(14,'Lisa Simpson','nenhum',3),(15,'Maggie Simpson','nenhum',7),(16,'Ned Flanders','nenhum',4),(17,'Moe Szyslak','nenhum',6),(18,'Apu Nahasapeemapetilon','nenhum',3),(19,'Krusty the Clown','nenhum',8),(20,'Barney Gumble','nenhum',5),(21,'Chief Wiggum','nenhum',2),(22,'Mr. Burns','nenhum',1),(23,'Ned Flanders','nenhum',6),(24,'Sideshow Bob','nenhum',7),(25,'Groundskeeper Willie','nenhum',4),(26,'Professor Frink','nenhum',2),(27,'Waylon Smithers','nenhum',3),(28,'Selma Bouvier','nenhum',8),(29,'Squeaky-Voiced Teen','nenhum',1),(30,'Kang and Kodos','nenhum',5);
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aluno_atrasado`
--

DROP TABLE IF EXISTS `aluno_atrasado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno_atrasado` (
  `aluno_id` int NOT NULL,
  `data` datetime NOT NULL,
  `portaria_email` varchar(144) NOT NULL,
  PRIMARY KEY (`aluno_id`,`data`),
  KEY `aluno_id` (`aluno_id`),
  KEY `fk_aluno_atrasado_portaria1_idx` (`portaria_email`),
  CONSTRAINT `aluno_atrasado_ibfk_1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  CONSTRAINT `fk_aluno_atrasado_portaria1` FOREIGN KEY (`portaria_email`) REFERENCES `portaria` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno_atrasado`
--

LOCK TABLES `aluno_atrasado` WRITE;
/*!40000 ALTER TABLE `aluno_atrasado` DISABLE KEYS */;
INSERT INTO `aluno_atrasado` VALUES (2,'2024-07-04 12:26:02','cerberus@ifpr.edu.br'),(5,'2024-07-04 12:25:47','cerberus@ifpr.edu.br'),(8,'2024-07-04 12:25:59','cerberus@ifpr.edu.br'),(10,'2024-07-04 12:25:51','cerberus@ifpr.edu.br'),(11,'2024-07-04 12:25:34','cerberus@ifpr.edu.br'),(17,'2024-07-04 12:25:56','cerberus@ifpr.edu.br'),(19,'2024-07-04 12:25:53','cerberus@ifpr.edu.br'),(21,'2024-07-04 12:25:45','cerberus@ifpr.edu.br'),(26,'2024-07-04 12:25:49','cerberus@ifpr.edu.br');
/*!40000 ALTER TABLE `aluno_atrasado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivo`
--

DROP TABLE IF EXISTS `motivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motivo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `motivo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivo`
--

LOCK TABLES `motivo` WRITE;
/*!40000 ALTER TABLE `motivo` DISABLE KEYS */;
INSERT INTO `motivo` VALUES (1,'Luto'),(2,'Médico'),(3,'Transporte'),(4,'Mal-estar'),(5,'Motivo particular'),(6,'Professor faltou'),(7,'Aula acabou mais cedo');
/*!40000 ALTER TABLE `motivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portaria`
--

DROP TABLE IF EXISTS `portaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portaria` (
  `email` varchar(144) NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_portaria_usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portaria`
--

LOCK TABLES `portaria` WRITE;
/*!40000 ALTER TABLE `portaria` DISABLE KEYS */;
INSERT INTO `portaria` VALUES ('cerberus@ifpr.edu.br'),('gandalf@ifpr.edu.br');
/*!40000 ALTER TABLE `portaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recado`
--

DROP TABLE IF EXISTS `recado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recado` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(144) NOT NULL,
  `recado` varchar(1000) NOT NULL,
  `data` date NOT NULL,
  `validade` date DEFAULT NULL,
  `sepae_email` varchar(144) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recado_sepae1_idx` (`sepae_email`),
  CONSTRAINT `fk_recado_sepae1` FOREIGN KEY (`sepae_email`) REFERENCES `sepae` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recado`
--

LOCK TABLES `recado` WRITE;
/*!40000 ALTER TABLE `recado` DISABLE KEYS */;
INSERT INTO `recado` VALUES (47,'Bom dia','Boa tarde e \nBoa noite','2024-07-04','2024-07-05','nereu.filho@ifpr.edu.br'),(48,'[ERRATA] Bom dia','Boa Tarde e \nBoa Noite','2024-07-04','2024-07-05','nereu.filho@ifpr.edu.br');
/*!40000 ALTER TABLE `recado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavel`
--

DROP TABLE IF EXISTS `responsavel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsavel` (
  `email` varchar(144) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_responsavel_usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel`
--

LOCK TABLES `responsavel` WRITE;
/*!40000 ALTER TABLE `responsavel` DISABLE KEYS */;
INSERT INTO `responsavel` VALUES ('charliebrown@gmail.com','98765432100'),('eggman.robotnik@gmail.com','12345678912'),('francesco.bernoulli@gmail.com','12345678935'),('franklin@gmail.com','45612398700'),('king.boo@gmail.com','12345678944'),('kratos@gmail.com','12345678933'),('linus@gmail.com','55555555501'),('lucy@gmail.com','12345678901'),('marcie@gmail.com','12398745600'),('neymar.junior@gmail.com','56345678977'),('peppermint@gmail.com','24681357900'),('peppermintfriend@gmail.com','98712398700'),('pigpen@gmail.com','45698712300'),('rerun@gmail.com','98745612300'),('sallybrown@gmail.com','12398712300'),('schroeder@gmail.com','13579246801'),('snoopy@gmail.com','13136465468'),('woodstock@gmail.com','98712345600');
/*!40000 ALTER TABLE `responsavel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavel_has_aluno`
--

DROP TABLE IF EXISTS `responsavel_has_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsavel_has_aluno` (
  `aluno_id` int NOT NULL,
  `responsavel_email` varchar(144) NOT NULL,
  PRIMARY KEY (`aluno_id`,`responsavel_email`),
  KEY `fk_responsavel_has_alunos_alunos1_idx` (`aluno_id`),
  KEY `fk_responsavel_has_aluno_responsavel1_idx` (`responsavel_email`),
  CONSTRAINT `fk_responsavel_has_aluno_responsavel1` FOREIGN KEY (`responsavel_email`) REFERENCES `responsavel` (`email`),
  CONSTRAINT `fk_responsavel_has_alunos_alunos1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel_has_aluno`
--

LOCK TABLES `responsavel_has_aluno` WRITE;
/*!40000 ALTER TABLE `responsavel_has_aluno` DISABLE KEYS */;
INSERT INTO `responsavel_has_aluno` VALUES (1,'kratos@gmail.com'),(2,'eggman.robotnik@gmail.com'),(3,'neymar.junior@gmail.com'),(4,'king.boo@gmail.com'),(5,'francesco.bernoulli@gmail.com'),(6,'francesco.bernoulli@gmail.com'),(7,'kratos@gmail.com'),(8,'eggman.robotnik@gmail.com'),(10,'neymar.junior@gmail.com'),(11,'snoopy@gmail.com'),(12,'lucy@gmail.com'),(13,'marcie@gmail.com'),(14,'peppermint@gmail.com'),(15,'peppermintfriend@gmail.com'),(16,'pigpen@gmail.com'),(17,'rerun@gmail.com'),(18,'sallybrown@gmail.com'),(19,'schroeder@gmail.com'),(20,'linus@gmail.com'),(21,'woodstock@gmail.com'),(22,'neymar.junior@gmail.com'),(23,'lucy@gmail.com'),(24,'marcie@gmail.com'),(25,'peppermint@gmail.com'),(26,'peppermintfriend@gmail.com'),(27,'pigpen@gmail.com'),(28,'rerun@gmail.com'),(29,'sallybrown@gmail.com'),(30,'schroeder@gmail.com');
/*!40000 ALTER TABLE `responsavel_has_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavel_libera_aluno`
--

DROP TABLE IF EXISTS `responsavel_libera_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsavel_libera_aluno` (
  `aluno_id` int NOT NULL,
  `data` datetime NOT NULL,
  `horario_saida` datetime DEFAULT NULL,
  `motivo_id` int NOT NULL,
  `responsavel_email` varchar(144) NOT NULL,
  PRIMARY KEY (`aluno_id`,`data`,`responsavel_email`),
  KEY `fk_tbResponsavel_has_tbAlunos_tbAlunos1_idx` (`aluno_id`),
  KEY `fk_responsavel_libera_aluno_motivo1_idx` (`motivo_id`),
  KEY `fk_responsavel_libera_aluno_responsavel1_idx` (`responsavel_email`),
  CONSTRAINT `fk_responsavel_libera_aluno_motivo1` FOREIGN KEY (`motivo_id`) REFERENCES `motivo` (`id`),
  CONSTRAINT `fk_responsavel_libera_aluno_responsavel1` FOREIGN KEY (`responsavel_email`) REFERENCES `responsavel` (`email`),
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbAlunos1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel_libera_aluno`
--

LOCK TABLES `responsavel_libera_aluno` WRITE;
/*!40000 ALTER TABLE `responsavel_libera_aluno` DISABLE KEYS */;
INSERT INTO `responsavel_libera_aluno` VALUES (4,'2024-07-04 00:00:00','2024-07-04 12:33:48',6,'kratos@gmail.com');
/*!40000 ALTER TABLE `responsavel_libera_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepae`
--

DROP TABLE IF EXISTS `sepae`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sepae` (
  `email` varchar(144) NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_sepae_usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sepae`
--

LOCK TABLES `sepae` WRITE;
/*!40000 ALTER TABLE `sepae` DISABLE KEYS */;
INSERT INTO `sepae` VALUES ('direcao.ensino.pinhais@ifpr.edu.br'),('eduardo.tieppo@ifpr.edu.br'),('francisco.kuhn@ifpr.edu.br'),('nereu.filho@ifpr.edu.br'),('tatiana.niwa@ifpr.edu.br');
/*!40000 ALTER TABLE `sepae` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepae_libera_aluno`
--

DROP TABLE IF EXISTS `sepae_libera_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sepae_libera_aluno` (
  `aluno_id` int NOT NULL,
  `data` datetime NOT NULL,
  `horario_saida` datetime DEFAULT NULL,
  `motivo_id` int NOT NULL,
  `sepae_email` varchar(144) NOT NULL,
  PRIMARY KEY (`aluno_id`,`data`,`sepae_email`),
  KEY `fk_tbSepae_has_tbAlunos_tbAlunos1_idx` (`aluno_id`),
  KEY `fk_sepae_libera_aluno_motivo1_idx` (`motivo_id`),
  KEY `fk_sepae_libera_aluno_sepae1_idx` (`sepae_email`),
  CONSTRAINT `fk_sepae_libera_aluno_motivo1` FOREIGN KEY (`motivo_id`) REFERENCES `motivo` (`id`),
  CONSTRAINT `fk_sepae_libera_aluno_sepae1` FOREIGN KEY (`sepae_email`) REFERENCES `sepae` (`email`),
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbAlunos1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sepae_libera_aluno`
--

LOCK TABLES `sepae_libera_aluno` WRITE;
/*!40000 ALTER TABLE `sepae_libera_aluno` DISABLE KEYS */;
INSERT INTO `sepae_libera_aluno` VALUES (2,'2024-07-04 12:24:26','2024-07-04 12:33:42',1,'nereu.filho@ifpr.edu.br'),(8,'2024-07-04 12:24:32','2024-07-04 12:33:35',1,'nereu.filho@ifpr.edu.br'),(10,'2024-07-04 12:24:38','2024-07-04 12:33:23',1,'nereu.filho@ifpr.edu.br'),(15,'2024-07-04 12:24:32','2024-07-04 12:33:37',1,'nereu.filho@ifpr.edu.br'),(16,'2024-07-04 12:24:26','2024-07-04 12:33:44',1,'nereu.filho@ifpr.edu.br'),(19,'2024-07-04 12:24:38','2024-07-04 12:33:31',1,'nereu.filho@ifpr.edu.br'),(24,'2024-07-04 12:24:32','2024-07-04 12:33:40',1,'nereu.filho@ifpr.edu.br'),(25,'2024-07-04 12:24:26','2024-07-04 12:33:46',1,'nereu.filho@ifpr.edu.br'),(28,'2024-07-04 12:24:38','2024-07-04 12:33:33',1,'nereu.filho@ifpr.edu.br');
/*!40000 ALTER TABLE `sepae_libera_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turma`
--

DROP TABLE IF EXISTS `turma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `turma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `turma` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turma`
--

LOCK TABLES `turma` WRITE;
/*!40000 ALTER TABLE `turma` DISABLE KEYS */;
INSERT INTO `turma` VALUES (1,'ADM1'),(2,'ADM2'),(3,'ADM3'),(4,'ADM4'),(5,'INFO1'),(6,'INFO2'),(7,'INFO3'),(8,'INFO4');
/*!40000 ALTER TABLE `turma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `email` varchar(144) NOT NULL,
  `nome` varchar(144) NOT NULL,
  `senha` varchar(144) NOT NULL,
  `foto_path` varchar(144) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('cerberus@ifpr.edu.br','Cérbero Hades','$2y$10$SoQnabBBJNLzjJJW4AC3Ke4qBTq1u/6pWK7CwJKHo5gpC..7qB3BO','static/cerberus.jpg'),('charliebrown@gmail.com','Charlie Brown','#hash','nenhum'),('direcao.ensino.pinhais@ifpr.edu.br','Andrius Felipe Roque','$2y$10$k5DHEoynkqFJPa1lBi2SdeZleWE1xsahGj4ye/9qFY8csdOdJ1bMa','static/andrius.jpg'),('eduardo.tieppo@ifpr.edu.br','Eduardo Tieppo','$2y$10$wF4GS2MC/DxZ8HMh0nZzH.VUQH5kl38/Z8g/hCKXioF8E.B7Ryxlq','static/tieppo.png'),('eggman.robotnik@gmail.com','Dr. Eggman','#hash','nenhum'),('francesco.bernoulli@gmail.com','Francesco Bernoulli','#hash','nenhum'),('francisco.kuhn@ifpr.edu.br','Francisco Fernando Kühn','$2y$10$71NRrFV9nkfZudK8ypXdVefiAUgbVjMlKlxjeZ392Rax2HY.5nwOi','static/chicao.jpg'),('franklin@gmail.com','Franklin','#hash','nenhum'),('gandalf@ifpr.edu.br','Gandalf Cinza','$2y$10$u.SkNK.GVVC9LUvuTja7WeI0mrNCsYh7XWCNu.BU7lTE7pOJZnFze','static/gandalf.jpg'),('king.boo@gmail.com','King Boo','#hash','nenhum'),('kratos@gmail.com','Bom de Guerra','#hash','nenhum'),('linus@gmail.com','Linus van Pelt','#hash','nenhum'),('lucy@gmail.com','Lucy van Pelt','#hash','nenhum'),('marcie@gmail.com','Marcie','#hash','nenhum'),('nereu.filho@ifpr.edu.br','Nereu da Silva Filho','$2y$10$mSuU.LpMxc9yU/NBD9VP9ejSs236lr0jBKMROOHNs6V.AzxaDlg1G','static/nereu.jpg'),('neymar.junior@gmail.com','Neymar Jr.','$hash','nenhum'),('peppermint@gmail.com','Peppermint Patty','#hash','nenhum'),('peppermintfriend@gmail.com','Peppermint Patty\'s Friend','#hash','nenhum'),('pigpen@gmail.com','Pig-Pen','#hash','nenhum'),('rerun@gmail.com','Rerun','#hash','nenhum'),('sallybrown@gmail.com','Sally Brown','#hash','nenhum'),('schroeder@gmail.com','Schroeder','#hash','nenhum'),('snoopy@gmail.com','Snoopy','#hash','nenhum'),('tatiana.niwa@ifpr.edu.br','Tatiana Mayumi Niwa','$2y$10$rtNhkl2aaKL4v/ab8JtiA.sy8.3yEkuC4eqJC6QyxCt4UmrISSU1u','static/tati.jpg'),('woodstock@gmail.com','Woodstock','#hash','nenhum');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sepaisdb'
--

--
-- Dumping routines for database 'sepaisdb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-04 12:35:45

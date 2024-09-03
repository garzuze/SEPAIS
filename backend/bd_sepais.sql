CREATE DATABASE  IF NOT EXISTS `sepaisdb` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sepaisdb`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sepaisdb
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'Mateus','nenhum',1),(2,'Mariana','nenhum',4),(3,'Paulo','nenhum',5),(4,'Luan','nenhum',6),(5,'Mario','nenhum',2),(6,'Luigi','nenhum',2),(7,'Wario','nenhum',3),(8,'Waluigi','nenhum',7),(10,'Sonic','nenhum',8),(11,'Bart Simpson','nenhum',2),(12,'Homer Simpson','nenhum',5),(13,'Marge Simpson','nenhum',1),(14,'Lisa Simpson','nenhum',3),(15,'Maggie Simpson','nenhum',7),(16,'Ned Flanders','nenhum',4),(17,'Moe Szyslak','nenhum',6),(18,'Apu Nahasapeemapetilon','nenhum',3),(19,'Krusty the Clown','nenhum',8),(20,'Barney Gumble','nenhum',5),(21,'Chief Wiggum','nenhum',2),(22,'Mr. Burns','nenhum',1),(23,'Ned Flanders','nenhum',6),(24,'Sideshow Bob','nenhum',7),(25,'Groundskeeper Willie','nenhum',4),(26,'Professor Frink','nenhum',2),(27,'Waylon Smithers','nenhum',3),(28,'Selma Bouvier','nenhum',8),(29,'Squeaky-Voiced Teen','nenhum',1),(30,'Kang and Kodos','nenhum',5),(31,'Lara Croft','static/default_user_icon.jpg',4),(32,'Sherlock Holmes','static/default_user_icon.jpg',1),(33,'Geralt Da Rívia','static/default_user_icon.jpg',7),(34,'Frodo Bolseiro','static/default_user_icon.jpg',8),(35,'Samwise Gamgee','static/default_user_icon.jpg',9),(36,'Luke Skywalker','static/default_user_icon.jpg',9),(37,'Leia Organa','static/default_user_icon.jpg',10);
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
INSERT INTO `aluno_atrasado` VALUES (2,'2024-07-04 12:26:02','cerberus@ifpr.edu.br'),(5,'2024-07-04 12:25:47','cerberus@ifpr.edu.br'),(8,'2024-07-04 12:25:59','cerberus@ifpr.edu.br'),(10,'2024-07-04 12:25:51','cerberus@ifpr.edu.br'),(11,'2024-07-04 12:25:34','cerberus@ifpr.edu.br'),(17,'2024-07-04 12:25:56','cerberus@ifpr.edu.br'),(19,'2024-07-04 12:25:53','cerberus@ifpr.edu.br'),(21,'2024-07-04 12:25:45','cerberus@ifpr.edu.br'),(26,'2024-07-04 12:25:49','cerberus@ifpr.edu.br'),(33,'2024-08-25 03:30:50','gandalf@ifpr.edu.br'),(34,'2024-08-25 21:51:58','gandalf@ifpr.edu.br'),(35,'2024-08-25 21:51:54','gandalf@ifpr.edu.br');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivo`
--

LOCK TABLES `motivo` WRITE;
/*!40000 ALTER TABLE `motivo` DISABLE KEYS */;
INSERT INTO `motivo` VALUES (1,'Luto'),(2,'Médico'),(3,'Transporte'),(4,'Mal-estar'),(5,'Motivo particular'),(6,'Professor faltou'),(7,'Aula acabou mais cedo'),(8,'Caiu do céu');
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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recado`
--

LOCK TABLES `recado` WRITE;
/*!40000 ALTER TABLE `recado` DISABLE KEYS */;
INSERT INTO `recado` VALUES (47,'Bom dia','Boa tarde e \nBoa noite','2024-07-04','2024-07-05','nereu.filho@ifpr.edu.br'),(48,'[ERRATA] Bom dia','Boa Tarde e \nBoa Noite','2024-07-04','2024-07-05','nereu.filho@ifpr.edu.br'),(49,'Time','All we have to decide is what to do with the time that is given to us.','2024-08-21','2024-08-30','tatiana.niwa@ifpr.edu.br'),(50,'A wizard is never late','A wizard is never late, nor is he early, he arrives precisely when he means to.','2024-08-21',NULL,'tatiana.niwa@ifpr.edu.br'),(51,'Judgment','Many that live deserve death. And some that die deserve life. Can you give it to them? Then do not be too eager to deal out death in judgment.','2024-08-21',NULL,'tatiana.niwa@ifpr.edu.br');
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
  `telefone` varchar(11) NOT NULL,
  PRIMARY KEY (`email`),
  CONSTRAINT `fk_responsavel_usuario1` FOREIGN KEY (`email`) REFERENCES `usuario` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel`
--

LOCK TABLES `responsavel` WRITE;
/*!40000 ALTER TABLE `responsavel` DISABLE KEYS */;
INSERT INTO `responsavel` VALUES ('bilbo.bolseiro@ifpr.edu.br','11768970088'),('bonnie@hotmail.com','11321312313'),('charliebrown@gmail.com','98765432100'),('chica@yahoo.com','33333333333'),('darth.vader@gmail.com','31545364564'),('eggman.robotnik@gmail.com','12345678912'),('foxy@gmail.com','41777777777'),('francesco.bernoulli@gmail.com','12345678935'),('franklin@gmail.com','45612398700'),('hermione.granger@hogwarts.edu.br','21912345678'),('king.boo@gmail.com','12345678944'),('kratos@gmail.com','12345678933'),('linus@gmail.com','55555555501'),('lucy@gmail.com','12345678901'),('marcie@gmail.com','12398745600'),('neymar.junior@gmail.com','56345678977'),('peppermint@gmail.com','24681357900'),('peppermintfriend@gmail.com','98712398700'),('pigpen@gmail.com','45698712300'),('rerun@gmail.com','98745612300'),('ruce.wayne@gothamcorp.com','11987654321'),('sallybrown@gmail.com','12398712300'),('schroeder@gmail.com','13579246801'),('scooby.doo@gmail.com','42113325534'),('snoopy@gmail.com','13136465468'),('tony.stark@starkindustries.com','31998765432'),('woodstock@gmail.com','98712345600');
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
INSERT INTO `responsavel_has_aluno` VALUES (1,'chica@yahoo.com'),(1,'kratos@gmail.com'),(2,'chica@yahoo.com'),(2,'eggman.robotnik@gmail.com'),(2,'hermione.granger@hogwarts.edu.br'),(3,'eggman.robotnik@gmail.com'),(3,'kratos@gmail.com'),(3,'neymar.junior@gmail.com'),(3,'peppermint@gmail.com'),(4,'foxy@gmail.com'),(4,'king.boo@gmail.com'),(4,'kratos@gmail.com'),(5,'francesco.bernoulli@gmail.com'),(5,'kratos@gmail.com'),(6,'chica@yahoo.com'),(6,'francesco.bernoulli@gmail.com'),(7,'kratos@gmail.com'),(8,'eggman.robotnik@gmail.com'),(8,'kratos@gmail.com'),(10,'chica@yahoo.com'),(10,'hermione.granger@hogwarts.edu.br'),(10,'neymar.junior@gmail.com'),(11,'snoopy@gmail.com'),(12,'bonnie@hotmail.com'),(12,'chica@yahoo.com'),(12,'lucy@gmail.com'),(13,'marcie@gmail.com'),(14,'peppermint@gmail.com'),(15,'chica@yahoo.com'),(15,'peppermintfriend@gmail.com'),(16,'eggman.robotnik@gmail.com'),(16,'franklin@gmail.com'),(16,'pigpen@gmail.com'),(17,'rerun@gmail.com'),(18,'franklin@gmail.com'),(18,'sallybrown@gmail.com'),(19,'schroeder@gmail.com'),(20,'linus@gmail.com'),(21,'woodstock@gmail.com'),(22,'neymar.junior@gmail.com'),(23,'chica@yahoo.com'),(23,'lucy@gmail.com'),(24,'marcie@gmail.com'),(25,'peppermint@gmail.com'),(26,'peppermintfriend@gmail.com'),(27,'pigpen@gmail.com'),(28,'rerun@gmail.com'),(29,'bonnie@hotmail.com'),(29,'sallybrown@gmail.com'),(30,'schroeder@gmail.com'),(31,'foxy@gmail.com'),(31,'schroeder@gmail.com'),(33,'marcie@gmail.com'),(33,'scooby.doo@gmail.com'),(34,'bilbo.bolseiro@ifpr.edu.br'),(35,'bilbo.bolseiro@ifpr.edu.br'),(36,'darth.vader@gmail.com'),(37,'darth.vader@gmail.com');
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
INSERT INTO `responsavel_libera_aluno` VALUES (4,'2024-07-04 00:00:00','2024-07-04 12:33:48',6,'kratos@gmail.com'),(10,'2024-09-03 14:50:00','2024-09-03 14:51:00',5,'neymar.junior@gmail.com'),(28,'2024-08-21 00:00:00','2024-08-21 19:19:51',3,'neymar.junior@gmail.com'),(30,'2024-08-21 00:00:00','2024-08-21 19:19:53',4,'neymar.junior@gmail.com');
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
  `isAutorizado` tinyint(1) DEFAULT '0',
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
INSERT INTO `sepae_libera_aluno` VALUES (1,'2024-08-22 20:26:54',NULL,6,'tatiana.niwa@ifpr.edu.br',1),(1,'2024-09-03 14:31:04','2024-09-03 14:50:03',8,'nereu.filho@ifpr.edu.br',1),(2,'2024-07-04 12:24:26','2024-07-04 12:33:42',1,'nereu.filho@ifpr.edu.br',0),(2,'2024-08-22 20:27:12',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(2,'2024-08-23 18:43:13',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(3,'2024-08-21 15:49:06','2024-08-21 19:16:39',7,'tatiana.niwa@ifpr.edu.br',0),(3,'2024-08-22 20:27:17',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(3,'2024-08-23 18:42:20',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(4,'2024-08-21 15:49:00','2024-08-21 19:16:47',7,'tatiana.niwa@ifpr.edu.br',0),(4,'2024-08-22 20:27:21',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(5,'2024-08-22 20:26:45',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(6,'2024-08-22 20:26:45',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(7,'2024-08-21 15:48:50','2024-08-21 19:16:55',7,'tatiana.niwa@ifpr.edu.br',0),(7,'2024-08-22 20:27:08',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(7,'2024-08-23 18:43:17',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(8,'2024-07-04 12:24:32','2024-07-04 12:33:35',1,'nereu.filho@ifpr.edu.br',0),(8,'2024-08-21 15:48:55','2024-08-21 19:16:50',7,'tatiana.niwa@ifpr.edu.br',0),(8,'2024-08-22 20:27:25',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(8,'2024-08-23 18:42:48',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(8,'2024-08-25 03:30:22','2024-08-25 03:30:40',7,'tatiana.niwa@ifpr.edu.br',0),(8,'2024-09-03 14:30:59','2024-09-03 14:51:01',4,'nereu.filho@ifpr.edu.br',1),(10,'2024-07-04 12:24:38','2024-07-04 12:33:23',1,'nereu.filho@ifpr.edu.br',0),(10,'2024-08-22 20:26:49',NULL,4,'tatiana.niwa@ifpr.edu.br',0),(10,'2024-08-23 18:42:29',NULL,5,'tatiana.niwa@ifpr.edu.br',0),(11,'2024-08-22 20:26:45',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(12,'2024-08-21 15:49:06','2024-08-21 19:16:41',7,'tatiana.niwa@ifpr.edu.br',0),(12,'2024-08-22 20:27:17',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(12,'2024-08-23 18:42:20',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(13,'2024-08-22 20:26:54',NULL,6,'tatiana.niwa@ifpr.edu.br',1),(13,'2024-09-03 14:31:04','2024-09-03 14:50:05',8,'nereu.filho@ifpr.edu.br',1),(14,'2024-08-21 15:48:50','2024-08-21 19:16:58',7,'tatiana.niwa@ifpr.edu.br',0),(14,'2024-08-22 20:27:08',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(14,'2024-08-23 18:43:17',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(15,'2024-07-04 12:24:32','2024-07-04 12:33:37',1,'nereu.filho@ifpr.edu.br',0),(15,'2024-08-21 15:48:55','2024-08-21 19:16:52',7,'tatiana.niwa@ifpr.edu.br',0),(15,'2024-08-22 20:27:25',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(15,'2024-08-23 18:42:48',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(15,'2024-08-25 03:30:22','2024-08-25 03:30:44',7,'tatiana.niwa@ifpr.edu.br',0),(15,'2024-09-03 14:30:59',NULL,4,'nereu.filho@ifpr.edu.br',0),(16,'2024-07-04 12:24:26','2024-07-04 12:33:44',1,'nereu.filho@ifpr.edu.br',0),(16,'2024-08-22 20:27:12',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(16,'2024-08-23 18:43:13',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(17,'2024-08-21 15:49:00','2024-08-21 19:16:46',7,'tatiana.niwa@ifpr.edu.br',0),(17,'2024-08-22 20:27:21',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(18,'2024-08-21 15:48:50','2024-08-21 19:16:56',7,'tatiana.niwa@ifpr.edu.br',0),(18,'2024-08-22 20:27:08',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(18,'2024-08-23 18:43:17',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(19,'2024-07-04 12:24:38','2024-07-04 12:33:31',1,'nereu.filho@ifpr.edu.br',0),(19,'2024-08-22 20:26:49',NULL,4,'tatiana.niwa@ifpr.edu.br',0),(19,'2024-08-23 18:42:29',NULL,5,'tatiana.niwa@ifpr.edu.br',0),(20,'2024-08-21 15:49:06','2024-08-21 19:16:43',7,'tatiana.niwa@ifpr.edu.br',0),(20,'2024-08-22 20:27:17',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(20,'2024-08-23 18:42:20',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(21,'2024-08-22 20:26:45',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(22,'2024-08-22 20:26:54',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(22,'2024-09-03 14:31:04','2024-09-03 14:50:07',8,'nereu.filho@ifpr.edu.br',1),(23,'2024-08-21 15:49:00','2024-08-21 19:16:49',7,'tatiana.niwa@ifpr.edu.br',0),(23,'2024-08-22 20:27:21',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(24,'2024-07-04 12:24:32','2024-07-04 12:33:40',1,'nereu.filho@ifpr.edu.br',0),(24,'2024-08-21 15:48:55','2024-08-21 19:16:53',7,'tatiana.niwa@ifpr.edu.br',0),(24,'2024-08-22 20:27:25',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(24,'2024-08-23 18:42:48',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(24,'2024-08-25 03:30:22','2024-08-25 03:30:46',7,'tatiana.niwa@ifpr.edu.br',0),(24,'2024-09-03 14:30:59',NULL,4,'nereu.filho@ifpr.edu.br',0),(25,'2024-07-04 12:24:26','2024-07-04 12:33:46',1,'nereu.filho@ifpr.edu.br',0),(25,'2024-08-22 20:27:12',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(25,'2024-08-23 18:43:13',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(26,'2024-08-22 20:26:45',NULL,3,'tatiana.niwa@ifpr.edu.br',0),(27,'2024-08-21 15:48:50','2024-08-21 19:17:00',7,'tatiana.niwa@ifpr.edu.br',0),(27,'2024-08-22 20:27:08',NULL,7,'tatiana.niwa@ifpr.edu.br',0),(27,'2024-08-23 18:43:17',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(28,'2024-07-04 12:24:38','2024-07-04 12:33:33',1,'nereu.filho@ifpr.edu.br',0),(28,'2024-08-22 20:26:49',NULL,4,'tatiana.niwa@ifpr.edu.br',0),(28,'2024-08-23 18:42:29',NULL,5,'tatiana.niwa@ifpr.edu.br',0),(29,'2024-08-22 20:26:54',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(29,'2024-09-03 14:31:04','2024-09-03 14:50:09',8,'nereu.filho@ifpr.edu.br',1),(30,'2024-08-21 15:49:06','2024-08-21 19:19:53',7,'tatiana.niwa@ifpr.edu.br',0),(30,'2024-08-22 20:27:17',NULL,6,'tatiana.niwa@ifpr.edu.br',0),(30,'2024-08-23 18:42:20',NULL,2,'tatiana.niwa@ifpr.edu.br',0),(33,'2024-08-25 03:30:22','2024-08-25 03:30:36',7,'tatiana.niwa@ifpr.edu.br',0),(33,'2024-09-03 14:30:59',NULL,4,'nereu.filho@ifpr.edu.br',0),(34,'2024-08-25 21:51:21','2024-08-25 21:51:48',6,'tatiana.niwa@ifpr.edu.br',0),(35,'2024-08-25 21:51:13','2024-08-25 21:51:50',2,'tatiana.niwa@ifpr.edu.br',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turma`
--

LOCK TABLES `turma` WRITE;
/*!40000 ALTER TABLE `turma` DISABLE KEYS */;
INSERT INTO `turma` VALUES (1,'ADM1'),(2,'ADM2'),(3,'ADM3'),(4,'ADM4'),(5,'INFO1'),(6,'INFO2'),(7,'INFO3'),(8,'INFO4'),(9,'BCC1'),(10,'GTI1');
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
  `senha` varchar(144) DEFAULT NULL,
  `foto_path` varchar(144) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('bilbo.bolseiro@ifpr.edu.br','Bilbo Bolseiro',NULL,'static/default_user_icon.jpg'),('bonnie@hotmail.com','Bonnie Bunnie',NULL,'static/default_user_icon.jpg'),('cerberus@ifpr.edu.br','Cérbero Hades','$2y$10$SoQnabBBJNLzjJJW4AC3Ke4qBTq1u/6pWK7CwJKHo5gpC..7qB3BO','static/cerberus.jpg'),('charliebrown@gmail.com','Charlie Brown','#hash','nenhum'),('chica@yahoo.com','Chica Chicken',NULL,'static/default_user_icon.jpg'),('darth.vader@gmail.com','Darth Vader',NULL,'static/default_user_icon.jpg'),('direcao.ensino.pinhais@ifpr.edu.br','Andrius Felipe Roque','$2y$10$k5DHEoynkqFJPa1lBi2SdeZleWE1xsahGj4ye/9qFY8csdOdJ1bMa','static/andrius.jpg'),('eduardo.tieppo@ifpr.edu.br','Eduardo Tieppo','$2y$10$wF4GS2MC/DxZ8HMh0nZzH.VUQH5kl38/Z8g/hCKXioF8E.B7Ryxlq','static/tieppo.png'),('eggman.robotnik@gmail.com','Dr. Eggman','#hash','nenhum'),('foxy@gmail.com','Foxy Pirate',NULL,'static/default_user_icon.jpg'),('francesco.bernoulli@gmail.com','Francesco Bernoulli','#hash','nenhum'),('francisco.kuhn@ifpr.edu.br','Francisco Fernando Kühn','$2y$10$71NRrFV9nkfZudK8ypXdVefiAUgbVjMlKlxjeZ392Rax2HY.5nwOi','static/chicao.jpg'),('franklin@gmail.com','Franklin','#hash','nenhum'),('gandalf@ifpr.edu.br','Gandalf Cinza','$2y$10$u.SkNK.GVVC9LUvuTja7WeI0mrNCsYh7XWCNu.BU7lTE7pOJZnFze','static/gandalf.jpg'),('hermione.granger@hogwarts.edu.br','Hermione Granger',NULL,'static/default_user_icon.jpg'),('king.boo@gmail.com','King Boo','#hash','nenhum'),('kratos@gmail.com','Bom de Guerra','#hash','nenhum'),('linus@gmail.com','Linus van Pelt','#hash','nenhum'),('lucy@gmail.com','Lucy van Pelt','#hash','nenhum'),('marcie@gmail.com','Marcie','#hash','nenhum'),('nereu.filho@ifpr.edu.br','Nereu da Silva Filho','$2y$10$mSuU.LpMxc9yU/NBD9VP9ejSs236lr0jBKMROOHNs6V.AzxaDlg1G','static/nereu.jpg'),('neymar.junior@gmail.com','Neymar Jr.','$hash','nenhum'),('peppermint@gmail.com','Peppermint Patty','#hash','nenhum'),('peppermintfriend@gmail.com','Peppermint Patty\'s Friend','#hash','nenhum'),('pigpen@gmail.com','Pig-Pen','#hash','nenhum'),('rerun@gmail.com','Rerun','#hash','nenhum'),('ruce.wayne@gothamcorp.com','Bruce Wayne',NULL,'static/default_user_icon.jpg'),('sallybrown@gmail.com','Sally Brown','#hash','nenhum'),('schroeder@gmail.com','Schroeder','#hash','nenhum'),('scooby.doo@gmail.com','Scooby Doo',NULL,'static/default_user_icon.jpg'),('snoopy@gmail.com','Snoopy','#hash','nenhum'),('tatiana.niwa@ifpr.edu.br','Tatiana Mayumi Niwa','$2y$10$rtNhkl2aaKL4v/ab8JtiA.sy8.3yEkuC4eqJC6QyxCt4UmrISSU1u','static/tati.jpg'),('tony.stark@starkindustries.com','Tony Stark',NULL,'static/default_user_icon.jpg'),('woodstock@gmail.com','Woodstock','#hash','nenhum');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `viewname`
--

DROP TABLE IF EXISTS `viewname`;
/*!50001 DROP VIEW IF EXISTS `viewname`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `viewname` AS SELECT 
 1 AS `email`,
 1 AS `nome`,
 1 AS `telefone`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'sepaisdb'
--

--
-- Dumping routines for database 'sepaisdb'
--

--
-- Final view structure for view `viewname`
--

/*!50001 DROP VIEW IF EXISTS `viewname`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewname` AS select `responsavel`.`email` AS `email`,`usuario`.`nome` AS `nome`,`responsavel`.`telefone` AS `telefone` from (`usuario` join `responsavel`) where (`usuario`.`email` = `responsavel`.`email`) order by `responsavel`.`email` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-03 14:53:38

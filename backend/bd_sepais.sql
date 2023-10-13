CREATE DATABASE  IF NOT EXISTS `sepaisdb` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sepaisdb`;
-- MySQL dump 10.13  Distrib 8.0.32, for Win64 (x86_64)
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'Mateus','nenhum',1),(2,'Mariana','nenhum',4),(3,'Paulo','nenhum',5),(4,'Luan','nenhum',6),(5,'Mario','nenhum',2),(6,'Luigi','nenhum',2),(7,'Wario','nenhum',3),(8,'Waluigi','nenhum',7),(9,'Waluigi','nenhum',7),(10,'Sonic','nenhum',8);
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `aluno_liberado_responsavel`
--

DROP TABLE IF EXISTS `aluno_liberado_responsavel`;
/*!50001 DROP VIEW IF EXISTS `aluno_liberado_responsavel`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `aluno_liberado_responsavel` AS SELECT 
 1 AS `Aluno`,
 1 AS `Turma`,
 1 AS `Motivo`,
 1 AS `Responsável`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `aluno_liberado_sepae`
--

DROP TABLE IF EXISTS `aluno_liberado_sepae`;
/*!50001 DROP VIEW IF EXISTS `aluno_liberado_sepae`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `aluno_liberado_sepae` AS SELECT 
 1 AS `Aluno`,
 1 AS `Turma`,
 1 AS `Motivo`,
 1 AS `Servidor`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `aluno_responsavel`
--

DROP TABLE IF EXISTS `aluno_responsavel`;
/*!50001 DROP VIEW IF EXISTS `aluno_responsavel`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `aluno_responsavel` AS SELECT 
 1 AS `Responsável`,
 1 AS `Aluno`,
 1 AS `Turma`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `alunos_visualizar`
--

DROP TABLE IF EXISTS `alunos_visualizar`;
/*!50001 DROP VIEW IF EXISTS `alunos_visualizar`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `alunos_visualizar` AS SELECT 
 1 AS `id`,
 1 AS `Nome`,
 1 AS `Turma`,
 1 AS `Foto`*/;
SET character_set_client = @saved_cs_client;

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
  `username` varchar(45) NOT NULL,
  `nome` varchar(144) NOT NULL,
  `senha` varchar(144) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portaria`
--

LOCK TABLES `portaria` WRITE;
/*!40000 ALTER TABLE `portaria` DISABLE KEYS */;
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
  `sepae_username` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbRecados_tbSepae1_idx` (`sepae_username`),
  CONSTRAINT `fk_tbRecados_tbSepae1` FOREIGN KEY (`sepae_username`) REFERENCES `sepae` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recado`
--

LOCK TABLES `recado` WRITE;
/*!40000 ALTER TABLE `recado` DISABLE KEYS */;
INSERT INTO `recado` VALUES (1,'Reunião do Pais','A reunião dos pais vai acontecer nesta sexta-feira','2023-10-05','2023-10-14','Neras'),(2,'Semana Científica','A semana científica ira acontecer dos dias 11/10 a 13/10. Se divirta!','2023-10-06','2023-10-14','Chicão'),(3,'Boas Vindas','Boas vindas ao Instituto Federal','2023-02-15',NULL,'Neras'),(4,'Rematrícula','Realize a rematrícula o quanto antes','2023-02-15','2023-03-01','Chicão'),(5,'Processo Seletivo – Curso de Especialização em Estudos da Linguagem','Informações importantes: Inscrição: de 04 até 24 de outubro – online por meio de formulário eletrônico; Custo: gratuito – sem taxa de inscrição ou cobrança de mensalidades. Duração do Curso: 12 meses, com início no 1º semestre de 2024; Oferta: 30 vagas; Modalidade: semipresencial, com aulas nas segundas e quartas-feiras, das 18:30 às 22:30 no Campus Pinhais do IFPR.','2023-10-09','2023-10-25','Tati');
/*!40000 ALTER TABLE `recado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `recados`
--

DROP TABLE IF EXISTS `recados`;
/*!50001 DROP VIEW IF EXISTS `recados`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `recados` AS SELECT 
 1 AS `Título`,
 1 AS `Recado`,
 1 AS `Data`,
 1 AS `Enviado_por`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `responsavel`
--

DROP TABLE IF EXISTS `responsavel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsavel` (
  `email` varchar(144) NOT NULL,
  `nome` varchar(144) NOT NULL,
  `senha` varchar(144) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel`
--

LOCK TABLES `responsavel` WRITE;
/*!40000 ALTER TABLE `responsavel` DISABLE KEYS */;
INSERT INTO `responsavel` VALUES ('eggman.robotnik@gmail.com','Dr. Eggman','$hash','12345678912'),('francesco.bernoulli@gmail.com','Francesco Bernoulli','$hash','12345678944'),('king.boo@gmail.com','King Boo','$hash','12345678922'),('kratos@gmail.com','Bom de Guerra','$hash','12345678933'),('neymar.junior@gmail.com','Neymar Jr.','$hash','12345678955');
/*!40000 ALTER TABLE `responsavel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavel_has_aluno`
--

DROP TABLE IF EXISTS `responsavel_has_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsavel_has_aluno` (
  `responsavel_email` varchar(144) NOT NULL,
  `aluno_id` int NOT NULL,
  PRIMARY KEY (`responsavel_email`,`aluno_id`),
  KEY `fk_responsavel_has_alunos_alunos1_idx` (`aluno_id`),
  KEY `fk_responsavel_has_alunos_responsavel1_idx` (`responsavel_email`),
  CONSTRAINT `fk_responsavel_has_alunos_alunos1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  CONSTRAINT `fk_responsavel_has_alunos_responsavel1` FOREIGN KEY (`responsavel_email`) REFERENCES `responsavel` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel_has_aluno`
--

LOCK TABLES `responsavel_has_aluno` WRITE;
/*!40000 ALTER TABLE `responsavel_has_aluno` DISABLE KEYS */;
INSERT INTO `responsavel_has_aluno` VALUES ('kratos@gmail.com',1),('eggman.robotnik@gmail.com',2),('neymar.junior@gmail.com',3),('king.boo@gmail.com',4),('francesco.bernoulli@gmail.com',5),('francesco.bernoulli@gmail.com',6),('kratos@gmail.com',7),('eggman.robotnik@gmail.com',8),('king.boo@gmail.com',9),('neymar.junior@gmail.com',10);
/*!40000 ALTER TABLE `responsavel_has_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsavel_libera_aluno`
--

DROP TABLE IF EXISTS `responsavel_libera_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsavel_libera_aluno` (
  `responsavel_email` varchar(144) NOT NULL,
  `aluno_id` int NOT NULL,
  `data` datetime NOT NULL,
  `horario_saida` datetime DEFAULT NULL,
  `motivo_id` int NOT NULL,
  PRIMARY KEY (`responsavel_email`,`aluno_id`,`data`),
  KEY `fk_tbResponsavel_has_tbAlunos_tbAlunos1_idx` (`aluno_id`),
  KEY `fk_tbResponsavel_has_tbAlunos_tbResponsavel_idx` (`responsavel_email`),
  KEY `fk_responsavel_libera_aluno_motivo1_idx` (`motivo_id`),
  CONSTRAINT `fk_responsavel_libera_aluno_motivo1` FOREIGN KEY (`motivo_id`) REFERENCES `motivo` (`id`),
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbAlunos1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbResponsavel` FOREIGN KEY (`responsavel_email`) REFERENCES `responsavel` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsavel_libera_aluno`
--

LOCK TABLES `responsavel_libera_aluno` WRITE;
/*!40000 ALTER TABLE `responsavel_libera_aluno` DISABLE KEYS */;
INSERT INTO `responsavel_libera_aluno` VALUES ('eggman.robotnik@gmail.com',2,'2023-10-10 00:00:00',NULL,1),('eggman.robotnik@gmail.com',2,'2023-10-12 00:00:00',NULL,5),('eggman.robotnik@gmail.com',8,'2023-10-11 00:00:00',NULL,4),('francesco.bernoulli@gmail.com',5,'2023-10-05 00:00:00',NULL,5),('francesco.bernoulli@gmail.com',5,'2023-10-12 00:00:00',NULL,3),('francesco.bernoulli@gmail.com',6,'2023-10-11 00:00:00',NULL,1),('king.boo@gmail.com',4,'2023-10-10 00:00:00',NULL,3),('king.boo@gmail.com',4,'2023-10-12 00:00:00',NULL,2),('king.boo@gmail.com',9,'2023-10-11 00:00:00',NULL,2),('kratos@gmail.com',1,'2023-10-10 00:00:00',NULL,2),('kratos@gmail.com',1,'2023-10-12 00:00:00',NULL,5),('kratos@gmail.com',7,'2023-10-11 00:00:00',NULL,3),('neymar.junior@gmail.com',3,'2023-10-10 00:00:00',NULL,4),('neymar.junior@gmail.com',3,'2023-10-12 00:00:00',NULL,4),('neymar.junior@gmail.com',10,'2023-10-11 00:00:00',NULL,4);
/*!40000 ALTER TABLE `responsavel_libera_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepae`
--

DROP TABLE IF EXISTS `sepae`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sepae` (
  `username` varchar(45) NOT NULL,
  `nome` varchar(144) NOT NULL,
  `email` varchar(144) NOT NULL,
  `senha` varchar(144) NOT NULL,
  `foto_path` varchar(144) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sepae`
--

LOCK TABLES `sepae` WRITE;
/*!40000 ALTER TABLE `sepae` DISABLE KEYS */;
INSERT INTO `sepae` VALUES ('Chicão','Francisco Fernando Kühn','francisco.kuhn@ifpr.edu.br','$hash','nenhum'),('Neras','Nereu Filho','nereu.filho@ifpr.edu.br','$hash','nenhum'),('Tati','Tatiana Mayumi Niwa','tatiana.niwa@ifpr.edu.br','$hash','nenhum');
/*!40000 ALTER TABLE `sepae` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sepae_libera_aluno`
--

DROP TABLE IF EXISTS `sepae_libera_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sepae_libera_aluno` (
  `sepae_username` varchar(45) NOT NULL,
  `aluno_id` int NOT NULL,
  `data` datetime NOT NULL,
  `horario_saida` datetime DEFAULT NULL,
  `motivo_id` int NOT NULL,
  PRIMARY KEY (`sepae_username`,`aluno_id`,`data`),
  KEY `fk_tbSepae_has_tbAlunos_tbAlunos1_idx` (`aluno_id`),
  KEY `fk_tbSepae_has_tbAlunos_tbSepae1_idx` (`sepae_username`),
  KEY `fk_sepae_libera_aluno_motivo1_idx` (`motivo_id`),
  CONSTRAINT `fk_sepae_libera_aluno_motivo1` FOREIGN KEY (`motivo_id`) REFERENCES `motivo` (`id`),
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbAlunos1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`),
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbSepae1` FOREIGN KEY (`sepae_username`) REFERENCES `sepae` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sepae_libera_aluno`
--

LOCK TABLES `sepae_libera_aluno` WRITE;
/*!40000 ALTER TABLE `sepae_libera_aluno` DISABLE KEYS */;
INSERT INTO `sepae_libera_aluno` VALUES ('Chicão',2,'2023-10-11 00:00:00',NULL,6),('Chicão',4,'2023-10-10 00:00:00','0000-00-00 00:00:00',6),('Chicão',4,'2023-10-18 00:00:00',NULL,7),('Chicão',5,'2023-10-10 00:00:00',NULL,6),('Chicão',5,'2023-10-18 00:00:00',NULL,7),('Chicão',9,'2023-10-11 00:00:00','0000-00-00 00:00:00',7),('Chicão',10,'2023-10-18 00:00:00','0000-00-00 00:00:00',6),('Neras',1,'2023-10-10 00:00:00',NULL,6),('Neras',3,'2023-10-10 00:00:00',NULL,6),('Neras',6,'2023-10-18 00:00:00',NULL,6),('Neras',7,'2023-10-18 00:00:00',NULL,6),('Neras',8,'2023-10-11 00:00:00',NULL,6),('Neras',10,'2023-10-18 00:00:00',NULL,6),('Tati',6,'2023-10-11 00:00:00',NULL,7),('Tati',7,'2023-10-11 00:00:00',NULL,6);
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
-- Dumping events for database 'sepaisdb'
--

--
-- Dumping routines for database 'sepaisdb'
--

--
-- Final view structure for view `aluno_liberado_responsavel`
--

/*!50001 DROP VIEW IF EXISTS `aluno_liberado_responsavel`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `aluno_liberado_responsavel` AS select `aluno`.`nome` AS `Aluno`,`turma`.`turma` AS `Turma`,`motivo`.`motivo` AS `Motivo`,`responsavel`.`nome` AS `Responsável` from ((((`responsavel_libera_aluno` join `responsavel`) join `aluno`) join `motivo`) join `turma`) where ((`aluno`.`id` = `responsavel_libera_aluno`.`aluno_id`) and (`motivo`.`id` = `responsavel_libera_aluno`.`motivo_id`) and (`responsavel`.`email` = `responsavel_libera_aluno`.`responsavel_email`) and (`responsavel_libera_aluno`.`data` = curdate()) and (`responsavel_libera_aluno`.`horario_saida` is null) and (`turma`.`id` = `aluno`.`turma_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `aluno_liberado_sepae`
--

/*!50001 DROP VIEW IF EXISTS `aluno_liberado_sepae`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `aluno_liberado_sepae` AS select `aluno`.`nome` AS `Aluno`,`turma`.`turma` AS `Turma`,`motivo`.`motivo` AS `Motivo`,`sepae_libera_aluno`.`sepae_username` AS `Servidor` from (((`sepae_libera_aluno` join `aluno`) join `turma`) join `motivo`) where ((`aluno`.`id` = `sepae_libera_aluno`.`aluno_id`) and (`sepae_libera_aluno`.`data` = curdate()) and (`sepae_libera_aluno`.`horario_saida` is null) and (`turma`.`id` = `aluno`.`turma_id`) and (`motivo`.`id` = `sepae_libera_aluno`.`motivo_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `aluno_responsavel`
--

/*!50001 DROP VIEW IF EXISTS `aluno_responsavel`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `aluno_responsavel` AS select `responsavel`.`nome` AS `Responsável`,`aluno`.`nome` AS `Aluno`,`turma`.`turma` AS `Turma` from (((`responsavel_has_aluno` join `responsavel`) join `aluno`) join `turma`) where ((`responsavel`.`email` = `responsavel_has_aluno`.`responsavel_email`) and (`aluno`.`id` = `responsavel_has_aluno`.`aluno_id`) and (`turma`.`id` = `aluno`.`turma_id`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `alunos_visualizar`
--

/*!50001 DROP VIEW IF EXISTS `alunos_visualizar`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `alunos_visualizar` AS select `aluno`.`id` AS `id`,`aluno`.`nome` AS `Nome`,`turma`.`turma` AS `Turma`,`aluno`.`foto_path` AS `Foto` from (`aluno` join `turma`) where (`turma`.`id` = `aluno`.`turma_id`) order by `aluno`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `recados`
--

/*!50001 DROP VIEW IF EXISTS `recados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `recados` AS select `recado`.`titulo` AS `Título`,`recado`.`recado` AS `Recado`,`recado`.`data` AS `Data`,`recado`.`sepae_username` AS `Enviado_por` from `recado` where ((curdate() < `recado`.`validade`) or (`recado`.`validade` is null)) */;
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

-- Dump completed on 2023-10-11 11:59:57

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`responsavel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`responsavel` (
  `email` VARCHAR(144) NOT NULL,
  `nome` VARCHAR(144) NOT NULL,
  `senha` VARCHAR(144) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sepae`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`sepae` (
  `username` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(144) NOT NULL,
  `email_institucional` VARCHAR(144) NOT NULL,
  `senha` VARCHAR(144) NOT NULL,
  `foto_path` VARCHAR(144) NULL,
  PRIMARY KEY (`username`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`recados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`recados` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(144) NOT NULL,
  `recado` VARCHAR(1000) NOT NULL,
  `data` DATE NOT NULL,
  `validade` DATE NULL,
  `sepae_username` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tbRecados_tbSepae1_idx` (`sepae_username` ASC) VISIBLE,
  CONSTRAINT `fk_tbRecados_tbSepae1`
    FOREIGN KEY (`sepae_username`)
    REFERENCES `mydb`.`sepae` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`turma` (
  `turma` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`turma`),
  UNIQUE INDEX `turma_UNIQUE` (`turma` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`alunos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`alunos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `foto_path` VARCHAR(144) NOT NULL,
  `turma_turma` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tbAlunos_tbTurma1_idx` (`turma_turma` ASC) VISIBLE,
  CONSTRAINT `fk_tbAlunos_tbTurma1`
    FOREIGN KEY (`turma_turma`)
    REFERENCES `mydb`.`turma` (`turma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`motivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`motivos` (
  `motivos` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`motivos`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`responsavel_libera_alunos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`responsavel_libera_alunos` (
  `responsavel_email` VARCHAR(144) NOT NULL,
  `alunos_id` INT NOT NULL,
  `data` DATETIME NOT NULL,
  `motivos_motivos` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`responsavel_email`, `alunos_id`, `data`),
  INDEX `fk_tbResponsavel_has_tbAlunos_tbAlunos1_idx` (`alunos_id` ASC) VISIBLE,
  INDEX `fk_tbResponsavel_has_tbAlunos_tbResponsavel_idx` (`responsavel_email` ASC) VISIBLE,
  INDEX `fk_tbResponsavel_libera_tbAlunos_tbMotivos1_idx` (`motivos_motivos` ASC) VISIBLE,
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbResponsavel`
    FOREIGN KEY (`responsavel_email`)
    REFERENCES `mydb`.`responsavel` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbAlunos1`
    FOREIGN KEY (`alunos_id`)
    REFERENCES `mydb`.`alunos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbResponsavel_libera_tbAlunos_tbMotivos1`
    FOREIGN KEY (`motivos_motivos`)
    REFERENCES `mydb`.`motivos` (`motivos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sepae_libera_alunos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`sepae_libera_alunos` (
  `sepae_username` VARCHAR(45) NOT NULL,
  `alunos_id` INT NOT NULL,
  `data` DATETIME NOT NULL,
  `motivos_motivos` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`sepae_username`, `alunos_id`, `data`),
  INDEX `fk_tbSepae_has_tbAlunos_tbAlunos1_idx` (`alunos_id` ASC) VISIBLE,
  INDEX `fk_tbSepae_has_tbAlunos_tbSepae1_idx` (`sepae_username` ASC) VISIBLE,
  INDEX `fk_tbSepae_libera_tbAlunos_tbMotivos1_idx` (`motivos_motivos` ASC) VISIBLE,
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbSepae1`
    FOREIGN KEY (`sepae_username`)
    REFERENCES `mydb`.`sepae` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbAlunos1`
    FOREIGN KEY (`alunos_id`)
    REFERENCES `mydb`.`alunos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbSepae_libera_tbAlunos_tbMotivos1`
    FOREIGN KEY (`motivos_motivos`)
    REFERENCES `mydb`.`motivos` (`motivos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`responsavel_has_alunos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`responsavel_has_alunos` (
  `responsavel_email` VARCHAR(144) NOT NULL,
  `alunos_id` INT NOT NULL,
  PRIMARY KEY (`responsavel_email`, `alunos_id`),
  INDEX `fk_responsavel_has_alunos_alunos1_idx` (`alunos_id` ASC) VISIBLE,
  INDEX `fk_responsavel_has_alunos_responsavel1_idx` (`responsavel_email` ASC) VISIBLE,
  CONSTRAINT `fk_responsavel_has_alunos_responsavel1`
    FOREIGN KEY (`responsavel_email`)
    REFERENCES `mydb`.`responsavel` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responsavel_has_alunos_alunos1`
    FOREIGN KEY (`alunos_id`)
    REFERENCES `mydb`.`alunos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

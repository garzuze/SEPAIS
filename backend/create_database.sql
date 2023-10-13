-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sepaisDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sepaisDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sepaisDB` DEFAULT CHARACTER SET utf8 ;
USE `sepaisDB` ;

-- -----------------------------------------------------
-- Table `sepaisDB`.`responsavel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`responsavel` (
  `email` VARCHAR(144) NOT NULL,
  `nome` VARCHAR(144) NOT NULL,
  `senha` VARCHAR(144) NOT NULL,
  `cpf` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`sepae`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`sepae` (
  `username` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(144) NOT NULL,
  `email_institucional` VARCHAR(144) NOT NULL,
  `senha` VARCHAR(144) NOT NULL,
  `foto_path` VARCHAR(144) NOT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`recado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`recado` (
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
    REFERENCES `sepaisDB`.`sepae` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`turma` (
  `id` INT NOT NULL,
  `turma` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`aluno` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(144) NOT NULL,
  `foto_path` VARCHAR(144) NOT NULL,
  `turma_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_aluno_turma1_idx` (`turma_id` ASC) VISIBLE,
  CONSTRAINT `fk_aluno_turma1`
    FOREIGN KEY (`turma_id`)
    REFERENCES `sepaisDB`.`turma` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`motivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`motivo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `motivo` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`responsavel_libera_aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`responsavel_libera_aluno` (
  `responsavel_email` VARCHAR(144) NOT NULL,
  `aluno_id` INT NOT NULL,
  `data` DATETIME NOT NULL,
  `horario_saida` DATETIME NULL,
  `motivo_id` INT NOT NULL,
  PRIMARY KEY (`responsavel_email`, `aluno_id`, `data`),
  INDEX `fk_tbResponsavel_has_tbAlunos_tbAlunos1_idx` (`aluno_id` ASC) VISIBLE,
  INDEX `fk_tbResponsavel_has_tbAlunos_tbResponsavel_idx` (`responsavel_email` ASC) VISIBLE,
  INDEX `fk_responsavel_libera_aluno_motivo1_idx` (`motivo_id` ASC) VISIBLE,
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbResponsavel`
    FOREIGN KEY (`responsavel_email`)
    REFERENCES `sepaisDB`.`responsavel` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbResponsavel_has_tbAlunos_tbAlunos1`
    FOREIGN KEY (`aluno_id`)
    REFERENCES `sepaisDB`.`aluno` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responsavel_libera_aluno_motivo1`
    FOREIGN KEY (`motivo_id`)
    REFERENCES `sepaisDB`.`motivo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`sepae_libera_aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`sepae_libera_aluno` (
  `sepae_username` VARCHAR(45) NOT NULL,
  `aluno_id` INT NOT NULL,
  `data` DATETIME NOT NULL,
  `horario_saida` DATETIME NULL,
  `motivo_id` INT NOT NULL,
  PRIMARY KEY (`sepae_username`, `aluno_id`, `data`),
  INDEX `fk_tbSepae_has_tbAlunos_tbAlunos1_idx` (`aluno_id` ASC) VISIBLE,
  INDEX `fk_tbSepae_has_tbAlunos_tbSepae1_idx` (`sepae_username` ASC) VISIBLE,
  INDEX `fk_sepae_libera_aluno_motivo1_idx` (`motivo_id` ASC) VISIBLE,
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbSepae1`
    FOREIGN KEY (`sepae_username`)
    REFERENCES `sepaisDB`.`sepae` (`username`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbSepae_has_tbAlunos_tbAlunos1`
    FOREIGN KEY (`aluno_id`)
    REFERENCES `sepaisDB`.`aluno` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sepae_libera_aluno_motivo1`
    FOREIGN KEY (`motivo_id`)
    REFERENCES `sepaisDB`.`motivo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`responsavel_has_aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`responsavel_has_aluno` (
  `responsavel_email` VARCHAR(144) NOT NULL,
  `aluno_id` INT NOT NULL,
  PRIMARY KEY (`responsavel_email`, `aluno_id`),
  INDEX `fk_responsavel_has_alunos_alunos1_idx` (`aluno_id` ASC) VISIBLE,
  INDEX `fk_responsavel_has_alunos_responsavel1_idx` (`responsavel_email` ASC) VISIBLE,
  CONSTRAINT `fk_responsavel_has_alunos_responsavel1`
    FOREIGN KEY (`responsavel_email`)
    REFERENCES `sepaisDB`.`responsavel` (`email`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_responsavel_has_alunos_alunos1`
    FOREIGN KEY (`aluno_id`)
    REFERENCES `sepaisDB`.`aluno` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sepaisDB`.`portaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sepaisDB`.`portaria` (
  `username` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(144) NOT NULL,
  `senha` VARCHAR(144) NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

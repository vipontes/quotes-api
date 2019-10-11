CREATE SCHEMA IF NOT EXISTS `quotes` DEFAULT CHARACTER SET utf8 ;
USE `quotes` ;

-- -----------------------------------------------------
-- Table `quotes`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotes`.`usuario` (
  `usuario_id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` VARCHAR(128) NOT NULL,
  `usuario_email` VARCHAR(128) NOT NULL,
  `usuario_senha` VARCHAR(128) NOT NULL,
  `usuario_ativo` INT(1) NOT NULL DEFAULT '1',
  `usuario_sobre` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `usuario_email_UNIQUE` (`usuario_email` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quotes`.`quote`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotes`.`quote` (
  `quote_id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `quote_data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quote_conteudo` VARCHAR(255) NOT NULL,
  `quote_conteudo_ofensivo` INT(1) NOT NULL DEFAULT '0',
  `quote_usuario_conteudo_ofensivo_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`quote_id`),
  INDEX `fk_quote_1_idx` (`usuario_id` ASC),
  INDEX `fk_quote_2_idx` (`quote_usuario_conteudo_ofensivo_id` ASC),
  CONSTRAINT `fk_quote_1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `quotes`.`usuario` (`usuario_id`)
    ON UPDATE CASCADE,
  CONSTRAINT `fk_quote_2`
    FOREIGN KEY (`quote_usuario_conteudo_ofensivo_id`)
    REFERENCES `quotes`.`usuario` (`usuario_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quotes`.`reacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotes`.`reacao` (
  `reacao_id` INT(11) NOT NULL AUTO_INCREMENT,
  `reacao_descricao` VARCHAR(32) NOT NULL,
  `reacao_icon` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`reacao_id`),
  UNIQUE INDEX `reacao_descricao_UNIQUE` (`reacao_descricao` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quotes`.`quote_reacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotes`.`quote_reacao` (
  `quote_id` INT(11) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  `reacao_id` INT(11) NOT NULL,
  `quote_reacao_data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`quote_id`, `usuario_id`),
  INDEX `fk_quote_reacao_2_idx` (`usuario_id` ASC),
  INDEX `fk_quote_reacao_3_idx` (`reacao_id` ASC),
  CONSTRAINT `fk_quote_reacao_1`
    FOREIGN KEY (`quote_id`)
    REFERENCES `quotes`.`quote` (`quote_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_quote_reacao_2`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `quotes`.`usuario` (`usuario_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_quote_reacao_3`
    FOREIGN KEY (`reacao_id`)
    REFERENCES `quotes`.`reacao` (`reacao_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quotes`.`usuario_dispositivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quotes`.`usuario_dispositivo` (
  `usuario_dispositivo_id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `usuario_dispositivo` VARCHAR(255) NOT NULL,
  `token` TEXT NOT NULL,
  `refresh_token` TEXT NOT NULL,
  PRIMARY KEY (`usuario_dispositivo_id`),
  UNIQUE INDEX `index3` (`usuario_id` ASC, `usuario_dispositivo` ASC),
  INDEX `fk_usuario_dispositivo_1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_dispositivo_1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `quotes`.`usuario` (`usuario_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

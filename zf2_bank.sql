-- MySQL Workbench Synchronization
-- Generated: 2016-01-20 17:36
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Gaëtan

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `zf2_bank`.`assurance` 
ADD COLUMN `users_id` INT(11) NOT NULL AFTER `nom`,
ADD INDEX `fk_assurance_users1_idx` (`users_id` ASC);

ALTER TABLE `zf2_bank`.`bien` 
ADD COLUMN `assurance_id` INT(11) NOT NULL AFTER `prix`,
DROP PRIMARY KEY,
ADD PRIMARY KEY (`id`, `assurance_id`),
ADD INDEX `fk_bien_assurance1_idx` (`assurance_id` ASC);

ALTER TABLE `zf2_bank`.`users` 
ADD COLUMN `conseiller_id` INT(11) NOT NULL AFTER `password`,
ADD INDEX `fk_users_conseiller1_idx` (`conseiller_id` ASC);

ALTER TABLE `zf2_bank`.`assurance` 
ADD CONSTRAINT `fk_assurance_users1`
  FOREIGN KEY (`users_id`)
  REFERENCES `zf2_bank`.`users` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `zf2_bank`.`bien` 
ADD CONSTRAINT `fk_bien_assurance1`
  FOREIGN KEY (`assurance_id`)
  REFERENCES `zf2_bank`.`assurance` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `zf2_bank`.`users` 
ADD CONSTRAINT `fk_users_conseiller1`
  FOREIGN KEY (`conseiller_id`)
  REFERENCES `zf2_bank`.`conseiller` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

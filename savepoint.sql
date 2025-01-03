-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema savepoint
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `savepoint` ;

-- -----------------------------------------------------
-- Schema savepoint
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `savepoint` DEFAULT CHARACTER SET utf8mb3 ;
USE `savepoint` ;

-- -----------------------------------------------------
-- Table `savepoint`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(31) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`games` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(63) NOT NULL,
  `developer` VARCHAR(63) NOT NULL,
  `ageRestricted` TINYINT NOT NULL DEFAULT 0,
  `status` TINYINT NOT NULL DEFAULT 1,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` VARCHAR(255) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `publisher` VARCHAR(63) NULL DEFAULT NULL,
  `release_date` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`game_in_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`game_in_category` (
  `category_id` INT NOT NULL,
  `game_id` INT NOT NULL,
  PRIMARY KEY (`category_id`, `game_id`),
  INDEX `fk_categories_has_games_games1_idx` (`game_id` ASC) VISIBLE,
  INDEX `fk_categories_has_games_categories1_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_categories_has_games_categories1`
    FOREIGN KEY (`category_id`)
    REFERENCES `savepoint`.`categories` (`id`),
  CONSTRAINT `fk_categories_has_games_games1`
    FOREIGN KEY (`game_id`)
    REFERENCES `savepoint`.`games` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `displayname` VARCHAR(32) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `dateofbirth` DATETIME NULL DEFAULT NULL,
  `status` TINYINT NOT NULL DEFAULT 1,
  `isAdmin` TINYINT NOT NULL DEFAULT 0,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `displayname_UNIQUE` (`displayname` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`lists`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`lists` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(32) NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_lists_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_lists_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `savepoint`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`game_in_list`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`game_in_list` (
  `game_id` INT NOT NULL,
  `list_id` INT NOT NULL,
  PRIMARY KEY (`game_id`, `list_id`),
  INDEX `fk_lists_has_games_games1_idx` (`game_id` ASC) VISIBLE,
  INDEX `fk_game_in_list_lists1_idx` (`list_id` ASC) VISIBLE,
  CONSTRAINT `fk_lists_has_games_games1`
    FOREIGN KEY (`game_id`)
    REFERENCES `savepoint`.`games` (`id`),
  CONSTRAINT `fk_game_in_list_lists1`
    FOREIGN KEY (`list_id`)
    REFERENCES `savepoint`.`lists` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`platforms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`platforms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(31) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`game_on_platform`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`game_on_platform` (
  `platform_id` INT NOT NULL,
  `game_id` INT NOT NULL,
  PRIMARY KEY (`platform_id`, `game_id`),
  INDEX `fk_platforms_has_games_games1_idx` (`game_id` ASC) VISIBLE,
  INDEX `fk_platforms_has_games_platforms1_idx` (`platform_id` ASC) VISIBLE,
  CONSTRAINT `fk_platforms_has_games_games1`
    FOREIGN KEY (`game_id`)
    REFERENCES `savepoint`.`games` (`id`),
  CONSTRAINT `fk_platforms_has_games_platforms1`
    FOREIGN KEY (`platform_id`)
    REFERENCES `savepoint`.`platforms` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`user_owns_platform`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`user_owns_platform` (
  `platform_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`platform_id`, `user_id`),
  INDEX `fk_platforms_has_users_users1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_platforms_has_users_platforms1_idx` (`platform_id` ASC) VISIBLE,
  CONSTRAINT `fk_platforms_has_users_platforms1`
    FOREIGN KEY (`platform_id`)
    REFERENCES `savepoint`.`platforms` (`id`),
  CONSTRAINT `fk_platforms_has_users_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `savepoint`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `savepoint`.`ratings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `savepoint`.`ratings` (
  `user_id` INT NOT NULL,
  `game_id` INT NOT NULL,
  `rating` TINYINT NOT NULL,
  `review` TEXT NOT NULL,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `game_id`),
  INDEX `fk_users_has_games_games1_idx` (`game_id` ASC) VISIBLE,
  INDEX `fk_users_has_games_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_games_games1`
    FOREIGN KEY (`game_id`)
    REFERENCES `savepoint`.`games` (`id`),
  CONSTRAINT `fk_users_has_games_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `savepoint`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `mojo`.`client_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mojo`.`client_details` (
  `client_id` INT NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(255) NOT NULL ,
  `last_name` VARCHAR(255) NOT NULL ,
  `username` VARCHAR(255) NOT NULL ,
  `created_time` DATETIME NOT NULL ,
  `updated_time` DATETIME NOT NULL ,
  PRIMARY KEY (`client_id`) ,
  UNIQUE INDEX `client_id_UNIQUE` (`client_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mojo`.`product_details`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mojo`.`product_details` (
  `product_id` INT NOT NULL AUTO_INCREMENT ,
  `product_name` VARCHAR(255) NOT NULL ,
  `product_group` VARCHAR(255) NOT NULL ,
  `product_vendor` VARCHAR(255) NOT NULL ,
  `created_time` DATETIME NOT NULL ,
  `updated_time` DATETIME NOT NULL ,client_details
  PRIMARY KEY (`product_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mojo`.`client_product`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mojo`.`client_product` (
  `client_product_id` INT NOT NULL AUTO_INCREMENT ,
  `client_id` INT NOT NULL ,
  `product_id` INT NOT NULL ,
  `product_name` VARCHAR(255) NOT NULL ,
  `product_group` VARCHAR(255) NOT NULL ,
  `created_time` DATETIME NOT NULL ,
  `updated_time` DATETIME NOT NULL ,
  UNIQUE INDEX `product_id_UNIQUE` (`client_product_id` ASC) ,
  PRIMARY KEY (`client_product_id`) ,
  INDEX `client_id_idx` (`client_id` ASC) ,
  INDEX `product_id_idx` (`product_id` ASC) ,
  CONSTRAINT `client_id`
    FOREIGN KEY (`client_id` )
    REFERENCES `mojo`.`client_details` (`client_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `mojo`.`product_details` (`product_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

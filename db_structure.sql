SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema FootWearShop
-- -----------------------------------------------------
-- Footwear online store.

-- -----------------------------------------------------
-- Schema FootWearShop
--
-- Footwear online store.
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `FootWearShop` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `FootWearShop` ;

-- -----------------------------------------------------
-- Table `FootWearShop`.`Category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Category` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(45) NOT NULL,
  `season` SET('winter','summer','autumn','spring') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Shoe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Shoe` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Shoe` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `shoe_name` VARCHAR(45) NOT NULL,
  `size` TINYINT NOT NULL,
  `color` VARCHAR(45) NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  `price` DECIMAL(7,2) UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  `supplier_id` INT NOT NULL,
  `supplier_address_id` INT UNSIGNED NOT NULL,
  `supplier_supplier_info_id` INT NOT NULL,
  PRIMARY KEY (`id`, `category_id`, `supplier_id`, `supplier_address_id`, `supplier_supplier_info_id`),
  INDEX `fk_Shoe_Category1_idx` (`category_id` ASC),
  CONSTRAINT `fk_Shoe_Category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `FootWearShop`.`Category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Brand`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Brand` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Brand` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand_name` VARCHAR(45) NOT NULL,
  `reputation` SET('Unknown','Low', 'Medium', 'High') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Brand_has_Category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Brand_has_Category` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Brand_has_Category` (
  `brand_id` INT UNSIGNED NOT NULL,
  `category_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`brand_id`, `category_id`),
  INDEX `fk_Brand_has_Category_Category1_idx` (`category_id` ASC),
  INDEX `fk_Brand_has_Category_Brand1_idx` (`brand_id` ASC),
  CONSTRAINT `fk_Brand_has_Category_Brand1`
    FOREIGN KEY (`brand_id`)
    REFERENCES `FootWearShop`.`Brand` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Brand_has_Category_Category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `FootWearShop`.`Category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Role` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Role` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` SET('customer', 'staff', 'manager', 'admin') NOT NULL,
  `role_description` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`User_Info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`User_Info` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`User_Info` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gender` CHAR(1) NOT NULL,
  `nationality` VARCHAR(45) NOT NULL,
  `agegroup` VARCHAR(45) NOT NULL,
  `email_address` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`User` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`User` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `dob` DATE NOT NULL,
  `role_id` INT UNSIGNED NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `user_Info_id` INT UNSIGNED NOT NULL,
  `date_registered` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`, `user_Info_id`, `role_id`),
  INDEX `fk_User_Role1_idx` (`role_id` ASC),
  INDEX `fk_User_User_Info1_idx` (`user_Info_id` ASC),
  CONSTRAINT `fk_User_Role1`
    FOREIGN KEY (`role_id`)
    REFERENCES `FootWearShop`.`Role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_User_Info1`
    FOREIGN KEY (`user_Info_id`)
    REFERENCES `FootWearShop`.`User_Info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Address` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Address` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_line` VARCHAR(45) NOT NULL,
  `second_line` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `postcode` VARCHAR(45) NOT NULL,
  `country` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Delivery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Delivery` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Delivery` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tracking_number` INT NOT NULL,
  `delivery_type` VARCHAR(45) NOT NULL,
  `delivery_cost` VARCHAR(45) NOT NULL,
  `address_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `address_id`),
  INDEX `fk_Delivery_Address1_idx` (`address_id` ASC),
  UNIQUE INDEX `tracking_number_UNIQUE` (`tracking_number` ASC),
  CONSTRAINT `fk_Delivery_Address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `FootWearShop`.`Address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Order` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Order` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_placed` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_dispatched` TIMESTAMP NULL,
  `status` VARCHAR(45) NOT NULL,
  `total_cost` DECIMAL(7,2) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `delivery_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`, `delivery_id`),
  INDEX `fk_Order_User1_idx` (`user_id` ASC),
  INDEX `fk_Order_Delivery1_idx` (`delivery_id` ASC),
  CONSTRAINT `fk_Order_User1`
    FOREIGN KEY (`user_id`)
    REFERENCES `FootWearShop`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_Delivery1`
    FOREIGN KEY (`delivery_id`)
    REFERENCES `FootWearShop`.`Delivery` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Item_Order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Item_Order` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Item_Order` (
  `order_id` INT UNSIGNED NOT NULL,
  `shoe_id` INT UNSIGNED NOT NULL,
  `shoe_category_id` INT UNSIGNED NOT NULL,
  `item_quantity` SMALLINT UNSIGNED NOT NULL,
  PRIMARY KEY (`order_id`, `shoe_id`, `shoe_category_id`),
  INDEX `fk_Order_has_Shoe_Shoe1_idx` (`shoe_id` ASC, `shoe_category_id` ASC),
  INDEX `fk_Order_has_Shoe_Order1_idx` (`order_id` ASC),
  CONSTRAINT `fk_Order_has_Shoe_Order1`
    FOREIGN KEY (`order_id`)
    REFERENCES `FootWearShop`.`Order` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Order_has_Shoe_Shoe1`
    FOREIGN KEY (`shoe_id` , `shoe_category_id`)
    REFERENCES `FootWearShop`.`Shoe` (`id` , `category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Supplier` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Supplier` (
  `id` INT NOT NULL,
  `supplier_name` VARCHAR(45) NOT NULL,
  `address_id` INT UNSIGNED NOT NULL,
  `company_phonenumber` VARCHAR(45) NOT NULL,
  `contact_number` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`, `address_id`),
  INDEX `fk_Supplier_Address1_idx` (`address_id` ASC),
  CONSTRAINT `fk_Supplier_Address1`
    FOREIGN KEY (`address_id`)
    REFERENCES `FootWearShop`.`Address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`Shoe_has_Supplier`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`Shoe_has_Supplier` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`Shoe_has_Supplier` (
  `shoe_id` INT UNSIGNED NOT NULL,
  `shoe_category_id` INT UNSIGNED NOT NULL,
  `shoe_supplier_id` INT NOT NULL,
  `shoe_supplier_address_id` INT UNSIGNED NOT NULL,
  `shoe_supplier_supplier_info_id` INT NOT NULL,
  `supplier_id` INT NOT NULL,
  `supplier_address_id` INT UNSIGNED NOT NULL,
  `supplier_supplier_info_id` INT NOT NULL,
  PRIMARY KEY (`shoe_id`, `shoe_category_id`, `shoe_supplier_id`, `shoe_supplier_address_id`, `shoe_supplier_supplier_info_id`, `supplier_id`, `supplier_address_id`, `supplier_supplier_info_id`),
  INDEX `fk_Shoe_has_Supplier_Supplier1_idx` (`supplier_id` ASC, `supplier_address_id` ASC, `supplier_supplier_info_id` ASC),
  INDEX `fk_Shoe_has_Supplier_Shoe1_idx` (`shoe_id` ASC, `shoe_category_id` ASC, `shoe_supplier_id` ASC, `shoe_supplier_address_id` ASC, `shoe_supplier_supplier_info_id` ASC),
  CONSTRAINT `fk_Shoe_has_Supplier_Shoe1`
    FOREIGN KEY (`shoe_id` , `shoe_category_id` , `shoe_supplier_id` , `shoe_supplier_address_id` , `shoe_supplier_supplier_info_id`)
    REFERENCES `FootWearShop`.`Shoe` (`id` , `category_id` , `supplier_id` , `supplier_address_id` , `supplier_supplier_info_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Shoe_has_Supplier_Supplier1`
    FOREIGN KEY (`supplier_id` , `supplier_address_id`)
    REFERENCES `FootWearShop`.`Supplier` (`id` , `address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FootWearShop`.`User_has_Address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FootWearShop`.`User_has_Address` ;

CREATE TABLE IF NOT EXISTS `FootWearShop`.`User_has_Address` (
  `User_id` INT UNSIGNED NOT NULL,
  `User_user_Info_id` INT UNSIGNED NOT NULL,
  `User_role_id` INT UNSIGNED NOT NULL,
  `Address_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`User_id`, `User_user_Info_id`, `User_role_id`, `Address_id`),
  INDEX `fk_User_has_Address_Address1_idx` (`Address_id` ASC),
  INDEX `fk_User_has_Address_User1_idx` (`User_id` ASC, `User_user_Info_id` ASC, `User_role_id` ASC),
  CONSTRAINT `fk_User_has_Address_User1`
    FOREIGN KEY (`User_id` , `User_user_Info_id` , `User_role_id`)
    REFERENCES `FootWearShop`.`User` (`id` , `user_Info_id` , `role_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Address_Address1`
    FOREIGN KEY (`Address_id`)
    REFERENCES `FootWearShop`.`Address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- Feel free to change these descriptions!
INSERT INTO `FootWearShop`.`Role` (`id`, `role_name`, `role_description`) VALUES (NULL, 'customer', 'Customers can order items from the store.');
INSERT INTO `FootWearShop`.`Role` (`id`, `role_name`, `role_description`) VALUES (NULL, 'staff', 'Staff perform duties such as tracking stock.');
INSERT INTO `FootWearShop`.`Role` (`id`, `role_name`, `role_description`) VALUES (NULL, 'manager', 'Managers are responsible for the staff.');
INSERT INTO `FootWearShop`.`Role` (`id`, `role_name`, `role_description`) VALUES (NULL, 'admin', 'Administrators have full access.');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

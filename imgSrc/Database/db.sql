SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';



CREATE SCHEMA IF NOT EXISTS `mailsigner` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

USE `mailsigner`;



-- -----------------------------------------------------

-- Table `mailsigner`.`ProductType`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`ProductType` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`ProductType` (

  `productType` VARCHAR(45) NOT NULL ,

  PRIMARY KEY (`productType`) )

ENGINE = InnoDB;





-- -----------------------------------------------------

-- Table `mailsigner`.`ProductState`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`ProductState` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`ProductState` (

  `productState` INT NOT NULL ,

  `description` VARCHAR(45) NULL ,

  PRIMARY KEY (`productState`) )

ENGINE = InnoDB;





-- -----------------------------------------------------

-- Table `mailsigner`.`Product`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`Product` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`Product` (

  `productNumber` INT NOT NULL AUTO_INCREMENT ,

  `productName` VARCHAR(45) NOT NULL ,

  `description` LONGTEXT NULL ,

  `imageLocation` VARCHAR(45) NULL ,

  `productType` VARCHAR(45) NOT NULL ,

  `productState` INT NOT NULL ,

  `validity` INT NULL ,

  `quantity` INT NULL ,

  `priceDKK` FLOAT NOT NULL ,

  PRIMARY KEY (`productNumber`) ,

  INDEX `fk_Product_ProductType` (`productType` ASC) ,

  INDEX `fk_Product_ProductState1` (`productState` ASC) ,

  CONSTRAINT `fk_Product_ProductType`

    FOREIGN KEY (`productType` )

    REFERENCES `mailsigner`.`ProductType` (`productType` )

    ON DELETE NO ACTION

    ON UPDATE CASCADE,

  CONSTRAINT `fk_Product_ProductState1`

    FOREIGN KEY (`productState` )

    REFERENCES `mailsigner`.`ProductState` (`productState` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB

AUTO_INCREMENT = 10000;





-- -----------------------------------------------------

-- Table `mailsigner`.`Countries`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`Countries` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`Countries` (

  `isoName` VARCHAR(2) NOT NULL ,

  `name` VARCHAR(45) NOT NULL ,

  PRIMARY KEY (`isoName`) )

ENGINE = InnoDB;





-- -----------------------------------------------------

-- Table `mailsigner`.`UserType`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`UserType` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`UserType` (

  `userType` VARCHAR(3) NOT NULL ,

  PRIMARY KEY (`userType`) )

ENGINE = InnoDB;





-- -----------------------------------------------------

-- Table `mailsigner`.`User`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`User` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`User` (

  `idUser` INT NOT NULL AUTO_INCREMENT ,

  `companyName` VARCHAR(45) NOT NULL ,

  `firstName` VARCHAR(45) NOT NULL ,

  `lastName` VARCHAR(45) NOT NULL ,

  `mail` VARCHAR(45) NOT NULL ,

  `password` VARCHAR(34) NOT NULL ,

  `address` VARCHAR(45) NOT NULL ,

  `city` VARCHAR(45) NOT NULL ,

  `postCode` INT NOT NULL ,

  `country` VARCHAR(2) NOT NULL ,

  `userType` VARCHAR(3) NOT NULL ,

  `activated` TINYINT(1) NOT NULL DEFAULT 0 ,

  PRIMARY KEY (`idUser`) ,

  INDEX `fk_User_Countries1` (`country` ASC) ,

  INDEX `fk_User_UserType1` (`userType` ASC) ,

  CONSTRAINT `fk_User_Countries1`

    FOREIGN KEY (`country` )

    REFERENCES `mailsigner`.`Countries` (`isoName` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION,

  CONSTRAINT `fk_User_UserType1`

    FOREIGN KEY (`userType` )

    REFERENCES `mailsigner`.`UserType` (`userType` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB

AUTO_INCREMENT = 10000;





-- -----------------------------------------------------

-- Table `mailsigner`.`Order`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`Order` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`Order` (

  `idOrder` INT NOT NULL AUTO_INCREMENT ,

  `idUser` INT NOT NULL ,

  `address` VARCHAR(45) NOT NULL ,

  `city` VARCHAR(45) NOT NULL ,

  `postcode` INT NOT NULL ,

  `date` DATETIME NOT NULL ,

  `expires` DATETIME NULL ,

  `dueDate` DATETIME NOT NULL ,

  `active` TINYINT(1) NOT NULL DEFAULT 1 ,

  PRIMARY KEY (`idOrder`, `idUser`) ,

  INDEX `fk_Order_User` (`idUser` ASC) ,

  CONSTRAINT `fk_Order_User`

    FOREIGN KEY (`idUser` )

    REFERENCES `mailsigner`.`User` (`idUser` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB

AUTO_INCREMENT = 10000;





-- -----------------------------------------------------

-- Table `mailsigner`.`OrderItem`

-- -----------------------------------------------------

DROP TABLE IF EXISTS `mailsigner`.`OrderItem` ;



CREATE  TABLE IF NOT EXISTS `mailsigner`.`OrderItem` (

  `idOrderItems` INT NOT NULL AUTO_INCREMENT ,

  `idOrder` INT NOT NULL ,

  `productNumber` INT NOT NULL ,

  `quantity` INT NOT NULL ,

  `priceDKK` FLOAT NOT NULL ,

  PRIMARY KEY (`idOrderItems`, `idOrder`) ,

  INDEX `fk_OrderItem_Order1` (`idOrder` ASC) ,

  INDEX `fk_OrderItem_Product1` (`productNumber` ASC) ,

  CONSTRAINT `fk_OrderItem_Order1`

    FOREIGN KEY (`idOrder` )

    REFERENCES `mailsigner`.`Order` (`idOrder` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION,

  CONSTRAINT `fk_OrderItem_Product1`

    FOREIGN KEY (`productNumber` )

    REFERENCES `mailsigner`.`Product` (`productNumber` )

    ON DELETE NO ACTION

    ON UPDATE NO ACTION)

ENGINE = InnoDB;







SET SQL_MODE=@OLD_SQL_MODE;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;

SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


insert into Countries values ('DK', 'Denmark'), ('SE', 'Sweden');

INSERT INTO UserType VALUES ('dmo'), ('cst'), ('adm');

INSERT INTO ProductType (productType) VALUES ('MailSigner'), ('Signature');

INSERT INTO ProductState(productState ,description) VALUES ('0', 'Deactivated'), ('1', 'Activated');

INSERT INTO Product(productName, description, imageLocation, productType, productState, validity, quantity, priceDKK)
VALUES ('MailSigner-10', NULL, NULL, 'MailSigner', 1, 1, 10, 200),
('MailSigner-50', NULL, NULL, 'MailSigner', 1, 1, 50, 150),
('MailSigner-100', NULL, NULL, 'MailSigner', 1, 1, 100, 100),
('MailSigner-200', NULL, NULL, 'MailSigner', 1, 1, 200, 80),
('MailSigner-unlim', NULL, NULL, 'MailSigner', 1, 1, 10000000, 80);

INSERT INTO `Product` (`productNumber`, `productName`, `description`, `imageLocation`, `productType`, `productState`, `validity`, `quantity`, `priceDKK`) 
VALUES (NULL, 'Test Signature', 'Fancy pantsy signature', '/img/signatures/test.jpg', 'Signature', '1', NULL, NULL, '50');
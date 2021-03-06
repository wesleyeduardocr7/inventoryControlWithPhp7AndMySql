-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_branch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_branch` (
  `idbranch` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `street` VARCHAR(100) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `state` VARCHAR(50) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `manager` VARCHAR(50) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idbranch`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_client` (
  `idclient` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idclient`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_orderstatus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_orderstatus` (
  `idorderstatus` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idorderstatus`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_paymentmethod`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_paymentmethod` (
  `idpaymentmethod` INT NOT NULL,
  `name` VARCHAR(20) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpaymentmethod`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_product` (
  `idproduct` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `sequential` VARCHAR(100) NOT NULL,
  `barcode` VARCHAR(100) NOT NULL,
  `description` VARCHAR(256) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_stock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_stock` (
  `idbranch` INT NOT NULL,
  `idproduct` INT NOT NULL,
  `quantity` INT NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`, `idbranch`),
  INDEX `fk_tb_stock_tb_product1_idx` (`idproduct` ASC) ,
  INDEX `fk_tb_stock_tb_branch1_idx` (`idbranch` ASC) ,
  CONSTRAINT `fk_tb_stock_tb_branch1`
    FOREIGN KEY (`idbranch`)
    REFERENCES `wesley22_db`.`tb_branch` (`idbranch`),
  CONSTRAINT `fk_tb_stock_tb_product1`
    FOREIGN KEY (`idproduct`)
    REFERENCES `wesley22_db`.`tb_product` (`idproduct`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `cpf` VARCHAR(15) NOT NULL,
  `login` VARCHAR(20) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_stockorder`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_stockorder` (
  `idstockorder` INT NOT NULL AUTO_INCREMENT,
  `idbranch` INT NOT NULL,
  `iduser` INT NOT NULL,
  `idclient` INT NULL DEFAULT NULL,
  `idpaymentmethod` INT NULL DEFAULT NULL,
  `ordertype` VARCHAR(20) NOT NULL,
  `deliverynote` VARCHAR(256) NULL DEFAULT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstockorder`),
  INDEX `fk_tb_stockorder_tb_branch1_idx` (`idbranch` ASC) ,
  INDEX `fk_tb_stockorder_tb_user1_idx` (`iduser` ASC) ,
  INDEX `fk_tb_stockorder_tb_cliente1_idx` (`idclient` ASC),
  INDEX `fk_tb_stockorder_tb_paymentmethod1_idx` (`idpaymentmethod` ASC) ,
  CONSTRAINT `fk_tb_stockorder_tb_branch1`
    FOREIGN KEY (`idbranch`)
    REFERENCES `wesley22_db`.`tb_branch` (`idbranch`),
  CONSTRAINT `fk_tb_stockorder_tb_cliente1`
    FOREIGN KEY (`idclient`)
    REFERENCES `wesley22_db`.`tb_client` (`idclient`),
  CONSTRAINT `fk_tb_stockorder_tb_paymentmethod1`
    FOREIGN KEY (`idpaymentmethod`)
    REFERENCES `wesley22_db`.`tb_paymentmethod` (`idpaymentmethod`),
  CONSTRAINT `fk_tb_stockorder_tb_user1`
    FOREIGN KEY (`iduser`)
    REFERENCES `wesley22_db`.`tb_user` (`iduser`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `wesley22_db`.`tb_stockorderitem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wesley22_db`.`tb_stockorderitem` (
  `idstockorderitem` INT NOT NULL AUTO_INCREMENT,
  `idproduct` INT NOT NULL,
  `idstockorder` INT NOT NULL,
  `idorderstatus` INT NOT NULL,
  `quantity` INT NULL DEFAULT NULL,
  `unitaryvalue` DECIMAL(10,2) NULL DEFAULT NULL,
  `totalvalue` DECIMAL(10,2) NULL DEFAULT NULL,
  `dtremoved` DATETIME NULL DEFAULT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstockorderitem`),
  INDEX `fk_tb_stockorderitem_tb_product1_idx` (`idproduct` ASC) ,
  INDEX `fk_tb_stockorderitem_tb_stockorder1_idx` (`idstockorder` ASC) ,
  INDEX `fk_tb_stockorderitem_tb_orderstatus1_idx` (`idorderstatus` ASC) ,
  CONSTRAINT `fk_tb_stockorderitem_tb_orderstatus1`
    FOREIGN KEY (`idorderstatus`)
    REFERENCES `wesley22_db`.`tb_orderstatus` (`idorderstatus`),
  CONSTRAINT `fk_tb_stockorderitem_tb_product1`
    FOREIGN KEY (`idproduct`)
    REFERENCES `wesley22_db`.`tb_product` (`idproduct`),
  CONSTRAINT `fk_tb_stockorderitem_tb_stockorder1`
    FOREIGN KEY (`idstockorder`)
    REFERENCES `wesley22_db`.`tb_stockorder` (`idstockorder`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO tb_paymentmethod (idpaymentmethod,name) values (1,'À VISTA');
INSERT INTO tb_paymentmethod (idpaymentmethod,name) values (2,'BOLETO');
INSERT INTO tb_paymentmethod (idpaymentmethod,name) values (3,'CARTÃO');

INSERT INTO tb_orderstatus (idorderstatus,name) values (1,'ATIVO');
INSERT INTO tb_orderstatus (idorderstatus,name) values (2,'CANCELADO');
INSERT INTO tb_orderstatus (idorderstatus,name) values (3,'PROCESSADO');


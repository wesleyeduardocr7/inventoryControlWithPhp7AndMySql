-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema inventorycontrol
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema inventorycontrol
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `inventorycontrol` DEFAULT CHARACTER SET utf8 ;
USE `inventorycontrol` ;

-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_branch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_branch` (
  `idbranch` INT NOT NULL AUTO_INCREMENT,
  `address` VARCHAR(100) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `state` VARCHAR(45) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `manager` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idbranch`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_stock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_stock` (
  `idstock` INT NOT NULL AUTO_INCREMENT,
  `idbranch` INT NOT NULL,
  `responsible` VARCHAR(45) NOT NULL,
  `telephone` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idstock`, `idbranch`),
  INDEX `fk_Estoque_Filial1_idx` (`idbranch` ASC) VISIBLE,
  CONSTRAINT `fk_Estoque_Filial1`
    FOREIGN KEY (`idbranch`)
    REFERENCES `inventorycontrol`.`tb_branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_stockorder`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_stockorder` (
  `idstockorder` INT NOT NULL AUTO_INCREMENT,
  `idstock` INT NOT NULL,
  `ordertype` VARCHAR(20) NOT NULL,
  `situation` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idstockorder`, `idstock`),
  INDEX `fk_PedidoEstoque_Estoque1_idx` (`idstock` ASC) VISIBLE,
  CONSTRAINT `fk_PedidoEstoque_Estoque1`
    FOREIGN KEY (`idstock`)
    REFERENCES `inventorycontrol`.`tb_stock` (`idstock`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_product` (
  `idproduct` INT NOT NULL AUTO_INCREMENT,
  `idstock` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `unityprice` DECIMAL(10,2) NOT NULL,
  `totalamount` INT NOT NULL,
  PRIMARY KEY (`idproduct`, `idstock`),
  INDEX `fk_tb_product_tb_stock1_idx` (`idstock` ASC) VISIBLE,
  CONSTRAINT `fk_tb_product_tb_stock1`
    FOREIGN KEY (`idstock`)
    REFERENCES `inventorycontrol`.`tb_stock` (`idstock`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_stockorderitem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_stockorderitem` (
  `idstockorder` INT NOT NULL,
  `idproduct` INT NOT NULL,
  `requestedquantity` INT NOT NULL,
  PRIMARY KEY (`idstockorder`, `idproduct`),
  INDEX `fk_ItemPedidoEstoque_Produto1_idx` (`idproduct` ASC) VISIBLE,
  CONSTRAINT `fk_ItemPedidoEstoque_PedidoEstoque1`
    FOREIGN KEY (`idstockorder`)
    REFERENCES `inventorycontrol`.`tb_stockorder` (`idstockorder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ItemPedidoEstoque_Produto1`
    FOREIGN KEY (`idproduct`)
    REFERENCES `inventorycontrol`.`tb_product` (`idproduct`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

insert into tb_branch (address,city,state,telephone,manager) values ('Rua do Sol', 'Santa Ines', 'Maranhão' , '32146598','Rodrigo');
insert into tb_branch (address,city,state,telephone,manager)values ('Rua do Comercio', 'Santa Luzia', 'Maranhão' ,'965565','Antonio');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua da paz', 'Bacabal', 'Maranhão' ,'945132','Gabriel');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua Principal', 'Imperatriz', 'Maranhão' ,'42156465','Luis');
insert into tb_branch (address,city,state,telephone,manager) values ('AV 12', 'Caxias', 'Maranhão' ,'6944521','Paulo');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua central', 'Balsas', 'Maranhão' ,'656598','Lima');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua 10', 'Alto Alegre', 'Maranhão' ,'9855498','Alan');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua do fio', 'Picos', 'Piaui' ,'1115478','Cristiano');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua da banana', 'Santa Rita', 'Maranhão' ,'46852598','Leticia');
insert into tb_branch (address,city,state,telephone,manager) values ('Rua da Estrela', 'Santa Luzia', 'Maranhão' ,'46852598','Gabriela');


insert into tb_stock (idbranch,responsible,telephone) values (2,'Gabriel','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (6,'Antonia','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (8,'Lucilia','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (4,'Andressa','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (8,'Jamilly','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (4,'Fernanda','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (1,'Luiza','84751665');
insert into tb_stock (idbranch,responsible,telephone) values (7,'Vilma','8434565');


DELIMITER $$
CREATE PROCEDURE `sp_branch_save`(
pidbranch int(11),
paddress varchar(100),
pcity varchar(45),
pstate varchar(45),
ptelephone varchar(20),
pmanager varchar(100)
)
BEGIN
	
	IF pidbranch > 0 THEN
		
		UPDATE tb_branch
        SET 
			address = paddress,
            city =  pcity ,
            state = pstate,
            telephone = ptelephone,
            manager= pmanager
            
        WHERE idbranch = pidbranch;
        
    ELSE
		
		INSERT INTO tb_branch (address,city,state,telephone, manager) 
        VALUES(paddress,pcity,pstate,ptelephone, pmanager);
        
        SET pidbranch = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_branch WHERE idbranch = pidbranch;
    
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE `sp_stock_save`(
pidstock int(11),
pidbranch int(11),
presponsible varchar(50),
ptelephone varchar(20)
)
BEGIN
	
	IF pidstock > 0 THEN
		
		UPDATE tb_stock
        SET            
		   idbranch = pidbranch,         
		   responsible = presponsible,
           telephone = ptelephone
                        
        WHERE idstock = pidstock;
        
    ELSE
		
		INSERT INTO tb_stock (idbranch,responsible,telephone) 
        VALUES(pidbranch,presponsible,ptelephone);
        
        SET pidstock = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_stock WHERE idstock = pidstock;
    
END$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

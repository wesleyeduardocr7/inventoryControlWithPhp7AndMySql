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
-- Table `inventorycontrol`.`tb_product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_product` (
  `idproduct` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `sequential` VARCHAR(100) NOT NULL,
  `barcode` VARCHAR(100) NOT NULL,
  `description` VARCHAR(256) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_branch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_branch` (
  `idbranch` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `street` VARCHAR(100) NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `state` VARCHAR(50) NOT NULL,
  `telephone` VARCHAR(20) NOT NULL,
  `manager` VARCHAR(50) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idbranch`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_stock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_stock` (
  `idbranch` INT(11) NOT NULL,
  `idproduct` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_tb_stock_tb_product1_idx` (`idproduct` ASC) VISIBLE,
  PRIMARY KEY (`idproduct`, `idbranch`),
  INDEX `fk_tb_stock_tb_branch1_idx` (`idbranch` ASC) VISIBLE,
  CONSTRAINT `fk_tb_stock_tb_product1`
    FOREIGN KEY (`idproduct`)
    REFERENCES `inventorycontrol`.`tb_product` (`idproduct`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_stock_tb_branch1`
    FOREIGN KEY (`idbranch`)
    REFERENCES `inventorycontrol`.`tb_branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_user` (
  `iduser` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `cpf` VARCHAR(15) NOT NULL,
  `login` VARCHAR(20) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iduser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_client`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_client` (
  `idclient` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(45) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idclient`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_paymentmethod`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_paymentmethod` (
  `idpaymentmethod` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpaymentmethod`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_stockorder`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_stockorder` (
  `idstockorder` INT(11) NOT NULL AUTO_INCREMENT,
  `idbranch` INT(11) NOT NULL,
  `iduser` INT(11) NOT NULL,
  `idclient` INT(11) NOT NULL,
  `idpaymentmethod` INT(11) NULL,
  `ordertype` VARCHAR(20) NOT NULL,
  `deliverynote` VARCHAR(256) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstockorder`),
  INDEX `fk_tb_stockorder_tb_branch1_idx` (`idbranch` ASC) VISIBLE,
  INDEX `fk_tb_stockorder_tb_user1_idx` (`iduser` ASC) VISIBLE,
  INDEX `fk_tb_stockorder_tb_client1_idx` (`idclient` ASC) VISIBLE,
  INDEX `fk_tb_stockorder_tb_paymentmethod1_idx` (`idpaymentmethod` ASC) VISIBLE,
  CONSTRAINT `fk_tb_stockorder_tb_branch1`
    FOREIGN KEY (`idbranch`)
    REFERENCES `inventorycontrol`.`tb_branch` (`idbranch`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_stockorder_tb_user1`
    FOREIGN KEY (`iduser`)
    REFERENCES `inventorycontrol`.`tb_user` (`iduser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_stockorder_tb_client1`
    FOREIGN KEY (`idclient`)
    REFERENCES `inventorycontrol`.`tb_client` (`idclient`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_stockorder_tb_paymentmethod1`
    FOREIGN KEY (`idpaymentmethod`)
    REFERENCES `inventorycontrol`.`tb_paymentmethod` (`idpaymentmethod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_orderstatus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_orderstatus` (
  `idstatus` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstatus`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `inventorycontrol`.`tb_stockorderitem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inventorycontrol`.`tb_stockorderitem` (
  `idstockorderitem` INT(11) NOT NULL AUTO_INCREMENT,
  `idproduct` INT(11) NOT NULL,
  `idstockorder` INT(11) NOT NULL,
  `idstatus` INT NOT NULL,
  `quantity` INT(11) NOT NULL,
  `unitaryvalue` DECIMAL(10,2) NOT NULL,
  `totalvalue` DECIMAL(10,2) NOT NULL,
  `dtremoved` DATETIME NULL,
  `dtregister` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstockorderitem`),
  INDEX `fk_tb_stockorderitem_tb_product1_idx` (`idproduct` ASC) VISIBLE,
  INDEX `fk_tb_stockorderitem_tb_stockorder1_idx` (`idstockorder` ASC) VISIBLE,
  INDEX `fk_tb_stockorderitem_tb_orderstatus1_idx` (`idstatus` ASC) VISIBLE,
  CONSTRAINT `fk_tb_stockorderitem_tb_product1`
    FOREIGN KEY (`idproduct`)
    REFERENCES `inventorycontrol`.`tb_product` (`idproduct`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_stockorderitem_tb_stockorder1`
    FOREIGN KEY (`idstockorder`)
    REFERENCES `inventorycontrol`.`tb_stockorder` (`idstockorder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_stockorderitem_tb_orderstatus1`
    FOREIGN KEY (`idstatus`)
    REFERENCES `inventorycontrol`.`tb_orderstatus` (`idstatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


/*INSERTS DE TABELAS BASE PARA TESTES | https://www.generatedata.com/ */

/*
INSERT INTO tb_branch (name,street,city,state,telephone,manager) VALUES ("Ullamcorper Consulting","477-3322 Dapibus Av.","Rio de Janeiro","RJ","(791) 897-9190","Porter Bartlett"),("Nullam Lobortis LLP","1655 Ipsum St.","Campinas","SP","(347) 255-1392","Phillip Watson"),("Aliquam Gravida LLC","5405 Nunc Av.","Jundiaí","São Paulo","(230) 674-6563","Quentin Newman"),("Donec Porttitor Incorporated","Ap #589-6840 Luctus Rd.","Piracicaba","SP","(564) 441-7862","Drew Saunders"),("Placerat Augue Corp.","P.O. Box 232, 8584 Accumsan Rd.","Osasco","SP","(204) 435-3838","Boris Salinas"),("Nullam Velit Dui Consulting","3773 Aliquam Street","Blumenau","SC","(900) 837-4079","Ronan Dickerson"),("Luctus Ipsum Leo Ltd","7501 Et, Road","Belford Roxo","Rio de Janeiro","(825) 441-5466","Carlos Sharp"),("Nisl Arcu Consulting","Ap #839-5072 Ut Av.","Mogi das Cruzes","São Paulo","(206) 345-2336","Quinlan Rosa"),("Lacus LLP","135-7916 Suspendisse Street","Lauro de Freitas","BA","(155) 437-5850","Kareem Camacho"),("Ut Molestie PC","P.O. Box 768, 2269 Suspendisse St.","Piracicaba","São Paulo","(294) 238-1762","Tate Weeks"),("Eget Limited","502-2792 Eu, St.","Osasco","SP","(650) 772-6435","Yoshio Conley"),("Eget Metus Eu Associates","607-7065 Sed Rd.","Florianópolis","SC","(211) 651-8394","Oren Riley"),("Dui Nec Foundation","P.O. Box 971, 7373 Interdum St.","Açailândia","MA","(723) 948-2436","Tad Slater"),("Quisque Varius Ltd","8164 Orci Av.","Olinda","PE","(307) 171-2106","Omar Bishop"),("Semper Et Lacinia LLP","436 Morbi Avenue","Balsas","MA","(254) 762-5215","Ezekiel Sharp"),("Venenatis Corp.","P.O. Box 469, 2404 Mauris Street","Chapecó","Santa Catarina","(239) 688-0772","Chester Langley"),("Non Arcu Vivamus Corp.","Ap #139-5503 Ac, St.","São Gonçalo","RJ","(420) 717-3611","Ahmed Chan"),("Dolor Foundation","P.O. Box 473, 165 Purus, St.","Osasco","São Paulo","(450) 226-2259","Garth Joseph"),("Metus Facilisis Consulting","Ap #713-955 Sed Ave","Sete Lagoas","MG","(633) 141-9173","Rashad Robertson"),("Et Magnis PC","7279 Mauris Rd.","Juiz de Fora","MG","(487) 215-8082","Ciaran Mercado"),("Turpis Vitae Incorporated","851 Eros St.","Guarulhos","SP","(900) 499-0149","Andrew Kerr"),("Duis PC","775-5060 Nam Road","Valparaíso de Goiás","Goiás","(800) 172-4428","Mark Harrell"),("Eget Odio Inc.","934-6536 Ultricies Rd.","Betim","Minas Gerais","(765) 467-5426","Price Logan"),("Dapibus PC","967-9024 Elit. St.","Guarulhos","SP","(155) 529-3673","Emmanuel Kelley"),("Pellentesque Industries","8735 Tincidunt Ave","Guarulhos","São Paulo","(156) 973-3777","Amery Pennington"),("Semper Et PC","672-4736 Metus. Street","Piracicaba","SP","(368) 793-4845","Jamal Valentine"),("Odio Vel Est Foundation","Ap #877-5959 Nulla St.","Guarulhos","São Paulo","(189) 605-5483","Honorato Davis"),("Lacus Etiam Incorporated","571-6251 Mauris Rd.","Recife","Pernambuco","(298) 610-4081","Duncan Cannon"),("Ut Sagittis Lobortis Industries","1586 Eget Avenue","Piracicaba","SP","(675) 992-6260","Abraham Flores"),("Auctor Incorporated","P.O. Box 644, 5168 Mollis Ave","Uberlândia","MG","(832) 416-6586","David Bowman"),("In Cursus Industries","1816 Mauris Av.","Campinas","SP","(245) 453-9257","Joseph Guy"),("Et Magnis Corp.","P.O. Box 806, 8923 Ante. Road","Contagem","MG","(542) 801-4677","Steven Noel"),("Nunc Ac Mattis Corporation","Ap #737-8413 Ante Avenue","Crato","Ceará","(117) 736-5621","James Gibson"),("Suspendisse Aliquet Sem Associates","Ap #553-5880 Vitae, St.","Anápolis","GO","(291) 939-2178","Jelani Walsh"),("Ac PC","P.O. Box 169, 159 Pharetra St.","Florianópolis","SC","(380) 496-6739","Alec Clark"),("Tincidunt Neque Consulting","Ap #260-2248 Sed Street","Colombo","Paraná","(664) 387-2053","Len Shannon"),("Nullam Corporation","310-9794 Magna Road","Marabá","Pará","(877) 487-1962","Barrett Webb"),("Mauris Blandit Enim Limited","Ap #665-3357 Commodo Street","Guarulhos","São Paulo","(593) 601-3319","Salvador Young"),("Aliquet Nec Imperdiet Associates","Ap #849-3788 Elit. St.","Vitória da Conquista","BA","(936) 680-1012","Aidan Humphrey"),("Lorem Foundation","P.O. Box 871, 913 Sit St.","Ribeirão Preto","SP","(935) 861-5403","Ferdinand Gentry"),("Duis Associates","756-3478 Nec Av.","Contagem","MG","(297) 846-6734","Vernon Sweet"),("Ullamcorper Limited","248-3915 Tellus Road","Petrópolis","Rio de Janeiro","(610) 515-2323","Chandler Clayton"),("Magna Ut Tincidunt Institute","Ap #883-5158 Amet, Rd.","Camaçari","BA","(806) 951-3120","Connor Clark"),("A Consulting","7241 Quis St.","Marabá","PA","(280) 452-5806","Evan Dunlap"),("Orci Lobortis Incorporated","P.O. Box 187, 1524 Pede. Rd.","Rio de Janeiro","RJ","(305) 938-8953","Darius Buckner"),("Phasellus Elit Incorporated","P.O. Box 371, 3601 Pellentesque, St.","Diadema","SP","(213) 613-9168","Colt Morales"),("Lorem Eget Mollis Incorporated","8959 Et, Avenue","São Gonçalo","Rio de Janeiro","(395) 755-4487","Kane Bonner"),("Pretium Aliquet Inc.","8826 Ut, St.","Florianópolis","SC","(165) 246-6608","Rajah Cantu"),("Natoque Penatibus Et LLC","P.O. Box 401, 3463 Lacinia Av.","São Luís","Maranhão","(754) 610-0975","Preston Weaver"),("Consectetuer Inc.","Ap #521-5513 Sollicitudin Street","Rio de Janeiro","RJ","(184) 733-4861","Benedict Santana");
INSERT INTO tb_branch (name,street,city,state,telephone,manager) VALUES ("Integer Vitae Nibh Limited","808-9248 Magna. Street","Guarulhos","SP","(121) 602-4696","Barclay Vincent"),("In Lorem Company","Ap #944-8807 Ipsum Road","Bragança","Pará","(138) 385-9661","Tiger Martin"),("Ac Tellus Ltd","Ap #299-7799 Nunc Rd.","Canoas","RS","(950) 906-7043","Vaughan Durham"),("Fusce Mi Industries","Ap #263-862 Lectus St.","Mogi das Cruzes","São Paulo","(843) 977-4836","Wesley Wilkerson"),("Turpis Aliquam Limited","P.O. Box 773, 5870 Tincidunt Road","Cascavel","Paraná","(991) 500-6057","August Holcomb"),("Tellus Industries","Ap #688-5303 Nisl Rd.","Bragança","PA","(937) 508-2641","Jerry Blanchard"),("Nulla Eget Institute","602-4796 Vitae, Av.","Rio Grande","Rio Grande do Sul","(230) 916-6884","Coby Hodges"),("Non Inc.","723-8824 Malesuada St.","Valparaíso de Goiás","GO","(687) 773-6159","Drake Fleming"),("Eu Nulla At Consulting","P.O. Box 925, 2429 Dapibus Avenue","Foz do Iguaçu","PR","(879) 624-3680","Dean Green"),("Donec Nibh Enim Institute","234-4261 Nunc Road","Novo Hamburgo","Rio Grande do Sul","(403) 417-6141","Isaiah Farrell"),("Ligula Company","P.O. Box 407, 4495 Risus, Rd.","Jundiaí","São Paulo","(838) 269-8941","Clinton Cummings"),("Malesuada Augue Ut LLP","P.O. Box 778, 3988 Magna. St.","São Luís","MA","(113) 989-2817","Reese Cross"),("Lorem Vehicula Et Industries","2502 Sapien St.","Belém","PA","(240) 849-0669","Aidan Nash"),("Pellentesque Tellus Associates","2050 Tincidunt Av.","Caruaru","PE","(271) 383-8803","Uriah Macdonald"),("Nulla Institute","4448 At Rd.","Guarulhos","SP","(920) 468-4081","Luke Wheeler"),("Dictum Phasellus In Limited","P.O. Box 416, 5511 Mi, Street","Abaetetuba","PA","(120) 328-8436","Marvin Sharpe"),("Vestibulum Lorem Associates","241-8199 Vel, Avenue","Itabuna","Bahia","(412) 962-6714","Vaughan Farmer"),("Eget Tincidunt Foundation","Ap #999-861 Enim Rd.","Guarulhos","SP","(681) 304-7251","Jared Blackwell"),("Tellus Lorem Inc.","919-3612 Mus. Rd.","Diadema","São Paulo","(575) 333-3441","Harding Hogan"),("Metus LLC","P.O. Box 343, 4410 Donec Av.","Piracicaba","São Paulo","(248) 900-4246","Harding Ware"),("Dapibus Ltd","495-3242 Non, Street","Mauá","São Paulo","(181) 584-3209","Aaron Warner"),("Metus Vivamus Euismod Corp.","P.O. Box 809, 2516 Proin Avenue","Vitória da Conquista","Bahia","(735) 666-5574","Graiden Carson"),("Vulputate Consulting","7530 Sodales St.","Mauá","SP","(537) 260-6440","Caleb Townsend"),("Eget Ipsum Donec Associates","P.O. Box 633, 5090 Mus. Ave","Paulista","PE","(694) 362-3581","Brian Wiley"),("Mi LLP","P.O. Box 322, 2344 Donec Street","Divinópolis","Minas Gerais","(654) 101-3223","Cedric Floyd"),("Quis Corp.","Ap #505-2209 Ut Rd.","Cascavel","Paraná","(581) 220-7605","Rashad Stephens"),("Dui Nec Tempus LLC","P.O. Box 958, 5808 Iaculis Avenue","Vitória da Conquista","BA","(520) 614-1633","Martin Reed"),("Cum Foundation","Ap #510-1453 Malesuada Rd.","Santa Rita","Paraíba","(290) 397-4170","Yardley Garrison"),("Rhoncus Proin LLP","190-9466 Phasellus Avenue","Carapicuíba","São Paulo","(997) 436-5192","Brent Graham"),("Posuere Corporation","P.O. Box 773, 2581 Ultricies Avenue","Santa Maria","Rio Grande do Sul","(535) 203-8240","Ulysses Ayala"),("Ultrices PC","457-5763 Ultricies Rd.","Niterói","Rio de Janeiro","(162) 743-8226","Len Ortiz"),("Amet Foundation","Ap #876-368 Vitae, Av.","São José dos Pinhais","PR","(466) 409-1096","Barrett Black"),("Eu Eros Company","P.O. Box 666, 6498 Eu, Ave","Piracicaba","São Paulo","(373) 481-1743","Adrian Bradley"),("Maecenas Mi Associates","494-9372 Blandit St.","Santa Luzia","Minas Gerais","(782) 264-5436","Fulton Leon"),("Non Limited","P.O. Box 302, 3211 Nunc. Road","Foz do Iguaçu","PR","(816) 902-3623","Geoffrey Buckner"),("Mi Pede Nonummy LLP","Ap #782-2008 Hendrerit. Rd.","São Luís","MA","(401) 888-8526","Macaulay Hampton"),("Accumsan Interdum LLC","Ap #984-1362 Rhoncus Street","Mauá","SP","(558) 233-6539","Carson Lynch"),("Consequat Incorporated","P.O. Box 301, 3683 Nonummy Avenue","Itapipoca","Ceará","(954) 109-8627","Lance Pratt"),("Est Congue A Foundation","9265 Elit St.","Criciúma","SC","(514) 594-5087","Tiger Wilkinson"),("Fusce Aliquet Magna Company","Ap #765-5592 Tristique Avenue","Campinas","São Paulo","(988) 884-1438","Robert Mccall"),("Interdum Nunc Sollicitudin Company","225-6942 Vel, Street","Anápolis","Goiás","(586) 818-9066","Felix Macias"),("Mauris Corp.","232-4872 Sodales Ave","Ponta Grossa","PR","(886) 253-7791","Zahir Johnson"),("Erat Vel Pede LLP","9993 Nec, Avenue","Porto Alegre","Rio Grande do Sul","(951) 835-1235","Shad Sanders"),("Pharetra Ltd","902-1915 Et, St.","Caruaru","PE","(845) 782-3547","Cole Cunningham"),("Donec Egestas Aliquam Company","P.O. Box 218, 1798 Semper, Ave","Piracicaba","SP","(266) 739-8517","Gareth Morgan"),("Euismod Et Commodo Incorporated","925-2522 Placerat Ave","Parauapebas","PA","(811) 700-1341","Alfonso Carson"),("At Limited","P.O. Box 507, 1269 Ipsum Street","Itapipoca","Ceará","(867) 544-2317","Leroy Meyers"),("Varius LLC","4371 Vel, St.","Betim","Minas Gerais","(251) 734-5352","Cyrus Reyes"),("At Sem Inc.","Ap #941-3781 Scelerisque Av.","Santa Maria","RS","(601) 596-3792","Raja Carey"),("Nunc Pulvinar Inc.","413-1640 Leo. Ave","Itabuna","BA","(387) 937-4845","Allistair Delacruz");

INSERT INTO tb_product (name,sequential,barcode,description,price) VALUES ("soups","UZD72KUG4HY","FGU61VMD1RN","aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam",93),("desserts","FMM76FNZ6FK","MCP23MEY1TC","augue. Sed molestie. Sed id risus quis diam luctus lobortis.",107),("stews","NHU08PKE5HF","WRN78GMC7TK","ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices,",93),("stews","TEB94VQQ4IV","SSI05LXD1PF","feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam",127),("pies","QOC34WEP8ZT","JCN16EMA1KP","Cras sed leo. Cras vehicula aliquet libero. Integer in magna.",91),("pasta","TUW63JDJ5JS","DBN85MGX9NU","at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum",36),("stews","XCJ81FGF6PK","MEF02XTC9SG","tellus eu augue porttitor interdum. Sed auctor odio a purus.",7),("seafood","ZTA01UBI7HL","VJN85FRN1TC","nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere",146),("seafood","SNM43UWO9IY","FAT18LUL6KQ","amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat",41),("pies","DQU94BGK8KV","XZY03EEZ0LD","Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci.",112),("salads","UOY30KYG8IE","QZY51HGF8ZQ","nec urna suscipit nonummy. Fusce fermentum fermentum arcu. Vestibulum ante",6),("seafood","KLZ53TBR4IO","EUZ28JHM7ER","Curabitur egestas nunc sed libero. Proin sed turpis nec mauris",20),("salads","COY15CUM6KM","OOS12GSA4XN","euismod ac, fermentum vel, mauris. Integer sem elit, pharetra ut,",20),("sandwiches","XKR19UIO1SS","RQS01INV3XV","lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet",69),("sandwiches","UKE52FZR3BM","RLV20HFX9CT","facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa.",41),("seafood","FBC79PSH5OJ","PJZ45CBU0SE","Praesent interdum ligula eu enim. Etiam imperdiet dictum magna. Ut",105),("pasta","CEJ11WSJ6US","XDS61VUZ2CI","lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue. Sed",131),("desserts","RWU27UAX8AS","FQF78UQD6QJ","tristique senectus et netus et malesuada fames ac turpis egestas.",58),("noodles","ZRW73DZK9EF","NPQ16QXR5IQ","Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus,",63),("soups","KBI99USW0WT","JCH04PGW9GS","elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum",23),("stews","XOK82XWQ2FU","ZWX02VJY8XC","egestas nunc sed libero. Proin sed turpis nec mauris blandit",35),("pies","FNL85BDV3ZF","HZY03HAU8RE","Etiam imperdiet dictum magna. Ut tincidunt orci quis lectus. Nullam",38),("seafood","DVA39GYN8VG","BLG46XUM3HY","in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla",80),("pies","KAK88UWJ6QO","CBA19QYB8BK","Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum",121),("pies","QIL06SKM9IO","FUV72KOV1TS","dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus",30),("seafood","QST57GFA7EQ","TEC19XRI1DX","cubilia Curae; Phasellus ornare. Fusce mollis. Duis sit amet diam",102),("cereals","MNV02QBZ0DX","WPD56KLG6WZ","consequat, lectus sit amet luctus vulputate, nisi sem semper erat,",13),("noodles","GWO54GEL8IK","KSC72HHC4LS","dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor",43),("seafood","CRA23XIO3CM","JNZ76GCI8ET","mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada.",60),("pasta","SFP08CWI4JE","NHG02RBE4TP","eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit",77),("cereals","OEC10LYN6LJ","CCJ47NHI0MH","a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed",18),("desserts","IPO39NJT1XF","SOO94YFC5DW","id risus quis diam luctus lobortis. Class aptent taciti sociosqu",35),("stews","CJJ02UXY7YZ","FKX79LGQ1PA","arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus.",129),("cereals","AZC89DSR0GV","ZKT22TZZ7HO","elit sed consequat auctor, nunc nulla vulputate dui, nec tempus",4),("desserts","IQX51NIB2QX","SAI22HXX3ZG","tristique senectus et netus et malesuada fames ac turpis egestas.",132),("sandwiches","WJJ35UII2VG","VKI05LDS9YX","lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in",36),("stews","XFP58QWH3QY","DAM03BDK7RN","Duis mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum.",50),("pasta","TSV22QKQ0ZQ","SFZ02SMM2BE","neque venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede",140),("seafood","AHJ10LIN0RW","NIP57FKX7RZ","Ut tincidunt vehicula risus. Nulla eget metus eu erat semper",8),("stews","SER03CYJ8FF","MWJ79KOR2FL","turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy ut,",4),("desserts","WQV53RLH6DW","SVN06XLD0EX","Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus.",25),("sandwiches","TEU70QHO8WY","CTN12DSU5BZ","interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt",4),("soups","RWD57NOY0CW","OQW50SML9EB","vitae risus. Duis a mi fringilla mi lacinia mattis. Integer",57),("seafood","AHJ12PFI8XF","YGM58VPU5YR","diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget,",137),("sandwiches","GJJ62CEF5EX","AKI79YHB1ZV","et, euismod et, commodo at, libero. Morbi accumsan laoreet ipsum.",119),("pasta","XCB26RKJ2MW","URE89ASX8FT","interdum enim non nisi. Aenean eget metus. In nec orci.",75),("stews","ONW55KNB1NG","NIJ08ARR4GX","In nec orci. Donec nibh. Quisque nonummy ipsum non arcu.",28),("pasta","CXE55PUV1JD","ISM11ZDO5EL","malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris",78),("cereals","WQM39KRC0PY","RFD13IPR8WG","Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi,",9),("sandwiches","ACQ70IOR2JT","KUT63TBY4WQ","dictum placerat, augue. Sed molestie. Sed id risus quis diam",44),("pies","VNK02LAT8KI","LPD55WNQ2MG","Proin sed turpis nec mauris blandit mattis. Cras eget nisi",104),("cereals","IWG73NND4AA","NHB53EQX6YE","ligula consectetuer rhoncus. Nullam velit dui, semper et, lacinia vitae,",71),("pasta","FAV07FBQ4NW","FST73TKJ3UD","Sed id risus quis diam luctus lobortis. Class aptent taciti",86),("salads","LNF83IMU7MA","ASU19EDO1ZW","interdum ligula eu enim. Etiam imperdiet dictum magna. Ut tincidunt",43),("sandwiches","MSN57JJT4FO","XHT32MRN7NU","eu, odio. Phasellus at augue id ante dictum cursus. Nunc",148),("noodles","DZR65GYF5GO","DIH92FYS2XO","tellus justo sit amet nulla. Donec non justo. Proin non",46),("stews","OEW70NYL9JK","ZGM05TQS2IN","leo, in lobortis tellus justo sit amet nulla. Donec non",135),("seafood","AYL05DBB4IM","QMM00GWN3UP","erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum",123),("pasta","AVC29TBW3IV","ULI58NMX0KZ","Curabitur dictum. Phasellus in felis. Nulla tempor augue ac ipsum.",44),("soups","OJX30NCG3LQ","GAF59DMW0EX","nascetur ridiculus mus. Donec dignissim magna a tortor. Nunc commodo",73),("desserts","SZM09RCE1GZ","BHL30ZYJ6FP","accumsan sed, facilisis vitae, orci. Phasellus dapibus quam quis diam.",103),("sandwiches","OYK11QCJ0UZ","WML34YOZ5WW","luctus et ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis.",137),("pasta","LQJ97JYU3MW","MQS48KPP7CF","non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum",55),("soups","WGK27LXH7OW","AEY37KDV4AH","Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna.",71),("sandwiches","YIQ50JXA2BV","KRJ07JTY4DK","ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin",87),("sandwiches","LQA89MJJ9VJ","JDA02YUD1HJ","neque pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc",143),("soups","PEI98XXA4IE","ZZI60CTZ9GQ","Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis",136),("salads","HAY45LJQ5MC","XQK67FXJ7KT","Cum sociis natoque penatibus et magnis dis parturient montes, nascetur",34),("salads","KUW21ZED4ZC","OPC56KES1PB","Phasellus at augue id ante dictum cursus. Nunc mauris elit,",27),("noodles","VSC55ZFM5SW","JMA77VXB1JW","mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy",72),("salads","ZRS88VPE7FX","QMY17EUK8EV","venenatis lacus. Etiam bibendum fermentum metus. Aenean sed pede nec",45),("stews","VVZ88ISF6IC","QUC38EEA0GP","ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac",17),("pies","NLY70TBL6ZX","IDP48PAN4XS","nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus",23),("seafood","VFN19YPQ5BR","AUV22NVP4KZ","Duis sit amet diam eu dolor egestas rhoncus. Proin nisl",108),("soups","ITK81GPC8QO","LMP74EEH0UC","eu dui. Cum sociis natoque penatibus et magnis dis parturient",107),("stews","PAS42KPL9DP","CEI08YBD1CB","mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor",98),("stews","EZG88SUR8MW","HXC51YPW4JR","Nulla tincidunt, neque vitae semper egestas, urna justo faucibus lectus,",88),("pies","KNQ35BAS4UG","BPW66TYW3FK","elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu",146),("pasta","VEO46DSG1AE","DAF85FSE5SN","dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et",127),("cereals","DQO17HHW5GR","YGG35GBH4AX","quam. Curabitur vel lectus. Cum sociis natoque penatibus et magnis",50),("pasta","XLF74ISR1XY","JZQ04KXH1JK","blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer",132),("pasta","SIT52BUG8EX","UPL08COH9WF","Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec",27),("soups","COL25HHD3GG","VBT63UZI8PJ","parturient montes, nascetur ridiculus mus. Donec dignissim magna a tortor.",56),("stews","XZE88SUY2KN","VZN24ZUE7WM","diam at pretium aliquet, metus urna convallis erat, eget tincidunt",48),("cereals","GHY29GFB9GU","NDD40BVA6IB","Sed eget lacus. Mauris non dui nec urna suscipit nonummy.",92),("desserts","RWP37GLU7GE","CDM41PJF3TI","Praesent eu dui. Cum sociis natoque penatibus et magnis dis",74),("salads","VOF70KFX0EB","ZQI03AMG5TP","feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum",105),("noodles","FFI95RPE3MV","MWS53KGS5OM","eget nisi dictum augue malesuada malesuada. Integer id magna et",15),("stews","FKE41EIF4RW","OFN70WEJ6CQ","malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis",23),("desserts","UUM29LPS1BN","LSY25KON4DK","ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque.",18),("sandwiches","ART70INE3KL","IBX21VFN5XS","venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien.",133),("stews","XLH78GOI0GQ","ZOP16YSR4VJ","dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor",114),("salads","PNP00MGV2IR","KVI64IKZ6DM","sit amet luctus vulputate, nisi sem semper erat, in consectetuer",64),("pasta","BKD85MGY3EM","ZEH63CLH3SP","ac mattis semper, dui lectus rutrum urna, nec luctus felis",116),("pasta","XQS07BPL7EX","QPX77YRH9WA","erat volutpat. Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla.",142),("seafood","XKD57FPB2IV","IHA50IES3GA","sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis",135),("soups","TIB27JWV5PN","OID85MYV5ZP","mus. Donec dignissim magna a tortor. Nunc commodo auctor velit.",105),("cereals","VVR42YKF3FL","BWV19GCC2BC","at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac",93),("stews","HWR61CYT5NU","MQD81HLA1LP","mi enim, condimentum eget, volutpat ornare, facilisis eget, ipsum. Donec",142),("stews","FMN98YXX4OC","BHF79KZY8BM","non massa non ante bibendum ullamcorper. Duis cursus, diam at",64);
INSERT INTO tb_product (name,sequential,barcode,description,price) VALUES ("desserts","III31OSC8IV","KOR76MEE7BI","iaculis odio. Nam interdum enim non nisi. Aenean eget metus.",113),("sandwiches","OUI45UYX3UV","KJL08XXU8QZ","Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede.",38),("noodles","BHN48HFV6WA","MWO05OXZ5VQ","purus. Nullam scelerisque neque sed sem egestas blandit. Nam nulla",2),("pies","CBH94GXZ8JN","WHL91RYZ5VA","sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique",96),("pasta","VVC32EMG7GN","PKM88GLR3SH","ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem elit,",94),("cereals","ULG69DNC0JG","ZNH52LOZ7EJ","blandit. Nam nulla magna, malesuada vel, convallis in, cursus et,",64),("pies","MLW96EWJ7AR","FMA33QJM3OC","lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi.",121),("desserts","MGQ83MMX5CE","OQX06UMF2TT","volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis.",135),("pasta","WNL14DAK8JT","NIN44MSO4MG","Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus",140),("seafood","GOW24EDV8FP","KZY03CAR5GE","mauris sapien, cursus in, hendrerit consectetuer, cursus et, magna. Praesent",21),("sandwiches","ZHV86MNE5QW","VJF32QNW5AX","egestas blandit. Nam nulla magna, malesuada vel, convallis in, cursus",149),("pies","MRC26OVW5VX","XFM62UEX0RP","Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo",139),("soups","QXB36WFX5WB","GWY08ZCC4WC","primis in faucibus orci luctus et ultrices posuere cubilia Curae;",119),("pasta","XCB74PZQ3HI","NHC47OIR5MC","auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus,",112),("sandwiches","FVH32OVB3ES","TTK74RUL7EU","molestie. Sed id risus quis diam luctus lobortis. Class aptent",129),("pies","KWV04WIV7HS","MWX23HLK7QJ","vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit",92),("seafood","AFJ20MHD1VR","XUR15FUS0PT","sem. Nulla interdum. Curabitur dictum. Phasellus in felis. Nulla tempor",19),("cereals","MGQ27JBY0VF","AQK91AWD9PY","a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.",136),("desserts","VRT76XPE9FL","ISS33SXH7PD","mi eleifend egestas. Sed pharetra, felis eget varius ultrices, mauris",116),("pasta","QQQ70HCR3KB","ORT97DXQ2BY","non dui nec urna suscipit nonummy. Fusce fermentum fermentum arcu.",131),("soups","MEF94YEX0DD","TEQ00SNA8QW","feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum",74),("salads","XGO56FPR7AQ","KDM03HGH4HO","Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum",61),("soups","RMN64JEF5FF","IQH11JGY6TS","lobortis quis, pede. Suspendisse dui. Fusce diam nunc, ullamcorper eu,",88),("salads","GGU42GMS5VX","XCA16WOK0HY","est, mollis non, cursus non, egestas a, dui. Cras pellentesque.",42),("cereals","SUD54JXA0XP","XIP13ANK8KY","habitant morbi tristique senectus et netus et malesuada fames ac",125),("pasta","IMO61XHX4JD","XAR11NAS6PE","commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa",48),("pasta","HPB49KOM3TG","WQR27DHB0OD","Nunc lectus pede, ultrices a, auctor non, feugiat nec, diam.",38),("seafood","UUO28MAM4KN","EYB64IRB6SS","mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor",146),("pies","LLM21QJY8UK","QPW85CAW9XG","Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum metus. Aenean",127),("soups","MEU24QWO2NA","XXJ18PWM7GH","convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc",119),("desserts","AZF92NZQ4JU","OVY04YUZ1NR","sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus",109),("cereals","KCB61GQN2FV","TIT89VDA4AR","sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum",78),("salads","BXR35ONG7GF","ZAF60ZUR7QX","Donec porttitor tellus non magna. Nam ligula elit, pretium et,",46),("soups","JHV59GGU8PV","GZG54WEJ7LW","luctus sit amet, faucibus ut, nulla. Cras eu tellus eu",17),("desserts","FSJ45JUX9GA","FCP74QIV2ZX","ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend",58),("seafood","LDE04AKO6HV","UHU17KFI8XX","ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris",93),("sandwiches","IQZ19YXK9EE","ATO89EWT7DI","dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing",38),("pasta","BWQ41PAN8VH","NOV56UHT7OD","enim, sit amet ornare lectus justo eu arcu. Morbi sit",79),("pies","HRK25SVW7FF","LFO89HKU6AO","sit amet, faucibus ut, nulla. Cras eu tellus eu augue",66),("pies","IHF80CFA9AI","ZLD88XMO6YY","pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum.",90),("pasta","OVI69NEV9GS","PZX46PFD0IF","Nulla dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit.",79),("pasta","ETC37DOK6IO","CPK07QXX8VO","mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla,",119),("stews","ZIH00ZIA5GU","ECX81GQT1EV","egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla",28),("stews","XCD51QSS3MW","DAI32KFD8MQ","tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi",43),("noodles","MYO99WPZ6EZ","MYP45BCJ9US","nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus",96),("soups","BUJ04HQY9VP","NKH42PCD4YV","nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet.",111),("noodles","UUU59QRL2WI","KUP43FFY3BP","velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices.",140),("pies","YAJ80CGD8AF","LCZ11MEN7AC","molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl",149),("stews","LVZ39DFV6SG","DDG04XUZ3QX","ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin",97),("cereals","MAG49FYX0IW","ZVS11NQA9ID","mollis. Duis sit amet diam eu dolor egestas rhoncus. Proin",132),("salads","MID13PIQ6HO","VVS55SFY4FW","ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec,",12),("noodles","WBW84STC6IG","NJP53DJV5WA","eleifend, nunc risus varius orci, in consequat enim diam vel",52),("sandwiches","SFO04SSN4WQ","FZS49DND5UE","tellus. Aenean egestas hendrerit neque. In ornare sagittis felis. Donec",124),("sandwiches","CWY95KCH6TP","QRW27XGA3DV","tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id,",131),("pies","IMT90LYL1VQ","TUN12TQZ9KH","ornare, elit elit fermentum risus, at fringilla purus mauris a",137),("noodles","YAA32NKW7SL","FJB22NGC6EK","metus eu erat semper rutrum. Fusce dolor quam, elementum at,",19),("cereals","PUU07KVS0NW","CBO41IEG1TM","at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et",82),("salads","OHM10NIJ1QX","VFK21SBF8CZ","enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie",50),("cereals","ISY51YCT0BA","WJQ49KPL5WG","sit amet luctus vulputate, nisi sem semper erat, in consectetuer",145),("stews","CDV23SIZ0SG","PYH12WEB4IG","a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras",139),("noodles","ARM98GYE3OV","WKI35JCW6CV","et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien,",93),("cereals","HBF92JIO1EF","PQC48YKW4DB","varius et, euismod et, commodo at, libero. Morbi accumsan laoreet",52),("desserts","IUS47WTP7VJ","UON13JBK5NK","a purus. Duis elementum, dui quis accumsan convallis, ante lectus",50),("soups","CPH71FWD8WQ","ACH48PRI7AL","mattis ornare, lectus ante dictum mi, ac mattis velit justo",59),("seafood","YPE80MGU9PP","TCL95LRN9PK","sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id",142),("cereals","CQT33IYB8PW","QJM77OEE2UW","enim consequat purus. Maecenas libero est, congue a, aliquet vel,",115),("cereals","NIB34SBP1JU","YBN77TUO6TH","imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non,",10),("noodles","EVV36VFN3SP","FCF81ZAF1BL","lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum",5),("pasta","IVI65HGL2JV","GRK99GQA3CP","diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis eget,",99),("desserts","FUY19NGO9OB","PWS97ZCU5OW","lacus vestibulum lorem, sit amet ultricies sem magna nec quam.",28),("sandwiches","TZU66WFP2EA","MVN87RRN0UM","felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem,",69),("sandwiches","YKS49OIO2HI","URT66MTS1NK","commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus",128),("seafood","AIZ69DFL5PM","CTI66OAC6FD","tincidunt aliquam arcu. Aliquam ultrices iaculis odio. Nam interdum enim",141),("salads","URT39HGS1KP","PMH61DEC1LR","vulputate, nisi sem semper erat, in consectetuer ipsum nunc id",6),("soups","EEV99UCP3ZX","JNA29BUW6BO","nec, diam. Duis mi enim, condimentum eget, volutpat ornare, facilisis",16),("noodles","ZWD05SXL5AG","ZDG52GLP3OD","amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque,",102),("sandwiches","UBI16MQD8KU","FDQ94MUN3VM","dapibus quam quis diam. Pellentesque habitant morbi tristique senectus et",20),("pasta","WNH05PCX0CT","RJB71HMI1CK","aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non,",70),("desserts","CHT30GGO7LA","QNZ23JUR6XK","massa. Integer vitae nibh. Donec est mauris, rhoncus id, mollis",127),("sandwiches","MJD33OHP6AM","VSX72HKK9MW","fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat",86),("desserts","CDA60GVM6DF","MHI07APW4BR","id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque",7),("salads","ZDH72JGB9UM","DSU64ZSU2XT","dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero.",129),("stews","QAT01XSG1WH","QBP42RVR0MZ","ultrices a, auctor non, feugiat nec, diam. Duis mi enim,",55),("soups","FSY17SIK1RB","OAF94TXX5IT","neque. Sed eget lacus. Mauris non dui nec urna suscipit",30),("desserts","VEI82KQA2QP","EBA48WTM3MO","nisi. Cum sociis natoque penatibus et magnis dis parturient montes,",87),("soups","XRH41ZKR4QL","OJB23HFW6EE","cursus purus. Nullam scelerisque neque sed sem egestas blandit. Nam",46),("desserts","ZKI49QOB8KI","KLA38PSR9NO","Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel",125),("pies","TWP39SOV5QU","QNA07TLF1PO","Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede.",109),("pasta","CNT24UCW2PQ","DNM45OGW8FR","Proin sed turpis nec mauris blandit mattis. Cras eget nisi",22),("soups","WYQ17TUI0ON","JTH48SXI2AU","posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget,",50),("pasta","VLI23LWA8AV","PGW80SHW2AN","ligula. Aliquam erat volutpat. Nulla dignissim. Maecenas ornare egestas ligula.",11),("stews","YVV15SZZ1NF","DIO08XRG6PP","semper, dui lectus rutrum urna, nec luctus felis purus ac",89),("salads","VFF22VXV4PA","YHX88HUW2WS","eget tincidunt dui augue eu tellus. Phasellus elit pede, malesuada",101),("stews","KEE56OIM7VB","DKE71HAN1QT","nec, cursus a, enim. Suspendisse aliquet, sem ut cursus luctus,",33),("desserts","WVV31VGB4KD","ZGV44AUR8AV","Sed congue, elit sed consequat auctor, nunc nulla vulputate dui,",96),("desserts","LZE14NLD7IM","EHJ90IGP7JA","a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque",43),("pies","CVY72CFW2ZE","EYU73CAV3MG","quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed",104),("soups","JWO27AJN5HM","CAS62SYD2RW","magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed,",49),("pies","BKX48ZBT4PL","OVH39CAK3OQ","sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus",72),("pasta","VOI09ABU5SG","LQV97AFV9QE","id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis",68);

INSERT INTO tb_user (name,cpf,login,password) VALUES ("Adrian Page","16010312 8351","I9O 4X3","PYH38XQN4HR"),("Brendan Ballard","16600110 6167","E3A 5N9","YZX70HRV3FU"),("Davis Finch","16930803 9982","C4U 8C2","LJQ32QMK4LG"),("Kenyon Madden","16460416 9328","L1C 2V3","GPW65WWN0MH"),("Murphy Jefferson","16920829 5502","J0M 2J9","UYO29UDK3JF"),("Tad Clements","16490514 8641","I9B 4O2","BNO95HHS6IA"),("Holmes Olsen","16170607 8316","K8K 6L8","GOG09BCR3BN"),("Hamilton Hudson","16100418 7090","M5G 2H2","CMT11LNV8HF"),("Quinlan Hudson","16601011 1364","O6X 3B9","XTE74XHP0CM"),("Malachi Phelps","16570911 1321","G2Y 0L3","TER23FSB3VL"),("Dennis Huber","16740230 8667","S0Z 0H7","DZP88QDT0PJ"),("Barclay Garner","16400825 2258","A3I 0D4","UUD84RFM5PD"),("Raymond Page","16691007 0702","E1C 9W9","FSB87ZQO9QF"),("Ignatius Preston","16831208 9934","F5H 0Q7","ATO06BKD5AI"),("Kyle Hood","16580930 0295","G4S 1E2","GTV07ZXD0YJ"),("Brody Mccray","16180928 6188","D2S 8Q7","WBD67AHH0PX"),("Jordan Richardson","16031015 7490","P6W 8F2","WEB35SSK0KV"),("Steven Meyer","16130103 3310","S3W 8X4","ANU02BKR2VB"),("Gregory Conley","16461007 1716","Y2S 5H1","FHB47CEP0EC"),("Hasad Gilbert","16110609 0572","D6D 1E1","LFS05MLJ6NR"),("Hamilton Carr","16091127 6939","X4D 6F7","GCX28MEF6MY"),("Cooper Shaffer","16750822 4511","P2W 0L4","GQX98SSB8IK"),("Thane Mcknight","16770828 3598","V9G 9A3","WHQ06XND1VO"),("Levi Cobb","16700411 8928","L9P 5C2","SPB77CDK5PY"),("Benedict Browning","16510424 6060","A0K 5L8","SPT64GXP7DJ"),("Logan Casey","16260414 0521","F8G 9C8","EDZ61ZVA4OZ"),("Arden Evans","16120711 5013","W2U 5E7","TJB96MRV9DW"),("Ryder Mueller","16220414 4436","W6A 7S1","YRV45BHD8KL"),("Leonard Barlow","16141003 9919","M6C 8K6","ATS16GPP7YY"),("Ivan Keith","16300606 1042","N7P 2H0","PMN98BAW6NX"),("Dante Hudson","16891228 8878","N7G 8D0","HWY24NQV7LH"),("Prescott Sykes","16570101 0190","D9Q 6K3","UFA69UVR5XR"),("Ross Blankenship","16140104 7210","R9F 9G3","FTI67LRT2UM"),("Judah Peck","16060316 6315","Q5W 0I3","VZW66PPC4AS"),("Kenneth Graham","16300225 1399","M5Z 3F8","NRM23ZGR3UG"),("Paul Mcpherson","16000223 9507","N9K 1H9","IVK11DEO2YS"),("Colby Parks","16091219 4255","I7G 7Q1","FOQ94HGN7XR"),("Roth Beasley","16521130 2913","P5V 4I5","EVB97YZT5NF"),("Quinlan Beach","16041103 9969","Q9L 9C0","YXJ39NMT7TY"),("Stewart Berg","16471103 2393","N5C 9W9","ZXO37ZNO8ON"),("Damian Russo","16710609 0017","O6X 4T6","NRA97HIL9KU"),("Adam Robles","16760907 8816","E6C 8T8","JWP04TWQ2UP"),("Berk Barr","16110428 4656","J7U 5L7","UHP47TCL8JJ"),("Forrest Blackburn","16390327 8004","S1O 4K4","JIV23ZPQ2BK"),("Lionel Obrien","16700526 5538","D9U 4Q0","JDF88UJQ6ER"),("Brady Wong","16391229 4158","A1C 8M8","BEA08VEP3ZW"),("Rigel Mayer","16030823 9763","W4U 3U4","WTI24IYW4MF"),("Daquan Huffman","16310430 3130","G1Z 4M7","ZTH51YXX2UD"),("Graham Lowery","16621226 1082","B3C 4R4","FKR28NZQ5FQ"),("Burton Klein","16651206 3089","R5Q 8S9","CYM76PNN0QI"),("Timon Kemp","16250628 9954","J3B 3C3","EUR36DLR0IO"),("Clarke Parker","16511010 3917","F1T 0Z4","YYT40XQP9JC"),("Justin Williamson","16800908 6615","Y8O 4X3","TLA74SFJ4JO"),("Brennan Bonner","16800626 6251","J3E 5H7","LBD77JFJ5LO"),("Fitzgerald Stevens","16660211 4818","O8I 9N1","UQP94WOW3YE"),("Colt Sellers","16280418 3362","Y5U 8V2","BFF99BYT5AE"),("Samson Gamble","16070106 2390","J8I 3T9","TCH45HXV4AN"),("Ezekiel Harrison","16680924 5761","F3F 8Q1","BZD57VLB1LN"),("Alfonso Baird","16950320 1148","T1T 3Z4","LFD43FIK6BC"),("Robert Estrada","16651127 2574","T4I 6P3","COF62DCN0LB"),("Alec Bush","16020827 5545","I9H 8B6","AWD74FHB9XM"),("Bruce Lloyd","16600209 8454","E9X 8K7","ORH28SDS9GC"),("Allen Perez","16080116 9772","M9O 4Z1","FLS20NKZ0BZ"),("Camden Barnes","16230517 1650","I5E 8U2","DDM32CXG2LG"),("Upton Ford","16771206 0529","C0K 6J8","UQF95CVL0HK"),("Murphy Hammond","16050507 1993","D7X 8A4","BYV38OWH8DM"),("Yardley Palmer","16520408 7349","G2G 7X6","XKF70UAZ5WH"),("Wesley Myers","16040613 8594","L8A 8K0","RHR41OKG0KC"),("Sean Blankenship","16600319 4757","J1B 0U6","PMR36RRH6CQ"),("Davis Boyer","16740322 5951","F2I 0X7","FTO70SUI2BN"),("Brock Sparks","16780120 2412","G2T 0M2","VCR20CAR4AO"),("Vance Spence","16270510 0788","U8O 3A7","YZD99QCO2RL"),("Nissim Perkins","16530114 0694","E5O 7L6","CXC56URC6RK"),("Stone Blake","16440512 0140","I7F 0F1","MZN39DIR0QN"),("Caesar Emerson","16520513 1476","H4J 9D4","CIE77PJZ1FF"),("Brendan Rutledge","16641208 4144","F4D 8P2","MYN20PNQ5HU"),("Moses Burch","16560905 1460","A7F 0G9","WDO64VOC7SO"),("Reece Fisher","16410108 4582","V9J 6Z9","BTZ79MNO0QR"),("Dominic Good","16810130 2399","T0N 0F4","MPL80CQR1YO"),("Dorian Adkins","16730514 1389","M0T 1A6","JPZ29GGP7IR"),("Xenos Newton","16200118 6291","G4J 8M4","ILT81DAF3YE"),("Macaulay Watts","16650413 5556","I0X 1N6","IZD33EPD1ZX"),("Laith Grant","16260320 1415","T8Y 3U7","IPU93DWO4GP"),("Uriel Spencer","16620814 3310","U3C 9J6","XBE80JHG5UC"),("Marsden Mccall","16280303 4095","W5Y 4J6","CVU86TXF6SJ"),("Bernard Rogers","16941021 3368","H0S 1V6","KYW34VPU7BG"),("Dieter Figueroa","16400327 1493","T0Z 6R6","ETT23EWY4KW"),("Hamish Henson","16850818 3715","A4C 6M0","IPP28OWW7LR"),("Theodore Chen","16400613 8756","U1N 0R0","UNY03EHB0HN"),("Kaseem Weiss","16411212 5143","J6C 3G6","ETK32UUK9SD"),("Barrett Fernandez","16640226 0217","O0M 7G3","VLF39BBR4NG"),("Brody Potts","16220513 8171","Z7V 6J6","JTP46OSH8ND"),("Simon Gay","16521028 4740","N3H 2F5","NAC04NZM1SG"),("Slade Holman","16390224 2852","F8H 7E6","ASS31GWY6PX"),("Peter Hall","16210925 4256","V2K 1W2","HWP78YOR6FQ"),("Hall Goodman","16580317 9463","J4B 8W4","PTW63KAJ3TK"),("Dorian Koch","16430402 0342","K5C 1W5","WGV23OEE5IW"),("Lyle Barnett","16860802 5469","V0A 1N0","QYB60TSY5LA"),("Abdul Smith","16700612 5327","H9Q 8O8","EXR83VBU8JR"),("Bradley Greer","16960905 1223","N8X 7M5","NJD58YTJ6PS");

INSERT INTO tb_client (name,cpf) VALUES ("Eagan Mason","16290504 3515"),("Lamar Ware","16320620 3097"),("Victor Boyle","16270202 6978"),("Brendan Mcgee","16990822 5817"),("Ira Norton","16550713 9904"),("Guy Hensley","16871107 1814"),("Benedict Robbins","16301228 6625"),("Boris Stewart","16231228 3001"),("Craig Franklin","16071202 0155"),("Phillip Koch","16380407 9642"),("Channing Beck","16441022 2147"),("Kane Fletcher","16100722 0419"),("Dalton Barrett","16181214 3707"),("Zeus Michael","16061027 9937"),("Allistair Gallagher","16600124 9389"),("Camden Hensley","16530901 8801"),("Alan Woodward","16731113 9138"),("Brett Palmer","16280813 8826"),("Herman Whitney","16580430 5687"),("Hammett Barker","16060202 9001"),("Yuli Flynn","16510425 6598"),("Gannon Bridges","16411223 0026"),("Josiah Ellis","16341220 5019"),("Ali Mills","16221016 0764"),("Garrison Conley","16141104 9560"),("Vladimir Stone","16460617 4854"),("Ashton Brady","16070618 4249"),("Tobias Pearson","16620220 2781"),("Christopher Arnold","16920513 3490"),("Ciaran England","16871125 3669"),("Nash Dunn","16610301 4624"),("Kaseem Soto","16010319 2282"),("Dieter Cannon","16461129 9563"),("Martin Skinner","16440404 4929"),("Francis Cabrera","16851107 0677"),("Malcolm Hahn","16170501 2472"),("Flynn Walker","16931101 3495"),("Ciaran Petersen","16710415 6760"),("Aquila Carpenter","16220321 8603"),("Eagan Stuart","16990120 5956"),("Lester Franks","16930301 9773"),("Lane Paul","16680929 6384"),("Vincent Salas","16541104 5528"),("Emery Carpenter","16430618 8600"),("Jesse Bender","16130709 1825"),("Upton Moore","16980308 0226"),("Giacomo Gallagher","16820618 7935"),("Acton Drake","16470727 1468"),("Austin Knowles","16361123 1444"),("Howard Pugh","16441019 8602"),("Aidan Buckner","16560916 2788"),("Jared Michael","16240919 4863"),("Fletcher Beasley","16840901 4985"),("Blaze Meadows","16171005 3099"),("Lucian Galloway","16540617 4218"),("Ali Peters","16521109 9618"),("Abel Greene","16111203 3541"),("Austin Hatfield","16710325 6447"),("Mufutau Barnes","16950723 4798"),("Sebastian Tyler","16650914 3068"),("Gavin Payne","16370607 6084"),("Jeremy Wise","16350723 0047"),("Zeph Bailey","16290211 4046"),("Gabriel Alvarado","16881023 5641"),("Walter Richard","16731022 5318"),("Chaney Douglas","16250623 0255"),("Dalton Henderson","16150425 5249"),("Beau Cannon","16301122 7026"),("Philip Orr","16790423 5384"),("Arsenio Pena","16960707 9127"),("Kenyon Moreno","16241029 2847"),("Aquila Marsh","16980320 8306"),("John Hinton","16150629 2091"),("Hu Gibson","16521021 9688"),("John Atkinson","16471224 1985"),("Keane Owens","16001213 5158"),("Keegan Morrison","16950826 4034"),("Fuller Hall","16120616 6058"),("Callum Zamora","16630515 9979"),("Bevis Weeks","16150826 9568"),("Maxwell Dennis","16961217 5886"),("Thaddeus Mercer","16410423 0067"),("Shad Simon","16741122 2784"),("Malik Beasley","16600413 6492"),("Fulton Pennington","16210810 5996"),("John Steele","16620230 4934"),("Hu Mcbride","16490515 3336"),("Paki Bradley","16430526 5920"),("Stewart Harris","16030908 7724"),("Malcolm Guzman","16590303 9310"),("Sebastian Patrick","16730618 4164"),("Oren Mcdonald","16720928 0291"),("Lev Knox","16740101 1767"),("Reese Vasquez","16540208 3678"),("Arsenio Bright","16680421 7120"),("Nehru Patton","16461101 8930"),("Nash Jacobson","16320320 5566"),("Palmer Whitley","16800427 1899"),("Lee Price","16571202 0543"),("George Franco","16261201 8834");
INSERT INTO tb_client (name,cpf) VALUES ("Octavius Richmond","16900305 0458"),("Orson Rogers","16860124 4794"),("Harper Sellers","16380923 0570"),("Gabriel Bryan","16870824 0489"),("Fritz Neal","16751128 6465"),("Cadman Long","16730826 7652"),("Garrison Bradford","16600704 5922"),("Randall Hardy","16830320 6505"),("Kennedy Joseph","16111106 5114"),("Lucius Griffith","16870826 2939"),("Colby Bullock","16420815 4031"),("Carlos Wheeler","16300806 6361"),("Brett Hodges","16740927 7352"),("Kamal Mcdaniel","16620703 6770"),("Gannon Little","16530905 0051"),("Ryan Chan","16030506 5690"),("Darius Moss","16540309 6059"),("Hayes Chen","16531222 2150"),("Nero Sweeney","16901027 4893"),("Kevin Rodgers","16421217 7960"),("Ronan Gould","16510423 6202"),("Baker Trevino","16830218 6757"),("Hakeem Kirby","16941012 1033"),("Owen Munoz","16561125 6271"),("Ryder Mckay","16710430 4253"),("Conan Rice","16190203 7892"),("Fulton Bowman","16471107 5194"),("Ronan Cooper","16670617 7893"),("Damon Whitney","16200830 1752"),("Allen Gomez","16630717 1741"),("Norman Charles","16170726 5615"),("Drake Sloan","16490116 8882"),("Keith Gross","16410226 2351"),("Ignatius Sloan","16240714 8192"),("Amal Warren","16111230 8299"),("Thomas Mason","16890820 9748"),("Lee Cline","16000626 2638"),("Nissim Vega","16000210 1509"),("Moses Burch","16500802 6444"),("Laith Stanley","16141204 8462"),("Camden Jackson","16540105 2740"),("Callum Dudley","16141203 4611"),("Dillon Camacho","16870223 0353"),("Gavin Leon","16101117 1525"),("Emery Hudson","16200604 8140"),("Vernon Roberts","16710907 4612"),("Ross Morse","16590328 7109"),("Ezekiel Bishop","16300616 2741"),("Baxter Stokes","16210306 3224"),("Tarik Jenkins","16131029 7203"),("Lyle Curry","16830305 2974"),("Quentin Medina","16700629 8991"),("Hyatt Taylor","16501212 9705"),("Wallace Morin","16600801 7227"),("Zeph Bryant","16270922 5177"),("Zachary Craig","16110601 0240"),("Steven Justice","16971111 7813"),("Lionel Short","16700725 1122"),("Ciaran Martinez","16471128 5827"),("Gabriel Vance","16720715 5602"),("Eagan Decker","16160123 2257"),("Christian Torres","16060111 5900"),("Dieter Marquez","16250220 7448"),("Jakeem Frye","16300327 3673"),("Hayes Foreman","16240301 9611"),("Ryan Reese","16970112 9364"),("Hilel Ballard","16990608 1105"),("Gannon Oliver","16791221 6392"),("Connor Beard","16290620 9750"),("Chester Montgomery","16980508 8250"),("Darius Goodman","16710909 8538"),("Daniel Henderson","16030330 1873"),("Alden Hampton","16560220 7820"),("Stephen Barnes","16890519 5379"),("Plato Cross","16300309 1364"),("Fletcher Mayo","16000923 0657"),("Owen Wooten","16410112 1988"),("Dillon Clay","16250111 9511"),("Melvin Dean","16281025 9214"),("Laith Lane","16260509 4834"),("Brett Lee","16210729 8420"),("Rigel Suarez","16501210 3296"),("Vladimir Dalton","16860626 2247"),("Kelly Juarez","16971006 6532"),("Edward Knowles","16680827 1289"),("Zachery Riddle","16250410 3231"),("Burke Espinoza","16720921 0629"),("Aaron Estrada","16630324 6984"),("Michael Drake","16690426 1796"),("Chase Stanley","16691013 2270"),("Randall Fowler","16420613 3854"),("Ferris Griffith","16881022 3936"),("Daniel Cochran","16411111 1813"),("Zeus Hardy","16161108 3237"),("Edward Wiggins","16490323 9475"),("Reese Wheeler","16270922 6746"),("Clarke Horton","16730715 3366"),("Hayes Colon","16070317 0399"),("Steven Johns","16220930 7723"),("Carlos Mcclure","16270228 6523");

INSERT INTO tb_stock (idbranch,idproduct,quantity) VALUES (23,172,884),(45,153,434),(72,148,203),(32,45,297),(45,159,308),(1,164,61),(77,105,868),(18,180,722),(46,119,238),(65,104,150),(57,18,415),(76,144,183),(11,174,872),(24,50,685),(13,88,950),(3,61,573),(7,160,443),(6,97,145),(76,199,950),(35,118,837),(97,51,423),(87,56,25),(96,3,695),(64,174,915),(19,131,964),(49,126,497),(92,131,703),(35,194,580),(59,50,271),(96,22,364),(49,178,935),(34,191,492),(8,166,947),(78,148,453),(3,81,835),(42,138,164),(60,197,970),(81,38,297),(55,45,548),(88,154,385),(14,9,250),(51,102,438),(51,88,304),(97,193,361),(20,153,508),(51,59,325),(26,70,93),(64,189,993),(38,105,856),(99,112,223),(81,80,912),(50,103,769),(1,20,491),(16,120,612),(26,94,976),(42,158,145),(42,87,29),(45,61,407),(91,8,854),(12,193,208);
INSERT INTO tb_stock (idbranch,idproduct,quantity) VALUES (75,155,946),(15,41,972),(56,66,39),(10,148,192),(39,24,23),(89,3,375),(38,13,683),(60,167,946),(18,15,956),(85,110,202),(67,67,224),(31,41,797),(27,88,7),(59,98,536),(53,190,864),(56,3,257),(75,148,679),(62,143,99),(54,4,751),(12,132,308),(40,118,158),(29,44,109),(19,79,802),(43,59,22),(29,190,105),(86,18,304),(73,178,213),(36,76,238),(28,127,223),(11,20,705),(87,6,358),(48,51,608),(65,170,936),(12,142,874),(99,198,3),(49,44,530),(45,13,852),(56,163,610),(54,16,740),(90,45,510);
*/

# PROCEDURES PARA INSERTS E UPDATES

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_branch_save`(
pidbranch int(11),
pname varchar(100),
pstreet  varchar(100),
pcity varchar(50),
pstate varchar(50),
ptelephone varchar(20),
pmanager varchar(50)
)
BEGIN
	
	IF pidbranch > 0 THEN
		
		UPDATE tb_branch
        SET 
            name = pname,
			street = pstreet,
            city =  pcity ,
            state = pstate,
            telephone = ptelephone,
            manager= pmanager
            
        WHERE idbranch = pidbranch;
        
    ELSE
		
		INSERT INTO tb_branch (name,street,city,state,telephone, manager) 
        VALUES(pname,pstreet,pcity,pstate,ptelephone, pmanager);
        
        SET pidbranch = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_branch WHERE idbranch = pidbranch;
    
END$$
DELIMITER ;

        
DELIMITER $$
CREATE PROCEDURE `sp_stock_save`(
pidbranch int(11),
pidproduct int(11),
pquantity int(11)
)
BEGIN

	if (  (select exists( select * from tb_branch where idbranch = pidbranch ))  AND
    (select exists( select * from tb_product where idproduct = pidproduct )) )  then
	
         INSERT INTO tb_stock (idbranch,idproduct,quantity) 
         VALUES(pidbranch,pidproduct,pquantity);
        
         SET pidbranch = LAST_INSERT_ID();
         SET pidproduct = LAST_INSERT_ID();           
          
		 select * from tb_stock;
             
    END IF; 
    
END$$
DELIMITER ;

call sp_product_save(15,'ed','ed','ed','ed',200);

select * from tb_product;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_product_save`(
pidproduct int(11),
pname varchar(100),
psequential  varchar(256),
pbarcode varchar(256),
pdescription varchar(256),
pprice float
)
BEGIN
	
	IF pidproduct > 0 THEN
		
		UPDATE tb_product
        SET 
            name = pname,
			sequential = psequential,
            barcode =  pbarcode ,
            description = pdescription,
            price = pprice

        WHERE idproduct = pidproduct;
        
    ELSE
		
		INSERT INTO tb_product (name,sequential,barcode,description,price) 
        VALUES(pname,psequential,pbarcode,pdescription,pprice);
        
        SET pidproduct = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_product WHERE idproduct = pidproduct;
    
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_save`(
piduser int(11),
pname varchar(100),
pcpf  varchar(256),
plogin varchar(256),
ppassword varchar(256)
)
BEGIN
	
	IF piduser > 0 THEN
		
		UPDATE tb_user
        SET 
            name = pname,
			cpf = pcpf,
            login =  plogin ,
            password = ppassword          

        WHERE iduser = piduser;
        
    ELSE
		
		INSERT INTO tb_user (name,cpf,login,password) 
        VALUES(pname,pcpf,plogin,ppassword);
        
        SET piduser = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_user WHERE iduser = piduser;
    
END$$
DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

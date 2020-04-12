
# PROCEDURES PARA INSERTS E UPDATES

DELIMITER $$
CREATE  PROCEDURE `sp_branch_save`(
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


DELIMITER $$
CREATE  PROCEDURE `sp_product_save`(
pidproduct int(11),
pname varchar(100),
psequential  varchar(256),
pbarcode varchar(256),
pdescription varchar(256)
)
BEGIN
	
	IF pidproduct > 0 THEN
		
		UPDATE tb_product
        SET 
            name = pname,
			sequential = psequential,
            barcode =  pbarcode ,
            description = pdescription          

        WHERE idproduct = pidproduct;
        
    ELSE
		
		INSERT INTO tb_product (name,sequential,barcode,description) 
        VALUES(pname,psequential,pbarcode,pdescription);
        
        SET pidproduct = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_product WHERE idproduct = pidproduct;
    
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE `sp_user_save`(
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



DELIMITER $$
CREATE  PROCEDURE `sp_client_save`(
pidclient int(11),
pname varchar(100),
pcpf  varchar(256)
)
BEGIN
	
	IF pidclient > 0 THEN
		
		UPDATE tb_client
        SET 
            name = pname,
			cpf = pcpf      

        WHERE idclient = pidclient;
        
    ELSE
		
		INSERT INTO tb_client (name,cpf) 
        VALUES(pname,pcpf);
        
        SET pidclient = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_client WHERE idclient = pidclient;
    
END$$
DELIMITER ;



DELIMITER $$
CREATE  PROCEDURE `sp_stockorder_output_save`(
pidstockorder int(11),
pidbranch int(11),
piduser int(11),
pidclient int(11),
pidpaymentmethod int(11),
pordertype varchar(20),
pdeliverynote varchar(256)
)
BEGIN
	
	IF(  NOT (select exists( select * from tb_stockorder where idstockorder = pidstockorder ) )  AND
       (select exists( select * from tb_branch where idbranch = pidbranch ) ) AND
       (select exists( select * from tb_user where iduser = piduser ) ) AND
        (select exists( select * from tb_client where idclient = pidclient ) )
    
    )THEN
     
		INSERT INTO tb_stockorder (idbranch,iduser,idclient, idpaymentmethod, ordertype,  deliverynote) 
        VALUES(pidbranch,piduser,pidclient, pidpaymentmethod,  pordertype, pdeliverynote) ;
        
        SET pidstockorder = LAST_INSERT_ID();
        
    ELSE 
    
        UPDATE tb_stockorder
        SET 
            idbranch =  pidbranch,
		    iduser = piduser, 
			idclient = pidclient,	
			idpaymentmethod = pidpaymentmethod, 
			ordertype = pordertype,         
			deliverynote = pdeliverynote 
            
        WHERE idstockorder = pidstockorder;   
		        
    END IF;
    
    SELECT * FROM tb_stockorder WHERE idstockorder= pidstockorder;
    
END$$
DELIMITER ;

 DELIMITER $$
CREATE  PROCEDURE `sp_stockorderitem_save`(
pidstockorderitem int(11),
pidproduct int(11),
pidstockorder int(11),
pidorderstatus int(11),
pquantity int(11),
punitaryvalue float,
ptotalvalue float,
pdtremoved datetime
)
BEGIN
	
    declare pidbranch int(11) ;
    
      select b.idbranch as idbranch from tb_branch b inner join tb_stockorder so on so.idbranch = b.idbranch where so.idstockorder = pidstockorder into pidbranch;  
    
	IF ( NOT (select exists( select * from tb_stockorderitem where idstockorderitem = pidstockorderitem ) ) ) THEN
		
        select 'ok 1';
        
		INSERT INTO tb_stockorderitem (idproduct,idstockorder,idorderstatus, quantity, unitaryvalue, totalvalue, dtremoved) 
        VALUES(pidproduct,pidstockorder,pidorderstatus, pquantity, punitaryvalue, ptotalvalue, pdtremoved) ;
        
        SET pidstockorderitem = LAST_INSERT_ID();
        
    ELSE 
    
    select 'ok 2';
    
        UPDATE tb_stockorderitem
        SET 
            idproduct = pidproduct,
		    idstockorder = 	pidstockorder ,
			idorderstatus = pidorderstatus ,
			quantity = pquantity ,
			unitaryvalue = punitaryvalue ,
			totalvalue = ptotalvalue ,
            dtremoved = pdtremoved
        WHERE idstockorderitem = pidstockorderitem;
        
		UPDATE tb_stock
        SET 
            
		quantity = quantity - pquantity
            
        WHERE idproduct = pidproduct and idbranch = pidbranch;
		        
    END IF;
    
    SELECT * FROM tb_stockorderitem WHERE idstockorderitem = pidstockorderitem;
    
END$$
DELIMITER ;

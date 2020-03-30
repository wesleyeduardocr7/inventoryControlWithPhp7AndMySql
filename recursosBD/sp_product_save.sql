USE `invetorycontrol`;
DROP procedure IF EXISTS `sp_product_save`;

DELIMITER $$
USE `invetorycontrol`$$
CREATE PROCEDURE `sp_product_save`(
pidproduct int(11),
pname varchar(100),
punityprice decimal(10,2),
ptotalamount int
)
BEGIN
	
	IF pidproduct > 0 THEN
		
		UPDATE tb_product
        SET 
			name = pname,
            unityprice = punityprice,
            totalamount = ptotalamount
            
        WHERE idproduct = pidproduct;
        
    ELSE
		
		INSERT INTO tb_product (name, unityprice, totalamount) 
        VALUES(pname, punityprice, ptotalamount);
        
        SET pidproduct = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_products WHERE idproduct = pidproduct;
    
END$$

DELIMITER ;
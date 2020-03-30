USE `invetorycontrol`;
DROP procedure IF EXISTS `sp_stock_save`;

DELIMITER $$
USE `invetorycontrol`$$
CREATE PROCEDURE `sp_stock_save`(
pidstock int(11),
pidbranch int(11),
pidproduct int(11)
)
BEGIN
	
	IF pidstock > 0 THEN
		
		UPDATE tb_stock
        SET 
			idbranch = pidbranch,
            idproduct = pidproduct
                        
        WHERE idstock = pidstock;
        
    ELSE
		
		INSERT INTO tb_stock (idbranch, idproduct) 
        VALUES(pidbranch, pidproduct);
        
        SET pidstock = LAST_INSERT_ID();
        
    END IF;
    
    SELECT * FROM tb_stock WHERE idstock = pidstock;
    
END$$

DELIMITER ;
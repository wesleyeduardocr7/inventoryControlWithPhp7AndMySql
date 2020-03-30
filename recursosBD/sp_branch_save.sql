USE `invetorycontrol`;
DROP procedure IF EXISTS `sp_branch_save`;

DELIMITER $$
USE `invetorycontrol`$$
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
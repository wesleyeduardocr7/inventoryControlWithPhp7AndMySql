CALL sp_stockorder_output_save(0,101, 102, 202, null, null, null);

INSERT INTO tb_stockorder (idbranch,iduser,idclient, idpaymentmethod, ordertype,  deliverynote) 
        VALUES(0,101, 102, 202, null, null, null);
        
        CALL sp_stockorderitem_save(0, 202, 6, 1, 6, 6, 36, null);
        
        INSERT INTO tb_stockorderitem (idproduct,idstockorder,idorderstatus, quantity, unitaryvalue, totalvalue, dtremoved) 
        VALUES(202, 8, 1, 4, 4, 12, null);
        
      CALL sp_stockorderitem_save(0, 202, 8, 1, 4, 4, 12, null);
      
      SELECT  * FROM tb_stockorder so 
			INNER JOIN tb_stockorderitem soi ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_stock s ON b.idbranch = s.idbranch
			WHERE so.idstockorder = 11 AND soi.idproduct = 202;
      
      
      
      	INSERT INTO tb_stockorderitem (idproduct,idstockorder,idorderstatus, quantity, unitaryvalue, totalvalue, dtremoved) 
        VALUES(202, 8, 1, 4, 4, 12, null);
        
        
        
	SELECT * FROM tb_stockorderitem soi INNER JOIN tb_stockorder so on soi.idstockorder = so.idstockorder
    INNER JOIN tb_branch b ON so.idbranch = b.idbranch
    INNER JOIN tb_stock s ON s.idbranch = b.idbranch
    INNER JOIN tb_product p ON s.idproduct = p.idproduct
    WHERE b.idbranch = 102 AND p.idproduct = 202;
    
    
    SELECT s.quantity FROM tb_stockorder so INNER JOIN tb_branch b ON so.idbranch = b.idbranch
	INNER JOIN tb_stock s ON s.idbranch = b.idbranch 
	INNER JOIN tb_product p ON s.idproduct = p.idproduct
    WHERE so.idstockorder = 11 AND p.idproduct = 202;
     
     
     
     CALL sp_stockorderitem_save(8, 2, 4, 2, 12, 12, 144, null);
     
     
     SELECT  * FROM tb_stockorder so 
			INNER JOIN tb_stockorderitem soi ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_stock s ON b.idbranch = s.idbranch
            INNER JOIN tb_product p ON s.idproduct = p.idproduct
			WHERE so.idstockorder = 10 AND p.name = 'Manteiga';
            
            
            SELECT p.idproduct, p.name,p.sequential,p.barcode,p.description, s.quantity AS stockquantity
			FROM tb_branch b INNER JOIN tb_stock s ON s.idbranch = b.idbranch
			INNER JOIN tb_product p ON s.idproduct = p.idproduct
			WHERE p.name = 'Manteiga' AND s.idbranch = 1;
            
            SELECT  * FROM tb_stockorder so 
			INNER JOIN tb_stockorderitem soi ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_stock s ON b.idbranch = s.idbranch
			INNER JOIN tb_product p ON s.idproduct = p.idproduct
			WHERE so.idstockorder = 10 ;
            
            SELECT * FROM tb_product WHERE name = 'Café';
            
            
            SELECT  * FROM tb_stockorder so 
			INNER JOIN tb_stockorderitem soi ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_stock s ON b.idbranch = s.idbranch
			INNER JOIN tb_product p ON s.idproduct = p.idproduct
			WHERE so.idstockorder = 10 AND p.name = 'Manteiga';
            
            SELECT * FROM tb_stockorder WHERE idpaymentmethod != 0 AND deliverynote != 0 ORDER BY dtregister DESC;
            
            
            SELECT * FROM tb_stockorder ORDER BY dtregister DESC;
            
            select * from tb_stockorder so inner join tb_stockorderitem soi on so.idstockorder = soi.idstockorder;
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        
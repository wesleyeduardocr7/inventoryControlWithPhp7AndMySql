
SELECT * FROM inventorycontrol.tb_stock;

select * from tb_stockorderitem soi inner join tb_stockorder so on soi.idstockorder = so.idstockorder where so.idstockorder = 28;

select so.idbranch, b.name AS namebranch from tb_stockorder so inner join tb_branch b on so.idbranch = b.idbranch where so.idstockorder = 28;

SELECT so.idclient, c.name  AS nameclient  FROM tb_stockorder so 
			INNER JOIN tb_client c ON so.idclient = c.idclient WHERE so.idstockorder = 28;
            
            
            
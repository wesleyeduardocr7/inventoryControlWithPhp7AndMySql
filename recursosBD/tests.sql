

SELECT soi.idstockorderitem, o.name as namestatus, soi.idstockorder, soi.idproduct, p.name as nameproduct, soi.quantity as requestedquantity, soi.unitaryvalue, soi.totalvalue
			FROM  tb_stockorderitem soi INNER JOIN tb_stockorder so ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_product p ON soi.idproduct = p.idproduct
			INNER JOIN tb_orderstatus o ON soi.idorderstatus = o.idorderstatus
			WHERE soi.idstockorder = 116;


SELECT p.idproduct, p.name,p.sequential,p.barcode,p.description, s.quantity AS stockquantity
			FROM tb_branch b INNER JOIN tb_stock s ON s.idbranch = b.idbranch
			INNER JOIN tb_product p ON s.idproduct = p.idproduct
			WHERE s.idproduct = 1 AND s.idbranch = 1;
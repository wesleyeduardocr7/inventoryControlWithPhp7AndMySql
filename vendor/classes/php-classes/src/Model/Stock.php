<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class Stock extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT b.idbranch,b.name AS namebranch,p.idproduct,p.name AS nameproduct,s.quantity, s.dtregister
		FROM tb_branch b INNER JOIN tb_stock s ON b.idbranch = s.idbranch
		INNER JOIN tb_product p ON p.idproduct = s.idproduct ORDER BY s.dtregister DESC");
	}
	
  	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_stock_save(:idbranch , :idproduct, :quantity)", array(
			":idbranch"=>(int)$this->getidbranch(),
			":idproduct"=>(int)$this->getidproduct(),
			":quantity"=>$this->getquantity(),			
		));

		return $results;

	}

	public static function verifyQuantityRequestedStock($idstockorder, $idproduct)
	{

		$sql = new Sql();

		$results = $sql->select(" SELECT s.quantity FROM tb_stockorder so INNER JOIN tb_branch b ON so.idbranch = b.idbranch
		INNER JOIN tb_stock s ON s.idbranch = b.idbranch 
		INNER JOIN tb_product p ON s.idproduct = p.idproduct
		WHERE so.idstockorder = :idstockorder AND p.idproduct = :idproduct", array(
			":idstockorder"=>(int)$idstockorder,
			":idproduct"=>(int)$idproduct			
		));

		return $results[0];
		
	}

    public function get($idstock)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_stock WHERE idstock = :idstock", [
			':idstock'=>$idstock
		]);

		$this->setData($results[0]);
	}

    
    public function delete()
	{
		$sql = new Sql();

		$sql->query("DELETE FROM tb_stock WHERE idstock = :idstock", [
			':idstock'=>$this->getidstock()
		]);
	}

    public function getValues()
	{
		$values = parent::getValues();

		return $values;
	}


}
?>
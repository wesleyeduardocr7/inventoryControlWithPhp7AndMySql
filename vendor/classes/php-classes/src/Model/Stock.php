<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class Stock extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_stock ORDER BY idstock");
    }

    public static function listBranchsWithStocksAndProducts()
	{
		$sql = new Sql();

        return $sql->select("SELECT s.idstock, b.idbranch, b.manager, 
        b.city,p.idproduct,p.name, p.unityprice, p.totalamount
        FROM tb_branch b INNER JOIN tb_stock s ON b.idbranch = s.idbranch
        INNER JOIN tb_product p ON s.idproduct = p.idproduct ORDER BY s.idstock ");
    }


  	public function save()
	{

		$sql = new Sql();

		$sql->select("CALL sp_stock_save(:idstock, :idbranch, :idproduct)", array(
			":idstock"=>(int)$this->getidstock(),
			":idbranch"=>(int)$this->getidbranch(),
			":idproduct"=>(int)$this->getidproduct()			
		));
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
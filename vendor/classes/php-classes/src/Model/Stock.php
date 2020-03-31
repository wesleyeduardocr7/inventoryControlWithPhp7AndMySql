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
	
  	public function save()
	{

		$sql = new Sql();

		$sql->select("CALL sp_stock_save(:idstock, :idbranch , :responsible, :telephone)", array(
			":idstock"=>$this->getidstock(),
			":idbranch"=>(int)$this->getidbranch(),
			":responsible"=>$this->getresponsible(),
			":telephone"=>$this->gettelephone()
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
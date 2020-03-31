<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class Product extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_product ORDER BY idproduct");
    }
    
	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_product_save(:idproduct, :idstock, :name, :unityprice, :totalamount)", array(
			":idproduct"=>()$this->getidproduct(),
			":idproduct"=>$this->getidstock(),
			":name"=>$this->getname(),
            ":unityprice"=>$this->getunityprice(),
            ":totalamount"=>$this->gettotalamount()
		));
	}

    public function get($idproduct)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_product WHERE idproduct = :idproduct", [
			':idproduct'=>$idproduct
		]);

		$this->setData($results[0]);
	}

    
    public function delete()
	{
		$sql = new Sql();

		$sql->query("DELETE FROM tb_product WHERE idproduct = :idproduct", [
			':idproduct'=>$this->getidproduct()
		]);
	}

    public function getValues()
	{
		$values = parent::getValues();

		return $values;
	}


}
?>
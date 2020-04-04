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
	
	public static function branchProduct($idproduct,$idbranch)
	{
		$sql = new Sql();
		
		return $sql->select("SELECT p.idproduct, p.name,p.sequential,p.barcode,p.description,p.price, s.quantity AS stockquantity
		FROM tb_branch b INNER JOIN tb_stock s ON s.idbranch = b.idbranch
		INNER JOIN tb_product p ON s.idproduct = p.idproduct
		WHERE s.idproduct = :idproduct AND s.idbranch = :idbranch",array(
		":idproduct"=>$idproduct,
		":idbranch"=>$idbranch
		));
    }
    

	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_product_save(:idproduct, :name, :sequential, :barcode, :description, :price)", array(
			":idproduct"=>(int)$this->getidproduct(),
			":name"=>$this->getname(),
			":sequential"=>$this->getsequential(),
            ":barcode"=>$this->getbarcode(),
			":description"=>$this->getdescription(),
			":price"=>$this->getprice(),
		));
	}

    public function get($idproduct)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_product WHERE idproduct = :idproduct", [
			':idproduct'=>$idproduct
		]);

		if(count($results)<=0){
			return null;
		}else{
			$this->setData($results[0]);	
			return $this;
		}
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
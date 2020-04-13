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
	
	public static function checkProductBranch($idproduct,$idbranch)
	{
		$sql = new Sql();
		
		$result = $sql->select("SELECT p.idproduct, p.name,p.sequential,p.barcode,p.description, s.quantity AS stockquantity
			FROM tb_branch b INNER JOIN tb_stock s ON s.idbranch = b.idbranch
			INNER JOIN tb_product p ON s.idproduct = p.idproduct
			WHERE s.idproduct = :idproduct AND s.idbranch = :idbranch",array(
			":idproduct"=>$idproduct,
			":idbranch"=>$idbranch
		));

		if (count($result) >= 1 ){
			return true;		
		}else{
			return false;
		}
	}
	
   
    
	
	public static function checksProductItemOrder($idproduct,$idstockorder)
	{
		$sql = new Sql();
		
		$result =  $sql->select("SELECT  * FROM tb_stockorder so 
			INNER JOIN tb_stockorderitem soi ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_stock s ON b.idbranch = s.idbranch
			WHERE so.idstockorder = :idstockorder AND soi.idproduct = :idproduct",array(
			":idproduct"=>$idproduct,
			":idstockorder"=>$idstockorder
		));
		
		if (count($result) > 0 ){
			return true;		
		}else{
			return false;
		}
    }
	
	
	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_product_save(:idproduct, :name, :sequential, :barcode, :description)", array(
			":idproduct"=>(int)$this->getidproduct(),
			":name"=>$this->getname(),
			":sequential"=>$this->getsequential(),
            ":barcode"=>$this->getbarcode(),
			":description"=>$this->getdescription()			
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

	public function getByName($name)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_product WHERE name = :name", [
			':name'=>$name
		]);

		if(count($results)<=0){
			return null;
		}else{
			$this->setData($results[0]);	
			return $this;
		}
	}

	public function getProductInBranch($idproduct)
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
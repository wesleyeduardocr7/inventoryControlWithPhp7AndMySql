<?php 

namespace Classes\Controller;

use \Classes\Model;
use \Classes\DB\Sql;

class StockOrder extends Model {

   
    public function get($idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_stockorder WHERE idstockorder = :idstockorder", [
			':idstockorder'=>$idstockorder
		]);

		$this->setData($results[0]);
	}

	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_stockorder_save(:idproduct, :name, :sequential, :barcode, :description, :price)", array(
			":idproduct"=>(int)$this->getidproduct(),
			":name"=>$this->getname(),
			":sequential"=>$this->getsequential(),
            ":barcode"=>$this->getbarcode(),
			":description"=>$this->getdescription(),
			":price"=>$this->getprice(),
		));
	}
 

}

?>
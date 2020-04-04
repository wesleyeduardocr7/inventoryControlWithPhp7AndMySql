<?php 

namespace Classes\Controller;

use \Classes\Model;
use \Classes\DB\Sql;

class StockOrderItem extends Model {

   
    public function get($idstockorderitem)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_stockorderitem WHERE idstockorderitem = :idstockorderitem", [
			':idstockorderitem'=>$idstockorderitem
		]);

		$this->setData($results[0]);
	}

	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_stockorderitem_save(:idstockorderitem, :idproduct, :idstockorder, :idorderstatus, :quantity, :unitaryvalue, :totalvalue, :dtremoved)", array(
			"idstockorderitem"=>$this->getidstockorderitem(), 
			"idproduct"=>$this->getidproduct(),
			"idstockorder"=>$this->getidstockorder(),
			"idorderstatus"=>$this->getidorderstatus(),
			"quantity"=>$this->getquantity(),
			"unitaryvalue"=>$this->getunitaryvalue(),  
			"totalvalue"=> $this->gettotalvalue(),
			"dtremoved"=> $this->getdtremoved()
		));
	}
 

}

?>
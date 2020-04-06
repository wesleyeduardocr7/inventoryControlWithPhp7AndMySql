<?php 

namespace Classes\Controller;

use \Classes\Model;
use \Classes\DB\Sql;

class StockOrder extends Model {
  

	public function save()
	{
		$sql = new Sql();

		 $result =$sql->select("CALL sp_stockorder_output_save(:idstockorder,:idbranch, :iduser, :idclient, :idpaymentmethod, :ordertype, :deliverynote)", array(
			"idstockorder"=>$this->getidstockorder(),
			"idbranch"=>$this->getidbranch(),
			"iduser"=>$this->getiduser(),
			"idclient"=>$this->getidclient(),
			"idpaymentmethod"=>$this->getidpaymentmethod(),
			"ordertype"=>$this->getordertype(),
			"deliverynote"=>$this->getdeliverynote()
		));

		return $result[0];
	}

	
    public function get($idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_stockorder WHERE idstockorder = :idstockorder", [
			':idstockorder'=>$idstockorder
		]);

		$this->setData($results[0]);
	}
 

}

?>
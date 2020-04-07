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
	
	public static function getItens( $idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT soi.idstockorderitem, o.name as namestatus, soi.idstockorder, soi.idproduct, p.name as nameproduct, soi.quantity as requestedquantity, soi.unitaryvalue, soi.totalvalue
			FROM  tb_stockorderitem soi INNER JOIN tb_stockorder so ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_product p ON soi.idproduct = p.idproduct
			INNER JOIN tb_orderstatus o ON soi.idorderstatus = o.idorderstatus
			WHERE soi.idstockorder = :idstockorder", [
			':idstockorder'=>$idstockorder
		]);	

		return $results;
		
	}

	public static function temItens( $idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT soi.idstockorderitem, o.name as namestatus, soi.idstockorder, soi.idproduct, p.name as nameproduct, soi.quantity as requestedquantity, soi.unitaryvalue, soi.totalvalue
			FROM  tb_stockorderitem soi INNER JOIN tb_stockorder so ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_product p ON soi.idproduct = p.idproduct
			INNER JOIN tb_orderstatus o ON soi.idorderstatus = o.idorderstatus
			WHERE soi.idstockorder = :idstockorder", [
			':idstockorder'=>$idstockorder
		]);	

		if(count($results)>0){
			return true;
		}else{
			return false;
		}
		
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
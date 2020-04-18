<?php 

namespace Classes\Controller;

use \Classes\Model;
use \Classes\DB\Sql;
use Classes\Model\Branch;

class StockOrder extends Model {
  
	public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("  SELECT * FROM tb_stockorder WHERE idpaymentmethod != 0 ORDER BY dtregister DESC");
	}
	
	public static function listAllStockOrderOutput()
	{
		$sql = new Sql();

		return $sql->select("  SELECT * FROM tb_stockorder WHERE idpaymentmethod != 0 AND ordertype = 'exitrequest' ORDER BY dtregister DESC");
	}
	
	public static function listAllStockOrderInput()
	{
		$sql = new Sql();

		return $sql->select("  SELECT * FROM tb_stockorder WHERE idpaymentmethod != 0 AND ordertype = 'entryrequest' ORDER BY dtregister DESC");
    }


	public function save()
	{
		$sql = new Sql();

		 $result =$sql->select("CALL sp_stockorder_save(:idstockorder,:idbranch, :iduser, :idclient, :idpaymentmethod, :ordertype, :deliverynote)", array(
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

	public function saveStockOrderInput()
	{
		$sql = new Sql();

		 $result =$sql->select("CALL sp_stockorder_input_save(:idstockorder,:idbranch, :iduser, :idclient, :idpaymentmethod, :ordertype, :deliverynote)", array(
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


	public static function getOrderTypeLoadByIdStockOrder($idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT ordertype FROM tb_stockorder WHERE idstockorder = :idstockorder", [
			':idstockorder'=>$idstockorder
		]);

		$this->setData($results[0]);
	}


	public static function returnsQuantityToStock($idbranch, $idproduct, $quantity, $ordertype){

		$sql = new Sql();

		$sql->select("CALL sp_updatestock(:idbranch, :idproduct, :quantity, :ordertype)", array(
			":idbranch"=>(int)$idbranch,
			":idproduct"=>(int)$idproduct,
			":quantity"=>(int)$quantity,
			":ordertype"=>$ordertype		   
	   ));

	}

	
	public static function returnQuantityOfAllItemsToStock($ordertype,$idstockorder){

		$itens = StockOrderItem::getItens($idstockorder);

		for($i = 0; $i < count($itens); $i++ ){

			if($itens[$i]['namestatus'] === 'ATIVO'){

				$idbranch = (int) Branch::getStockOrderBranch($idstockorder)['idbranch'];

				$idproduct = StockOrderItem::getIdProductLoadByIdStockOrderItem($itens[$i]['idstockorderitem']);

				$quantity = StockOrderItem::getQuantityLoadByIdStockOrderItem($itens[$i]['idstockorderitem']);

				
				if($ordertype == 'exitrequest'){
					
					StockOrder::returnsQuantityToStock($idbranch, $idproduct,$quantity, 'entryrequest');

				}else{
					
					StockOrder::returnsQuantityToStock($idbranch, $idproduct,$quantity, 'exitrequest');
				}

			}
		}
	} 

}

?>
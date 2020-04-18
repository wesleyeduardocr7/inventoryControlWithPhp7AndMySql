<?php

namespace Classes\Controller;

use \Classes\Model;
use \Classes\DB\Sql;
use Classes\Model\Branch;
use Classes\Model\Stock;
use DateTime;

class StockOrderItem extends Model
{


	public function get($idstockorderitem)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_stockorderitem WHERE idstockorderitem = :idstockorderitem", [
			':idstockorderitem' => $idstockorderitem
		]);

		$this->setData($results[0]);
	}

	public static function getItens($idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT soi.idstockorderitem, o.name as namestatus, soi.idstockorder, soi.idproduct, p.name as nameproduct, soi.quantity as requestedquantity, soi.unitaryvalue, soi.totalvalue
			FROM  tb_stockorderitem soi INNER JOIN tb_stockorder so ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_product p ON soi.idproduct = p.idproduct
			INNER JOIN tb_orderstatus o ON soi.idorderstatus = o.idorderstatus
			WHERE soi.idstockorder = :idstockorder", [
			':idstockorder' => $idstockorder
		]);

		return $results;
	}

	public static function temItens($idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT soi.idstockorderitem, o.name as namestatus, soi.idstockorder, soi.idproduct, p.name as nameproduct, soi.quantity as requestedquantity, soi.unitaryvalue, soi.totalvalue
			FROM  tb_stockorderitem soi INNER JOIN tb_stockorder so ON soi.idstockorder = so.idstockorder
			INNER JOIN tb_branch b ON so.idbranch = b.idbranch
			INNER JOIN tb_product p ON soi.idproduct = p.idproduct
			INNER JOIN tb_orderstatus o ON soi.idorderstatus = o.idorderstatus
			WHERE soi.idstockorder = :idstockorder", [
			':idstockorder' => $idstockorder
		]);

		if (count($results) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function save()
	{
		$sql = new Sql();
	
		$sql->select("CALL sp_stockorderitem_save(:idstockorderitem, :idproduct, :idstockorder, :idorderstatus, :quantity, :unitaryvalue, :totalvalue, :dtremoved)", array(
			"idstockorderitem" => (int) $this->getidstockorderitem(),
			"idproduct" => (int) $this->getidproduct(),
			"idstockorder" => (int) $this->getidstockorder(),
			"idorderstatus" => (int) $this->getidorderstatus(),
			"quantity" => (int) $this->getquantity(),
			"unitaryvalue" => (float) $this->getunitaryvalue(),
			"totalvalue" => (float) $this->gettotalvalue(),
			"dtremoved" => $this->getdtremoved()
		));
		
	}


	public static function saveAndUpdateItemsStatus($idstockorder, $idorderstatus)
	{
		$sql = new Sql();

		$itens = StockOrderItem::getItens($idstockorder);

		for ($i = 0; $i < count($itens); $i++) {

			if($itens[$i]['namestatus'] != 'CANCELADO'){

				$sql->select("CALL sp_stockorderitem_save(:idstockorderitem, :idproduct, :idstockorder, :idorderstatus, :quantity, :unitaryvalue, :totalvalue, :dtremoved)", array(
					"idstockorderitem" => $itens[$i]['idstockorderitem'],
					"idproduct" => $itens[$i]['idproduct'],
					"idstockorder" => $idstockorder,
					"idorderstatus" => $idorderstatus,
					"quantity" => $itens[$i]['requestedquantity'],
					"unitaryvalue" => $itens[$i]['unitaryvalue'],
					"totalvalue" => $itens[$i]['totalvalue'],
					"dtremoved" => null
				));

			}
		}
	}

	public static function saveAndUpdateItemsInputStatus($idstockorder, $idorderstatus)
	{
		$sql = new Sql();

		$itens = StockOrderItem::getItens($idstockorder);

		for ($i = 0; $i < count($itens); $i++) {

			$sql->select("CALL sp_stockorderitem_input_save(:idstockorderitem, :idproduct, :idstockorder, :idorderstatus, :quantity, :unitaryvalue, :totalvalue, :dtremoved)", array(
				"idstockorderitem" => $itens[$i]['idstockorderitem'],
				"idproduct" => $itens[$i]['idproduct'],
				"idstockorder" => $idstockorder,
				"idorderstatus" => $idorderstatus,
				"quantity" => $itens[$i]['requestedquantity'],
				"unitaryvalue" => $itens[$i]['unitaryvalue'],
				"totalvalue" => $itens[$i]['totalvalue'],
				"dtremoved" => null
			));
		}
	}


	public static function deleteItem($idstockorder, $idorderstatus, $idstockorderitem)
	{
		$sql = new Sql();

		$itens = StockOrderItem::getItens($idstockorder);

		for ($i = 0; $i < count($itens); $i++) {

			if ($itens[$i]['idstockorderitem'] === $idstockorderitem) {

				$sql->select("CALL sp_stockorderitem_delete(:idstockorderitem, :idproduct, :idstockorder, :idorderstatus, :quantity, :unitaryvalue, :totalvalue, :dtremoved)", array(
					"idstockorderitem" => $itens[$i]['idstockorderitem'],
					"idproduct" => $itens[$i]['idproduct'],
					"idstockorder" => $idstockorder,
					"idorderstatus" => $idorderstatus,
					"quantity" => $itens[$i]['requestedquantity'],
					"unitaryvalue" => $itens[$i]['unitaryvalue'],
					"totalvalue" => $itens[$i]['totalvalue'],
					"dtremoved" => null
				));

				return true;
			}
		}

		return false;
	}



	public static function checkIfItemWasCanceledLoadByIdStockOrderItem($idstockorder, $idstockorderitem)
	{

		$itens = StockOrderItem::getItens($idstockorder);

		for ($i = 0; $i < count($itens); $i++) {

			if ($itens[$i]['idstockorderitem'] === $idstockorderitem) {

				if ($itens[$i]["namestatus"] === 'CANCELADO') {

					return true;
				}
			}
		}

		return false;
	}

	public static function checkIfItemWasActivatedLoadByIdproductAndStatus($idstockorder, $idproduct)
	{
		$itens = StockOrderItem::getItens($idstockorder);

		for ($i = 0; $i < count($itens); $i++) {

			if ($itens[$i]['idproduct'] === $idproduct && $itens[$i]["namestatus"] === 'ATIVO') {

				return true;
				
			}
		}

		return false;
	}

	public static function checkIfItemWasProcessed($idstockorder, $idstockorderitem)
	{

		$itens = StockOrderItem::getItens($idstockorder);

		for ($i = 0; $i < count($itens); $i++) {

			if ($itens[$i]['idstockorderitem'] === $idstockorderitem) {

				if ($itens[$i]["namestatus"] === 'PROCESSADO') {

					return true;
				}
			}
		}

		return false;
	}

	public static function checkIfAllItemsWasCanceled($idstockorder)
	{
		$itens = StockOrderItem::getItens($idstockorder);

		$quantiyItems = count($itens);
		$quantiyCanceled = 0;

		for ($i = 0; $i < $quantiyItems; $i++) {

			if ($itens[$i]["namestatus"] === 'CANCELADO') {

				$quantiyCanceled++;
			}
		}

		if ($quantiyItems === $quantiyCanceled) {
			return true;
		} else {
			return false;
		}
	}

	public static function checkIfAllItemsWasProcessed($idstockorder)
	{
		$itens = StockOrderItem::getItens($idstockorder);

		$quantiyItems = count($itens);
		$quantiyCanceled = 0;

		for ($i = 0; $i < $quantiyItems; $i++) {

			if ($itens[$i]["namestatus"] === 'PROCESSADO') {

				$quantiyCanceled++;
			}
		}

		if ($quantiyItems === $quantiyCanceled && $quantiyItems>0 ) {
			return true;
		} else {
			return false;
		}
	}


	public static  function totalValueItensStockOrder($idstockorder)
	{
		$itens = StockOrderItem::getItens($idstockorder);

		$totalvalue = 0;;

		for($i = 0; $i < count($itens); $i++){

			if($itens[$i]['namestatus'] != 'CANCELADO'){

				$totalvalue += $itens[$i]["totalvalue"];	
			}
		}	

		return (float)$totalvalue;

	}


   public static function checkIfAllItemsWasProcessedOrCanceled($idstockorder){

		$itens = StockOrderItem::getItens($idstockorder);

		$quantiyItems = count($itens);
		$quantiy = 0;

		for ($i = 0; $i < $quantiyItems; $i++) {

			if ($itens[$i]["namestatus"] === 'PROCESSADO' || $itens[$i]["namestatus"] === 'CANCELADO') {

				$quantiy++;
			}
		}

		if ($quantiyItems === $quantiy && $quantiyItems>0 ) {

			return true;

		} else {

			return false;
		}

   }

	public static function checkForProcessedItem($idstockorder){

		$itens = StockOrderItem::getItens($idstockorder);

		$quantiyItems = count($itens);

		for ($i = 0; $i < $quantiyItems; $i++) {

			if ($itens[$i]["namestatus"] === 'PROCESSADO') {
				return true;
			}
		}

		return false;

	}


	public static function getIdProductLoadByIdStockOrderItem($idstockorderitem):int{

		$sql = new Sql();

		$result = $sql->select("SELECT idproduct FROM tb_stockorderitem WHERE idstockorderitem = :idstockorderitem LIMIT 1 ", [
			':idstockorderitem' => $idstockorderitem
		]);
		
		return (int) $result[0]['idproduct'];
	}

	public static function getQuantityLoadByIdStockOrderItem($idstockorderitem):int{

		$sql = new Sql();

		$result = $sql->select("SELECT quantity FROM tb_stockorderitem WHERE idstockorderitem = :idstockorderitem LIMIT 1 ", [
			':idstockorderitem' => $idstockorderitem
		]);
		
		return (int) $result[0]['quantity'];
	}

}

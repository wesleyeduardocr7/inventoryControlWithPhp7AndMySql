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
 

}

?>
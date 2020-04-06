<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class Client extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_client ORDER BY idclient");
    }
    
	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_client_save(:idclient, :name, :cpf)", array(
			":idclient"=>$this->getidclient(),
			":name"=>$this->getname(),
			":cpf"=>$this->getcpf()           		
		));
	}

    public function get($idclient)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_client WHERE idclient = :idclient", [
			':idclient'=>$idclient
		]);

		if(count($results)<=0){
			return null;
		}else{
			$this->setData($results[0]);	
			return $this;
		}	
	}

	public static function getStockOrderClient($idstockorder)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT so.idclient, c.name  AS nameclient  FROM tb_stockorder so 
		INNER JOIN tb_client c ON so.idclient = c.idclient WHERE so.idstockorder = :idstockorder", [
			':idstockorder'=>$idstockorder
		]);

		return $results[0];
		
	}

    
    public function delete()
	{
		$sql = new Sql();

		$sql->query("DELETE FROM tb_client WHERE idclient = :idclient", [
			':idclient'=>$this->getidclient()
		]);
	}

    public function getValues()
	{
		$values = parent::getValues();

		return $values;
	}


}
?>
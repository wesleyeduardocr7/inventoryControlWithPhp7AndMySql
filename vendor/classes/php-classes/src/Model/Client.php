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
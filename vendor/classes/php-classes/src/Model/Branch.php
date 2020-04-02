<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class Branch extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_branch ORDER BY dtregister DESC");
    }
    
	public function save()
	{
		$sql = new Sql();

		$sql->select("CALL sp_branch_save(:idbranch, :name, :street,:city, :state, :telephone, :manager)", array(
			":idbranch"=>(int)$this->getidbranch(),
			":name"=>$this->getname(),
			":street"=> $this->getstreet(),
			":city"=> $this->getcity(),
			":state"=> $this->getstate(),
            ":telephone"=>$this->gettelephone(),
            ":manager"=>$this->getmanager()
		));
	}

    public function get($idbranch)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_branch WHERE idbranch = :idbranch", [
			':idbranch'=>$idbranch
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

		$sql->query("DELETE FROM tb_branch WHERE idbranch = :idbranch", [
			':idbranch'=>$this->getidbranch()
		]);
	}

    public function getValues()
	{
		$values = parent::getValues();

		return $values;
	}


}
?>
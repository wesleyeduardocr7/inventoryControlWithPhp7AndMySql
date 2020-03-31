<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class Branch extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_branch ORDER BY idbranch");
    }
    
	public function save()
	{
		$sql = new Sql();

		$sql->select("CALL sp_branch_save(:idbranch, :address,:city, :state, :telephone, :manager)", array(
			":idbranch"=>(int)$this->getidbranch(),
			":address"=> $this->getaddress(),
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

		$this->setData($results[0]);
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
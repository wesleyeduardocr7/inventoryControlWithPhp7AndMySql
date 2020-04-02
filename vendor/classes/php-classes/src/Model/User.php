<?php 

namespace Classes\Model;

use \Classes\Model;
use \Classes\DB\Sql;

class User extends Model {

    public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_user ORDER BY iduser");
    }
    
	public function save()
	{
		$sql = new Sql();

		 $sql->select("CALL sp_user_save(:iduser, :name, :cpf, :login, :password)", array(
			":iduser"=>$this->getiduser(),
			":name"=>$this->getname(),
			":cpf"=>$this->getcpf(),
            ":login"=>$this->getlogin(),
			":password"=>$this->getpassword()			
		));
	}

    public function get($iduser)
	{
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_user WHERE iduser = :iduser", [
			':iduser'=>$iduser
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

		$sql->query("DELETE FROM tb_user WHERE iduser = :iduser", [
			':iduser'=>$this->getiduser()
		]);
	}

    public function getValues()
	{
		$values = parent::getValues();

		return $values;
	}


}
?>
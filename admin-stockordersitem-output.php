<?php

use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\User;
use \Classes\PageAdmin;

$app->get("/admin/stockorder-output/create/:idbranch/:iduser/:idclient", function ($idbranch,$iduser,$idclient) {
	
    $page = new PageAdmin();

    $page->setTpl("stockorders-output-create",array(
		'idbranch'=>$idbranch,
		'iduser'=>$iduser,
		'idclient'=>$idclient,
		'error'=>''		
	));
});


$app->post("/admin/stockordersitem-output/create", function () {
	
	$dataStockOrder = $_POST;

	$branch = new Branch();
	$user = new User();
	$client = new Client();

	$resultSearchBranch = $branch->get($dataStockOrder['idbranch']);
	$resultSearchUser = $user->get($dataStockOrder['iduser']);
	$resultSearchClient = $client->get($dataStockOrder['idclient']);

	if($resultSearchBranch === null || $resultSearchUser === null || $resultSearchClient === null){
		
		$page = new PageAdmin();

		$page->setTpl("stockorders-output-create",array(			
			'idbranch'=>$dataStockOrder['idbranch'],
			'iduser'=>$dataStockOrder['iduser'],
			'idclient'=>$dataStockOrder['idclient'],
			'error'=>'Erro! Filial, Usuário ou Cliente com Código Inválido'
		));
		
	}else{

		$page = new PageAdmin();

		$page->setTpl("stockordersitem-output-create",array(
			'idbranch'=>$branch->getidbranch(),
			'namebranch'=>$branch->getname(),
			'iduser'=>$user->getiduser(),
			'nameuser'=>$user->getname(),
			'idclient'=>$client->getidclient(),
			'nameclient'=>$client->getname()				
		));
	}
   
});




?>

<?php

use Classes\Controller\StockOrder;
use \Classes\PageAdmin;
use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\User;

function createStockOrder($dataStockOrder,$orderType){

	$stockorder = new StockOrder();
	$branch = new Branch();
	$user = new User();	
	$client = new Client();

	$resultSearchBranch = $branch->get($dataStockOrder['idbranch']);
	$resultSearchUser = $user->get($dataStockOrder['iduser']);

	switch ($orderType) {

		case 'exitrequest':
			
			$resultSearchClient = $client->get($dataStockOrder['idclient']);
		
			if (isDatasExistsExitOrder($resultSearchBranch,$resultSearchUser,$resultSearchClient)){

				$data = fillInputParameters('exitrequest',$stockorder,$branch,$user,$client);

				$stockorder->setData($data);

				$stockorder = $stockorder->save();
				
				$totalValueItens =  StockOrderItem::totalValueItensStockOrder($stockorder['idstockorder']);

				createPageStockOrderItem($orderType,$stockorder,$branch,$user,$client,$totalValueItens);
			
			}else{

				createPageStockOrder('exitrequest','Erro! Filial, Usuário ou Cliente com Código Inválido.');
			}
	

		break;

		case 'entryrequest':
			
			if (isDatasExistsEntryOrder($resultSearchBranch,$resultSearchUser)){

				$data = fillInputParameters('entryrequest',$stockorder,$branch,$user,$client);

				$stockorder->setData($data);

				$stockorder = $stockorder->save();
				
				$totalValueItens =  StockOrderItem::totalValueItensStockOrder($stockorder['idstockorder']);

				createPageStockOrderItem($orderType,$stockorder,$branch,$user,$client,$totalValueItens);
			
			}else{

				createPageStockOrder('entryrequest','Erro! Filial ou Usuário com Código Inválido.');

			}

		break;

	}

}


function fillInputParameters($orderType,$stockorder,$branch,$user,$client){

	if($orderType === 'exitrequest'){

		$idclient = $client->getidclient();

	}else{

		$idclient = null;
	}

	$data = [
		"idstockorder" => $stockorder->getidstockorder(),
		"idbranch" => $branch->getidbranch(),
		"iduser" => $user->getiduser(),
		"idclient" => $idclient,
		"idpaymentmethod" => null,
		"ordertype" => $orderType,
		"deliverynote" => null
	];	

	return $data;

}


function isDatasExistsExitOrder($resultSearchBranch,$resultSearchUser,$resultSearchClient){
	
	if ($resultSearchBranch != null && $resultSearchUser != null && $resultSearchClient != null) {
		
		return true;
	}

	return false;
}


function isDatasExistsEntryOrder($resultSearchBranch,$resultSearchUser){
	
	if ($resultSearchBranch != null && $resultSearchUser != null) {
		
		return true;
	}

	return false;
}



function createPageStockOrder($orderType,$error){

	$page = new PageAdmin();
	
    $page->setTpl("stockorders-create",array(
		'idbranch'=>'',
		'iduser'=>'',
		'idclient'=>'',
		'ordertype'=>$orderType,
		'idstockorder'=>'',		
		'checkout'=>'',	
		'error'=>$error
	));
}


function createPageStockOrderItem($orderType,$stockorder,$branch,$user,$client,$totalValueItens){

	if($orderType === 'exitrequest'){

		$idclient = $client->getidclient();

		$nameclient = $client->getname();

	}else{

		$idclient = 'null';

		$nameclient = 'null';
	}

	$page = new PageAdmin();
	
	$page->setTpl("stockordersitem-create", array(
		'idstockorder' => $stockorder['idstockorder'],
		'idbranch' => $branch->getidbranch(),
		'namebranch' => $branch->getname(),
		'iduser' => $user->getiduser(),
		'nameuser' => $user->getname(),
		'idclient' => $idclient,
		'nameclient' => $nameclient,
		'ordertype'=>$orderType,
		'errorNotItens' => '',
		'errorQuantityNotAvailable' => '',
		'error' => '',
		'idproduct' => '',
		'name' => '',
		'description' => '',
		'itens'=>'',
		'totalvalueitems'=>$totalValueItens
	));


}

function printOrderItems($idstockorder){

    $itens = StockOrderItem::getItens($idstockorder);

    return $itens;
}


?>
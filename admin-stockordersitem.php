<?php

use Classes\Controller\StockOrderItem;
use Classes\Controller\StockOrder;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\Product;
use Classes\Model\User;
use \Classes\PageAdmin;


$app->get("/admin/stockordersitem-output/create/:idbranch/:iduser/:idclient/:idstockorder", function ($idbranch,$iduser,$idclient,$idstockorder) {

	$page = new PageAdmin();

    $page->setTpl("stockorders-output-create",array(
		'idbranch'=>$idbranch,
		'iduser'=>$iduser,
		'idclient'=>$idclient,
		'error'=>'',
		'paymentmethod'=>'add',
		'deliverynote'=>'add',
		'finishrequest'=>'add',
		'idstockorder'=>$idstockorder
		
	));


});

$app->get("/admin/stockorders-output/create/finish/:idbranch/:iduser/:idclient/:idstockorder", function ($idbranch,$iduser,$idclient,$idstockorder) {

	$page = new PageAdmin();

    $page->setTpl("stockorders-output-create",array(
		'idbranch'=>$idbranch,
		'iduser'=>$iduser,
		'idclient'=>$idclient,
		'error'=>'',
		'paymentmethod'=>'add',
		'deliverynote'=>'add',
		'finishrequest'=>'add',		
		'idstockorder'=>$idstockorder
	));
});

$app->get("/admin/stockordersitem-output/create/:idbranch/:iduser/:idclient/:idstockorder", function ($idbranch,$iduser,$idclient,$idstockorder) {

	$parameter = $_GET;

	$branch = new Branch();
	$user = new User();
	$client = new Client();

	$branch->get($idbranch);
	$user->get($iduser);
	$client->get($idclient);
		
	if( is_numeric($parameter['product_search_parameter'])  ){

		$idproduct = (int) $parameter['product_search_parameter'];

		$product = new Product();

		$resultSearchProductItemOrder = $product->checksProductItemOrder($idproduct,$idstockorder);

		$resultSearchProductBranch = $product->checkProductBranch($idproduct,$idbranch);

		if($resultSearchProductItemOrder){

			$itens = StockOrderItem::getItens($idstockorder);
		
			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branch->getidbranch(),
				'namebranch'=>$branch->getname(),
				'iduser'=>$user->getiduser(),
				'nameuser'=>$user->getname(),
				'idclient'=>$client->getidclient(),
				'nameclient'=>$client->getname(),
				'error'=>'Erro! Já existem Item com esse Produto!',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',				
				'itens'=>$itens					
			));
							
		}else if(!$resultSearchProductBranch){

			$itens = StockOrderItem::getItens($idstockorder);

			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branch->getidbranch(),
				'namebranch'=>$branch->getname(),
				'iduser'=>$user->getiduser(),
				'nameuser'=>$user->getname(),
				'idclient'=>$client->getidclient(),
				'nameclient'=>$client->getname(),
				'error'=>'Erro! Produto não existe no estoque da filial!',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>$itens						
			));

		}else{

			$itens = StockOrderItem::getItens($idstockorder);

			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

			$userStockOrder = User::getStockOrderUser($idstockorder);

			$clientStockOrder = Client::getStockOrderClient($idstockorder);

			$product = new Product();

			$product->get($idproduct);
			
			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branchStockOrder['idbranch'],
				'namebranch'=>$branchStockOrder['namebranch'],
				'iduser'=>$userStockOrder['iduser'],
				'nameuser'=>$userStockOrder['nameuser'],
				'idclient'=>$clientStockOrder['idclient'],
				'nameclient'=>$clientStockOrder['nameclient'],
				'error'=>'',						
				'idproduct'=>$product->getidproduct(),
				'name'=>$product->getname(),
				'description'=>$product->getdescription(),
				'requestedquantity'=>'',
				'unitaryorice'=>'',				
				'totalvalue'=>'',
				'itens'=>$itens
			
			));
			
		}
		
	}else{
		
	}

	exit;

});



$app->post("/admin/stockordersitem-output/additem/:idproduct/:idstockorder", function ($idproduct,$idstockorder) {

	$parameter = $_POST;

	$requestedQuantity = (int)$parameter['requestedquantity'];
	$unitaryValue = (float)$parameter['unitaryprice'];
	$totalValueItem = (float)$requestedQuantity * $unitaryValue;

	$stockorderitem = new StockOrderItem();

	$data = [
		"idproduct"=>$idproduct,
		"idstockorder"=>$idstockorder,
		"idorderstatus"=>1,
		"quantity"=>$requestedQuantity,
		"unitaryvalue"=>$unitaryValue,
		"totalvalue"=>$totalValueItem,
		"dtremoved"=>null
	];


	$stockorderitem->setData($data);
	
	$stockorderitem->save();	
	
	$itens = StockOrderItem::getItens($idstockorder);

	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = Client::getStockOrderClient($idstockorder);
	
	$page = new PageAdmin();

	$page->setTpl("stockordersitem-create",array(
		'idstockorder'=>$idstockorder,
		'idbranch'=>$branchStockOrder['idbranch'],
		'namebranch'=>$branchStockOrder['namebranch'],
		'iduser'=>$userStockOrder['iduser'],
		'nameuser'=>$userStockOrder['nameuser'],
		'idclient'=>$clientStockOrder['idclient'],
		'nameclient'=>$clientStockOrder['nameclient'],
		'error'=>'',						
		'idproduct'=>'',
		'name'=>'',
		'description'=>'',
		'requestedquantity'=>'',
		'unitaryorice'=>'',
		'stockquantity'=>'',
		'totalvalue'=>'',
		'itens'=>$itens
	
	));	
	
	exit;

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


		$stockorder = new StockOrder();
		
		$data = [
			"idstockorder"=>$stockorder->getidstockorder(),
			"idbranch"=>$branch->getidbranch(),
			"iduser"=>$user->getiduser(),
			"idclient"=>$client->getidclient(),
			"idpaymentmethod"=>null,
			"ordertype"=>'SAÍDA',
			"deliverynote"=>null
		];	
		
		$stockorder->setData($data);
		
		$result = $stockorder->save();
		
		$page = new PageAdmin();

		$page->setTpl("stockordersitem-create",array(
			'idstockorder'=>$result['idstockorder'],
			'idbranch'=>$branch->getidbranch(),
			'namebranch'=>$branch->getname(),
			'iduser'=>$user->getiduser(),
			'nameuser'=>$user->getname(),
			'idclient'=>$client->getidclient(),
			'nameclient'=>$client->getname(),
			'error'=>'',
			'idproduct'=>'',
			'name'=>'',
			'description'=>'',
			'stockquantity'=>''
		));
	}
   
});

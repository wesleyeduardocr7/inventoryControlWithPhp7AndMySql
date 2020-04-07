<?php

use Classes\Controller\StockOrderItem;
use Classes\Controller\StockOrder;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\Product;
use Classes\Model\User;
use \Classes\PageAdmin;


// Bt Adicionar Item Tela Pedido de Estoque
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
			'idbranch'=>$branch->getidbranch(),
			'iduser'=>$user->getiduser(),
			'idclient'=>$client->getidclient(),
			'error'=>'Erro! Filial, Usuário ou Cliente com Código Inválido.',
			'checkout'=>''
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
		
		$resultSaveStockOrder = $stockorder->save();
		
		$page = new PageAdmin();

		$page->setTpl("stockordersitem-create",array(
			'idstockorder'=>$resultSaveStockOrder['idstockorder'],
			'idbranch'=>$branch->getidbranch(),
			'namebranch'=>$branch->getname(),
			'iduser'=>$user->getiduser(),
			'nameuser'=>$user->getname(),
			'idclient'=>$client->getidclient(),
			'nameclient'=>$client->getname(),
			'errorNotItens'=>'',
			'error'=>'',
			'idproduct'=>'',
			'name'=>'',
			'description'=>''
			
		));
	}
   
});

//Bt Pesquisa Produdo tela Item Pedido de Estoque
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
			
			$itens = printOrderItems($idstockorder);
		
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
				'errorNotItens'=>'',
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
				'errorNotItens'=>'',
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
				'errorNotItens'=>'',				
				'idproduct'=>$product->getidproduct(),
				'name'=>$product->getname(),
				'description'=>$product->getdescription(),				
				'itens'=>$itens			
			));
			
		}
		
	}else{

		//Busca por Nome
		
	}

	exit;

});


// BT Adicionar quantidade Solicitada e Preço Unitário tela Itens do Pedido
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
		'errorNotItens'=>'',					
		'idproduct'=>'',
		'name'=>'',
		'description'=>'',		
		'itens'=>$itens	
	));	
	
	exit;

});



//Bt Ver Itens de Um Pedido
$app->get("/admin/stockordersitem-output/create/:idstockorder", function ($idstockorder) {

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
		'errorNotItens'=>'',				
		'idproduct'=>'',
		'name'=>'',
		'description'=>'',				
		'itens'=>$itens			
	));

});



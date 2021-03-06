<?php

use Classes\Controller\StockOrder;
use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\Product;
use Classes\Model\User;
use Classes\PageAdmin;

$app->get("/admin/stockorders/create/:orderType", function ($orderType) {
	
	$error = '';

	$checkout = 'false';

	$idstockorder = '';

	createPageStockOrder($orderType,$error,$checkout, $idstockorder);

	exit;    
});

// Bt Concluir
$app->get("/admin/stockorders/finalizeitems/create/:ordertype/:idstockorder", function ($ordertype,$idstockorder) {

	$branch = new Branch();
	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
	$branch->get($branchStockOrder['idbranch']);
	
	$user = new User();
	$userStockOrder = User::getStockOrderUser($idstockorder);
	$user->get($userStockOrder['iduser']);

	$client = new Client();
	
	$product = new Product();	

	if($ordertype == 'exitrequest')
	{	
		$clientStockOrder = Client::getStockOrderClient($idstockorder);
		$client->get($clientStockOrder['idclient']);
	}

	$itens = StockOrderItem::getItens($idstockorder);

	if(count($itens)<=0){
		
		clearProductData($product);

		$error = 'Erro! Pedido sem Itens';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);		

	}else if( StockOrderItem::checkIfAllItemsWasProcessed($idstockorder)){

		clearProductData($product);

		$error = 'Erro! Todos Os Pedidos Já Foram PROCESSADOS';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);		
	
	}else if(StockOrderItem::checkForProcessedItem($idstockorder)){

		clearProductData($product);

		$error = 'Erro! Pedido Já Foi Finalizado';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);		

	}else if(StockOrderItem::checkIfAllItemsWasCanceled($idstockorder)){

		clearProductData($product);

		$error = 'Erro! Todos Os Pedidos Estão CANCELADOS. Insira um Item No Pedido';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);		

	}else{

		$error = '';

		$checkout = 'true';

		createPageStockOrder($ordertype,$error, $checkout, $idstockorder);

	}

	
exit;

});



$app->post("/admin/stockorders/create/checkout/:ordertype/:idstockorder", function ($ordertype,$idstockorder) {

	$stockOrder = new StockOrder();

	$parameters = $_POST;

	$deliverynote = $parameters['deliverynote'];
	
	$idpaymentmethod =  paymentMethod($parameters['gender']);

	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = new Client();

	if($ordertype == 'exitrequest')
	{	
		$clientStockOrder = Client::getStockOrderClient($idstockorder);

		$data = [	
			"idstockorder"=>$idstockorder,
			'idbranch'=>$branchStockOrder['idbranch'],		
			'iduser'=>$userStockOrder['iduser'],
			'idclient'=>$clientStockOrder['idclient'],
			"idpaymentmethod"=>$idpaymentmethod,
			"ordertype"=>$ordertype,
			"deliverynote"=>$deliverynote
		];
	}else{


		$data = [	
			"idstockorder"=>$idstockorder,
			'idbranch'=>$branchStockOrder['idbranch'],		
			'iduser'=>$userStockOrder['iduser'],
			'idclient'=>null,
			"idpaymentmethod"=>$idpaymentmethod,
			"ordertype"=>$ordertype,
			"deliverynote"=>$deliverynote
		];


	}			

	$stockOrder->setData($data);

	$stockOrder->save();
	
	StockOrderItem::saveAndUpdateItemsStatus($idstockorder,3);

	if($ordertype == 'exitrequest'){

		header("Location: /admin/stockorders-output");

	}else{

		header("Location: /admin/stockorders-input");
	}
	
	exit;

});


$app->get("/admin/stockorders", function () {

	$stockorders = StockOrder::listAll();

	$page = new PageAdmin();

    $page->setTpl("stockorders", array(
		'stockorders' => $stockorders
		
	));
	
	exit;

});

$app->get("/admin/stockorders-output", function () {

	$stockorders = StockOrder::listAllStockOrderOutput();

	$page = new PageAdmin();

    $page->setTpl("stockorders-output", array(
		'stockorders' => $stockorders
		
	));
	
	exit;

});


$app->get("/admin/stockorders-input", function () {

	$stockorders = StockOrder::listAllStockOrderInput();

	$page = new PageAdmin();

    $page->setTpl("stockorders-input", array(
		'stockorders' => $stockorders
		
	));
	
	exit;

});



?>

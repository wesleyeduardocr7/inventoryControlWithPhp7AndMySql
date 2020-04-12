<?php

use Classes\Controller\StockOrder;
use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use Classes\Model\Client;
use \Classes\PageAdmin;
use \Classes\Model\Stock;
use Classes\Model\User;

$app->post("/admin/stockorders-output/create/finish/:idstockorder", function ($idstockorder) {

	$stockOrder = new StockOrder();

	$parameters = $_POST;

	$deliverynote = $parameters['deliverynote'];
	
	$idpaymentmethod =  paymentMethod($parameters['gender']);

	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = Client::getStockOrderClient($idstockorder);
		
	$data = [	
		"idstockorder"=>$idstockorder,
		'idbranch'=>$branchStockOrder['idbranch'],
		'namebranch'=>$branchStockOrder['namebranch'],
		'iduser'=>$userStockOrder['iduser'],
		'idclient'=>$clientStockOrder['idclient'],
		"idpaymentmethod"=>$idpaymentmethod,
		"ordertype"=>'SAÍDA',
		"deliverynote"=>$deliverynote
	];

	$stockOrder->setData($data);

	$stockOrder->save();

	StockOrderItem::saveAndUpdateItemsStatus($idstockorder,3);

	header("Location: /admin/stockorders-output");
	
	exit;

});


/*
$app->get("/admin/stockorders-output/create/deleteitem/:idstockorder/:idstockorderitem", function ($idstockorder,$idstockorderitem) {
	
	$page = new PageAdmin();

	$itens = StockOrderItem::getItens($idstockorder);
	
	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = Client::getStockOrderClient($idstockorder);

	if($itens[0]["namestatus"]=!'CANCELADO'){
			
		StockOrderItem::deleteItem($idstockorder,2,$idstockorderitem);
		
		$page->setTpl("stockordersitem-create", array(
			'idstockorder' => $idstockorder,
			'idbranch' => $branchStockOrder['idbranch'],
			'namebranch' => $branchStockOrder['namebranch'],
			'iduser' => $userStockOrder['iduser'],
			'nameuser' => $userStockOrder['nameuser'],
			'idclient' => $clientStockOrder['idclient'],
			'nameclient' => $clientStockOrder['nameclient'],
			'error' => '',
			'errorNotItens' => '',
			'errorQuantityNotAvailable' => '',
			'idproduct' => '',
			'name' => '',
			'description' => '',
			'itens' => $itens
		));	

	}else{

		$page->setTpl("stockordersitem-create", array(
			'idstockorder' => $idstockorder,
			'idbranch' => $branchStockOrder['idbranch'],
			'namebranch' => $branchStockOrder['namebranch'],
			'iduser' => $userStockOrder['iduser'],
			'nameuser' => $userStockOrder['nameuser'],
			'idclient' => $clientStockOrder['idclient'],
			'nameclient' => $clientStockOrder['nameclient'],
			'error' => '',
			'errorNotItens' => 'Item já foi Cancelado',
			'errorQuantityNotAvailable' => '',
			'idproduct' => '',
			'name' => '',
			'description' => '',
			'itens' => $itens
		));	

	}

	exit;

});*/




$app->get("/admin/stockorders-output", function () {

	$stockorders = StockOrder::listAll();

	$page = new PageAdmin();

    $page->setTpl("stockorders-output", array(
        'stockorders' => $stockorders
    ));
   
	

});


$app->get("/admin/stockorders-output/create", function () {

    $page = new PageAdmin();

    $page->setTpl("stockorders-output-create",array(
		'idbranch'=>'',
		'iduser'=>'',
		'idclient'=>'',
		'error'=>'',
		'checkout'=>'',			
		'idstockorder'=>''
		
	));
});


$app->get("/admin/stockorders-output/create/:idbranch/:iduser/:idclient", function ($idbranch,$iduser,$idclient) {

	$page = new PageAdmin();

    $page->setTpl("stockorders-output-create",array(
		'idbranch'=>$idbranch,
		'iduser'=>$iduser,
		'idclient'=>$idclient,
		'error'=>'',
		'checkout'=>'',	
		'idstockorder'=>''
		
	));

});


$app->get("/admin/stockorders-output/create/checkout/:idbranch/:iduser/:idclient/:idstockorder", function ($idbranch,$iduser,$idclient,$idstockorder) {
	
	$itens = StockOrderItem::getItens($idstockorder);

	if(count($itens)>0){		

		if($itens[0]['namestatus'] == 'PROCESSADO'){

			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
		
			$userStockOrder = User::getStockOrderUser($idstockorder);
		
			$clientStockOrder = Client::getStockOrderClient($idstockorder);
	
			$itens = StockOrderItem::getItens($idstockorder);
	
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
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Erro! Itens do Pedido ja foram PROCESSADOS',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>$itens					
			));
	
		}else if(count($itens)>0){
	
			$page = new PageAdmin();
	
			$page->setTpl("stockorders-output-create",array(
				'idbranch'=>'',
				'iduser'=>'',
				'idclient'=>'',
				'error'=>'',
				'checkout'=>'true',		
				'idstockorder'=>$idstockorder
			));
			
		}else{				
	
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
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Pedido não possuí Itens',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>''						
			));
	
		}

	}else{


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
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Erro! Pedido sem Itens',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>''						
			));
	



	}
	
	
    
});




$app->post("/admin/stockorders/create", function () {

    $stock = new Stock();

    $stock->setData($_POST);
    
    $stock->save();

    header("Location: /admin/stocks");
    exit;
});

$app->get("/admin/stocks/:idstock", function($idstock){

	$stock = new Stock();

	$stock->get((int)$idstock);

	$page = new PageAdmin();

	$page->setTpl("stocks-update", [
		'stock'=>$stock->getValues()
	]);

});

$app->post("/admin/stock/:idstock", function($idstock){
    

	$stock = new Stock();

	$stock->get((int)$idstock);

	$stock->setData($_POST);

	$stock->save();

	header('Location: /admin/stocks');
	exit;

});

$app->get("/admin/stocks/:idstock/delete", function($idstock){

	$stock = new Stock();

	$stock->get((int)$idstock);

	$stock->delete();

	header('Location: /admin/stocks');
	exit;

});



function paymentMethod($parameter){

	if($parameter === 'avista'){
		return 1;
	}else if ($parameter === 'boleto'){
		return 2;
	}else{
		return 3;
	}
	
}

?>

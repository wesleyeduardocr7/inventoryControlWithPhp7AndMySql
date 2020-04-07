<?php

use Classes\Controller\StockOrder;
use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use Classes\Model\Client;
use \Classes\PageAdmin;
use \Classes\Model\Stock;
use Classes\Model\User;

$app->get("/admin/stockorders-output/create/finish/:idstockorder/:idpaymentmethod/:deliverynote", function ($idstockorder,$idpaymentmethod,$deliverynote) {

	$stockorder = new StockOrder();

	$stockorder->get($idstockorder);
	
	exit;

});



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

	$page = new PageAdmin();

	if(count($itens)>0){

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

		$page->setTpl("stockordersitem-create",array(
			'idstockorder'=>$idstockorder,
			'idbranch'=>$branchStockOrder['idbranch'],
			'namebranch'=>$branchStockOrder['namebranch'],
			'iduser'=>$userStockOrder['iduser'],
			'nameuser'=>$userStockOrder['nameuser'],
			'idclient'=>$clientStockOrder['idclient'],
			'nameclient'=>$clientStockOrder['nameclient'],
			'error'=>'',
			'errorNotItens'=>'Pedido não possuí Itens',
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


?>

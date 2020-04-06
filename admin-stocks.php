<?php

use \Classes\PageAdmin;
use \Classes\Model\Stock;

$app->get("/admin/stocks", function () {

	$stocks = Stock::listAll();

    $page = new PageAdmin();

    $page->setTpl("stocks",array(
		'stocks'=>$stocks
	));
});


$app->get("/admin/stocks/create", function () {

    $page = new PageAdmin();

    $page->setTpl("stocks-create",array(
		'idbranch'=>'',
		'idproduct'=>'',
		'quantity'=>'',
		'error'=>''
	));
});


$app->post("/admin/stocks/create", function () {

	$stock = new Stock();
	
	$stock->setData($_POST);	
	
	$result = $stock->save();
	
	if( count($result) <= 0 ){
			
		$page = new PageAdmin();

		$page->setTpl("stocks-create",array(
			'idbranch'=>$stock->getidbranch(),
			'idproduct'=>$stock->getidproduct(),
			'quantity'=>$stock->getquantity(),	
			'error'=>'Erro! Códigos inválidos ou já existe estoque com esses dados'
		));

		exit;

	}else{
		
		header("Location: /admin/stocks");

		exit;
	}

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

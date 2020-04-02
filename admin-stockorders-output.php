<?php

use \Classes\PageAdmin;
use \Classes\Model\Stock;

$app->get("/admin/stockorders-output", function () {

   
});


$app->get("/admin/stockorders-output/create", function () {

    $page = new PageAdmin();

    $page->setTpl("stockorders-output-create",array(
		'idbranch'=>'',
		'iduser'=>'',
		'idclient'=>''
	));
});


$app->post("/admin/stocks/create", function () {

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
<?php

use Classes\Controller\StockOrder;
use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use \Classes\PageAdmin;
use \Classes\Model\Stock;
use Classes\Model\User;

$app->get("/admin/stockorders-input/create", function () {

    $page = new PageAdmin();

    $page->setTpl("stockorders-input-create",array(
		'idbranch'=>'',
		'iduser'=>'',		
		'checkout'=>'',		
		'error'=>''	
	));
});


$app->get("/admin/stockorders-input/create/checkout/:idstockorder", function ($idstockorder) {

	$itens = StockOrderItem::getItens($idstockorder);

	if(count($itens)>0){		

		if($itens[0]['namestatus'] == 'PROCESSADO'){

			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
		
			$userStockOrder = User::getStockOrderUser($idstockorder);
		
			$itens = StockOrderItem::getItens($idstockorder);

			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);
	
			$page = new PageAdmin();
	
			$page->setTpl("stockordersitem-input-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branchStockOrder['idbranch'],
				'namebranch'=>$branchStockOrder['namebranch'],
				'iduser'=>$userStockOrder['iduser'],
				'nameuser'=>$userStockOrder['nameuser'],			
				'error'=>'',
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Erro! Itens do Pedido ja foram PROCESSADOS',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>$itens	,
				'totalvalueitems'=>$totalValueItens			
			));
	
		}else if(StockOrderItem::checkIfAllItemsWasCanceled($idstockorder)){

			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
		
			$userStockOrder = User::getStockOrderUser($idstockorder);
		
			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);
	
			$itens = StockOrderItem::getItens($idstockorder);
	
			$page = new PageAdmin();
	
			$page->setTpl("stockordersitem-input-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branchStockOrder['idbranch'],
				'namebranch'=>$branchStockOrder['namebranch'],
				'iduser'=>$userStockOrder['iduser'],
				'nameuser'=>$userStockOrder['nameuser'],				
				'error'=>'',
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Erro! Não é possível Concluir Pedido com Todos os Itens Cancelados, Por favor Cancele o Pedido no Botão Cancelar',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>$itens	,
				'totalvalueitems'=>$totalValueItens		
			));				

		}else if(count($itens)>0){

			$page = new PageAdmin();
	
			$page->setTpl("stockorders-input-create",array(
				'idbranch'=>'',
				'iduser'=>'',
				'checkout'=>'true',
				'error'=>'',		
				'idstockorder'=>$idstockorder
			));
			
		}else{				
	
			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
		
			$userStockOrder = User::getStockOrderUser($idstockorder);
		
			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);
	
			$page = new PageAdmin();
	
			$page->setTpl("stockordersitem-input-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branchStockOrder['idbranch'],
				'namebranch'=>$branchStockOrder['namebranch'],
				'iduser'=>$userStockOrder['iduser'],
				'nameuser'=>$userStockOrder['nameuser'],			
				'error'=>'',
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Pedido não possuí Itens',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>''	,
				'totalvalueitems'=>$totalValueItens					
			));
	
		}

	}else{


		$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
		
			$userStockOrder = User::getStockOrderUser($idstockorder);
		
			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);
	
			$page = new PageAdmin();
	
			$page->setTpl("stockordersitem-input-create",array(
				'idstockorder'=>$idstockorder,
				'idbranch'=>$branchStockOrder['idbranch'],
				'namebranch'=>$branchStockOrder['namebranch'],
				'iduser'=>$userStockOrder['iduser'],
				'nameuser'=>$userStockOrder['nameuser'],				
				'error'=>'',
				'errorQuantityNotAvailable'=>'',
				'errorNotItens'=>'Erro! Pedido sem Itens',
				'idproduct'=>'',
				'name'=>'',
				'description'=>'',
				'itens'=>''	,
				'totalvalueitems'=>$totalValueItens			
			));

	}
	
    
});


$app->post("/admin/stockorders-input/create/finish/:idstockorder", function ($idstockorder) {

	$stockOrder = new StockOrder();

	$parameters = $_POST;

	$deliverynote = $parameters['deliverynote'];
	
	$idpaymentmethod =  paymentMethod($parameters['gender']);

	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);
		
	$data = [	
		"idstockorder"=>$idstockorder,
		'idbranch'=>$branchStockOrder['idbranch'],		
		'iduser'=>$userStockOrder['iduser'],
		'idclient'=>null,
		"idpaymentmethod"=>$idpaymentmethod,
		"ordertype"=>'ENTRADA',
		"deliverynote"=>$deliverynote
	];

	$stockOrder->setData($data);

	$stockOrder->save();

	StockOrderItem::saveAndUpdateItemsInputStatus($idstockorder,3);

	header("Location: /admin/stockorders-input");
	
	exit;

});

$app->get("/admin/stockorders-input", function () {

	$stockorders = StockOrder::listAll();

	$page = new PageAdmin();

    $page->setTpl("stockorders-input", array(
        'stockorders' => $stockorders
    ));	

});


$app->get("/admin/stockorders-input/create/:idbranch/:iduser", function ($idbranch,$iduser) {

	$page = new PageAdmin();

    $page->setTpl("stockorders-input-create",array(
		'idbranch'=>$idbranch,
		'iduser'=>$iduser,		
		'error'=>'',
		'checkout'=>'',	
		'idstockorder'=>''
		
	));

});



?>

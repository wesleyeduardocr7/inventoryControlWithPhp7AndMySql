<?php

use Classes\Controller\StockOrderItem;
use Classes\Controller\StockOrder;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\Product;
use Classes\Model\Stock;
use Classes\Model\User;
use \Classes\PageAdmin;


$app->post("/admin/stockordersitem/create/:orderType", function ($orderType) {

	$dataStockOrder = $_POST;
	
	createStockOrder($dataStockOrder,$orderType);

	exit;

});

$app->get("/admin/stockordersitem/create/:ordertype/:idbranch/:iduser/:idclient/:idstockorder", function ($ordertype,$idbranch,$iduser,$idclient,$idstockorder) {

	$parameter = $_GET;
	
	$branch = new Branch();
	$user = new User();
	$client = new Client();	
	$product = new Product();	
	$error = '';

	$branch->get($idbranch);
	$user->get($iduser);
	$client->get($idclient);
	
	
	if(is_numeric($parameter['product_search_parameter'])){	

		$product->get($parameter['product_search_parameter']);
		
	}else{

		$product->getByName($parameter['product_search_parameter']);				
	}

	if(StockOrderItem::checkIfAllItemsWasProcessed($idstockorder)){
			
		$error = 'Não é Possível mais Adicinar Itens Porque o Pedido Já Foi Finalizado';

		clearProductData($product);

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client,$product, $error);		

		exit;
	}

	if( Product::checksProductItemOrder($product->getidproduct(),$idstockorder)){

		clearProductData($product);

		$error = 'Erro! Já existem Item com esse Produto!';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client,$product, $error);	

		exit;

	}

	if( ! Product::checkProductBranch($product->getidproduct(),$branch->getidbranch())){
		
		clearProductData($product);

		$error = 'Erro! Produto não existe no estoque da filial!';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client,$product, $error);	

		exit;

	}
		
	createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);	
	
	exit;
});


// BT Adicionar quantidade Solicitada e Preço Unitário tela Itens do Pedido
$app->post("/admin/stockordersitem/additem/:ordertype/:idproduct/:idstockorder", function ($ordertype,$idproduct, $idstockorder) {

	$parameter = $_POST;
	
	$requestedQuantity = (int) $parameter['requestedquantity'];
	$unitaryValue = (float) $parameter['unitaryprice'];
	$totalValueItem = (float) $requestedQuantity * $unitaryValue;

	$branch = new Branch();
	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);
	$branch->get($branchStockOrder['idbranch']);
	
	$user = new User();
	$userStockOrder = user::getStockOrderUser($idstockorder);
	$user->get($userStockOrder['iduser']);

	$client = new Client();
	
	$product = new Product();
	$product->get($idproduct);

	if($ordertype == 'exitrequest')
	{	
		$clientStockOrder = Client::getStockOrderClient($idstockorder);
		$client->get($clientStockOrder['idclient']);
	}
	
	if($idproduct == 'null'){

		$error = 'Por favor pesquise por um Produto ';

		clearProductData($product);

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);	

		exit;

	}

	$resultSearchavailableQuantity = Stock::verifyQuantityRequestedStock($idstockorder, $idproduct);

	$availableQuantity = (int) $resultSearchavailableQuantity['quantity'];

	if ($requestedQuantity <= 0) {

		$error = 'Quantidade Solicitada Não pode ser menor ou igual a 0 ';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);	

		exit;

	}else if($unitaryValue <= 0){

		$error = 'Preço do Produto não pode ser menor ou igual a 0';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);	

		exit;

	}else if ($requestedQuantity > $availableQuantity) {

		$error = 'Quantidade Solicitada Inferior à Quantidade Disponível no Estoque' . ' || Quantidade Disponível = ' . $availableQuantity;

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);	

		exit;

	}else{

		$stockorderitem = new StockOrderItem();

		$data = [
			"idproduct" => $idproduct,
			"idstockorder" => $idstockorder,
			"idorderstatus" => 1,
			"quantity" => $requestedQuantity,
			"unitaryvalue" => $unitaryValue,
			"totalvalue" => $totalValueItem,
			"dtremoved" => null
		];

		$stockorderitem->setData($data);

		$stockorderitem->save();

		$error = '';

		createPageStockOrderItem($ordertype,$idstockorder,$branch,$user,$client, $product, $error);	

		exit;

	}	
});



//Bt Ver Itens de Um Pedido
$app->get("/admin/stockordersitem-output/create/:idstockorder", function ($idstockorder) {

	$itens = StockOrderItem::getItens($idstockorder);

	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = Client::getStockOrderClient($idstockorder);

	$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

	$page = new PageAdmin();

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
		'itens' => $itens,
		'totalvalueitems'=>$totalValueItens
		
	));
});



// BT Erro Ao Inserir quantidade e preço de produto nao Selecionado
$app->post("/admin/stockordersitem-output/additem//:idstockorder", function ($idstockorder) {


	$itens = StockOrderItem::getItens($idstockorder);

	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = Client::getStockOrderClient($idstockorder);

	$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

	$page = new PageAdmin();

	$page->setTpl("stockordersitem-create", array(
		'idstockorder' => $idstockorder,
		'idbranch' => $branchStockOrder['idbranch'],
		'namebranch' => $branchStockOrder['namebranch'],
		'iduser' => $userStockOrder['iduser'],
		'nameuser' => $userStockOrder['nameuser'],
		'idclient' => $clientStockOrder['idclient'],
		'nameclient' => $clientStockOrder['nameclient'],
		'error' => '',
		'errorQuantityNotAvailable' => 'Por favor informe um parâmetro de busca para o Produto',
		'errorNotItens' => '',
		'idproduct' => '',
		'name' => '',
		'description' => '',
		'itens' => $itens,
		'totalvalueitems'=>$totalValueItens
	));
});




$app->get("/admin/stockordersitem-output/deleteitem/:idstockorder/:idstockorderitem", function ($idstockorder,$idstockorderitem) {
	
	$itens = StockOrderItem::getItens($idstockorder);
	
	$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

	$userStockOrder = User::getStockOrderUser($idstockorder);

	$clientStockOrder = Client::getStockOrderClient($idstockorder);

	if( StockOrderItem::checkIfItemWasProcessed($idstockorder,$idstockorderitem) ){

		$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

		$page = new PageAdmin();

		$page->setTpl("stockordersitem-create", array(
			'idstockorder' => $idstockorder,
			'idbranch' => $branchStockOrder['idbranch'],
			'namebranch' => $branchStockOrder['namebranch'],
			'iduser' => $userStockOrder['iduser'],
			'nameuser' => $userStockOrder['nameuser'],
			'idclient' => $clientStockOrder['idclient'],
			'nameclient' => $clientStockOrder['nameclient'],
			'error' => '',
			'errorNotItens' => 'Item não pode ser CANCELADO porque já foi PROCESSADO',
			'errorQuantityNotAvailable' => '',
			'idproduct' => '',
			'name' => '',
			'description' => '',
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));	

	}else if( StockOrderItem::checkIfItemWasCanceled($idstockorder,$idstockorderitem) ){

		$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);
		
		$page = new PageAdmin();

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
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));			

	}else{

		StockOrderItem::deleteItem($idstockorder,2,$idstockorderitem);

		$itens = StockOrderItem::getItens($idstockorder);

		$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);
		
		$page = new PageAdmin();

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
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));	

	}

	exit;

});




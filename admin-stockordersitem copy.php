<?php

use Classes\Controller\StockOrderItem;
use Classes\Controller\StockOrder;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\Product;
use Classes\Model\Stock;
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

	if ($resultSearchBranch === null || $resultSearchUser === null || $resultSearchClient === null) {

		$page = new PageAdmin();

		$page->setTpl("stockorders-output-create", array(
			'idbranch' => $branch->getidbranch(),
			'iduser' => $user->getiduser(),
			'idclient' => $client->getidclient(),
			'error' => 'Erro! Filial, Usuário ou Cliente com Código Inválido.',
			'checkout' => ''
		));
	} else {


		$stockorder = new StockOrder();

		$data = [
			"idstockorder" => $stockorder->getidstockorder(),
			"idbranch" => $branch->getidbranch(),
			"iduser" => $user->getiduser(),
			"idclient" => $client->getidclient(),
			"idpaymentmethod" => null,
			"ordertype" => 'SAÍDA',
			"deliverynote" => null
		];

		$stockorder->setData($data);

		$resultSaveStockOrder = $stockorder->save();

		$totalValueItens =  StockOrderItem::totalValueItensStockOrder($stockorder->getidstockorder());

		$page = new PageAdmin();

		$page->setTpl("stockordersitem-create", array(
			'idstockorder' => $resultSaveStockOrder['idstockorder'],
			'idbranch' => $branch->getidbranch(),
			'namebranch' => $branch->getname(),
			'iduser' => $user->getiduser(),
			'nameuser' => $user->getname(),
			'idclient' => $client->getidclient(),
			'nameclient' => $client->getname(),
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
});

//Bt Pesquisa Produdo tela Item Pedido de Estoque
$app->get("/admin/stockordersitem-output/create/:idbranch/:iduser/:idclient/:idstockorder", function ($idbranch, $iduser, $idclient, $idstockorder) {

	$parameter = $_GET;

	$branch = new Branch();
	$user = new User();
	$client = new Client();

	$branch->get($idbranch);
	$user->get($iduser);
	$client->get($idclient);

	if(StockOrderItem::checkIfAllItemsWasProcessed($idstockorder)){

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
			'errorQuantityNotAvailable' => 'Não é Possível mais Adicinar Itens Porque o Pedido Já Foi Finalizado',
			'errorNotItens' => '',
			'idproduct' => '',
			'name' => '',
			'description' => '',
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));

	}else if (is_numeric($parameter['product_search_parameter'])) {

		$idproduct = (int) $parameter['product_search_parameter'];

		$product = new Product();

		$resultSearchProductItemOrder = $product->checksProductItemOrder($idproduct, $idstockorder);

		$resultSearchProductBranch = $product->checkProductBranch($idproduct, $idbranch);

		if ($resultSearchProductItemOrder) {

			
			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create", array(
				'idstockorder' => $idstockorder,
				'idbranch' => $branch->getidbranch(),
				'namebranch' => $branch->getname(),
				'iduser' => $user->getiduser(),
				'nameuser' => $user->getname(),
				'idclient' => $client->getidclient(),
				'nameclient' => $client->zgetname(),
				'error' => 'Erro! Já existem Item com esse Produto!',
				'errorQuantityNotAvailable' => '',
				'errorNotItens' => '',
				'idproduct' => '',
				'name' => '',
				'description' => '',
				'itens' => $itens,
				'totalvalueitems'=>$totalValueItens
			));
		} else if (!$resultSearchProductBranch) {

			$itens = StockOrderItem::getItens($idstockorder);

			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create", array(
				'idstockorder' => $idstockorder,
				'idbranch' => $branch->getidbranch(),
				'namebranch' => $branch->getname(),
				'iduser' => $user->getiduser(),
				'nameuser' => $user->getname(),
				'idclient' => $client->getidclient(),
				'nameclient' => $client->getname(),
				'error' => 'Erro! Produto não existe no estoque da filial!',
				'errorQuantityNotAvailable' => '',
				'errorNotItens' => '',
				'idproduct' => '',
				'name' => '',
				'description' => '',
				'itens' => $itens,
				'totalvalueitems'=>$totalValueItens
			));
		} else {

			$itens = StockOrderItem::getItens($idstockorder);

			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

			$userStockOrder = User::getStockOrderUser($idstockorder);

			$clientStockOrder = Client::getStockOrderClient($idstockorder);

			$product = new Product();

			$product->get($idproduct);

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
				'errorQuantityNotAvailable' => '',
				'error' => '',
				'errorNotItens' => '',
				'idproduct' => $product->getidproduct(),
				'name' => $product->getname(),
				'description' => $product->getdescription(),
				'itens' => $itens,
				'totalvalueitems'=>$totalValueItens
			));
		}
	} else {

		$nameProduct = $parameter['product_search_parameter'];
		
		$product = new Product();

		$product->getByName($nameProduct);
		
		$idproduct = (int) $product->getidproduct();

		$resultSearchProductItemOrder = $product->checksProductItemOrder($idproduct, $idstockorder);

		$resultSearchProductBranch = $product->checkProductBranch($idproduct, $idbranch);
		
		if ($resultSearchProductItemOrder) {

			
			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create", array(
				'idstockorder' => $idstockorder,
				'idbranch' => $branch->getidbranch(),
				'namebranch' => $branch->getname(),
				'iduser' => $user->getiduser(),
				'nameuser' => $user->getname(),
				'idclient' => $client->getidclient(),
				'nameclient' => $client->getname(),
				'error' => 'Erro! Já existem Item com esse Produto!',
				'errorQuantityNotAvailable' => '',
				'errorNotItens' => '',
				'idproduct' => '',
				'name' => '',
				'description' => '',
				'itens' => $itens,
				'totalvalueitems'=>$totalValueItens
			));
		} else if (!$resultSearchProductBranch) {

			$itens = StockOrderItem::getItens($idstockorder);

			$totalValueItens =  StockOrderItem::totalValueItensStockOrder($idstockorder);

			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create", array(
				'idstockorder' => $idstockorder,
				'idbranch' => $branch->getidbranch(),
				'namebranch' => $branch->getname(),
				'iduser' => $user->getiduser(),
				'nameuser' => $user->getname(),
				'idclient' => $client->getidclient(),
				'nameclient' => $client->getname(),
				'error' => 'Erro! Produto não existe no estoque da filial!',
				'errorQuantityNotAvailable' => '',
				'errorNotItens' => '',
				'idproduct' => '',
				'name' => '',
				'description' => '',
				'itens' => $itens,
				'totalvalueitems'=>$totalValueItens
			));
		} else {

			$itens = StockOrderItem::getItens($idstockorder);

			$branchStockOrder = Branch::getStockOrderBranch($idstockorder);

			$userStockOrder = User::getStockOrderUser($idstockorder);

			$clientStockOrder = Client::getStockOrderClient($idstockorder);

			$product = new Product();

			$product->getByName($nameProduct);

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
				'errorQuantityNotAvailable' => '',
				'error' => '',
				'errorNotItens' => '',
				'idproduct' => $product->getidproduct(),
				'name' => $product->getname(),
				'description' => $product->getdescription(),
				'itens' => $itens,
				'totalvalueitems'=>$totalValueItens
			));
		}
	}

	exit;
});


// BT Adicionar quantidade Solicitada e Preço Unitário tela Itens do Pedido
$app->post("/admin/stockordersitem-output/additem/:idproduct/:idstockorder", function ($idproduct, $idstockorder) {

	$parameter = $_POST;

	$requestedQuantity = (int) $parameter['requestedquantity'];
	$unitaryValue = (float) $parameter['unitaryprice'];
	$totalValueItem = (float) $requestedQuantity * $unitaryValue;
	
	$product = new Product();

	$product->get($idproduct);

	$resultSearchavailableQuantity = Stock::verifyQuantityRequestedStock($idstockorder, $idproduct);

	$availableQuantity = (int) $resultSearchavailableQuantity['quantity'];


	if ($requestedQuantity <= 0) {
		
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
			'errorQuantityNotAvailable' => 'Quantidade Solicitada Não pode ser menor ou igual a 0 ',
			'errorNotItens' => '',
			'idproduct' => $product->getidproduct(),
			'name' => $product->getname(),
			'description' => $product->getdescription(),
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));
		
	} else if($unitaryValue <= 0){
		
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
			'errorQuantityNotAvailable' => 'Preço do Produto não pode ser menor ou igual a 0',
			'errorNotItens' => '',
			'idproduct' => $product->getidproduct(),
			'name' => $product->getname(),
			'description' => $product->getdescription(),
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));


	} else if ($requestedQuantity <= $availableQuantity) {

		
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
			'errorQuantityNotAvailable' => '',
			'errorNotItens' => '',
			'idproduct' => $product->getidproduct(),
			'name' => $product->getname(),
			'description' => $product->getdescription(),
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));
	} else {

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
			'errorQuantityNotAvailable' => 'Quantidade Solicitada Inferior à Quantidade Disponível no Estoque' . ' || Quantidade Disponível = ' . $availableQuantity,
			'errorNotItens' => '',
			'idproduct' => $product->getidproduct(),
			'name' => $product->getname(),
			'description' => $product->getdescription(),
			'itens' => $itens,
			'totalvalueitems'=>$totalValueItens
		));
	}

	exit;
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




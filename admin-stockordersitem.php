<?php

use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use Classes\Model\Client;
use Classes\Model\Product;
use Classes\Model\User;
use \Classes\PageAdmin;


$app->get("/admin/stockordersitem-output/create/:idbranch/:iduser/:idclient", function ($idbranch,$iduser,$idclient) {

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

		$resultSearchProduct = $product->get($idproduct);

		if($resultSearchProduct == null){
		
			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create",array(
				'idbranch'=>$branch->getidbranch(),
				'namebranch'=>$branch->getname(),
				'iduser'=>$user->getiduser(),
				'nameuser'=>$user->getname(),
				'idclient'=>$client->getidclient(),
				'nameclient'=>$client->getname(),
				'error'=>'Erro! Produto não encontrado ou não pertence ao estoque da filial informada',
				'itens'=>''							
			));
							
		}else{

			
			$stockorderitem = new StockOrderItem();

			$data = [
				"idproduct"=>$idproduct,
				"idstockorder"=>null,
				"idorderstatus"=>1,
				"quantity"=>null,
				"unitaryvalue"=>null,
				"totalvalue"=>null,
				"dtremoved"=>null
			];

			$stockorderitem->setData($data);

			$stockorderitem->save();

			$item = Product::branchProduct($idproduct,$branch->getidbranch());
			
			$page = new PageAdmin();

			$page->setTpl("stockordersitem-create",array(
				'idbranch'=>$branch->getidbranch(),
				'namebranch'=>$branch->getname(),
				'iduser'=>$user->getiduser(),
				'nameuser'=>$user->getname(),
				'idclient'=>$client->getidclient(),
				'nameclient'=>$client->getname(),
				'error'=>''	,						
				'item'=>$item
			));	
			
		}
		
	}else{
		
	}

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

		$page = new PageAdmin();

		$page->setTpl("stockordersitem-create",array(
			'idbranch'=>$branch->getidbranch(),
			'namebranch'=>$branch->getname(),
			'iduser'=>$user->getiduser(),
			'nameuser'=>$user->getname(),
			'idclient'=>$client->getidclient(),
			'nameclient'=>$client->getname(),
			'error'=>''
							
		));
	}
   
});

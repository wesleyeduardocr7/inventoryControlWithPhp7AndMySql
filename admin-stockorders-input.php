<?php

use Classes\Controller\StockOrder;
use Classes\Controller\StockOrderItem;
use Classes\Model\Branch;
use Classes\Model\Client;
use \Classes\PageAdmin;
use \Classes\Model\Stock;
use Classes\Model\User;

$app->get("/admin/stockorders-input/create", function () {

    $page = new PageAdmin();

    $page->setTpl("stockorders-input-create",array(
		'idbranch'=>'',
		'iduser'=>'',		
		'error'=>''	
	));
});



?>

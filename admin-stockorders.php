<?php


$app->get("/admin/stockorders/create/:orderType", function ($orderType) {
	
	$error = '';

	createPageStockOrder($orderType,$error);

	exit;    
});


?>

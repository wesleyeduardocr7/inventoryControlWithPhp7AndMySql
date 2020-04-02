<?php

use Classes\Model\Client;
use \Classes\PageAdmin;

$app->get("/admin/clients", function () {

	$clients = Client::listAll();
	
    $page = new PageAdmin();

    $page->setTpl("clients", array(
        'clients' => $clients
    ));
});


$app->get("/admin/clients/create", function () {

    $page = new PageAdmin();

    $page->setTpl("clients-create");
});


$app->post("/admin/clients/create", function () {
	
	$client = new Client();
	
    $client->setData($_POST);

    $client->save();

    header("Location: /admin/clients");
    exit;
});

$app->get("/admin/clients/:idclient", function($idclient){

	$client = new Client();

	$client->get((int)$idclient);

	$page = new PageAdmin();

	$page->setTpl("clients-update", [
		'client'=>$client->getValues()
	]);

});

$app->post("/admin/clients/:idclient", function($idclient){

	$client = new Client();

	$client->get((int)$idclient);

	$client->setData($_POST);

	$client->save();

	header('Location: /admin/clients');
	exit;

});

$app->get("/admin/clients/:idclient/delete", function($idclient){

	$client = new Client();

	$client->get((int)$idclient);

	$client->delete();

	header('Location: /admin/clients');
	exit;

});


?>

<?php

use Classes\Model;
use \Classes\PageAdmin;
use \Classes\Model\Branch;

$app->get("/admin/affiliates", function () {

    $affiliates = Branch::listAll();

    $page = new PageAdmin();

    $page->setTpl("affiliates",array(
		'affiliates'=>$affiliates
	));
});


$app->get("/admin/affiliates/create", function () {

    $page = new PageAdmin();

    $page->setTpl("affiliates-create");
});


$app->post("/admin/affiliates/create", function () {

    $branch = new Branch();

	$branch->setData($_POST);

    $branch->save();

    header("Location: /admin/affiliates");
    exit;
});

$app->get("/admin/affiliates/:idbranch", function($idbranch){

	$branch = new branch();

	$branch->get((int)$idbranch);

	$page = new PageAdmin();

	$page->setTpl("affiliates-update", [
		'branch'=>$branch->getValues()
	]);

});

$app->post("/admin/affiliates/:idbranch", function($idbranch){

	$branch = new Branch();

	$branch->get((int)$idbranch);

	$branch->setData($_POST);

	$branch->save();

	header('Location: /admin/affiliates');
	exit;

});

$app->get("/admin/affiliates/:idbranch/delete", function($idbranch){

	$branch = new branch();

	$branch->get((int)$idbranch);

	$branch->delete();

	header('Location: /admin/affiliates');
	exit;

});


?>

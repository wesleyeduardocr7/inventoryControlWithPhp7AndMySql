<?php

use \Classes\PageAdmin;
use \Classes\Model\Branch;

$app->get("/admin/branchs", function () {

    $branchs = Branch::listAll();

    $page = new PageAdmin();

    $page->setTpl("branchs",array(
		'branchs'=>$branchs
	));
});


$app->get("/admin/branchs/create", function () {

    $page = new PageAdmin();

    $page->setTpl("branchs-create");
});


$app->post("/admin/branchs/create", function () {

    $branch = new Branch();

	$branch->setData($_POST);

    $branch->save();

    header("Location: /admin/branchs");
    exit;
});

$app->get("/admin/branchs/:idbranch", function($idbranch){

	$branch = new branch();

	$branch->get((int)$idbranch);

	$page = new PageAdmin();

	$page->setTpl("branchs-update", [
		'branch'=>$branch->getValues()
	]);

});

$app->post("/admin/branchs/:idbranch", function($idbranch){

	$branch = new Branch();

	$branch->get((int)$idbranch);

	$branch->setData($_POST);

	$branch->save();

	header('Location: /admin/branchs');
	exit;

});

$app->get("/admin/branchs/:idbranch/delete", function($idbranch){

	$branch = new branch();

	$branch->get((int)$idbranch);

	$branch->delete();

	header('Location: /admin/branchs');
	exit;

});


?>

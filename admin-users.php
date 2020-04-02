<?php

use \Classes\PageAdmin;
use \Classes\Model\User;


$app->get("/admin/users", function () {

	$users = User::listAll();
	
    $page = new PageAdmin();

    $page->setTpl("users", array(
        'users' => $users
    ));
});


$app->get("/admin/users/create", function () {

    $page = new PageAdmin();

    $page->setTpl("users-create");
});


$app->post("/admin/users/create", function () {
	
	$user = new User();
	
    $user->setData($_POST);

    $user->save();

    header("Location: /admin/users");
    exit;
});

$app->get("/admin/users/:iduser", function($iduser){

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", [
		'user'=>$user->getValues()
	]);

});

$app->post("/admin/users/:iduser", function($iduser){

	$user = new User();

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->save();

	header('Location: /admin/users');
	exit;

});

$app->get("/admin/users/:iduser/delete", function($iduser){

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header('Location: /admin/users');
	exit;

});


?>

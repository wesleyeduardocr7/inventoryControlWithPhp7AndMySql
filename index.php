<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once("admin.php");
require_once("admin-products.php");
require_once("admin-branchs.php");
require_once("admin-stocks.php");

$app->run();

 ?>
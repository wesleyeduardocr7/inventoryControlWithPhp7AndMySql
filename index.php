<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once("admin.php");
require_once("admin-products.php");
require_once("admin-branchs.php");
require_once("admin-stocks.php");
require_once("admin-users.php");
require_once("admin-clients.php");
require_once("admin-stockorders-output.php");
require_once("admin-stockordersitem.php");
require_once("functions.php");

$app->run();

?>
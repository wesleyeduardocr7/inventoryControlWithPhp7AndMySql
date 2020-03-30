<?php

use \Classes\PageAdmin;

$app->get('/', function() {

$pageAdmin = new PageAdmin();

$pageAdmin->setTpl("index"); 

});

?>
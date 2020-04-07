<?php

use Classes\Controller\StockOrderItem;

function printOrderItems($idstockorder){

    $itens = StockOrderItem::getItens($idstockorder);

    return $itens;

}



?>
<?php 
require_once "connectionProducts.php";


if($_POST['action']==="unbisible")
{
    $product_id = $_POST['product_id'];
    $obProductsTable->where("product_id",$product_id)->visible(false);
    exit;
}
if($_POST['action']==="plus_product")
{
    $product_id = $_POST['product_id'];
    $obProductsTable->where("product_id",$product_id)->quantity($_POST['quantity'], "plus");
    exit;
}

if($_POST['action']==="minus_product")
{
    $product_id = $_POST['product_id'];
    $obProductsTable->where("product_id",$product_id)->quantity($_POST['quantity'], "minus");
}
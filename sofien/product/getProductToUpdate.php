<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Product.php');
require_once('../controller/Market.php');
require_once('../controller/Price.php');
require_once('../controller/marketsProduct.php');
$model = new Model();
$model->Product = new Product();
$model->Price = new Price();
$model->Market = new Market();
$model->marketsProduct = new marketsProduct();
$product = $model->Product->findfirst(array(
    'conditions' => array(
        'id' => $_GET['id']
    )
));
$markets = $model->Market->find();
foreach ($markets as $key => $value) {
    $relation = $model->marketsProduct->findfirst(array(
        'conditions' => array(
            'idProduct' => $_GET['id'],
            'idMarket' => $value->id
        )
    ));
    if(isset($relation->id)){
        $value->Relation='checked';
    }else{
        $value->Relation='unchecked';
    }
    $prices=$model->Price->findfirst(array(
        'conditions'=>array(
            'idProduct' => $_GET['id'],
            'idMarket' => $value->id
        )
        ));
        $value->Prices=$prices;
}
$product->Markets=$markets;
echo json_encode($product);

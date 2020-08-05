f<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Product.php');
require_once('../controller/marketsProduct.php');
require_once('../controller/Market.php');
require_once('../controller/Price.php');
//print_r($_POST);
if (isset($_POST['name'])&&!empty($_POST['name'])) {
   print_r($_POST);
   $model = new Model();
$model->Product = new Product();
$model->Market = new Market();
$model->marketsProduct= new marketsProduct();
$marketsUpdate=$_POST['check_list'];
unset($_POST['check_list']);
$product= new stdClass();
$product->id=$_POST['id'];
$product->name=$_POST['name'];
$product->buyPrice=$_POST['buyPrice'];
$model->Product->save($product);
$toKeep=array();
$priceToKeep=array();
$model->Price= new Price();
foreach ($marketsUpdate as $key => $value) {
 $market = $model->marketsProduct->findfirst(array(
    'conditions'=>array(
        'idProduct'=>$_POST['id'],
        'idMarket'=>$value
    )
));
   if(!isset($market->id)||empty($market->id)){
       $data= new stdClass();
       $data->idMarket=$value;
       $data->idProduct=$_POST['id'];
    $id=$model->marketsProduct->save($data);
    $toKeep[]=$id;
   }else{
       $toKeep[]=$market->id;
   }


   $prices = $model->Price->findfirst(array(
    'conditions'=>array(
        'idProduct'=>$_POST['id'],
        'idMarket'=>$value
    )
));
   if(!isset($prices->id)||empty($prices->id)){
       $data= new stdClass();
       $data->idMarket=$value;
       $data->idProduct=$_POST['id'];
       $data->dayPrice=$_POST['dayPrice_'.$value];
       $data->nightPrice=$_POST['nightPrice_'.$value];
    $id=$model->Price->save($data);
    $priceToKeep[]=$id;
   }else{
       $priceToKeep[]=$prices->id;
       $prices->dayPrice=$_POST['dayPrice_'.$value];
       $prices->nightPrice=$_POST['nightPrice_'.$value];
       $model->Price->save($prices);

   }

}
//print_r($toDelete);
$markets = $model->marketsProduct->find(array(
    'conditions'=>array(
        'idProduct'=>$_POST['id']
    )
));
foreach ($markets as $k1 => $v1) {
   if (!in_array($v1->id,$toKeep)) {
 $model->marketsProduct->delete($v1->id);
   }
}


$price = $model->Price->find(array(
    'conditions'=>array(
        'idProduct'=>$_POST['id']
    )
));
foreach ($price as $k1 => $v1) {
   if (!in_array($v1->id,$priceToKeep)) {
 $model->Price->delete($v1->id);
   }
}

}
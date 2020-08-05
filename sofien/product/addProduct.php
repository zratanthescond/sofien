<?php
 require_once('../controller/conf.php');
 require_once('../controller/Model.php');
 require_once('../controller/Product.php');
 require_once('../controller/marketsProduct.php');
 require_once('../controller/Price.php');
 //print_r($_POST);
 if (isset($_POST['name'])&&!empty($_POST['name'])) {
     print_r($_POST);
    $model = new Model();
 $model->Product = new Product();
 $Product=new stdClass();
 $Product->name=$_POST['name'];
 $Product->buyPrice=$_POST['buyPrice'];
 $markets=$_POST['check_list'];
 unset($_POST['check_list']);
$id=$model->Product->save($Product);
$model->marketsProduct=new marketsProduct();
$relation= new stdClass();
$model->Price = new Price();
$relation->idProduct=$id;
foreach ($markets as $key => $value) {
    $relation->idMarket=$value;
    $model->marketsProduct->save($relation);
    $prices=new stdClass();
    $prices->idProduct=$id;
    $prices->idMarket=$value;
    $prices->dayPrice=$_POST['dayPrice_'.$value];
    $prices->nightPrice=$_POST['nightPrice_'.$value];
    print_r($prices);
    $model->Price->save($prices);
}
 if (!empty($id)) {
     echo'{"success":true}';
 }
 }
<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Product.php');
$model = new Model();
//print_r($_POST);
 $model->Product = new Product();
 $product=$model->Product->find(array(
     'search'=>array('name'=>$_POST['name'])
 ));
 echo  json_encode($product);
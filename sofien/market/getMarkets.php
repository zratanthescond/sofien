<?php
require_once('../controller/conf.php');
 require_once('../controller/Model.php');
 require_once('../controller/Market.php');
 $model = new Model();
 $model->Market = new Market();
$market=$model->Market->find();
echo json_encode($market);
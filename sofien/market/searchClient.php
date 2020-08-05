<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Client.php');
$model = new Model();
//print_r($_POST);
 $model->Client = new Client();
 $client=$model->Client->find(array(
     'search'=>array('psudo'=>$_POST['name'])
 ));
 echo  json_encode($client);
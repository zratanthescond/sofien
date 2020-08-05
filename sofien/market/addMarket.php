<?php
 require_once('../controller/conf.php');
 require_once('../controller/Model.php');
 require_once('../controller/Market.php');
 if (isset($_POST['name'])&&!empty($_POST['name'])) {
     //print_r($_POST);
    $model = new Model();
 $model->Market = new Market();
 $market=new stdClass();
 $market->name=$_POST['name'];
  $id=$model->Market->save($market);
 if (!empty($id)) {
     echo'{"success":true}';
 }
 }

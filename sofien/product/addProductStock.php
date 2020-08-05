<?php
//print_r($_POST);
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Buy.php');
if(isset($_POST['idProduct'])&&!empty($_POST['idProduct'])){
    if(isset($_POST['much'])&&!empty($_POST['much'])){
      if(intval($_POST['much'])>0 && intval($_POST['idProduct']>0)){
        $model = new Model();
          $model->Buy=new Buy();
          $model->Buy->save($_POST);

      }
    }
}
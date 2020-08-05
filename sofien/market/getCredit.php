<?php
//print_r($_GET);
require_once('../controller/conf.php');
 require_once('../controller/Model.php');
 require_once('../controller/Credit.php');
 require_once('../controller/Client.php');
 function validateDate($date, $format = 'yy-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
$date = date("yy-m-d");
// var_dump(validateDate($_GET['date']));
if (validateDate($_GET['date']) === true) {
    $date = $_GET['date'];
}
if ($date > date('yy-m-d')) {
    $date = date("yy-m-d");
}
 $model = new Model();
 $model->Credit = new Credit();
 $model->Client = new Client();
 $credit=$model->Credit->find(array(
 'conditions'=>array(
     'date'=>$date,
     'horraire'=>$_GET['horraire'],
     'idMarket'=>$_GET['idMarket']
 )
 ));
 foreach ($credit as $key => $value) {
     $value->Client=$model->Client->findfirst(array(
         'conditions'=>array(
             'id'=>$value->idClient
         )
         ));
 }
 //print_r($credit);
 echo json_encode($credit);
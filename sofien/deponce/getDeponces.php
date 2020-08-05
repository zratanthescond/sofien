<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Deponce.php');
function validateDate($date, $format = 'yy-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
$date=date("yy-m-d");
        // var_dump(validateDate($_GET['date']));
        if(validateDate($_GET['date'])===true){
            $date = $_GET['date'];
        }
        if($date>date('yy-m-d')){
            $date=date("yy-m-d"); 
        }
$model = new Model();
$model->Deponce = new Deponce();
if(isset($_GET['idMarket'])&&!empty($_GET['idMarket'])){
    $deponces=$model->Deponce->find(array(
        'conditions'=>array(
        'date'=>$date,
        'idMarket'=>$_GET['idMarket'],
        'horraire'=>$_GET['horraire']
        )
    ));
    echo json_encode($deponces);
}
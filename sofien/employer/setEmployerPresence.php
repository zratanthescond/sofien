<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Employer.php');
require_once('../controller/Presence.php');
function validateDate($date, $format = 'yy-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
$date = date("yy-m-d");
// var_dump(validateDate($_GET['date']));
if (validateDate($_POST['date']) === true) {
    $date = $_POST['date'];
}
if ($date > date('yy-m-d')) {
    $date = date("yy-m-d");
}
$model=new Model();
$model->Employer=new Employer();
$model->Presence=new Presence();
$presence=$model->Presence->findfirst(array(
    'conditions'=>array(
        'idEmployer'=> $_POST['idEmployer'],
        'idMarket'=>$_POST['idMarket'],
        'date'=>$date
    )
    ));
    print_r($_POST);
    print_r($presence);
   // die();
    if (isset($presence->id)) {
        echo 'found';
        if ($presence->status!==$_POST['status']) {
            echo 'not equal';
            $data=new stdClass();
            foreach ($_POST as $key => $value) {
                $data->$key=$value;
            }
           
            $data->id=$presence->id;
            print_r($data);
            $model->Presence->save($data);
        }
    }else{
            $_POST['date']=$date;
            $model->Presence->save($_POST); 
        }

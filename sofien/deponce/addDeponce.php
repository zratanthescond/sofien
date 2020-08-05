<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Deponce.php');
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
$model = new Model();
$model->Deponce = new Deponce();
function testEmpty($data){
    foreach ($data as $key => $value) {
        if (empty($data[$key])) {
           return 0; 
        }
    }
    return 1;
}
if (testEmpty($_POST)==1) {
    $data=new stdClass();
    foreach ($_POST as $key => $value) {
        $data->$key=trim($value);
     }
     $data->date=$date;
    $model->Deponce->save($data);
}
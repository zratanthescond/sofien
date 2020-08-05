<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Offre.php');
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
$model->Offre = new Offre();
$data=new stdClass();
foreach ($_POST as $key => $value) {
    $data->$key=$value;
}
//print_r($data);
$data->date=$date;
$model->Offre->save($data);
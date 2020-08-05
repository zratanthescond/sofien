<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Employer.php');
    $data=new stdClass();
foreach ($_POST as $key => $value) {
    $data->$key=$value;
}
$model=new Model();
$model->Employer= new Employer();
$model->Employer->save($data);
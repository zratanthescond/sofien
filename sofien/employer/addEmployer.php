<?php
//print_r($_POST);
function testEmtyFields($data)
{
    foreach ($data as $key => $value) {
        if (!isset($data[$key]) || empty($data[$key])) {
            return 0;
        }
    }
    return 1;
}
$data = $_POST;
if (testEmtyFields($data) === 1) {
    require_once('../controller/conf.php');
    require_once('../controller/Model.php');
    require_once('../controller/Employer.php');
    $model=new Model();
    $model->Employer=new Employer();
    $model->Employer->save($data);
}


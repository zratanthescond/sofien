<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Employer.php');

$model = new Model();
$model->Employer = new Employer();
$employers = $model->Employer->findfirst(array(
    'conditions' => array(
        'id' => $_GET['id']
    )
));
echo json_encode($employers);
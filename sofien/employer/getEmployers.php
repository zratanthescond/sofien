<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Employer.php');
require_once('../controller/Market.php');
require_once('../controller/Presence.php');
require_once('../controller/Avance.php');
$model=new Model();
$model->Employer=new Employer();
$model->Presence=new Presence();
$model->Avance=new Avance();
$employers=$model->Employer->find();
$model->Market=new Market();
foreach ($employers as $key => $value) {
    $value->market=$model->Market->findfirst(array(
        'conditions'=>array('id'=>$value->idMarket)
    ));
    $value->dayWorks=$model->Presence->findcount(
      array(
          'idEmployer'=>$value->id,
          'date'=>array(
              'operator'=>'>=',
              'value'=>date("yy-m-01")
          ))
          );
          $avance=array();
          $avance=  $model->Avance->findFirst(array(
              'conditions'=>array(
                'idEmployer'=>$value->id,
                'date'=>array(
                    'operator'=>'>=',
                    'value'=>date("yy-m-01")
                )),
            'sum'=>'much'
            ));
                $value->Avance=floatval(reset($avance));
                $value->Salary=$value->dayWorks*$value->daySalary;
                $value->NetSalary=$value->Salary-$value->Avance;
}
echo json_encode($employers);
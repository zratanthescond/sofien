<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Employer.php');
require_once('../controller/Market.php');
require_once('../controller/Presence.php');
require_once('../controller/Avance.php');
$model = new Model();
$model->Employer = new Employer();
$model->Avance=new Avance();
$employers = $model->Employer->find(array(
    'conditions' => array(
        'idMarket' => $_GET['idMarket']
    )
));
$model->Presence=new Presence();
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
foreach ($employers as $key => $value) {
    
    $p= $model->Presence->findfirst(array(
        'conditions' => array(
            'idEmployer' => $value->id,
            'idMarket' => $_GET['idMarket'],
            'date' => $date
        ),
        'fields'=>array(
            'status'
            )
    ));
    if (isset($p->status)&&$p->status==1) {
        $value->presence="checked";
    }else{
        $value->presence="unchecked"; 
    }

       $avance=array();
      $avance=$model->Avance->findFirst(array(
         'conditions'=>array(
             'date'=>$date,
             'idEmployer'=>$value->id,
             'idMarket'=>$_GET['idMarket'],
             'type'=>'avance'
         ),
         'sum'=>'much'
         ));
         //print_r($avance);
         $manque=array();
         $manque=$model->Avance->findFirst(array(
            'conditions'=>array(
                'date'=>$date,
                'idEmployer'=>$value->id,
                'idMarket'=>$_GET['idMarket'],
                'type'=>'manque'
            ),
            'sum'=>'much'
            
            ));
          // print_r($manque);
    $value->avance=intval(reset($avance)).'/'.intval(reset($manque));

}
echo json_encode($employers);

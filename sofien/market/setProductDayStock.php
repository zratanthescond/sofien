<?php
//print_r($_POST);
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Stock.php');
require_once('../controller/Buy.php');
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
if (isset($_POST['much'])&&!empty($_POST['much'])) {
$model = new Model();
$model->Stock = new Stock();
$model->Buy = new Buy(); 
$error=array(); 
//echo 'not empty';
if ( intval($_POST['much'])>0 ) {
    $sum = $model->Buy->findfirst(array(
        'conditions' => array(
            'idProduct' => $_POST['idProduct']
        ),
        'sum' => 'much'
    ));
    $productQuantity=intval(reset($sum));
    if ($_POST['much']>$productQuantity) {
         $error['errors']='quantité insuffisante';
    }else{
        $data=new stdClass();
        $data->dayStock=$_POST['much'];
        $data->idMarket=$_POST['idMarket'];
        $data->idProduct=$_POST['idProduct'];
        $data->date=$date;
        $data->horraire=$_POST['horraire'];
        $id=$model->Stock->save($data);
        if (!empty($id)) {
            $tomorrowStock=$model->Stock->findfirst(array(
                'conditions'=>array(
                    'idMarket'=>$_POST['idMarket'],
                    'idProduct'=>$_POST['idProduct'],
                    'date'=>'tomorrow',
                    'horraire'=>$_POST['horraire']
                )
                ));
                if (isset($tomorrowStock->id)&&!empty($tomorrowStock->id)) {
                 $tomorrowStock->date=$date;
                 $model->Stock->save($tomorrowStock);
                }
            $error['success']='seccess';
        }
    }
    
}else{
    $error['errors']="error";
}
}else{
    $error['errors']="error"; 
}
echo json_encode($error);

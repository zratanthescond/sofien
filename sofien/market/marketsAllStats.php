<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Market.php');
require_once('../controller/Price.php');
require_once('../controller/Product.php');
require_once('../controller/Offre.php');
require_once('../controller/Daylysell.php');
require_once('../controller/Deponce.php');
require_once('../controller/Avance.php');
function getSellPrice($data, $id)
{
    if ($id == 1) {
        $hour = intval(date("H"));
        // echo $hour;
        // if ($hour>0&&$hour<8) {
        //   return $data->nightPrice;
        // }
        if ($_POST['horraire'] == 'nuit') {
            return $data->nightPrice;
        }
    }

    return $data->dayPrice;
}
function validateDate($date, $format = 'yy-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
function getDayNet($from,$to){
if (isset($from )&& !empty($from)) {
    
    $model = new Model();
    $model->Price=new Price();
    $model->Avance= new Avance();
    $model->Market = new Market();
    $model->Product = new Product();
    $model->Offre = new Offre();
    $model->Daylysell = new Daylysell();
    $model->Deponce =  new Deponce();

    $detail = $model->Daylysell->findfirst(array(
        'conditions' => array(
            'date' => array('operator'=>'BETWEEN','FROM'=>$from,'TO'=>$to)
        ),
        'sum'=>'price'

    ));
    $deponces=$model->Deponce->findfirst(array(
        'conditions' => array(
            'date' => array('operator'=>'BETWEEN','FROM'=>$from,'TO'=>$to) 
        ),
        'sum'=>'much'

    ));
//print_r($deponces);
    $offre=$model->Offre->find(array(
        'conditions' => array(
            'date' => array('operator'=>'BETWEEN','FROM'=>$from,'TO'=>$to)
        )

    ));
    $offreCost=0;
    foreach ($offre as $key => $value) {
        $price=$model->Price->findfirst(array(
            'conditions'=>array(
            'idMarket'=>$value->idMarket,
            'idProduct'=>$value->idProduct
            
            )
            
            
        ));
        $offreCost+=$value->much * getSellPrice($price,$value->idMarket);
    }
    $avance=$model->Avance->findfirst(array(
        'conditions' => array(
            'date' =>  array('operator'=>'BETWEEN','FROM'=>$from,'TO'=>$to)
        ),
        'sum'=>'much'

    ));
    $stats=new stdClass();
    $stats->sells=floatval(reset($detail));
    $stats->deponces=$offreCost+floatval(reset($avance))+floatval(reset($deponces));
    $stats->deponces=$stats->deponces;
    $stats->offres=$offreCost;
    $stats->avances=floatval(reset($avance));
    $stats->achat=floatval(reset($deponces));
    $stats->achat=$stats->achat;
    $stats->net=$stats->sells-$stats->deponces;
   // print_r($stats);
    $labels=array('vendus total','toltal offre','total avance','total deponces','gain net');
    $stats->labels=$labels;
    $stats->data=array($stats->sells,$offreCost,$stats->avances,$stats->achat,$stats->net) ;    
     return $stats;   
}else{
    return array();
}
}
//print_r($_GET);
//$stats=new stdClass();

$stats=getDayNet($_GET['from'],$_GET['to']);
echo json_encode($stats);

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
function getDayNet($date,$horraire,$id){
if ((isset($id) && !empty($id))) {
    
    $model = new Model();
    $model->Price=new Price();
    $model->Avance= new Avance();
    $model->Market = new Market();
    $model->Product = new Product();
    $model->Offre = new Offre();
    $model->Daylysell = new Daylysell();
    //$model->Buy = new Buy();
    $model->Deponce =  new Deponce();

    $detail = $model->Daylysell->findfirst(array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $id,
            'horraire'=>$horraire
        ),
        'sum'=>'price'

    ));
    $deponces=$model->Deponce->findfirst(array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $id,
            'horraire'=>$horraire
        ),
        'sum'=>'much'

    ));

    $offre=$model->Offre->find(array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $id,
            'horraire'=>$horraire
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
            'date' => $date,
            'horraire'=>$horraire
        ),
        'sum'=>'much'

    ));
    $stats=new stdClass();
    $stats->sells=floatval(reset($detail));
    $stats->deponces=$offreCost+floatval(reset($avance))+floatval(reset($deponces));
    $stats->net=$stats->sells-$stats->deponces;
            
     return $stats;   
}else{
    return array();
}
}
$dateFrom=$_GET['from'];
$Jour=array();
$Nuit=array();
$Total=array();
$dates=array();
while($dateFrom<=$_GET['to']){
    
    $dates[]=$dateFrom;
    $jour=getDayNet($dateFrom,'jour',$_GET['id'])->net;
    $Jour[]=$jour;
    $nuit=getDayNet($dateFrom,'nuit',$_GET['id'])->net;
    $Nuit[]=$nuit;
    $Total[]=$jour+$nuit;
$dateFrom = date('yy-m-d', strtotime($dateFrom . ' +1 day'));
}
$stats=new stdClass();
$stats->dates=$dates;
$stats->jour=$Jour;
$stats->nuit=$Nuit;
$stats->Total=$Total;
//print_r($stats);
echo json_encode($stats);

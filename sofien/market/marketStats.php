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
if ((isset($_GET['id']) && !empty($_GET['id']))) {
    
    $model = new Model();
    $model->Price=new Price();
    $model->Avance= new Avance();
    $model->Market = new Market();
    $model->Product = new Product();
    $model->Offre = new Offre();
    $model->Daylysell = new Daylysell();
    //$model->Buy = new Buy();
    $model->Deponce =  new Deponce();

    $date=date("yy-m-d");
    // var_dump(validateDate($_GET['date']));
    if(validateDate($_GET['date'])===true){
        $date = $_GET['date'];
    }
    if($date>date('yy-m-d')){
        $date=date("yy-m-d"); 
    }

    $detail = $model->Daylysell->findfirst(array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $_GET['id'],
            'horraire'=>$_GET['horraire']
        ),
        'sum'=>'price'

    ));
    $deponces=$model->Deponce->findfirst(array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $_GET['id'],
            'horraire'=>$_GET['horraire']
        ),
        'sum'=>'much'

    ));

    $offre=$model->Offre->find(array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $_GET['id'],
            'horraire'=>$_GET['horraire']
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
            'horraire'=>$_GET['horraire']
        ),
        'sum'=>'much'

    ));
    $stats=new stdClass();
    $stats->sells=floatval(reset($detail));
    $stats->deponces=$offreCost+floatval(reset($avance))+floatval(reset($deponces));
    $stats->deponces=number_format($stats->deponces,2,",",".");
    $stats->net=$stats->sells-$stats->deponces;
            
     echo json_encode($stats);   
}else{
    echo '[]';
}
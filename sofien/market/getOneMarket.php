<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Market.php');
require_once('../controller/marketsProduct.php');
require_once('../controller/Product.php');
require_once('../controller/Stock.php');
require_once('../controller/Daylysell.php');
require_once('../controller/Buy.php');
function validateDate($date, $format = 'yy-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
if ((isset($_GET['id']) && !empty($_GET['id']))) {
    $model = new Model();
    $model->Market = new Market();
    $model->Product = new Product();
    $model->Stock = new Stock();
    $model->Daylysell = new Daylysell();
    $model->Buy = new Buy();
    $market = $model->Market->findfirst(array(
        'conditions' => array(
            'id' => $_GET['id']
        )
    ));
    if (isset($market->id)) {
        $model->marketsProduct = new marketsProduct();
        $productByMarket = $model->marketsProduct->find(
            array(
                'conditions' => array(
                    'idMarket' => $market->id
                )
            )
        );
        // print_r($productByMarket);
        $product = array();

        foreach ($productByMarket as $key => $value) {
            $product[] = $model->Product->findfirst(array(
                'conditions' => array(
                    'id' => $value->idProduct
                )
            ));
        }
        // print_r($product);
        $date=date("yy-m-d");
        // var_dump(validateDate($_GET['date']));
        if(validateDate($_GET['date'])===true){
            $date = $_GET['date'];
        }
        if($date>date('yy-m-d')){
            $date=date("yy-m-d"); 
        }
        // echo $date;
        foreach ($product as $k => $v) {
            //  print_r($v);
            $sells = $model->Stock->findfirst(array(
                'conditions' => array(
                    'idProduct' => $v->id,
                    'date' => $date,
                    'idMarket' => $_GET['id'],
                    'horraire'=>$_GET['horraire']
                ),
                'sum' => 'dayStock'
            ));
            $xxx = intval(reset($sells));
           // echo $xxx.'<br>';
            if($xxx<=0){
               // echo '<=0';
              $daystock=$model->Stock->findfirst(array(
                'conditions' => array(
                    'idProduct' => $v->id,
                    'date' => 'tomorrow',
                    'idMarket' => $_GET['id'],
                    'horraire'=>$_GET['horraire']
                )
                ))->dayStock;
                if ($daystock>0||$daystock===NULL||empty($daystock)) {
                    $v->dayStock=intval($daystock);
                }
            }else{
               $v->dayStock = $xxx; 
            }
            


            $detail = $model->Daylysell->findfirst(array(
                'conditions' => array(
                    'idProduct' => $v->id,
                    'date' => $date,
                    'idMarket' => $_GET['id'],
                    'horraire'=>$_GET['horraire']
                )

            ));
            // echo 'sdsfsdfsdffsdf';
            // print_r($detail);
            $sum = $model->Buy->findfirst(array(
                'conditions' => array(
                    'idProduct' => $v->id
                ),
                'sum' => 'much'
            ));
            // echo '<br>';
            // echo $v->id;
            // echo '<br>';
            // print_r($sum);
            // echo '<br>';

            $sell = $model->Stock->find(array(
                'conditions' => array(
                    'idProduct' => $v->id
                ),
                'sum' => 'dayStock'
            ));

            $v->Stock = intval(reset($sum) - reset($sell));
            $v->sells = intval($detail->much);
            $v->rest = intval($detail->rest);
            $v->price = floatval($detail->price);
            $v->dayPrice=floatval($detail->unitPriceSell);
            $market->Products = $product;
        }
        echo json_encode($market);
    }
}
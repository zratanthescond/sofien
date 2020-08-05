<?php
require_once('../controller/conf.php');
 require_once('../controller/Model.php');
 require_once('../controller/Product.php');
 require_once('../controller/Market.php');
 require_once('../controller/Buy.php');
 require_once('../controller/Stock.php');
 require_once('../controller/marketsProduct.php');
 require_once('../controller/Daylysell.php');

 $model = new Model();
 $model->Product = new Product();
 $model->Market = new Market();
 $model->Buy = new Buy();
 $model->Daylysell=new Daylysell();
 $model->Stock = new Stock();
 $model->marketsProduct= new marketsProduct();
$product=$model->Product->find();
foreach ($product as $key => $value) {
   $markets=$model->marketsProduct->find(array(
        'conditions'=>array(
            'idProduct'=>$value->id
        )
        ));
        $market='';
      //  print_r($markets);
        foreach ($markets as $k => $v) {
           //echo $v->idMarket;
           $market.='/ '.$model->Market->findfirst(array(
               'conditions'=>array(
                   'id'=>$v->idMarket
               ),
               'fields'=>array(
                   'name'
               )
               ))->name;
               //print_r($market);
        }
        $value->market=trim($market,'/') ;
        $sum=$model->Buy->findfirst(array(
            'conditions'=>array(
                'idProduct'=>$value->id
            ),
            'sum'=>'much'
        ));
      //  print_r($sum);
        $rest=$model->Stock->findfirst(array(
            'conditions'=>array(
                'idProduct'=>$value->id,
                'date'=>'tomorrow'
            ),
            'sum'=>'dayStock'
        ));
        $sells=$model->Daylysell->findfirst(array(
            'conditions'=>array(
                'idProduct'=>$value->id
            ),
            'sum'=>'much'
        ));
       // print_r($sells);
      // echo reset($sum);
       $value->Stock=intval(reset($sum))-(intval(reset($sells))+intval(reset($rest)) );
}
echo json_encode($product);
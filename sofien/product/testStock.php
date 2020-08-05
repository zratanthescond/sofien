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


        $sum=$model->Buy->findfirst(array(
            'conditions'=>array(
                'idProduct'=>$_GET['id']
            ),
            'sum'=>'much'
        ));
        print_r($sum);
        echo '<br>';
        $rest=$model->Stock->findfirst(array(
            'conditions'=>array(
                'idProduct'=>$_GET['id'],
                'date'=>'tomorrow'
            ),
            'sum'=>'dayStock'
        ));
        print_r($rest);
        echo '<br>';
        $sells=$model->Daylysell->findfirst(array(
            'conditions'=>array(
                'idProduct'=>$_GET['id']
            ),
            'sum'=>'much'
        ));
        print_r($sells);
        echo '<br>';
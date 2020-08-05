<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Offre.php');
require_once('../controller/Product.php');
require_once('../controller/User.php');

$model = new Model();
$model->Offre = new Offre();
$model->Product = new Product();
$model->User = new User();
$offres=$model->Offre->find(
    array(
        'conditions'=>array(
            'date'=>date("yy-m-d"),
            'idMarket'=>$_GET['idMarket']
        )
    )
        );
        $off=array();
        foreach ($offres as $key => $value) {
            $value->Product=$model->Product->findFirst(array(
                'condition'=>array(
                    'id'=>$value->idPoduct,
                )
                ));
                $value->User=$model->User->findFirst(array(
                    'condition'=>array(
                        'id'=>$value->idUser,
                    )
                    ));
                    $off[]=$value;
            
        }
        echo json_encode($off);
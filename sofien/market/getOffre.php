<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Offre.php');
require_once('../controller/Product.php');
require_once('../controller/User.php');
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
$model = new Model();
$model->Offre = new Offre();
$model->Product = new Product();
$model->User = new User();
$offres = $model->Offre->find(
    array(
        'conditions' => array(
            'date' => $date,
            'idMarket' => $_GET['idMarket'],
            'horraire'=>$_GET['horraire']
        )
    )
);
foreach ($offres as $key => $value) {
    // print_r($value);
    $value->Product = $model->Product->findFirst(array(
        'conditions' => array(
            'id' => $value->idProduct,
        ),
        'fields' => array(
            'name'
        )
    ));
    $value->User = $model->User->findFirst(array(
        'conditions' => array(
            'id' => $value->idUser,
        ),
        'fields' => array(
            'login'
        )
    ));
}
echo json_encode($offres);

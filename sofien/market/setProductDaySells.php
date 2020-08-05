<?php
//print_r($_POST);
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/Daylysell.php');
require_once('../controller/Product.php');
require_once('../controller/Stock.php');
require_once('../controller/Price.php');
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
$date = date("yy-m-d");
// var_dump(validateDate($_GET['date']));
if (validateDate($_POST['date']) === true) {
    $date = $_POST['date'];
}
if ($date > date('yy-m-d')) {
    $date = date("yy-m-d");
}
if (isset($_POST['much']) && !empty($_POST['much'])) {
    $model = new Model();
    $model->Daylysell = new Daylysell();
    $model->Product = new Product();
    $model->Stock = new Stock();
    $model->Price = new Price();
    $error = array();
    //echo 'not empty';
    $date = $date;
    if (intval($_POST['much']) > 0) {
        $item = $model->Daylysell->findfirst(array(
            'conditions' => array(
                'idProduct' => $_POST['idProduct'],
                'idMarket' => $_POST['idMarket'],
                'date' => $date,
                'horraire' => $_POST['horraire']
            ),
            'fields' => array(
                'id'
            )

        ));
        $unitPrice = $model->Product->findfirst(array(
            'conditions' => array(
                'id' => $_POST['idProduct']
            )
        ));
        $sellPrice = $model->Price->findfirst(array(
            'conditions' => array(
                'idProduct' => $_POST['idProduct'],
                'idMarket' => $_POST['idMarket']
            )
        ));
        $sells = $model->Stock->findfirst(array(
            'conditions' => array(
                'idProduct' => $_POST['idProduct'],
                'date' => $date,
                'idMarket' => $_POST['idMarket'],
                'horraire' => $_POST['horraire']
            ),
            'sum' => 'dayStock'
        ));
        $dayStock = intval(reset($sells));
        if ($dayStock==0) {
            $restToStock = $model->Stock->findfirst(array(
                'conditions' => array(
                    'idProduct' => $_POST['idProduct'],
                    'date' => 'tomorrow',
                    'idMarket' => $_POST['idMarket'],
                    'horraire' => $_POST['horraire']
    
                )
            ));
            if (isset($restToStock->dayStock)&&$restToStock->dayStock>0) {
                $dayStock=$restToStock->dayStock;
                $restToStock->date=$date;
                $model->Stock->save($restToStock);
            }
           
        }
        if ($dayStock < $_POST['much']) {
            $error['errors'] = "contite uffisant";
            echo json_encode($error);
            die();
        }
        $data = new stdClass();
        $data->idMarket = $_POST['idMarket'];
        $data->idProduct = $_POST['idProduct'];
        $data->much = $_POST['much'];
        $data->unitPriceSell = getSellPrice($sellPrice, $_POST['idMarket']);
        $data->price = $data->much * $data->unitPriceSell;
        $data->unitPrice = $unitPrice->buyPrice;
        $data->date = $date;
        $data->horraire = $_POST['horraire'];
        $data->rest = $dayStock - intval($_POST['much']);
        $restToStock = $model->Stock->findfirst(array(
            'conditions' => array(
                'idProduct' => $_POST['idProduct'],
                'date' => 'tomorrow',
                'idMarket' => $_POST['idMarket'],
                'horraire' => $_POST['horraire']

            )
        ));

        if (isset($item->id) && !empty($item->id)) {
            $data->id = $item->id;
            $model->Daylysell->save($data);
            if (!isset($restToStock->id) || empty($restToStock->id)) {
                $stock = new stdClass();
                $stock->dayStock = $data->rest;
                $stock->idMarket = $_POST['idMarket'];
                $stock->idProduct = $_POST['idProduct'];
                $stock->date = 'tomorrow';
                $stock->horraire = $_POST['horraire'];
                $model->Stock->save($stock);
            } else {
                $restToStock->dayStock = $data->rest;
                $model->Stock->save($restToStock);
            }
        } else {
            $model->Daylysell->save($data);
            if (!isset($restToStock->id) || empty($restToStock->id)) {
                $stock = new stdClass();
                $stock->dayStock = $data->rest;
                $stock->idMarket = $_POST['idMarket'];
                $stock->idProduct = $_POST['idProduct'];
                $stock->date = 'tomorrow';
                $stock->horraire = $_POST['horraire'];
                $model->Stock->save($stock);
            } else {
                $restToStock->dayStock = $data->rest;
                $model->Stock->save($restToStock);
            }
        }
    } else {
        $error['errors'] = "error";
    }
} else {
    $error['errors'] = "error";
}
echo json_encode($error);

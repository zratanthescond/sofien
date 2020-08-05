<?php
require_once('../controller/conf.php');
require_once('../controller/Model.php');
require_once('../controller/User.php');

$model = new Model();
$model->User = new User();
$users= $model->User->find();
echo(json_encode($users));
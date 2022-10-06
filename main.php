<?php
if (!isset($argv)) {
    throw new Exception('Missing arguments');
}

require_once 'DataModel.php';
require_once 'DataView.php';
require_once 'Action.php';
$input_array=require 'input.php';
$main_array = ['vasya', 'pupkin', 'apple', 23, 41, 55, 1, 2];

$model = new DataModel($main_array, $input_array);
$view = new DataView($model);
$view->executeAll();



<?php

require_once('vendor/autoload.php');
require_once(__DIR__ . '/../autoload.php');

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$data = [
    'shop_process_id'   => 800001
];

$request = LlevaUno\Bancard\Operations\PreAuthorization\Confirm\Confirm::send($data);
var_dump($request->json());
var_dump($request->response());



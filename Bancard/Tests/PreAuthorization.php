<?php

require_once('vendor/autoload.php');
require_once(__DIR__ . '/../autoload.php');

$redis = new Redis();

$redis->pconnect('127.0.0.1', 6379);

$id = $redis->incr("LlevaUno:Bancard:shop_process_id");

$data = [
    'shop_process_id'   => $id,
    'amount'            => '1000.00',
    'currency'          => 'PYG',
    'additional_data'   => 'Test additional data',
    'description'       => 'Test description'
];

$request = LlevaUno\Bancard\Operations\PreAuthorization\PreAuthorization::send($data);

var_dump($request->response());

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:PreAuthorization:{$id}",
    "shop_process_id",
    "$id"
);

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:PreAuthorization:{$id}",
    "data",
    json_encode($data)
);

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:PreAuthorization:{$id}",
    "request",
    $request->json()
);

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:PreAuthorization:{$id}",
    "reponse",
    $request->response()
);

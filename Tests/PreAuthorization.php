<?php

require_once(__DIR__ . '/../Bancard/autoload.php');

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$id = $redis->incr("LlevaUno:Bancard:shop_process_id");

$data = [
    'shop_process_id'   => $id,
    'amount'            => $_POST['amount'],
    'currency'          => 'PYG',
    'additional_data'   => '',
    'description'       => $_POST['description']
];

var_dump($data);

try {
    $request = LlevaUno\Bancard\Operations\PreAuthorization\PreAuthorization::init($data)->send();
} catch (Exception $e) {
    die($e->getMessage());
}


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
    "response",
    json_encode($request->response)
);

var_dump($request->redirect_to);

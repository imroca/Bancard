<?php

require_once(__DIR__ . "/../../Bancard/autoload.php");

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$data = LlevaUno\Bancard\Core\Response::read()->get();

$response = json_decode($data);

$id = $response->operation->shop_process_id;

header('Content-Type: application/json');

if ($data) {
    $redis->hSet(
        "LlevaUno:Bancard:PreAuthorization:PreAuthorization:{$id}",
        "confirm",
        $data
    );
    
    echo json_encode(array(
        'status' => 200,
        'message' => 'Success'
    ));
} else {
    echo json_encode(array(
        'status' => 404,
        'message' => 'Not found'
    ));
}

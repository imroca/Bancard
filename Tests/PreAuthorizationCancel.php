<?php

require_once(__DIR__ . '/../Bancard/autoload.php');

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$id = !empty($_GET['id']) ? $_GET['id'] : 0;

if (!$id) {
    die("Invalid parameters.");
}

$pid = $redis->hGet("LlevaUno:Bancard:PreAuthorization:PreAuthorization:" . $id, "shop_process_id");

if (!$pid) {
    die("No pid was selected.");
}

$data = [
    'shop_process_id'   => $pid,
];

try {
    $request = LlevaUno\Bancard\Operations\PreAuthorization\Cancel::init($data)->send();
} catch (Exception $e) {
    die($e->getMessage());
}

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:Cancel:{$id}",
    "shop_process_id",
    "$id"
);

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:Cancel:{$id}",
    "data",
    json_encode($data)
);

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:Cancel:{$id}",
    "request",
    $request->json()
);

$redis->hSet(
    "LlevaUno:Bancard:PreAuthorization:Cancel:{$id}",
    "response",
    json_encode($request->response)
);
